<?php 
namespace App\Models;

use CodeIgniter\Model;

class Accounting extends Model{
    protected $table      = 'accounting';
    protected $primaryKey     = 'id';
    protected $useTimestamps   = true;
    protected $useSoftDeletes = false; // Set to true if you're using soft deletes
    protected $allowedFields  = [
        'gudang_id', 'tanggal', 'deskripsi', 'bukti', 'status', 
    ];

    public function get_selected_gudang_id()
    {
        $row = $this->db->table('selected_gudang')->select('gudang_id')->where('status', true)->get()->getRowObject();
        return (int)$row->gudang_id;
    }

    public function periode()
    {
        $dataRow = $this->db->table('accounting_periode')->select('tanggal');
        $data['awal'] = $dataRow->where('type', 1)->get()->getFirstRow();
        $data['akhir'] = $dataRow->where('type', 2)->get()->getFirstRow();

        return $data;
    }

    public function get_kode_akun3_like($name)
    {
        $row = $this->db->table('accounting_category3')->select('kode')->like('name', $name)->get()->getRowObject();
        return (int)$row->kode;
    }

    // Function to insert into arus_kas
    public function insert_arus_kas($tanggal, $kode, $debit, $kredit, $deskripsi = null)
    {
        $this->db->table('arus_kas')->insert([
            'gudang_id' => $this->get_selected_gudang_id(),
            'tanggal' => $tanggal,
            'category3_kode' => (int)$kode,
            'debit' => (int)$debit,
            'kredit' => (int)$kredit,
            'deskripsi' => $deskripsi,
        ]);
    }
    
    public function get_transaksiumum()
    {
        $periode = $this->periode();
        $data = $this->db->table($this->table)->where('tanggal >=', $periode['awal']->tanggal)->where('tanggal <=', $periode['akhir']->tanggal)->where('gudang_id', $this->get_selected_gudang_id())->get()->getResultArray();
        if (count($data)) {
            for ($i=0; $i < count($data); $i++) {
                $dataDetail = $this->db->table('accounting_detail ad')
                    ->select('ad.debit, ad.kredit, ad.category3_kode as kode, ac3.name AS name,')
                    ->join('accounting_category3 ac3', 'ac3.kode = ad.category3_kode', 'left')
                    ->where('ad.accounting_id', $data[$i]['id'])
                    ->get()->getResultArray();
                $data[$i]['detail'] = $dataDetail;
            }
        }

        return $data;
    }

    public function get_jurnalumum($awal = null, $akhir = null)
    {
        $dataRow = $this->db->table('accounting_detail ad')
            ->select('ad.debit, ad.kredit, ad.category3_kode, ac3.name AS category3_name, a.tanggal, a.status, a.deskripsi')
            ->join('accounting a', 'a.id=ad.accounting_id', 'inner')
            ->join('accounting_category3 ac3', 'ac3.kode = ad.category3_kode', 'left')
            ->where('a.status', true)
            ->where('a.gudang_id', $this->get_selected_gudang_id())
            ->orderBy('a.tanggal', 'ASC')
            ->orderBy('a.id', 'ASC');

        if ($awal && $akhir) {
            $dataRow->where('a.tanggal >=', $awal)
                    ->where('a.tanggal <=', $akhir);
        } else {
            $periode = $this->periode();
            $dataRow->where('a.tanggal >=', $periode['awal']->tanggal)->where('a.tanggal <=',$periode['akhir']->tanggal);
        }

        $data = $dataRow->get()->getResultArray();
        return $data;
    }

    public function get_posting($awal = null, $akhir = null, $category = null)
    {
        $dataRow = $this->db->table('accounting_detail ad')
        ->select('ad.debit, ad.kredit, ad.category3_kode, ac3.name AS category3_name, a.tanggal, a.status, a.deskripsi')
        ->join('accounting a', 'a.id=ad.accounting_id')
        ->join('accounting_category3 ac3', 'ac3.kode = ad.category3_kode')
        ->where('a.status', true)
        ->where('a.gudang_id', $this->get_selected_gudang_id())
        ->orderBy('a.tanggal', 'ASC')
        ->orderBy('a.id', 'ASC');

        if ($awal && $akhir) {
            $dataRow->where('a.tanggal >=', $awal)
                    ->where('a.tanggal <=', $akhir);
        } else {
            $periode = $this->periode();
            $dataRow->where('a.tanggal >=', $periode['awal']->tanggal)->where('a.tanggal <=',$periode['akhir']->tanggal);
        }

        if ($category) {
            $dataRow->where('ad.category3_kode', $category);
        } else {
            $kodeCategory3 = $this->db->table('accounting_category3')->like('name', 'kas')->get()->getFirstRow();
            $dataRow->where('ad.category3_kode', $kodeCategory3->kode);
        }

        $data = $dataRow->get()->getResultArray();
        return $data;
    }

