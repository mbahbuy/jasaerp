<?= $this->extend('dashboard/layouts/app'); ?>

<?= $this->section('content'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Neraca Lajur</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <content class="content">
      <!-- Start Content-->
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <form action="<?= url_to('accounting.neraca.lajur') ?>" method="get">
                            <input type="date" id="awal" name="awal" class="form-control" value="<?= $awal ?? '' ?>">
                        </div>
                        <div class="col">
                            <input type="date" id="akhir" name="akhir" class="form-control" value="<?= $akhir ?? '' ?>">
                        </div>
                        <div class="col">
                            <div class="button-list">
                                <button type="submit" class="btn btn-primary">Tampilkan</button>
                                <!-- <input type="submit" class="btn btn-success" value="Cetak PDF" formtarget="_blank" formaction="<?= url_to('accounting.neraca.lajur.pdf') ?>" formmethod="post"> -->
                                </form>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="card-body">
                <table class="table table-sm table-bordered">
                  <thead>
                    <tr>
                      <th scope="row" class="align-middle text-center" rowspan="2">Kode Akun</th>
                      <th scope="row" class="align-middle text-center" rowspan="2">Keterangan Jurnal</th>
                      <th scope="row" class="align-middle text-center" colspan="2">Neraca Saldo</th>
                      <th scope="row" class="align-middle text-center" colspan="2">Jurnal Penyesuaian</th>
                      <th scope="row" class="align-middle text-center" colspan="2">NS yang disesuaikan</th>
                      <th scope="row" class="align-middle text-center" colspan="2">Laba Rugi</th>
                      <th scope="row" class="align-middle text-center" colspan="2">Neraca</th>
                    </tr>
                    <tr>
                        <th scope="row" class="align-middle text-center">Debit</th>
                        <th scope="row" class="align-middle text-center">Kredit</th>
                        <th scope="row" class="align-middle text-center">Debit</th>
                        <th scope="row" class="align-middle text-center">Kredit</th>
                        <th scope="row" class="align-middle text-center">Debit</th>
                        <th scope="row" class="align-middle text-center">Kredit</th>
                        <th scope="row" class="align-middle text-center">Debit</th>
                        <th scope="row" class="align-middle text-center">Kredit</th>
                        <th scope="row" class="align-middle text-center">Debit</th>
                        <th scope="row" class="align-middle text-center">Kredit</th>
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

                            // Laba Rugi(LR)
                            $tdeblr = 0;
                            $tkrelr = 0;

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

                                // Laba Rugi
                                $lb_deb = 0;
                                $lb_kre = 0;
                                if ($kode == 4) {
                                  $lb_deb = ($debitnsnew + $kreditnsnew);
                                  $tdeblr += $lb_deb;
                                }

                                if ($kode == 5) {
                                  $lb_kre = ($debitnsnew + $kreditnsnew);
                                  $tkrelr += $lb_kre;
                                }

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
                                <td class="align-middle text-center"><?= $data[$i]['kode'] ?></td>
                                <td class="align-middle text-left"><?= $data[$i]['name'] ?></td>
                                <td class="align-middle text-center"><?= 'Rp ' . number_format($debitnew, 0, '', '.') ?></td>
                                <td class="align-middle text-center"><?= 'Rp ' . number_format($kreditnew, 0, '', '.') ?></td>
                                <td class="align-middle text-center"><?= 'Rp ' . number_format($debitjpnew, 0, '', '.') ?></td>
                                <td class="align-middle text-center"><?= 'Rp ' . number_format($kreditjpnew, 0, '', '.') ?></td>
                                <td class="align-middle text-center"><?= 'Rp ' . number_format($debitnsnew, 0, '', '.') ?></td>
                                <td class="align-middle text-center"><?= 'Rp ' . number_format($kreditnsnew, 0, '', '.') ?></td>
                                <td class="align-middle text-center"><?= 'Rp ' . number_format($lb_deb, 0, '', '.') ?></td>
                                <td class="align-middle text-center"><?= 'Rp ' . number_format($lb_kre, 0, '', '.') ?></td>
                                <td class="align-middle text-center"><?= 'Rp ' . number_format($debitnrcnew, 0, '', '.') ?></td>
                                <td class="align-middle text-center"><?= 'Rp ' . number_format($kreditnrcnew, 0, '', '.') ?></td>
                            </tr>
                        <?php endfor; ?>
                    <?php else: ?>
                      <tr><td colspan="8" class="align-middle text-center">Belum ada data</td></tr>
                    <?php endif; ?>
                  </tbody>

                  <tfoot>
                    <tr>
                        <th class="align-middle text-center" colspan="2"><em>Total</em></th>
                        <td  class="align-middle text-right"><?= 'Rp ' . number_format($tdeb, 0, '', '.') ?></td>
                        <td  class="align-middle text-right"><?= 'Rp ' . number_format($tkre, 0, '', '.') ?></td>
                        <td  class="align-middle text-right"><?= 'Rp ' . number_format($tdebjp, 0, '', '.') ?></td>
                        <td  class="align-middle text-right"><?= 'Rp ' . number_format($tkrejp, 0, '', '.') ?></td>
                        <td  class="align-middle text-right"><?= 'Rp ' . number_format($tdebns, 0, '', '.') ?></td>
                        <td  class="align-middle text-right"><?= 'Rp ' . number_format($tkrens, 0, '', '.') ?></td>
                        <td  class="align-middle text-right"><?= 'Rp ' . number_format($tdeblr, 0, '', '.') ?></td>
                        <td  class="align-middle text-right"><?= 'Rp ' . number_format($tkrelr, 0, '', '.') ?></td>
                        <td  class="align-middle text-right"><?= 'Rp ' . number_format($tdebn, 0, '', '.') ?></td>
                        <td  class="align-middle text-right"><?= 'Rp ' . number_format($tkren, 0, '', '.') ?></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <!-- end card-body-->
            </div>
            <!-- end card-->
          </div>
          <!-- end col -->
        </div>
        <!-- end row -->
      </div>
      <!-- container -->
    </content>
    <!-- content -->


  </div>
  <!-- /.content-wrapper -->


<?= $this->endSection(); ?>