<?php 
namespace App\Controllers\Dashboard\Accounting;

use App\Controllers\BaseController;
use App\Models\{Accounting};
use Config\Database;
use TCPDF;

class LaporanController extends BaseController
{
    protected $umum, $db;

    public function __construct()
    {
        $this->umum = new Accounting();
        $this->db = Database::connect();
        session();
        helper('date');
    }

    public function persediaan()
    {
        $awal = $this->request->getVar('awal');
        $akhir = $this->request->getVar('akhir');
        
        $data = $this->umum->get_laporan_persediaan_barang($awal, $akhir);

        return view('dashboard/accounting/laporan/persediaan', [
            'title' => 'Laporan Persediaan Barang',
            'hal' => 'laporan/persediaan',
            'data' => $data,
            'awal' => $awal ?? '',
            'akhir' => $akhir ?? '',
        ]);
    }

    public function persediaanpdf()
    {
        $awal = $this->request->getVar('awal');
        $akhir = $this->request->getVar('akhir');
        
        $data = $this->umum->get_laporan_persediaan_barang($awal, $akhir);

        $html = view('dashboard/accounting/laporan/persediaanpdf', [
            'title' => 'Laporan Persediaan Barang',
            'hal' => 'laporan/persediaan',
            'data' => $data,
            'awal' => $awal ?? '',
            'akhir' => $akhir ?? '',
        ]);

        // create new PDF document
        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set margins
        $pdf->SetMargins(20, 4, 3);

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('dejavusans', '', 8, '', true);

        // Print text using writeHTMLCell()
        $pdf->writeHTML($html, true, false, true, false, '');


        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $this->response->setContentType('application/pdf');
        $pdf->Output('Laporan_arus_barang.pdf', 'I');
    }

    public function labarugi()
    {
        $awal = $this->request->getVar('awal');
        $akhir = $this->request->getVar('akhir');

        $data = $this->umum->get_laporan_labarugi($awal, $akhir);

        return view('dashboard/accounting/laporan/labarugi', [
            'title' => 'Laporan Laba Rugi',
            'hal' => 'laporan/labarugi',
            'data' => $data,
            'awal' => $awal ?? '',
            'akhir' => $akhir ?? '',
        ]);
    }

    public function labarugipdf()
    {
        $awal = $this->request->getVar('awal');
        $akhir = $this->request->getVar('akhir');

        $data = $this->umum->get_laporan_labarugi($awal, $akhir);

        $html = view('dashboard/accounting/laporan/labarugipdf', [
            'title' => 'Laporan Laba Rugi',
            'hal' => 'laporan/labarugi',
            'data' => $data,
            'awal' => $awal ?? '',
            'akhir' => $akhir ?? '',
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
        $pdf->Output('Laporan_laba_rugi.pdf', 'I');
    }

    public function modal()
    {
        $awal = $this->request->getVar('awal');
        $akhir = $this->request->getVar('akhir');

        $data = $this->umum->get_laporan_perubahanmodal($awal, $akhir);

        return view('dashboard/accounting/laporan/modal', [
            'title' => 'Laporan Perubahan Modal',
            'hal' => 'laporan/modal',
            'data' => $data,
            'awal' => $awal ?? '',
            'akhir' => $akhir ?? '',
        ]); 
    }

    public function modalpdf()
    {
        $awal = $this->request->getVar('awal');
        $akhir = $this->request->getVar('akhir');

        $data = $this->umum->get_laporan_perubahanmodal($awal, $akhir);

        $html = view('dashboard/accounting/laporan/modalpdf', [
            'title' => 'Laporan Perubahan Modal',
            'hal' => 'laporan/modal',
            'data' => $data,
            'awal' => $awal ?? '',
            'akhir' => $akhir ?? '',
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
        $pdf->Output('Laporan_perubahan_modal.pdf', 'I');
    }

    public function neraca()
    {
        $awal = $this->request->getVar('awal');
        $akhir = $this->request->getVar('akhir');

        $data = $this->umum->get_laporan_neraca($awal, $akhir);

        return view('dashboard/accounting/laporan/neraca', [
            'title' => 'Laporan Neraca',
            'hal' => 'laporan/neraca',
            'data' => $data,
            'awal' => $awal ?? '',
            'akhir' => $akhir ?? '',
        ]);
    }

    public function neracapdf()
    {
        $awal = $this->request->getVar('awal');
        $akhir = $this->request->getVar('akhir');

        $data = $this->umum->get_laporan_neraca($awal, $akhir);

        $html = view('dashboard/accounting/laporan/neracapdf', [
            'title' => 'Laporan Neraca',
            'hal' => 'laporan/neraca',
            'data' => $data,
            'awal' => $awal ?? '',
            'akhir' => $akhir ?? '',
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
        $pdf->Output('Laporan_neraca.pdf', 'I');
    }

    public function kas()
    {
        $awal = $this->request->getVar('awal');
        $akhir = $this->request->getVar('akhir');

        $data = $this->umum->get_laporan_arus_kas($awal, $akhir);

        return view('dashboard/accounting/laporan/kas', [
            'title' => 'Laporan Arus Kas',
            'hal' => 'laporan/kas',
            'data' => $data,
            'awal' => $awal ?? '',
            'akhir' => $akhir ?? '',
        ]);
    }

    public function kaspdf()
    {
        $awal = $this->request->getVar('awal');
        $akhir = $this->request->getVar('akhir');

        $data = $this->umum->get_laporan_arus_kas($awal, $akhir);

        $html = view('dashboard/accounting/laporan/kaspdf', [
            'title' => 'Laporan Arus Kas',
            'hal' => 'laporan/kas',
            'data' => $data,
            'awal' => $awal ?? '',
            'akhir' => $akhir ?? '',
        ]);

        // create new PDF document
        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set margins
        $pdf->SetMargins(20, 4, 3);

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('dejavusans', '', 8, '', true);

        // Print text using writeHTMLCell()
        $pdf->writeHTML($html, true, false, true, false, '');


        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $this->response->setContentType('application/pdf');
        $pdf->Output('Laporan_arus_kas.pdf', 'I');
    }
}
