<?php 
namespace App\Models;

use CodeIgniter\Model;

class Penyesuaian extends Model{
    protected $table      = 'penyesuaian';
    protected $primaryKey     = 'id';
    protected $useTimestamps   = true;
    protected $useSoftDeletes = false; // Set to true if you're using soft deletes
    protected $allowedFields  = [
        'gudang_id', 'tanggal', 'deskripsi', 'nilai', 'waktu', 'jumlah',
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

    public function get_transaksipenyesuaian()
    {
        $periode = $this->periode();
        $data = $this->db->table($this->table)->where('tanggal >=', $periode['awal']->tanggal)->where('tanggal <=', $periode['akhir']->tanggal)->where('gudang_id', $this->get_selected_gudang_id())->get()->getResultArray();
        if (count($data)) {
            for ($i=0; $i < count($data); $i++) {
                $dataDetail = $this->db->table('penyesuaian_detail ad')
                    ->select('ad.debit, ad.kredit, ad.category3_kode, ac3.name AS category3_name,')
                    ->join('accounting_category3 ac3', 'ac3.kode = ad.category3_kode', 'left')
                    ->where('ad.penyesuaian_id', $data[$i]['id'])
                    ->get()->getResultArray();
                $data[$i]['detail'] = $dataDetail;
            }
        }

        return $data;
    }

    public function get_jurnalpenyesuaian($awal = null, $akhir = null)
    {
        $dataRow = $this->db->table('penyesuaian_detail pd')
            ->select('pd.category3_kode, ac3.name AS category3_name, p.tanggal, p.deskripsi')
            ->join('accounting_category3 ac3', 'ac3.kode = pd.category3_kode')
            ->join('penyesuaian p', 'p.id = pd.penyesuaian_id')
            ->selectSum('pd.debit', 'jumdebit')
            ->selectSum('pd.kredit', 'jumkredit')
            ->where('p.gudang_id', $this->get_selected_gudang_id())
            ->groupBy('pd.category3_kode, ac3.name, p.tanggal, p.deskripsi');

        if ($awal && $akhir) {
            $dataRow->where('p.tanggal >=', $awal)
                    ->where('p.tanggal <=', $akhir);
        } else {
            $periode = $this->periode();
            $dataRow->where('p.tanggal >=', $periode['awal']->tanggal)->where('p.tanggal <=',$periode['akhir']->tanggal);
        }

        $data = $dataRow->get()->getResultArray();
        return $data;
    }
}