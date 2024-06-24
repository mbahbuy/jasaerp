<!DOCTYPE html>
<html lang="en">
  <head>
    <style type="text/css">
        body {
        margin: 0;
        font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        text-align: left;
        background-color: #fff;
        }
        .judul {
            font-style: italic;
            font-size: 20px;
        }
        .table {
        width: 100%;
        margin-bottom: 1rem;
        }

        .table th,
        .table td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #000000;
        }

        .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #000000;
        }

        .table tbody + tbody {
        border-top: 2px solid #000000;
        }
        .table-bordered {
        border: 1px solid #000000;
        }

        .table-bordered th,
        .table-bordered td {
        border: 1px solid #000000;
        }

        .table-bordered thead th,
        .table-bordered thead td {
        border-bottom-width: 2px;
        }

        .align-middle {
            vertical-align: middle !important;
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }
    </style>
  </head>
  <body>
        <h1 class="judul">Laporan Arus Kas</h1>
        <p>Periode : <?= $awal != '' && $akhir != '' ? formatDateIndonesian($awal) . ' s/d ' . formatDateIndonesian($akhir) :'-' ?></p>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="row" style="width: 60px;" class="align-middle text-center">Tanggal</th>
                    <th scope="row" style="width: 75px;" class="align-middle text-center">Keterangan Jurnal</th>
                    <th scope="row" style="width: 75px;" class="align-middle text-center">Pemasukan</th>
                    <th scope="row" style="width: 75px;" class="align-middle text-center">Pengeluaran</th>
                    <th scope="row" style="width: 75px;" class="align-middle text-center">Saldo</th>
                    <th scope="row" style="width: 150px;" class="align-middle text-center">Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $total_saldo = 0;
                if (count($data)): ?>
                    <?php for ($i=0; $i < count($data); $i++): ?>
                        <?php $total_saldo += $data[$i]['saldo']; ?>
                        <tr>
                            <td style="width: 60px;" class="align-middle text-center"><?= $i === 0 || $data[$i]['tanggal'] !== $data[$i-1]['tanggal'] ? formatDateIndonesian($data[$i]['tanggal']) : '' ?></td>
                            <td style="width: 75px;" class="align-middle text-left"><?= $data[$i]['name'] ?></td>
                            <td style="width: 75px;" class="align-middle text-center"><?= 'Rp ' . number_format($data[$i]['masuk'], 0, '', '.') ?></td>
                            <td style="width: 75px;" class="align-middle text-center"><?= 'Rp ' . number_format($data[$i]['keluar'], 0, '', '.') ?></td>
                            <td style="width: 75px;" class="align-middle text-center"><?= 'Rp ' . number_format($data[$i]['saldo'], 0, '', '.') ?></td>
                            <td style="width: 150px;" class="align-middle text-left"><?= $data[$i]['deskripsi'] ?></td>
                        </tr>
                    <?php endfor; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="align-middle text-center">Belum ada data</td></tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th style="width: 135px;" colspan="2" class="align-middle text-center">Total saldo:</th>
                    <th  style="width: 225px;" colspan="3" class="align-middle text-right"><?= 'Rp ' . number_format($total_saldo, 0, '', '.') ?></th>
                    <th  style="width: 150px;"></th>
                </tr>
            </tfoot>
        </table>

        <br/><br/><br/><br/>
        <em><?= formatDateIndonesianFull(date('Y-m-d')) ?></em>
        <p>Pimpinan AKN</p>
        <br/><br/><br/><br/>
        <p>____________</p>

  </body>
</html>
