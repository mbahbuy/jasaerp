<?= $this->extend('dashboard/layouts/app'); ?>

<?= $this->section('content'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Laporan Arus Kas</h1>
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
                            <form action="<?= url_to('accounting.laporan.kas') ?>" method="get">
                            <input type="date" id="awal" name="awal" class="form-control" value="<?= $awal ?? '' ?>">
                        </div>
                        <div class="col">
                            <input type="date" id="akhir" name="akhir" class="form-control" value="<?= $akhir ?? '' ?>">
                        </div>
                        <div class="col">
                            <div class="button-list">
                                <button type="submit" class="btn btn-primary">Tampilkan</button>
                                <input type="submit" class="btn btn-success" value="Cetak PDF" formtarget="_blank" formaction="<?= url_to('accounting.laporan.kas.pdf') ?>" formmethod="post">
                                </form>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="card-body">
                <table class="table table-sm table-bordered">
                  <thead>
                    <tr>
                      <th scope="row" class="align-middle text-center">Tanggal</th>
                      <th scope="row" class="align-middle text-center">Keterangan Jurnal</th>
                      <th scope="row" class="align-middle text-center">Pemasukan</th>
                      <th scope="row" class="align-middle text-center">Pengeluaran</th>
                      <th scope="row" class="align-middle text-center">Saldo</th>
                      <th scope="row" class="align-middle text-center">Deskripsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      $total_saldo = 0;
                    if (count($data)): ?>
                        <?php for ($i=0; $i < count($data); $i++): ?>
                          <?php $total_saldo += $data[$i]['saldo']; ?>
                            <tr>
                                <td class="align-middle text-center"><?= $i === 0 || $data[$i]['tanggal'] !== $data[$i-1]['tanggal'] ? formatDateIndonesian($data[$i]['tanggal']) : '' ?></td>
                                <td class="align-middle text-left"><?= $data[$i]['name'] ?></td>
                                <td class="align-middle text-center"><?= 'Rp ' . number_format($data[$i]['masuk'], 0, '', '.') ?></td>
                                <td class="align-middle text-center"><?= 'Rp ' . number_format($data[$i]['keluar'], 0, '', '.') ?></td>
                                <td class="align-middle text-center"><?= 'Rp ' . number_format($data[$i]['saldo'], 0, '', '.') ?></td>
                                <td class="align-middle text-left"><?= $data[$i]['deskripsi'] ?></td>
                            </tr>
                        <?php endfor; ?>
                    <?php else: ?>
                      <tr><td colspan="5" class="align-middle text-center">Belum ada data</td></tr>
                    <?php endif; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="2" class="align-middle text-center">Total saldo:</th>
                      <th colspan="3" class="align-middle text-right"><?= 'Rp ' . number_format($total_saldo, 0, '', '.') ?></th>
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