<?php

namespace App\Controllers\Dashboard\Preference;

use App\Controllers\BaseController;
use App\Models\{Category};

class CategoryController extends BaseController
{
    protected $kategori;

    public function __construct()
    {
        $this->kategori = new Category();

        session();
    }

    public function index()
    {
        return view('dashboard/preference/rubrik', [
            'title' => 'Kategori',
            'hal' => 'preference/rubrik',
            'data' => $this->kategori->orderBy('id_kategori', 'DESC')->get()->getResult(),
        ]);
    }

    public function store()
    {
        $validationRules = [
            'rubrik' => 'required|is_unique[categories.nama_kategori]',
        ];
    
        $validationMessages = [
            'required' => '{field} harus di isi.',
            'is_unique' => '{field} sudah ada dalam daftar kategori.',
        ];
    
        // Validate the input data
        if (!$this->validate($validationRules, $validationMessages)) {
            $validationErrors = implode(', ', $this->validator->getErrors());
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => $validationErrors]);
        }

        $this->kategori->insert(['nama_kategori' => $this->request->getVar('rubrik')]);
        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Kategori berhasil ditambahkan']);
    }

    public function update($slug)
    {
        $validationRules = [
            'rubrik' => 'required|is_unique[categories.nama_kategori]',
        ];
    
        $validationMessages = [
            'required' => '{field} harus di isi.',
            'is_unique' => '{field} sudah ada dalam daftar kategori.',
        ];
    
        // Validate the input data
        if (!$this->validate($validationRules, $validationMessages)) {
            $validationErrors = implode(', ', $this->validator->getErrors());
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => $validationErrors]);
        }

        $existingRubrik = $this->kategori->where('slug', $slug)->first();
        if (!$existingRubrik) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'Kategori tidak ditemukan']);
        }

        $this->kategori->update($existingRubrik['id_kategori'], ['nama_kategori' => $this->request->getVar('rubrik')]);
        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Kategori berhasil dirubah']);
    }

    public function delete($slug)
    {
        $existingRubrik = $this->kategori->where('slug', $slug)->first();
        if (!$existingRubrik) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'Kategori tidak ditemukan']);
        }

        // set status false to kategori
        $this->kategori->update($existingRubrik['id_kategori'], ['status' => false]);

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Kategori berhasil dihapus']);
    }

    public function restore($slug)
    {
        $existingRubrik = $this->kategori->where('slug', $slug)->first();
        if (!$existingRubrik) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'Kategori tidak ditemukan']);
        }

        // set status true to kategori
        $this->kategori->update($existingRubrik['id_kategori'], ['status' => true]);

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Kategori berhasil di ambil dari tempat sampah']);
    }
}