    public function get_neracasaldo($awal = null, $akhir = null)
    {
        $dataRow = $this->db->table('accounting_detail ad')
            ->select('ad.category3_kode, ac3.name AS category3_name')
            ->join('accounting_category3 ac3', 'ac3.kode = ad.category3_kode')
            ->join('accounting a', 'a.id = ad.accounting_id', 'left')
            ->where('a.gudang_id', $this->get_selected_gudang_id())
            ->selectSum('ad.debit', 'jumdebit')
            ->selectSum('ad.kredit', 'jumkredit')
            ->groupBy('ad.category3_kode, ac3.name'); 
        
            if ($awal && $akhir) {
                $dataRow->where('a.tanggal >=', $awal)
                        ->where('a.tanggal <=', $akhir);
            } else {
                $periode = $this->periode();
                $dataRow->where('a.tanggal >=', $periode['awal']->tanggal)->where('a.tanggal <=',$periode['akhir']->tanggal);
            }

  
        $data = $dataRow->get()->getResultArray();

        return $data;
    }

    public function get_neracalajur($awal = null, $akhir = null)
    {
        // First subquery
        $subquery1Row = $this->db->table('accounting_detail as ad')
            ->select('ad.category3_kode as kode, ac3.name, SUM(ad.debit) as jumdebit, SUM(ad.kredit) as jumkredit, 0 as jumdebits, 0 as jumkredits')
            ->join('accounting as a', 'a.id = ad.accounting_id', 'left')
            ->join('accounting_category3 as ac3', 'ac3.kode = ad.category3_kode')
            ->where('a.gudang_id', $this->get_selected_gudang_id())
            ->groupBy('ac3.name, ad.category3_kode');

        // Second subquery
        $subquery2Row = $this->db->table('penyesuaian_detail as pd')
            ->select('pd.category3_kode as kode, ac3.name, 0 as jumdebit, 0 as jumkredit, SUM(pd.debit) as jumdebits, SUM(pd.kredit) as jumkredits')
            ->join('penyesuaian as p', 'p.id = pd.penyesuaian_id', 'right')
            ->join('accounting_category3 as ac3', 'ac3.kode = pd.category3_kode')
            ->where('p.gudang_id', $this->get_selected_gudang_id())
            ->groupBy('ac3.name, pd.category3_kode');
        
        if ($awal && $akhir) {
            $subquery1Row
                ->where('a.tanggal >=', $awal)
                ->where('a.tanggal <=', $akhir);

            $subquery2Row
                ->where('p.tanggal >=', $awal)
                ->where('p.tanggal <=', $akhir);
        } else {
            $periode = $this->periode();
            $subquery1Row
                ->where('a.tanggal >=', $periode['awal']->tanggal)
                ->where('a.tanggal <=', $periode['akhir']->tanggal);

            $subquery2Row
                ->where('p.tanggal >=', $periode['awal']->tanggal)
                ->where('p.tanggal <=', $periode['akhir']->tanggal);
        }

        $subquery1 = $subquery1Row->getCompiledSelect();
        $subquery2 = $subquery2Row->getCompiledSelect();

        // Main query
        $sql = $this->db->query("
                SELECT 
                    tbl_new.kode,
                    tbl_new.name, 
                    SUM(tbl_new.jumdebit) as total_debit,
                    SUM(tbl_new.jumkredit) as total_kredit,
                    SUM(tbl_new.jumdebits) as total_debits,
                    SUM(tbl_new.jumkredits) as total_kredits
                FROM (
                    $subquery1
    
                    UNION ALL
    
                    $subquery2
    
                ) as tbl_new 
                GROUP BY tbl_new.kode, tbl_new.name
        ");


        $data = $sql->getResultArray();
        return $data;
    }

    public function get_laporan_labarugi($awal = null, $akhir = null)
    {
        // First subquery
        $subquery1Row = $this->db->table('accounting_detail as ad')
            ->select('ad.category3_kode as kode, ac3.name, SUM(ad.debit) as jumdebit, SUM(ad.kredit) as jumkredit, 0 as jumdebits, 0 as jumkredits')
            ->join('accounting as a', 'a.id = ad.accounting_id', 'left')
            ->join('accounting_category3 as ac3', 'ac3.kode = ad.category3_kode')
            ->where('a.gudang_id', $this->get_selected_gudang_id())
            ->groupBy('ac3.name, ad.category3_kode');

        // Second subquery
        $subquery2Row = $this->db->table('penyesuaian_detail as pd')
            ->select('pd.category3_kode as kode, ac3.name, 0 as jumdebit, 0 as jumkredit, SUM(pd.debit) as jumdebits, SUM(pd.kredit) as jumkredits')
            ->join('penyesuaian as p', 'p.id = pd.penyesuaian_id', 'right')
            ->join('accounting_category3 as ac3', 'ac3.kode = pd.category3_kode')
            ->where('p.gudang_id', $this->get_selected_gudang_id())
            ->groupBy('ac3.name, pd.category3_kode');
        
            if ($awal && $akhir) {
                $subquery1Row
                    ->where('a.tanggal >=', $awal)
                    ->where('a.tanggal <=', $akhir);
    
                $subquery2Row
                    ->where('p.tanggal >=', $awal)
                    ->where('p.tanggal <=', $akhir);
            } else {
                $periode = $this->periode();
                $subquery1Row
                    ->where('a.tanggal >=', $periode['awal']->tanggal)
                    ->where('a.tanggal <=', $periode['akhir']->tanggal);
    
                $subquery2Row
                    ->where('p.tanggal >=', $periode['awal']->tanggal)
                    ->where('p.tanggal <=', $periode['akhir']->tanggal);
            }

        $subquery1 = $subquery1Row->getCompiledSelect();
        $subquery2 = $subquery2Row->getCompiledSelect();

        // Main query
        $sql = $this->db->query("
                SELECT 
                    tbl_new.kode,
                    tbl_new.name, 
                    SUM(tbl_new.jumdebit) as total_debit,
                    SUM(tbl_new.jumkredit) as total_kredit,
                    SUM(tbl_new.jumdebits) as total_debits,
                    SUM(tbl_new.jumkredits) as total_kredits
                FROM (
                    $subquery1
    
                    UNION ALL
    
                    $subquery2
    
                ) as tbl_new 
                WHERE tbl_new.kode >= 4000
                GROUP BY tbl_new.kode, tbl_new.name
        ");


        $data = $sql->getResultArray();
        return $data;
    }

    public function get_laporan_perubahanmodal($awal = null, $akhir = null)
    {
        // First subquery
        $subquery1Row = $this->db->table('accounting_detail as ad')
            ->select('ad.category3_kode as kode, ac3.name, SUM(ad.debit) as jumdebit, SUM(ad.kredit) as jumkredit, 0 as jumdebits, 0 as jumkredits')
            ->join('accounting as a', 'a.id = ad.accounting_id', 'left')
            ->join('accounting_category3 as ac3', 'ac3.kode = ad.category3_kode')
            ->where('a.gudang_id', $this->get_selected_gudang_id())
            ->groupBy('ac3.name, ad.category3_kode');

        // Second subquery
        $subquery2Row = $this->db->table('penyesuaian_detail as pd')
            ->select('pd.category3_kode as kode, ac3.name, 0 as jumdebit, 0 as jumkredit, SUM(pd.debit) as jumdebits, SUM(pd.kredit) as jumkredits')
            ->join('penyesuaian as p', 'p.id = pd.penyesuaian_id', 'right')
            ->join('accounting_category3 as ac3', 'ac3.kode = pd.category3_kode')
            ->where('p.gudang_id', $this->get_selected_gudang_id())
            ->groupBy('ac3.name, pd.category3_kode');
        
            if ($awal && $akhir) {
                $subquery1Row
                    ->where('a.tanggal >=', $awal)
                    ->where('a.tanggal <=', $akhir);
    
                $subquery2Row
                    ->where('p.tanggal >=', $awal)
                    ->where('p.tanggal <=', $akhir);
            } else {
                $periode = $this->periode();
                $subquery1Row
                    ->where('a.tanggal >=', $periode['awal']->tanggal)
                    ->where('a.tanggal <=', $periode['akhir']->tanggal);
    
                $subquery2Row
                    ->where('p.tanggal >=', $periode['awal']->tanggal)
                    ->where('p.tanggal <=', $periode['akhir']->tanggal);
            }

        $subquery1 = $subquery1Row->getCompiledSelect();
        $subquery2 = $subquery2Row->getCompiledSelect();

        // Main query
        $sql = $this->db->query("
                SELECT 
                    tbl_new.kode,
                    tbl_new.name, 
                    SUM(tbl_new.jumdebit) as total_debit,
                    SUM(tbl_new.jumkredit) as total_kredit,
                    SUM(tbl_new.jumdebits) as total_debits,
                    SUM(tbl_new.jumkredits) as total_kredits
                FROM (
                    $subquery1
    
                    UNION ALL
    
                    $subquery2
    
                ) as tbl_new 
                WHERE tbl_new.kode >= 3000
                GROUP BY tbl_new.kode, tbl_new.name
        ");


        $data = $sql->getResultArray();
        return $data;
    }

    public function get_laporan_neraca($awal = null, $akhir = null)
    {
        // First subquery
        $subquery1Row = $this->db->table('accounting_detail as ad')
            ->select('ad.category3_kode as kode, ac3.name, SUM(ad.debit) as jumdebit, SUM(ad.kredit) as jumkredit, 0 as jumdebits, 0 as jumkredits')
            ->join('accounting as a', 'a.id = ad.accounting_id', 'left')
            ->join('accounting_category3 as ac3', 'ac3.kode = ad.category3_kode')
            ->where('a.gudang_id', $this->get_selected_gudang_id())
            ->groupBy('ac3.name, ad.category3_kode');

        // Second subquery
        $subquery2Row = $this->db->table('penyesuaian_detail as pd')
            ->select('pd.category3_kode as kode, ac3.name, 0 as jumdebit, 0 as jumkredit, SUM(pd.debit) as jumdebits, SUM(pd.kredit) as jumkredits')
            ->join('penyesuaian as p', 'p.id = pd.penyesuaian_id', 'right')
            ->join('accounting_category3 as ac3', 'ac3.kode = pd.category3_kode')
            ->where('p.gudang_id', $this->get_selected_gudang_id())
            ->groupBy('ac3.name, pd.category3_kode');
        
            if ($awal && $akhir) {
                $subquery1Row
                    ->where('a.tanggal >=', $awal)
                    ->where('a.tanggal <=', $akhir);
    
                $subquery2Row
                    ->where('p.tanggal >=', $awal)
                    ->where('p.tanggal <=', $akhir);
            } else {
                $periode = $this->periode();
                $subquery1Row
                    ->where('a.tanggal >=', $periode['awal']->tanggal)
                    ->where('a.tanggal <=', $periode['akhir']->tanggal);
    
                $subquery2Row
                    ->where('p.tanggal >=', $periode['awal']->tanggal)
                    ->where('p.tanggal <=', $periode['akhir']->tanggal);
            }

        $subquery1 = $subquery1Row->getCompiledSelect();
        $subquery2 = $subquery2Row->getCompiledSelect();

        // Main query
        $sql = $this->db->query("
                SELECT 
                    tbl_new.kode,
                    tbl_new.name, 
                    SUM(tbl_new.jumdebit) as total_debit,
                    SUM(tbl_new.jumkredit) as total_kredit,
                    SUM(tbl_new.jumdebits) as total_debits,
                    SUM(tbl_new.jumkredits) as total_kredits
                FROM (
                    $subquery1
    
                    UNION ALL
    
                    $subquery2
    
                ) as tbl_new 
                WHERE tbl_new.kode < 4000
                GROUP BY tbl_new.kode, tbl_new.name
        ");


        $data = $sql->getResultArray();
        return $data;
    }

    public function get_laporan_persediaan_barang($awal = null, $akhir = null)
    {
        // Subquery untuk pembelian barang
        $subqueryPembelian = $this->db->table('detail_pembelian as pd')
            ->select('pd.barang_kode as kode, b.nama_barang, SUM(pd.jumlah) as jumlah_masuk, 0 as jumlah_keluar, 0 as stock')
            ->join('pembelian as p', 'p.faktur = pd.faktur', 'left')
            ->join('barang as b', 'b.kode_barang = pd.barang_kode')
            ->where('p.gudang_id', $this->get_selected_gudang_id())
            ->groupBy('pd.barang_kode, b.nama_barang');
    
        // Subquery untuk penjualan barang
        $subqueryPenjualan = $this->db->table('detail_penjualan as jd')
            ->select('jd.barang_kode as kode, b.nama_barang, 0 as jumlah_masuk, SUM(jd.jumlah) as jumlah_keluar, 0 as stock')
            ->join('penjualan as j', 'j.faktur = jd.faktur', 'right')
            ->join('barang as b', 'b.kode_barang = jd.barang_kode')
            ->where('j.gudang_id', $this->get_selected_gudang_id())
            ->groupBy('jd.barang_kode, b.nama_barang');
    
        // subquery barang
        $subqueryBarang = $this->db->table('barang')
            ->select('barang.kode_barang as kode, barang.nama_barang, 0 as jumlah_masuk, 0 as jumlah_keluar, stock_gudang.stock as stock')
            ->join('stock_gudang', 'barang.kode_barang = stock_gudang.barang_kode', 'left')
            ->join('gudang', 'barang.gudang_id = gudang.id_gudang', 'left')
            ->where('barang.gudang_id', $this->get_selected_gudang_id())
            ->where('barang.status', true)
            ->groupBy('barang.kode_barang, barang.nama_barang, stock_gudang.stock');
        
        if ($awal && $akhir) {
            $subqueryPembelian
                ->where('p.tanggal_faktur >=', $awal)
                ->where('p.tanggal_faktur <=', $akhir);
    
            $subqueryPenjualan
                ->where('j.tanggal_faktur >=', $awal)
                ->where('j.tanggal_faktur <=', $akhir);
        } else {
            $periode = $this->periode();
            $subqueryPembelian
                ->where('p.tanggal_faktur >=', $periode['awal']->tanggal)
                ->where('p.tanggal_faktur <=', $periode['akhir']->tanggal);
    
            $subqueryPenjualan
                ->where('j.tanggal_faktur >=', $periode['awal']->tanggal)
                ->where('j.tanggal_faktur <=', $periode['akhir']->tanggal);
        }
    
        $subquery1 = $subqueryPembelian->getCompiledSelect();
        $subquery2 = $subqueryPenjualan->getCompiledSelect();
        $subquery3 = $subqueryBarang->getCompiledSelect();
    
        // Main query
        $sql = $this->db->query("
            SELECT 
                tbl_new.kode,
                tbl_new.nama_barang,
                SUM(tbl_new.jumlah_masuk) as total_masuk,
                SUM(tbl_new.jumlah_keluar) as total_keluar,
                (SUM(tbl_new.jumlah_masuk) - SUM(tbl_new.jumlah_keluar)) as saldo_akhir,
                SUM(tbl_new.stock) as current_stock
            FROM (
                $subquery1
    
                UNION ALL
    
                $subquery2
    
                UNION ALL
    
                $subquery3
    
            ) as tbl_new 
            GROUP BY tbl_new.kode, tbl_new.nama_barang
        ");
    
        $data = $sql->getResultArray();
        return $data;
    }    

    public function get_laporan_arus_kas($awal = null, $akhir = null)
    {
        $dataRow = $this->db->table('arus_kas ak')
            ->select('
                ak.tanggal,
                ak.category3_kode as kode,
                ac3.name,
                SUM(ak.debit) as masuk,
                SUM(ak.kredit) as keluar,
                (SUM(ak.debit) - SUM(ak.kredit)) as saldo,
                ak.deskripsi
            ')
            ->join('accounting_category3 ac3', 'ac3.kode = ak.category3_kode')
            ->where('ak.gudang_id', $this->get_selected_gudang_id())
            ->groupBy('ak.tanggal, ak.category3_kode, ac3.name, ak.deskripsi');
    
        if ($awal && $akhir) {
            $dataRow->where('ak.tanggal >=', $awal)
                    ->where('ak.tanggal <=', $akhir);
        } else {
            $periode = $this->periode();
            $dataRow->where('ak.tanggal >=', $periode['awal']->tanggal)
                    ->where('ak.tanggal <=', $periode['akhir']->tanggal);
        }
        
        $data = $dataRow->get()->getResultArray();
        return $data;
    }

}