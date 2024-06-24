<?php 
namespace App\Controllers\Dashboard\Accounting;

use App\Controllers\BaseController;
use App\Models\{Accounting};
use Config\Database;

class JurnalController extends BaseController
{
    protected $transaksi, $db;

    public function __construct()
    {
        $this->transaksi = new Accounting();
        $this->db = Database::connect();
        session();
    }

    public function json()
    {
        $data = $this->transaksi->get_transaksiumum();
        return $this->response->setJSON($data);
    }

    public function index()
    {
        return view('dashboard/accounting/transaksi/umum', [
            'title' => 'Transaksi Umum',
            'hal' => 'transaksi/umum',
        ]);
    }

    public function store()
    {
        // Validation rules
        $validationRules = [
            'tanggal' => 'required|max_length[225]',
            'kwitansi' => 'max_length[225]',
            'deskripsi' => 'required',
            'accounting' => 'required|valid_json',
        ];

        $validationMessages = [
            'required' => '{field} harus di isi.',
            'valid_json' => '{field} bukanlah data JSON.',
        ];

        // Validate the input data
        if (!$this->validate($validationRules, $validationMessages)) {
            $validationErrors = implode(', ', $this->validator->getErrors());
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => $validationErrors]);
        }

        // save data
        $this->transaksi->save([
            'gudang_id' => $this->transaksi->get_selected_gudang_id(),
            'tanggal' => $this->request->getVar('tanggal'),
            'bukti' => $this->request->getVar('kwitansi'),
            'deskripsi' => $this->request->getVar('deskripsi'),
        ]);

        $id = $this->transaksi->insertID();
        $detail = json_decode($this->request->getVar('accounting'), true);

        // check bila ada kode akun kas
        $found = false;
        foreach ($detail as $item) {
            if ((int)$item['category3_kode'] == $this->transaksi->get_kode_akun3_like('kas')) {
                $found = true;
                break;
            }
        }

        // insert data to accounting detail
        foreach ($detail as $d) {
            $this->db->table('accounting_detail')->insert([
                'accounting_id' => $id,
                'category3_kode' => (int)$d['category3_kode'],
                'debit' => (int)$d['debit'],
                'kredit' => (int)$d['kredit'],
            ]);

            // If there is an account code of '1110'
            if ($found && (int)$d['category3_kode'] != $this->transaksi->get_kode_akun3_like('kas')) {
                // Insert all account codes except '1110' to arus_kas
                $this->transaksi->insert_arus_kas($this->request->getVar('tanggal'), $d['category3_kode'], $d['kredit'], $d['debit'], ($this->request->getVar('deskripsi') ?? ''));
            }
        }

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => "data akuntansi telah disimpan."]);
    }

    public function update($ID)
    {
        // Validation rules
        $validationRules = [
            'tanggal' => 'required|max_length[225]',
            'kwitansi' => 'max_length[225]',
            'deskripsi' => 'required',
            'accounting' => 'required|valid_json',
        ];
    
        // Validation messages
        $validationMessages = [
            'tanggal' => [
                'required' => 'Tanggal harus diisi.',
                'max_length' => 'Tanggal tidak boleh melebihi 225 karakter.',
            ],
            'kwitansi' => [
                'max_length' => 'Kwitansi tidak boleh melebihi 225 karakter.',
            ],
            'deskripsi' => [
                'required' => 'Deskripsi harus diisi.',
            ],
            'accounting' => [
                'required' => 'Accounting harus diisi.',
                'valid_json' => 'Accounting bukanlah data JSON.',
            ],
        ];
    
        // Validate the input data
        if (!$this->validate($validationRules, $validationMessages)) {
            $validationErrors = implode(', ', $this->validator->getErrors());
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => $validationErrors]);
        }
    
        // Check if the existing data is present
        $existingData = $this->transaksi->find($ID);
        if (!$existingData) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'Data transaksi tidak ditemukan']);
        }
    
        // Prepare the data for update
        $dataUpdate = [];
        $updateStatus = false;
    
        if ($existingData['tanggal'] !== $this->request->getVar('tanggal')) {
            $dataUpdate['tanggal'] = $this->request->getVar('tanggal');
            $updateStatus = true;
        }
    
        if ($existingData['bukti'] !== $this->request->getVar('kwitansi')) {
            $dataUpdate['bukti'] = $this->request->getVar('kwitansi');
            $updateStatus = true;
        }
    
        if ($existingData['deskripsi'] !== $this->request->getVar('deskripsi')) {
            $dataUpdate['deskripsi'] = $this->request->getVar('deskripsi');
            $updateStatus = true;
        }
    
        // Update the main transaction data if there are changes
        if ($updateStatus) {
            $this->transaksi->update($ID, $dataUpdate);
        }
    
        // Update the accounting details
        $detail = json_decode($this->request->getVar('accounting'), true);
        if (is_array($detail) && count($detail)) {
            // check bila ada kode akun kas
            $found = false;
            foreach ($detail as $i) {
                if ((int)$i['category3_kode'] == $this->transaksi->get_kode_akun3_like('kas')) {
                    $found = true;
                    break;
                }
            }
            
            // delete data lama
            if ($found) {
                $oldFound = $this->db->table('accounting_detail')->where('accounting_id', $ID)->get()->getResultArray();
                foreach ($oldFound as $of) {
                    if ($of['category3_kode'] != $this->transaksi->get_kode_akun3_like('kas')) {
                        $this->db->table('arus_kas')->where('tanggal', $existingData['tanggal'])->where('debit', $of['kredit'])->where('kredit', $of['debit'])->delete();
                    }
                }
            }
            $this->db->table('accounting_detail')->where('accounting_id', $ID)->delete();
    
            foreach ($detail as $d) {
                $this->db->table('accounting_detail')->insert([
                    'accounting_id' => $ID,
                    'category3_kode' => (int)$d['category3_kode'],
                    'debit' => (int)$d['debit'],
                    'kredit' => (int)$d['kredit'],
                ]);
    
                // jika terdapat kode akun kas
                if ($found) {
                    if ($d['category3_kode'] != $this->transaksi->get_kode_akun3_like('kas')) {
                        // masukkan semua data kode akun selain kas
                        $this->transaksi->insert_arus_kas(($dataUpdate['tanggal'] ?? $existingData['tanggal']), $d['category3_kode'], $d['kredit'], $d['debit'], ($dataUpdate['deskripsi'] ?? $existingData['deskripsi']));
                    }
                }
            }
        }
    
        // Return success message
        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Data perubahan akuntansi telah disimpan']);
    }
    

    public function delete($ID)
    {
        $existingData = $this->transaksi->find($ID);
        if (!$existingData) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'Data transaksi tidak ditemukan']);
        }

        $this->transaksi->delete($ID);
        $this->db->table('accounting_detail')->where('accounting_id', $ID)->delete();

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'data akuntansi telah dihapus']);
    }
}