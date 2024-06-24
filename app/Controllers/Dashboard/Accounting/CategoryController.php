<?php 
namespace App\Controllers\Dashboard\Accounting;

use App\Controllers\BaseController;
use App\Models\Accounting;
use Config\Database;

class CategoryController extends BaseController
{
    protected $db, $transaksi;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->transaksi = new Accounting();
        session();
    }

    public function index()
    {
        $category1 = $this->db->table('accounting_category1')->get()->getResult();
        $category2 = $this->db->table('accounting_category2 c2')
            ->select('c2.id, c2.kode, c2.name, c2.detail, c1.name AS category1, c1.kode AS category1_kode, c1.id AS category1_id')
            ->join('accounting_category1 c1', 'c1.kode=c2.category1_kode', 'left')
            ->get()->getResult();
        $category3 = $this->db->table('accounting_category3 c3')
            ->select('c3.id, c3.kode, c3.name, c3.detail, c1.name AS category1, c1.kode AS category1_kode, c1.id AS category1_id, c2.name AS category2, c2.kode AS category2_kode, c2.id AS category2_id')
            ->join('accounting_category1 c1', 'c1.kode=c3.category1_kode', 'left')
            ->join('accounting_category2 c2', 'c2.kode=c3.category2_kode', 'left')
            ->get()->getResult();

        $periode = $this->transaksi->periode();
                    
        return view('dashboard/accounting/category', [
            'title' => 'Accounting Category',
            'hal' => 'accounting/category',
            'category1' => $category1,
            'category2' => $category2,
            'category3' => $category3,
            'awal_periode' => $periode['awal'],
            'akhir_periode' => $periode['akhir'],
        ]);
    }

    // category1
    public function json1()
    {
        $category1 = $this->db->table('accounting_category1')->get()->getResultArray();
        return $this->response->setJSON($category1);
    }

    public function storec1()
    {
        $validationRules = [
            'category1' => 'required|is_unique[accounting_category1.name]',
            'category1_kode' => 'required|is_unique[accounting_category1.kode]',
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

        $this->db->table('accounting_category1')->insert(['name' => $this->request->getVar('category1'), 'kode' => $this->request->getVar('category1_kode')]);
        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Kategori berhasil ditambahkan']);
    }

    public function updatec1($id)
    {
        // Define validation rules
        $validationRules = [
            'category1' => "required|is_unique[accounting_category1.name,id,{$id}]",
            'category1_kode' => "required|is_unique[accounting_category1.kode,id,{$id}]",
        ];
    
        // Define validation messages
        $validationMessages = [
            'category1' => [
                'required' => 'Nama kategori harus diisi.',
                'is_unique' => 'Nama kategori sudah ada dalam daftar kategori.',
            ],
            'category1_kode' => [
                'required' => 'Kode kategori harus diisi.',
                'is_unique' => 'Kode kategori sudah ada dalam daftar kategori.',
            ],
        ];
    
        // Validate the input data
        if (!$this->validate($validationRules, $validationMessages)) {
            $validationErrors = implode(', ', $this->validator->getErrors());
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => $validationErrors]);
        }
    
        // Check if the category exists
        $existingC1 = $this->db->table('accounting_category1')->where('id', $id)->get()->getRowArray();
        if (!$existingC1) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'Kategori tidak ditemukan']);
        }
    
        // Update the category
        $this->db->table('accounting_category1')->update([
            'name' => $this->request->getVar('category1'),
            'kode' => $this->request->getVar('category1_kode')
        ], ['id' => $id]);
    
        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Kategori berhasil diubah']);
    }    

    public function deletec1($id)
    {
        $existingC1 = $this->db->table('accounting_category1')->where('id', $id)->get()->getRowArray();
        if (!$existingC1) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'Kategori tidak ditemukan']);
        }

        // set status false to kategori
        $this->db->table('accounting_category1')->delete(['id' => $id]);
        $this->db->table('accounting_category2')->where(['category1_kode' => $existingC1['kode']])->delete();
        $this->db->table('accounting_category3')->where(['category1_kode' => $existingC1['kode']])->delete();

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Kategori berhasil dihapus']);
    }

    // category2
    public function json2()
    {
        $category2 = $this->db->table('accounting_category2 c2')
        ->select('c2.id, c2.kode, c2.name, c2.detail, c1.name AS category1, c1.kode AS category1_kode, c1.id AS category1_id')
        ->join('accounting_category1 c1', 'c1.kode=c2.category1_kode', 'left')
        ->get()->getResult();
        return $this->response->setJSON($category2);
    }

    public function storec2()
    {
        $validationRules = [
            'category1' => 'required',
            'category2' => 'required|is_unique[accounting_category2.name]',
            'category2_kode' => 'required|is_unique[accounting_category2.kode]',
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

        $this->db->table('accounting_category2')->insert(['category1_kode' => $this->request->getVar('category1'),'name' => $this->request->getVar('category2'), 'kode' => $this->request->getVar('category2_kode')]);
        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Kategori berhasil ditambahkan']);
    }

    public function updatec2($id)
    {
        $validationRules = [
            'category1' => 'required',
            'category2' => "required|is_unique[accounting_category2.name,id,{$id}]",
            'category2_kode' => "required|is_unique[accounting_category2.kode,id,{$id}]",
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

        $existingC2 = $this->db->table('accounting_category2')->where('id', $id)->get()->getRowArray();
        if (!$existingC2) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'Kategori tidak ditemukan']);
        }

        $this->db->table('accounting_category2')->update([
            'category1_kode' => $this->request->getVar('category1'),
            'name' => $this->request->getVar('category2'),
            'kode' => $this->request->getVar('category2_kode')
        ], ['id' => $id]);
        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Kategori berhasil dirubah']);
    }

    public function deletec2($id)
    {
        $existingC2 = $this->db->table('accounting_category2')->where('id', $id)->get()->getRowArray();
        if (!$existingC2) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'Kategori tidak ditemukan']);
        }

        // set status false to kategori
        $this->db->table('accounting_category2')->delete(['id' => $id]);
        $this->db->table('accounting_category3')->where(['category2_kode' => $existingC2['kode']])->delete();

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Kategori berhasil dihapus']);
    }

    // category3
    public function json3()
    {
        $category3 = $this->db->table('accounting_category3 c3')
        ->select('c3.id, c3.kode, c3.name, c3.detail, c1.name AS category1, c1.kode AS category1_kode, c1.id AS category1_id, c2.name AS category2, c2.kode AS category2_kode, c2.id AS category2_id')
        ->join('accounting_category1 c1', 'c1.kode=c3.category1_kode', 'left')
        ->join('accounting_category2 c2', 'c2.kode=c3.category2_kode', 'left')
        ->get()->getResult();
        return $this->response->setJSON($category3);
    }

    public function storec3()
    {
        $validationRules = [
            'category1' => 'required',
            'category2' => 'required',
            'category3' => 'required|is_unique[accounting_category3.name]',
            'category3_kode' => 'required|is_unique[accounting_category3.kode]',
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

        $this->db->table('accounting_category3')->insert([
            'category1_kode' => $this->request->getVar('category1'),
            'category2_kode' => $this->request->getVar('category2'),
            'name' => $this->request->getVar('category3'),
            'kode' => $this->request->getVar('category3_kode'),
        ]);
        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Kategori berhasil ditambahkan']);
    }

    public function updatec3($id)
    {
        $validationRules = [
            'category1' => 'required',
            'category2' => 'required',
            'category3' => "required|is_unique[accounting_category3.name,id,{$id}]",
            'category3_kode' => "required|is_unique[accounting_category3.kode,id,{$id}]",
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

        $existingC3 = $this->db->table('accounting_category3')->where('id', $id)->get()->getRowArray();
        if (!$existingC3) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'Kategori tidak ditemukan']);
        }

        $this->db->table('accounting_category3')->update([
            'category1_kode' => $this->request->getVar('category1'),
            'category2_kode' => $this->request->getVar('category2'),
            'name' => $this->request->getVar('category3'),
            'kode' => $this->request->getVar('category3_kode'),
        ],['id' => $id]);
        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Kategori berhasil dirubah']);
    }

    public function deletec3($id)
    {
        $existingC3 = $this->db->table('accounting_category3')->where('id', $id)->get()->getRowArray();
        if (!$existingC3) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'Kategori tidak ditemukan']);
        }

        // set status false to kategori
        $this->db->table('accounting_category3')->delete(['id' => $id]);

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Kategori berhasil dihapus']);
    }

    public function periode()
    {
        $validationRules = [
            'awal' => 'required',
            'akhir' => 'required',
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

        $awal = $this->request->getVar('awal');
        $akhir = $this->request->getVar('akhir');

        $this->db->table('accounting_periode')->where('type', 1)->orWhere('type', 2)->delete();

        $data = [
            [
                'type' => 1,
                'tanggal' => $awal,
            ],[
                'type' => 2,
                'tanggal' => $akhir,
            ],
        ];
        $this->db->table('accounting_periode')->insertBatch($data);

        return redirect()->back()->with('message','Periode tersimpan');
    }
}
