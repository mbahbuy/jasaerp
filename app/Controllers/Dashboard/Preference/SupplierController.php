<?php 
namespace App\Controllers\Dashboard\Preference;

use App\Controllers\BaseController;
use App\Models\Supplier;
use Config\Database;

class SupplierController extends BaseController
{
    protected $db, $supplier;

    public function __construct()
    {
        $this->supplier = new Supplier();
        $this->db = Database::connect();
        session();
    }

    public function json()
    {
        $data = $this->supplier->findAll();

        return response()->setJSON($data);
    }

    public function index()
    {
        return view('dashboard/preference/supplier', [
            'title' => 'Supplier',
            'hal' => 'preference/supplier',
        ]);
    }

    public function store()
    {
        // Validation rules
        $validationRules = [
            'nama' => 'required|max_length[225]',
            'email' => 'permit_empty',
            'phone'    => 'required|max_length[25]',
            'nama_toko' => 'required|is_unique[supplier.nama_toko]|max_length[225]',
            'alamat_toko' => 'required|max_length[255]',
            'bank' => 'permit_empty',
            'no_rekening' => 'permit_empty',
        ];
    
        $validationMessages = [
            'required' => '{field} harus di isi.',
            'is_unique' => '{field} sudah ada dalam daftar berita.',
            'max_lenght' => '{field} melebihi dari jumlah huruf yang ditentukan',
            'min_lenght' => '{field} kurang dari jumlah huruf yang ditentukan',
        ];
    
        // Validate the input data
        if (!$this->validate($validationRules, $validationMessages)) {
            $validationErrors = implode(', ', $this->validator->getErrors());
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => $validationErrors]);
        }

        $dataStore = [];

        $dataStore['nama'] = $this->request->getVar('nama');
        $dataStore['email'] = $this->request->getVar('email') ?? '';
        $dataStore['phone'] = $this->request->getVar('phone');
        $dataStore['nama_toko'] = $this->request->getVar('nama_toko');
        $dataStore['alamat_toko'] = $this->request->getVar('alamat_toko');
        $dataStore['bank'] = $this->request->getVar('bank') ?? '';
        $dataStore['no_rekening'] = $this->request->getVar('no_rekening') ?? '';

        $this->supplier->insert($dataStore);

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => "Supplier($dataStore[nama]) telah disimpan"]);
    }

    public function update($ID)
    {
        // Validation rules
        $validationRules = [
            'nama' => 'required|max_length[225]',
            'email' => 'permit_empty',
            'phone'    => 'required|max_length[25]',
            'nama_toko' => 'required|max_length[225]',
            'alamat_toko' => 'required|max_length[255]',
            'bank' => 'permit_empty',
            'no_rekening' => 'permit_empty',
        ];
    
        $validationMessages = [
            'required' => '{field} harus di isi.',
            'is_unique' => '{field} sudah ada dalam daftar berita.',
            'max_length' => '{field} melebihi dari jumlah huruf yang ditentukan',
            'min_length' => '{field} kurang dari jumlah huruf yang ditentukan',
        ];
    
        // Validate the input data
        if (!$this->validate($validationRules, $validationMessages)) {
            $validationErrors = implode(', ', $this->validator->getErrors());
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => $validationErrors]);
        }
    
        // Fetch the existing Supplier data
        $existingData = $this->supplier->find($ID);
    
        if (!$existingData) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'Supplier tidak ditemukan']);
        }
    
        $dataUpdate = [];
        $statusUpdate = false;
    
        if ($this->request->getVar('nama') !== '' && $this->request->getVar('nama') !== $existingData['nama']) {
            $dataUpdate['nama'] = $this->request->getVar('nama');
            $statusUpdate = true;
        }
    
        if ($this->request->getVar('email') !== '' && $this->request->getVar('email') !== $existingData['email']) {
            $dataUpdate['email'] = $this->request->getVar('email');
            $statusUpdate = true;
        }
    
        if ($this->request->getVar('phone') !== '' && $this->request->getVar('phone') !== $existingData['phone']) {
            $dataUpdate['phone'] = $this->request->getVar('phone');
            $statusUpdate = true;
        }
    
        if ($this->request->getVar('nama_toko') !== '' && $this->request->getVar('nama_toko') !== $existingData['nama_toko']) {
            $dataUpdate['nama_toko'] = $this->request->getVar('nama_toko');
            $statusUpdate = true;
        }
    
        if ($this->request->getVar('alamat_toko') !== '' && $this->request->getVar('alamat_toko') !== $existingData['alamat_toko']) {
            $dataUpdate['alamat_toko'] = $this->request->getVar('alamat_toko');
            $statusUpdate = true;
        }
    
        if ($this->request->getVar('bank') !== '' && $this->request->getVar('bank') !== $existingData['bank']) {
            $dataUpdate['bank'] = $this->request->getVar('bank');
            $statusUpdate = true;
        }
    
        if ($this->request->getVar('no_rekening') !== '' && $this->request->getVar('no_rekening') !== $existingData['no_rekening']) {
            $dataUpdate['no_rekening'] = $this->request->getVar('no_rekening');
            $statusUpdate = true;
        }
    
        if ($statusUpdate === true) {
            $this->supplier->update($ID, $dataUpdate);
        }
    
        return $this->response->setJSON(['bg' => 'bg-success', 'message' => "Supplier({$existingData['nama']}) telah disimpan"]);
    }
    

    public function delete($ID)
    {
        // Fetch the existing article data
        $existingData = $this->supplier->find($ID);

        if (!$existingData) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'Supplier tidak ditemukan']);
        }

        $this->supplier->delete($ID);

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => "Supplier($existingData[nama]) telah dihapus."]);
    }

}