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
        <h1 class="judul">Laporan Neraca</h1>
        <p>Periode : <?= $awal != '' && $akhir != '' ? formatDateIndonesian($awal) . ' s/d ' . formatDateIndonesian($akhir) :'-' ?></p>

        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th style="width: 100px;" scope="row" class="align-middle text-center">Keterangan Jurnal</th>
                    <th style="width: 100px;" scope="row" class="align-middle text-center">Debit</th>
                    <th style="width: 100px;" scope="row" class="align-middle text-center">Kredit</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    // Neraca saldo
                    $tdeb = 0;
                    $tkre = 0;    

                    // Jurnal Penyesuaian
                    $tdebjp = 0;
                    $tkrejp = 0;

                    // Neraca saldo(NS) yang disesuaikan
                    $tdebns = 0;
                    $tkrens = 0;

                    // Neraca
                    $tdebn = 0;
                    $tkren = 0;
                ?>
            <?php if (count($data)): ?>
                <?php for ($i=0; $i < count($data); $i++): ?>
                    <?php 
                        // Neraca Saldo
                        $deb = $data[$i]['total_debit'];
                        $kre = $data[$i]['total_kredit'];
                        $neraca = $deb - $kre;

                        if ($neraca < 0) {
                            $kreditnew = abs($neraca);
                            $tkre += $kreditnew;
                        } else {
                            $kreditnew = 0;
                        }

                        if ($neraca > 0) {
                            $debitnew = $neraca;
                            $tdeb += $debitnew;
                        } else {
                            $debitnew = 0;
                        }

                        // jurnal penyesuaian as jp
                        $debjp = $data[$i]['total_debits'];
                        $krejp = $data[$i]['total_kredits'];
                        $jp = $debjp- $krejp;
                        
                        if ($jp < 0) {
                            $kreditjpnew = abs($jp);
                            $tkrejp += $kreditjpnew;
                        } else {
                            $kreditjpnew = 0;
                        }

                        if ($jp > 0) {
                            $debitjpnew = $jp;
                            $tdebjp += $debitjpnew;
                        } else {
                            $debitjpnew = 0;
                        }

                        // Neraca Saldo yang disesuaikan as ns
                        $ns = ($debitnew + $debitjpnew) - ($kreditnew + $kreditjpnew);
                        
                        if ($ns < 0) {
                            $kreditnsnew = abs($ns);
                            $tkrens += $kreditnsnew;
                        } else {
                            $kreditnsnew = 0;
                        }

                        if ($ns > 0) {
                            $debitnsnew = $ns;
                            $tdebns += $debitnsnew;
                        } else {
                            $debitnsnew = 0;
                        }

                        // Kode akun
                        $kode_akun = $data[$i]['kode'];
                        $kode = substr($kode_akun, 0, 1);

                        // Neraca
                        $debitnrcnew = 0;
                        $kreditnrcnew = 0;
                        if ($kode <= 3) {
                            if ($ns < 0) {
                            $kreditnrcnew = abs($ns);
                            $tkren += $kreditnrcnew;
                            }

                            if ($ns > 0) {
                                $debitnrcnew = $ns;
                                $tdebn += $debitnrcnew;
                            }
                        }
                    ?>
                    <tr>
                        <td style="width: 100px;" class="align-middle text-left"><?= $data[$i]['name'] ?></td>
                        <td style="width: 100px;" class="align-middle text-center"><?= 'Rp ' . number_format($debitnrcnew, 0, '', '.') ?></td>
                        <td style="width: 100px;" class="align-middle text-center"><?= 'Rp ' . number_format($kreditnrcnew, 0, '', '.') ?></td>
                    </tr>
                <?php endfor; ?>
            <?php else: ?>
                <tr><td style="width: 300px;" colspan="3" class="align-middle text-center">Belum ada data</td></tr>
            <?php endif; ?>
            </tbody>

            <tfoot>
            <tr>
                <th style="width: 100px;" class="align-middle text-center"><em>Total</em></th>
                <td style="width: 100px;" class="align-middle text-right"><?= 'Rp ' . number_format($tdebn, 0, '', '.') ?></td>
                <td style="width: 100px;" class="align-middle text-right"><?= 'Rp ' . number_format($tkren, 0, '', '.') ?></td>
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
