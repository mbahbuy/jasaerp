<?php 
namespace App\Controllers\Dashboard\Accounting;

use App\Controllers\BaseController;
use App\Models\{Accounting, Penyesuaian};
use Config\Database;
use TCPDF;

class NeracaController extends BaseController
{
    protected $umum, $db;

    public function __construct()
    {
        $this->umum = new Accounting();
        $this->db = Database::connect();
        session();
        helper('date');
    }

    public function saldo()
    {
        $awal = $this->request->getVar('awal');
        $akhir = $this->request->getVar('akhir');
        
        $data = $this->umum->get_neracasaldo($awal,$akhir);

        return view('dashboard/accounting/neracasaldo', [
            'title' => 'Neraca Saldo',
            'hal' => 'accounting/neraca/saldo',
            'data' => $data,
            'awal' => $awal ?? '',
            'akhir' => $akhir ?? '',
        ]);
    }

    public function saldopdf()
    {
        $awal = $this->request->getVar('awal');
        $akhir = $this->request->getVar('akhir');
        
        $data = $this->umum->get_neracasaldo($awal,$akhir);
        
        $html = view('dashboard/accounting/neracasaldopdf', [
            'title' => 'Neraca Saldo',
            'hal' => 'accounting/neraca/saldo/pdf',
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
        $pdf->SetFont('dejavusans', '', 12, '', true);

        // Print text using writeHTMLCell()
        $pdf->writeHTML($html, true, false, true, false, '');


        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $this->response->setContentType('application/pdf');
        $pdf->Output('Neraca_Saldo.pdf', 'I');
    }

    public function lajur()
    {
        $awal = $this->request->getVar('awal');
        $akhir = $this->request->getVar('akhir');

        $data = $this->umum->get_neracalajur($awal, $akhir);

        return view('dashboard/accounting/neracalajur', [
            'title' => 'Neraca Lajur',
            'hal' => 'accounting/neraca/lajur',
            'data' => $data,
            'awal' => $awal ?? '',
            'akhir' => $akhir ?? '',
        ]);
    
    }

    public function lajurpdf()
    {
        $awal = $this->request->getVar('awal');
        $akhir = $this->request->getVar('akhir');

        $data = $this->umum->get_neracalajur($awal, $akhir);

        $html = view('dashboard/accounting/neracalajurpdf', [
            'title' => 'Neraca Lajur',
            'hal' => 'accounting/neraca/lajur/pdf',
            'data' => $data,
            'awal' => $awal ?? '',
            'akhir' => $akhir ?? '',
        ]);

        // create new PDF document
        $pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set margins
        $pdf->SetMargins(20, 5, 4);

        // Add a page
        $pdf->AddPage();


        // set font
        $pdf->SetFont('times', 'BI', 9);

        // Print text using writeHTMLCell()
        $pdf->writeHTML($html, true, false, true, false, '');


        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $this->response->setContentType('application/pdf');
        $pdf->Output('Neraca_Lajur.pdf', 'I');

    }

}