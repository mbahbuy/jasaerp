<?php

namespace App\Controllers\Dashboard\Preference;

use App\Controllers\BaseController;
use App\Models\{Satuan};

class SatuanController extends BaseController
{
    protected $satuan;

    public function __construct()
    {
        $this->satuan = new Satuan();

        session();
    }

    public function index()
    {
        return view('dashboard/preference/satuan', [
            'title' => 'Satuan',
            'hal' => 'preference/satuan',
            'data' => $this->satuan->orderBy('id_satuan', 'DESC')->get()->getResult(),
        ]);
    }

    public function store()
    {
        $validationRules = [
            'satuan' => 'required|is_unique[satuan.nama_satuan]',
        ];
    
        $validationMessages = [
            'required' => '{field} harus di isi.',
            'is_unique' => '{field} sudah ada dalam daftar satuan.',
        ];
    
        // Validate the input data
        if (!$this->validate($validationRules, $validationMessages)) {
            $validationErrors = implode(', ', $this->validator->getErrors());
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => $validationErrors]);
        }

        $this->satuan->insert(['nama_satuan' => $this->request->getVar('satuan')]);
        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Satuan berhasil ditambahkan']);
    }

    public function update($slug)
    {
        $validationRules = [
            'satuan' => 'required|is_unique[satuan.nama_satuan]',
        ];
    
        $validationMessages = [
            'required' => '{field} harus di isi.',
            'is_unique' => '{field} sudah ada dalam daftar satuan.',
        ];
    
        // Validate the input data
        if (!$this->validate($validationRules, $validationMessages)) {
            $validationErrors = implode(', ', $this->validator->getErrors());
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => $validationErrors]);
        }

        $existingSatuan = $this->satuan->where('slug', $slug)->first();
        if (!$existingSatuan) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'Satuan tidak ditemukan']);
        }

        $this->satuan->update($existingSatuan['id_satuan'], ['nama_satuan' => $this->request->getVar('satuan')]);
        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Satuan berhasil dirubah']);
    }

    public function delete($slug)
    {
        $existingSatuan = $this->satuan->where('slug', $slug)->first();
        if (!$existingSatuan) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'Satuan tidak ditemukan']);
        }

        // set status false to Satuan
        $this->satuan->update($existingSatuan['id_satuan'], ['status' => false]);

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Satuan berhasil dihapus']);
    }

    public function restore($slug)
    {
        $existingSatuan = $this->satuan->where('slug', $slug)->first();
        if (!$existingSatuan) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'Satuan tidak ditemukan']);
        }

        // set status true to satuan
        $this->satuan->update($existingSatuan['id_satuan'], ['status' => true]);

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Satuan berhasil di ambil dari tempat sampah']);
    }
}
