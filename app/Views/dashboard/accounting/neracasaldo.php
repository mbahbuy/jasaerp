<?= $this->extend('dashboard/layouts/app'); ?>

<?= $this->section('content'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Neraca Saldo</h1>
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
                            <form action="<?= url_to('accounting.neraca.saldo') ?>" method="get">
                            <input type="date" id="awal" name="awal" class="form-control" value="<?= $awal ?? '' ?>">
                        </div>
                        <div class="col">
                            <input type="date" id="akhir" name="akhir" class="form-control" value="<?= $akhir ?? '' ?>">
                        </div>
                        <div class="col">
                            <div class="button-list">
                                <button type="submit" class="btn btn-primary">Tampilkan</button>
                                <!-- <input type="submit" class="btn btn-success" value="Cetak PDF" formtarget="_blank" formaction="<?= url_to('accounting.neraca.saldo.pdf') ?>" formmethod="post"> -->
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
                      <th scope="row" class="align-middle text-center" colspan="2">Saldo</th>
                    </tr>
                    <tr>
                        <th scope="row" class="align-middle text-center">Debit</th>
                        <th scope="row" class="align-middle text-center">Kredit</th>
                    </tr>
                  </thead>
                  <tbody>
                        <?php 
                            $tdeb = 0;
                            $tkre = 0;    
                        ?>
                    <?php if (count($data)): ?>
                        <?php for ($i=0; $i < count($data); $i++): ?>
                            <?php 
                                $deb = $data[$i]['jumdebit'];
                                $kre = $data[$i]['jumkredit'];
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
                                
                                
                                
                            ?>
                            <tr>
                                <td class="align-middle text-center"><?= $data[$i]['category3_kode'] ?></td>
                                <td class="align-middle <?= $data[$i]['jumdebit'] != 0 ? 'text-left' : 'text-right' ?>"><?= $data[$i]['category3_name'] ?></td>
                                <td class="align-middle text-center"><?= 'Rp ' . number_format($debitnew, 0, '', '.') ?></td>
                                <td class="align-middle text-center"><?= 'Rp ' . number_format($kreditnew, 0, '', '.') ?></td>
                            </tr>
                        <?php endfor; ?>
                    <?php else: ?>
                      <tr><td colspan="4" class="align-middle text-center">Belum ada data</td></tr>
                    <?php endif; ?>
                  </tbody>

                  <tfoot>
                    <tr>
                        <th class="align-middle text-center" colspan="2"><em>Total</em></th>
                        <td  class="align-middle text-right"><?= 'Rp ' . number_format($tdeb, 0, '', '.') ?></td>
                        <td  class="align-middle text-right"><?= 'Rp ' . number_format($tkre, 0, '', '.') ?></td>
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