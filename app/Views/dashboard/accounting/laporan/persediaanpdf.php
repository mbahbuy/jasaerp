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
        <h1 class="judul">Laporan Arus Barang</h1>
        <p>Periode : <?= $awal != '' && $akhir != '' ? formatDateIndonesian($awal) . ' s/d ' . formatDateIndonesian($akhir) :'-' ?></p>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 65px;" scope="row" class="align-middle text-center" >Kode Produk</th>
                    <th style="width: 250px;" scope="row" class="align-middle text-center" >Nama Produk</th>
                    <th style="width: 50px;" scope="row" class="align-middle text-center">Transaksi<br/>Masuk</th>
                    <th style="width: 50px;" scope="row" class="align-middle text-center">Transaksi<br/>Keluar</th>
                    <th style="width: 50px;" scope="row" class="align-middle text-center">Transaksi<br/>Sisa(arus)</th>
                    <th style="width: 50px;" scope="row" class="align-middle text-center" >Stock di gudang</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($data)): ?>
                    <?php for ($i=0; $i < count($data); $i++): ?>
                        <tr>
                            <td class="align-middle text-left" style="width: 65px;"><?= $data[$i]['kode'] ?></td>
                            <td class="align-middle text-left" style="width: 250px;"><?= $data[$i]['nama_barang'] ?></td>
                            <td style="width: 50px;" class="align-middle text-center"><?= $data[$i]['total_masuk'] ?></td>
                            <td style="width: 50px;" class="align-middle text-center"><?= $data[$i]['total_keluar'] ?></td>
                            <td style="width: 50px;" class="align-middle text-center"><?= $data[$i]['saldo_akhir'] ?></td>
                            <td style="width: 50px;" class="align-middle text-center"><?= $data[$i]['current_stock'] ?></td>
                        </tr>
                    <?php endfor; ?>
                <?php else: ?>
                    <tr><td style="width: 800px;" colspan="5" class="align-middle text-center">Belum ada data</td></tr>
                <?php endif; ?>
            </tbody>

        </table>

        <br/><br/><br/><br/>
        <em><?= formatDateIndonesianFull(date('Y-m-d')) ?></em>
        <p>Pimpinan AKN</p>
        <br/><br/><br/><br/>
        <p>____________</p>

  </body>
</html>
