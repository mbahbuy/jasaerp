<?php 
namespace App\Controllers\Dashboard\Preference;

use App\Controllers\BaseController;
use App\Models\{Gudang};
use Config\Database;
use PHPUnit\Util\Json;

class GudangController extends BaseController{
    protected $db, $gudang;

    public function __construct()
    {
        $this->gudang = new Gudang();
        $this->db = Database::connect();
        session();
    }

    public function json()
    {
        $data = $this->gudang->get_gudang_with_selected();

        return response()->setJSON($data);
    }

    public function index()
    {
        return view('dashboard/preference/gudang', [
            'title' => 'Gudang',
            'hal' => 'preference/gudang',
            'data' => $this->gudang->orderBy('id_gudang', 'DESC')->get()->getResult(),
        ]);
    }

    public function store()
    {
        $validationRules = [
            'gudang' => 'required|is_unique[gudang.nama_gudang]',
        ];
    
        $validationMessages = [
            'required' => '{field} harus di isi.',
            'is_unique' => '{field} sudah ada dalam daftar gudang.',
        ];
    
        // Validate the input data
        if (!$this->validate($validationRules, $validationMessages)) {
            $validationErrors = implode(', ', $this->validator->getErrors());
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => $validationErrors]);
        }


        $this->gudang->insert([
            'nama_gudang' => $this->request->getVar('gudang'),
            'alamat'        => $this->request->getVar('alamat') ?? '',
            'kapasitas'     => $this->request->getVar('kapasitas') ?? 0,
        ]);

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'gudang berhasil ditambahkan']);
    }

    public function update($id)
    {
        $validationRules = [
            'gudang' => "required|is_unique[gudang.nama_gudang,id_gudang,{$id}]",
        ];
    
        $validationMessages = [
            'required' => '{field} harus di isi.',
            'is_unique' => '{field} sudah ada dalam daftar gudang.',
        ];
    
        // Validate the input data
        if (!$this->validate($validationRules, $validationMessages)) {
            $validationErrors = implode(', ', $this->validator->getErrors());
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => $validationErrors]);
        }

        $existinggudang = $this->gudang->find($id);
        if (!$existinggudang) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'gudang tidak ditemukan']);
        }

        $update = false;
        $data = [];
        if ($existinggudang['nama_gudang'] !== $this->request->getVar('gudang')) {
            $update = true;
            $data['nama_gudang'] = $this->request->getVar('gudang');
        }

        if ($this->request->getVar('alamat') !== null && $this->request->getVar('alamat') !== $existinggudang['alamat']) {
            $update = true;
            $data['alamat'] = $this->request->getVar('alamat');
        }

        if ($this->request->getVar('kapasitans') !==null && $this->request->getVar('kapasitans') !== $existinggudang['kapasitans']) {
            $update = true;
            $data['kapasitans'] = $this->request->getVar('kapasitans');
        }

        if ($update) {
            $this->gudang->update($id, $data);
        }

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'gudang berhasil dirubah']);
    }

    public function delete($id)
    {
        $existinggudang = $this->gudang->find($id);
        if (!$existinggudang) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'gudang tidak ditemukan']);
        }

        // set status false to gudang
        $this->gudang->update($id, ['status' => false]);

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'gudang berhasil dihapus']);
    }

    public function restore($id)
    {
        $existinggudang = $this->gudang->find($id);
        if (!$existinggudang) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'gudang tidak ditemukan']);
        }

        // set status true to gudang
        $this->gudang->update($id, ['status' => true]);

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'gudang berhasil di ambil dari tempat sampah']);
    }

    public function selected($id)
    {
        $existinggudang = $this->gudang->find($id);
        if (!$existinggudang) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'gudang tidak ditemukan']);
        }

        if ($existinggudang['status'] == false) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'gudang ditemukan ditempat sampah']);
        }

        $this->gudang->set_selected_gudang($id);
        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'gudang dipilih sebagai default aktifitas']);
    }
}