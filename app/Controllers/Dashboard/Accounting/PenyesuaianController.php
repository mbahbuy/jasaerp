<?php 
namespace App\Controllers\Dashboard\Accounting;

use App\Controllers\BaseController;
use App\Models\{Penyesuaian};
use Config\Database;
use TCPDF;

class PenyesuaianController extends BaseController
{
    protected $transaksi, $db;

    public function __construct()
    {
        $this->transaksi = new Penyesuaian();
        $this->db = Database::connect();
        session();
        helper('date');
    }

    public function json()
    {
        $data = $this->transaksi->get_transaksipenyesuaian();

        return $this->response->setJSON($data);
    }

    public function index()
    {
        return view('dashboard/accounting/transaksi/penyesuaian', [
            'title' => 'Transaksi Penyesuaian',
            'hal' => 'transaksi/penyesuaian',
        ]);
    }

    public function store()
    {
        // Validation rules
        $validationRules = [
            'tanggal' => 'required|max_length[225]',
            'nilai' => 'required|max_length[225]',
            'waktu' => 'required|max_length[225]',
            'jumlah' => 'required|max_length[225]',
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
            'deskripsi' => $this->request->getVar('deskripsi') ?? '',
            'nilai' => $this->request->getVar('nilai'),
            'waktu' => $this->request->getVar('waktu'),
            'jumlah' => $this->request->getVar('jumlah'),
        ]);

        $id = $this->transaksi->insertID();
        $detail = json_decode($this->request->getVar('accounting'), true);

        // check bila ada kode akun kas
        $found = false;
        foreach ($detail as $item) {
            if (isset($item['category3_kode']) && $item['category3_kode'] == '1110') {
                $found = true;
                break;
            }
        }

        foreach ($detail as $d) {
            $this->db->table('penyesuaian_detail')->insert([
                'penyesuaian_id' => $id,
                'category3_kode' => (int)$d['category3_kode'],
                'debit' => (int)$d['debit'],
                'kredit' => (int)$d['kredit'],
            ]);

            // jika terdapat kode akun kas
            if ($found) {
                if ($d['category3_kode'] != '1110') {
                    //    masukkan semua data kode akun selain kas
                    $this->transaksi->insert_arus_kas($this->request->getVar('tanggal'), $d['category3_kode'], $d['kredit'], $d['debit'], ($this->request->getVar('deskripsi') ?? ''));
                }
            }
        }

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'data akuntansi telah disimpan']);
    }

    public function update($ID)
    {
        // Validation rules
        $validationRules = [
            'tanggal' => 'required|max_length[225]',
            'nilai' => 'required|max_length[225]',
            'waktu' => 'required|max_length[225]',
            'jumlah' => 'required|max_length[225]',
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

        $existingData = $this->transaksi->find($ID);
        if (!$existingData) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'Data transaksi tidak ditemukan']);
        }

        $updateStatus = false;
        $dataUpdate = [];

        if ($existingData['tanggal'] !== $this->request->getVar('tanggal')) {
            $dataUpdate['tanggal'] = $this->request->getVar('tanggal');
            $updateStatus = true;
        }

        if ($existingData['nilai'] !== $this->request->getVar('nilai')) {
            $dataUpdate['nilai'] = $this->request->getVar('nilai');
            $updateStatus = true;
        }

        if ($existingData['waktu'] !== $this->request->getVar('waktu')) {
            $dataUpdate['waktu'] = $this->request->getVar('waktu');
            $updateStatus = true;
        }

        if ($existingData['jumlah'] !== $this->request->getVar('jumlah')) {
            $dataUpdate['jumlah'] = $this->request->getVar('jumlah');
            $updateStatus = true;
        }

        if ($existingData['deskripsi'] !== $this->request->getVar('deskripsi')) {
            $dataUpdate['deskripsi'] = $this->request->getVar('deskripsi');
            $updateStatus = true;
        }

        if ($updateStatus) {
            $this->transaksi->update($ID, $dataUpdate);
        }
        $detail = json_decode($this->request->getVar('accounting'), true);
        if (count($detail)) {

            // check bila ada kode akun kas
            $found = false;
            foreach ($detail as $item) {
                if (isset($item['category3_kode']) && $item['category3_kode'] == '1110') {
                    $found = true;
                    break;
                }
            }

            // delete data lama
            if ($found) {
                $oldFound = $this->db->table('penyesuaian_detail')->where('penyesuaian_id', $ID)->get()->getResultArray();
                foreach ($oldFound as $of) {
                    if ($of['category3_kode'] != 1110) {
                        $this->db->table('arus_kas')->where('tanggal', ($existingData['tanggal'] !== $this->request->getVar('tanggal') ? $this->request->getVar('tanggal') : $existingData['tanggal']))->where('debit', $of['kredit'])->where('kredit', $of['debit'])->delete();
                    }
                }
            }

            $this->db->table('penyesuaian_detail')->where('penyesuaian_id', $ID)->delete();

            foreach ($detail as $d) {
                $this->db->table('penyesuaian_detail')->insert([
                    'penyesuaian_id' => $ID,
                    'category3_kode' => (int)$d['category3_kode'],
                    'debit' => (int)$d['debit'],
                    'kredit' => (int)$d['kredit'],
                ]);

                // jika terdapat kode akun kas
                if ($found) {
                    if ($d['category3_kode'] != '1110') {
                        //    masukkan semua data kode akun selain kas
                        $this->transaksi->insert_arus_kas(($existingData['tanggal'] !== $this->request->getVar('tanggal') ? $this->request->getVar('tanggal') : $existingData['tanggal']), $d['category3_kode'], $d['kredit'], $d['debit'], ($dataUpdate['deskripsi'] ?? $existingData['bukti']));
                    }
                }
            }
        }

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'data perubahan akuntansi telah disimpan']);
    }

    public function delete($ID)
    {
        $existingData = $this->transaksi->find($ID);
        if (!$existingData) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'Data transaksi tidak ditemukan']);
        }

        $this->transaksi->delete($ID);
        $this->db->table('penyesuaian_detail')->where('penyesuaian_id', $ID)->delete();

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'data akuntansi telah dihapus']);
    }

    public function jurnal()
    {
        $awal = $this->request->getVar('awal');
        $akhir = $this->request->getVar('akhir');

        $data = $this->transaksi->get_jurnalpenyesuaian($awal, $akhir);

        return view('dashboard/accounting/jurnalpenyesuaian', [
            'title' => 'jurnal Penyesuaian',
            'hal' => 'accounting/jurnalpenyesuaian',
            'data' => $data,
            'awal' => $awal,
            'akhir' => $akhir,
        ]);
    }

    public function jurnalpdf()
    {
        $awal = $this->request->getVar('awal');
        $akhir = $this->request->getVar('akhir');

        $data = $this->transaksi->get_jurnalpenyesuaian($awal, $akhir);

        $html = view('dashboard/accounting/jurnalpenyesuaianpdf', [
            'title' => 'jurnal Penyesuaian',
            'hal' => 'Accounting/jurnalpenyesuaian',
            'data' => $data,
            'awal' => $awal,
            'akhir' => $akhir,
        ]);

        // create new PDF document
        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set margins
        $pdf->SetMargins(30, 5, 4);

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('dejavusans', '', 8, '', true);

        // Print text using writeHTMLCell()
        $pdf->writeHTML($html, true, false, true, false, '');


        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $this->response->setContentType('application/pdf');
        $pdf->Output('Jurnal_Penyesuaian.pdf', 'I');
    }
}