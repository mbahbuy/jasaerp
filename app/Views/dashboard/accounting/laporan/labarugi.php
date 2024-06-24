<?= $this->extend('dashboard/layouts/app'); ?>

<?= $this->section('content'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Laporan Laba Rugi</h1>
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
                            <form action="<?= url_to('accounting.laporan.labarugi') ?>" method="get">
                            <input type="date" id="awal" name="awal" class="form-control" value="<?= $awal ?? '' ?>">
                        </div>
                        <div class="col">
                            <input type="date" id="akhir" name="akhir" class="form-control" value="<?= $akhir ?? '' ?>">
                        </div>
                        <div class="col">
                            <div class="button-list">
                                <button type="submit" class="btn btn-primary">Tampilkan</button>
                                <input type="submit" class="btn btn-success" value="Cetak PDF" formtarget="_blank" formaction="<?= url_to('accounting.laporan.labarugi.pdf') ?>" formmethod="post">
                                </form>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="card-body">
                <table class="table table-sm table-bordered">
                  <thead>
                    <tr>
                      <th scope="row" class="align-middle text-center" >Keterangan Jurnal</th>
                      <th scope="row" class="align-middle text-center" >Pendapatan</th>
                      <th scope="row" class="align-middle text-center" >Beban</th>
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
                            ?>
                            <tr>
                                <td class="align-middle <?= $kode == 4 ? 'text-left' : 'text-right' ?>"><?= $data[$i]['name'] ?></td>
                                <td class="align-middle text-center"><?= 'Rp ' . number_format($lb_deb, 0, '', '.') ?></td>
                                <td class="align-middle text-center"><?= 'Rp ' . number_format($lb_kre, 0, '', '.') ?></td>
                            </tr>
                        <?php endfor; ?>
                    <?php else: ?>
                      <tr><td colspan="4" class="align-middle text-center">Belum ada data</td></tr>
                    <?php endif; ?>
                  </tbody>

                  <tfoot>
                    <tr>
                        <th class="align-middle text-center" ><em>Total</em></th>
                        <td  class="align-middle text-right"><?= 'Rp ' . number_format($tdeblr, 0, '', '.') ?></td>
                        <td  class="align-middle text-right"><?= 'Rp ' . number_format($tkrelr, 0, '', '.') ?></td>
                    </tr>
                    <tr>
                        <th class="align-middle text-center" ><em>Laba Rugi:</em></th>
                        <td  class="align-middle text-right" colspan="2"><?= 'Rp ' . number_format(($tdeblr - $tkrelr), 0, '', '.') ?></td>
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