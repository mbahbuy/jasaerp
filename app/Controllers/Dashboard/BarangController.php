<?php 
namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\{Barang, Category, Satuan, Gudang};
use Config\Database;

class BarangController extends BaseController{

    protected $db, $barang, $kategori, $satuan, $gudang;

    public function __construct()
    {
        $this->barang = new Barang();
        $this->kategori = new Category();
        $this->satuan = new Satuan();
        $this->gudang = new Gudang();
        $this->db = Database::connect();
        session();
    }

    public function index()
    {
        return view('dashboard/barang/list', [
            'title' => 'List Barang',
            'hal' => 'barang/list',
        ]);
    }

    public function form()
    {
        return view('dashboard/barang/form', [
            'title' => 'Form Barang',
            'hal' => 'barang/form',
            'categories' => $this->kategori->findAll(),
            'satuan' => $this->satuan->findAll(),
            'gudang'   => $this->gudang->findAll(),
        ]);
    }

    public function store()
    {
        // Validation rules
        $validationRules = [
            'kode' => 'required|is_unique[barang.kode_barang]',
            'nama' => 'required|is_unique[barang.nama_barang]',
            'harga' => 'required',
            'kategori' => 'required|is_not_unique[categories.id_kategori]',
            'satuan' => 'required|is_not_unique[satuan.id_satuan]',

        ];
    
        // Handle the uploaded gambar image
        $file = $this->request->getFile('gambar');
        $namaGambar = 'default.png';
        if ($file && !$file->getError() == 4) {
            $validationRules['gambar'] = 'uploaded[gambar]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/gif,image/svg]|max_size[gambar,2048]';
            $namaGambar = $file->getRandomName();
            $file->move('images/', $namaGambar);
        }

        $validationMessages = [
            'required' => '{field} harus di isi.',
            'is_unique' => '{field} sudah ada dalam daftar barang.',
            'is_image' => '{field} harus berupa gambar.',
            'mime_in' => '{field} harus berupa file jpg, jpeg, gif, png, atau svg.',
            'max_size' => 'Maksimal ukuran {field} adalah 2MB.',
            'max_lenght' => '{field} melebihi huruf yang ditentukan',
            'is_not_unique' => 'Data tidak terdaftar dalam database.',
            'valid_json' => '{field} bukanlah data JSON.',
        ];
    
        // Validate the input data
        if (!$this->validate($validationRules, $validationMessages)) {
            $validationErrors = implode(', ', $this->validator->getErrors());
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => $validationErrors]);
        }

        // Save the barang data
        $this->barang->save([
            'nama_barang' => $this->request->getVar('nama'),
            'kode_barang' => $this->request->getVar('kode'),
            'harga_barang' => $this->request->getVar('harga'),
            'gambar_barang' => $namaGambar,
            'kategori_id' => $this->request->getVar('kategori'),
            'gudang_id' => $this->gudang->get_selected_gudang_id(),
            'satuan_id' => $this->request->getVar('satuan'),
        ]);

        // save stock to stock_gudang
        $this->gudang->insert_stock_gudang($this->request->getVar('kode'), $this->request->getVar('stock'));

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Barang telah disimpan']);

    }

    public function edit($slug)
    {
        $dataBarang = $this->barang->get_barang($slug);
        return view('dashboard/barang/edit', [
            'title' => 'Form Barang-' . $dataBarang['nama_barang'],
            'hal' => 'barang/form',
            'categories' => $this->kategori->findAll(),
            'satuan' => $this->satuan->findAll(),
            'gudang'   => $this->gudang->findAll(),
            'barang' => $dataBarang,
        ]);
    }

    public function update($slug)
    {
        // Validation rules
        $validationRules = [
            'kode' => 'required',
            'nama' => 'required',
            'kategori' => 'required|is_not_unique[categories.id_kategori]',
            'satuan' => 'required|is_not_unique[satuan.id_satuan]',

        ];
    
        $validationMessages = [
            'required' => '{field} harus di isi.',
            'is_image' => '{field} harus berupa gambar.',
            'mime_in' => '{field} harus berupa file jpg, jpeg, gif, png, atau svg.',
            'max_size' => 'Maksimal ukuran {field} adalah 2MB.',
            'max_lenght' => '{field} melebihi huruf yang ditentukan',
            'is_not_unique' => 'Data tidak terdaftar dalam database.',
            'valid_json' => '{field} bukanlah data JSON.',
        ];

        // Fetch the existing barang data
        $existingBarang = $this->barang->where('slug', $slug)->first();

        if (!$existingBarang) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'Barang tidak ditemukan']);
        }
    
        $id_barang = $existingBarang['id_barang'];

        // Get the old gambar filename
        $oldGambar = $this->request->getVar('old_gambar');

        // Handle the uploaded gambar image
        $fileGambar = $this->request->getFile('gambar');
        
        $namaGambar = $oldGambar;
        if ($fileGambar) {
            if (!$fileGambar->getError() == 4) {
                $validationRules['gambar'] = 'uploaded[gambar]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/gif,image/svg]|max_size[gambar,2048]';
                unlink(PUBPATH . 'images/' . $oldGambar);
                $namaGambar = $fileGambar->getRandomName();
                $fileGambar->move('images/', $namaGambar);
            }
        }

        // Validate the input data
        if (!$this->validate($validationRules, $validationMessages)) {
            $validationErrors = implode(', ', $this->validator->getErrors());
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => $validationErrors]);
        }

        // Update the barang data
        $this->barang->update( $id_barang, [
            'nama_barang' => $this->request->getVar('nama'),
            'kode_barang' => $this->request->getVar('kode'),
            'harga_barang' => $this->request->getVar('harga'),
            'gambar_barang' => $namaGambar,
            'kategori_id' => $this->request->getVar('kategori'),
            'gudang_id' => $this->gudang->get_selected_gudang_id(),
            'satuan_id' => $this->request->getVar('satuan'),
        ]);

        if ($existingBarang['kode_barang'] == $this->request->getVar('kode')) {
            // update stock to stock_gudang
            $this->gudang->update_stock_gudang($this->request->getVar('kode'), $this->request->getVar('stock'));
        } else {
            // delete stock
            $this->gudang->delete_stock_gudang($existingBarang['kode_barang']);
            // save stock to stock_gudang
            $this->gudang->insert_stock_gudang($this->request->getVar('kode'), $this->request->getVar('stock'));
        }

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Barang telah diperbarui']);

    }

    public function delete($slug)
    {
        $existingBarang = $this->barang->where('slug', $slug)->first();
        if (!$existingBarang) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'Barang tidak ditemukan']);
        }

        // set status false to barang
        $this->barang->update($existingBarang['id_barang'], ['status' => false]);

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Barang berhasil dimasukkan tempat sampah']);
    }

    public function restore($slug)
    {
        $existingBarang = $this->barang->where('slug', $slug)->first();
        if (!$existingBarang) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'barang tidak ditemukan']);
        }

        // set status true to barang
        $this->barang->update($existingBarang['id_barang'], ['status' => true]);

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Barang berhasil di ambil dari tempat sampah']);
    }

    public function json()
    {
        $data = $this->barang->get_all_barang_with_stock();
        
        return $this->response->setJSON($data);
    }

    public function stock($id)
    {
        // Validation rules
        $validationRules = [
            'stock' => 'required',
        ];

        $validationMessages = [
            'required' => '{field} harus di isi.',
        ];
    
        // Validate the input data
        if (!$this->validate($validationRules, $validationMessages)) {
            $validationErrors = implode(', ', $this->validator->getErrors());
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => $validationErrors]);
        }

        $existingBarang = $this->barang->first($id);
        if (!$existingBarang) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'barang tidak ditemukan']);
        }

        // delete stock
        $this->gudang->delete_stock_gudang($existingBarang['kode_barang']);
        // save stock to stock_gudang
        $this->gudang->insert_stock_gudang($existingBarang['kode_barang'], $this->request->getVar('stock'));

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Stock barang berhasil di update.']);
    }

    public function harga($id)
    {
        // Validation rules
        $validationRules = [
            'harga' => 'required',
        ];

        $validationMessages = [
            'required' => '{field} harus di isi.',
        ];
    
        // Validate the input data
        if (!$this->validate($validationRules, $validationMessages)) {
            $validationErrors = implode(', ', $this->validator->getErrors());
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => $validationErrors]);
        }

        $existingBarang = $this->barang->first($id);
        if (!$existingBarang) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'barang tidak ditemukan']);
        }

        // Update the barang data
        $this->barang->update( $id, ['harga_barang' => (int)$this->request->getVar('harga')]);

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Harga harang berhasil di update.']);
    }
}