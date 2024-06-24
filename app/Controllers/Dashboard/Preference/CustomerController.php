<?php 
namespace App\Controllers\Dashboard\Preference;

use App\Controllers\BaseController;
use App\Models\{Customer};
use Config\Database;

class CustomerController extends BaseController
{
    protected $db, $customer;

    public function __construct()
    {
        $this->customer = new Customer();
        $this->db = Database::connect();
        session();
    }

    public function json()
    {
        $data = $this->customer->findAll();
        return response()->setJSON($data);
    }

    public function index()
    {
        return view('dashboard/preference/customer', [
            'title' => 'Customer',
            'hal' => 'preference/customer',
        ]);
    }

    public function store()
    {
        // Validation rules
        $validationRules = [
            'nama' => 'required|max_length[225]',
            'email' => 'permit_empty',
            'phone'    => 'required|max_length[25]',
            'alamat' => 'permit_empty',
            'nama_toko' => 'required|is_unique[customer.nama_toko]|max_length[225]',
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
        $dataStore['alamat'] = $this->request->getVar('alamat') ?? '';
        $dataStore['nama_toko'] = $this->request->getVar('nama_toko');
        $dataStore['alamat_toko'] = $this->request->getVar('alamat_toko');
        $dataStore['bank'] = $this->request->getVar('bank') ?? '';
        $dataStore['no_rekening'] = $this->request->getVar('no_rekening') ?? '';

        $this->customer->insert($dataStore);

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => "Customer($dataStore[nama]) telah disimpan"]);
    }

    public function update($ID)
    {
        // Validation rules
        $validationRules = [
            'nama' => 'required|max_length[225]',
            'email' => 'permit_empty',
            'phone'    => 'required|max_length[25]',
            'alamat' => 'permit_empty',
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
    
        // Fetch the existing customer data
        $existingData = $this->customer->find($ID);
    
        if (!$existingData) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'Customer tidak ditemukan']);
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
    
        if ($this->request->getVar('alamat') !== '' && $this->request->getVar('alamat') !== $existingData['alamat']) {
            $dataUpdate['alamat'] = $this->request->getVar('alamat');
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
            $this->customer->update($ID, $dataUpdate);
        }
    
        return $this->response->setJSON(['bg' => 'bg-success', 'message' => "Customer({$existingData['nama']}) telah disimpan"]);
    }
    

    public function delete($ID)
    {
        // Fetch the existing article data
        $existingData = $this->customer->find($ID);

        if (!$existingData) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'Customer tidak ditemukan']);
        }

        $this->customer->delete($ID);

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => "Customer($existingData[nama]) telah dihapus."]);
    }

}