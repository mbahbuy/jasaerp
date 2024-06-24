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
        <h1 class="judul">Posting</h1>
        <p>Periode : <?= $awal != '' && $akhir != '' ? formatDateIndonesian($awal) . ' s/d ' . formatDateIndonesian($akhir) :'-' ?></p>

        <table class="table table-bordered">
            <thead>
                    <tr>
                      <th style="width: 60px;" class="align-middle text-center" rowspan="2">Tanggal</th>
                      <th style="width: 30px;" class="align-middle text-center" rowspan="2">Ref</th>
                      <th style="width: 150px;" class="align-middle text-center" rowspan="2">KetJurnal</th>
                      <th style="width: 75px;" class="align-middle text-center" rowspan="2">Debit</th>
                      <th style="width: 75px;" class="align-middle text-center" rowspan="2">Kredit</th>
                      <th style="width: 150px;" class="align-middle text-center" colspan="2">Saldo</th>
                    </tr>
                    <tr>
                        <th style="width: 75px;" class="align-middle text-center">Debit</th>
                        <th style="width: 75px;" class="align-middle text-center">Kredit</th>
                    </tr>
            </thead>
            <tbody>
                <?php 
                    $nilai = 0;
                ?> 
                <?php if (count($data)): ?>
                    <?php for ($i=0; $i < count($data); $i++): ?>
                        <?php 
                            $nilai = $data[$i]['debit'] != 0 ? $nilai + (int)$data[$i]['debit'] : $nilai - (int)$data[$i]['kredit'];
                            $debit = $nilai >= 0 ? $nilai : 0;    
                            $kredit = $nilai < 0 ? $nilai : 0;    
                        ?>
                        <tr>
                            <td style="width: 60px;" class="align-middle text-center"><?= $i === 0 || $data[$i]['tanggal'] !== $data[$i-1]['tanggal'] ? formatDateIndonesian($data[$i]['tanggal']) : '' ?></td>
                            <td style="width: 30px;" class="align-middle text-center"><?= $data[$i]['category3_kode'] ?></td>
                            <td style="width: 150px;" class="align-middle <?= $data[$i]['debit'] != 0 ? 'text-left' : 'text-right' ?>"><?= $data[$i]['category3_name'] ?></td>
                            <td style="width: 75px;" class="align-middle text-center"><?= 'Rp ' . number_format($data[$i]['debit'], 0, '', '.') ?></td>
                            <td style="width: 75px;" class="align-middle text-center"><?= 'Rp ' . number_format($data[$i]['kredit'], 0, '', '.') ?></td>
                            <td style="width: 75px;" class="align-middle text-center"><?= 'Rp ' . number_format($debit, 0, '', '.') ?></td>
                            <td style="width: 75px;" class="align-middle text-center"><?= 'Rp ' . number_format(abs($kredit), 0, '', '.') ?></td>
                        </tr>
                    <?php endfor; ?>
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
