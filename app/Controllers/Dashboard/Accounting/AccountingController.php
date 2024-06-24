<?php 
namespace App\Controllers\Dashboard\Accounting;

use App\Controllers\BaseController;
use App\Models\{Accounting};
use Config\Database;
use TCPDF;

class AccountingController extends BaseController
{
    protected $transaksi, $db;

    public function __construct()
    {
        $this->transaksi = new Accounting();
        $this->db = Database::connect();
        session();
        helper('date');
    }

    public function jurnalumum()
    {
        $awal = $this->request->getVar('awal');
        $akhir = $this->request->getVar('akhir');
        
        $data = $this->transaksi->get_jurnalumum($awal, $akhir);

        return view('dashboard/accounting/jurnalumum', [
            'title' => 'Jurnal Umum',
            'hal' => 'accounting/jurnalumum',
            'data' => $data,
            'awal' => $awal ?? '',
            'akhir' => $akhir ?? '',
        ]);
    }

    public function jurnalumumpdf()
    {
        $awal = $this->request->getVar('awal');
        $akhir = $this->request->getVar('akhir');
        
        $data = $this->transaksi->get_jurnalumum($awal, $akhir);

        $html = view('dashboard/accounting/jurnalumumpdf', [
            'title' => 'Jurnal Umum',
            'hal' => 'accounting/jurnalumum',
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
        $pdf->SetMargins(25, 4, 3);

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('dejavusans', '', 8, '', true);

        // Print text using writeHTMLCell()
        $pdf->writeHTML($html, true, false, true, false, '');


        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $this->response->setContentType('application/pdf');
        $pdf->Output('Jurnal_Umum.pdf', 'I');
    }

    public function posting()
    {
        $awal = $this->request->getVar('awal');
        $akhir = $this->request->getVar('akhir');
        $category = $this->request->getVar('category');

        $data = $this->transaksi->get_posting($awal, $akhir, $category);

        return view('dashboard/accounting/posting', [
            'title' => 'Posting',
            'hal' => 'accounting/posting',
            'data' => $data,
            'awal' => $awal ?? '',
            'akhir' => $akhir ?? '',
            'category' => $category,
        ]);
    }

    public function postingpdf()
    {
        $awal = $this->request->getVar('awal');
        $akhir = $this->request->getVar('akhir');
        $category = $this->request->getVar('category');

        $data = $this->transaksi->get_posting($awal, $akhir, $category);

        $html = view('dashboard/accounting/postingpdf', [
            'title' => 'Posting',
            'hal' => 'accounting/posting',
            'data' => $data,
            'awal' => $awal ?? '',
            'akhir' => $akhir ?? '',
            'category' => $category,
        ]);

        // create new PDF document
        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set margins
        $pdf->SetMargins(10, 4, 3);

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('dejavusans', '', 8, '', true);

        // Print text using writeHTMLCell()
        $pdf->writeHTML($html, true, false, true, false, '');


        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $this->response->setContentType('application/pdf');
        $pdf->Output('Posting.pdf', 'I');
    }
}