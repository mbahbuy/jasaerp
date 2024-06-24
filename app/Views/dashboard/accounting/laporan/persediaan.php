<?= $this->extend('dashboard/layouts/app'); ?>

<?= $this->section('content'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Laporan Arus Barang</h1>
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
                            <form action="<?= url_to('accounting.laporan.persediaan') ?>" method="get">
                            <input type="date" id="awal" name="awal" class="form-control" value="<?= $awal ?? '' ?>">
                        </div>
                        <div class="col">
                            <input type="date" id="akhir" name="akhir" class="form-control" value="<?= $akhir ?? '' ?>">
                        </div>
                        <div class="col">
                            <div class="button-list">
                                <button type="submit" class="btn btn-primary">Tampilkan</button>
                                <input type="submit" class="btn btn-success" value="Cetak PDF" formtarget="_blank" formaction="<?= url_to('accounting.laporan.persediaan.pdf') ?>" formmethod="post">
                                </form>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="card-body">
                <table class="table table-sm table-bordered">
                  <thead>
                    <tr>
                      <th scope="row" class="align-middle text-center" rowspan="2">Kode Produk</th>
                      <th scope="row" class="align-middle text-center" rowspan="2">Nama Produk</th>
                      <th scope="row" class="align-middle text-center" colspan="3">Transaksi</th>
                      <th scope="row" class="align-middle text-center" rowspan="2">Stock di gudang</th>
                    </tr>
                    <tr>
                      <th scope="row" class="align-middle text-center">Masuk</th>
                      <th scope="row" class="align-middle text-center">Keluar</th>
                      <th scope="row" class="align-middle text-center">Sisa(arus)</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (count($data)): ?>
                        <?php for ($i=0; $i < count($data); $i++): ?>
                            <tr>
                                <td class="align-middle text-left"><?= $data[$i]['kode'] ?></td>
                                <td class="align-middle text-left"><?= $data[$i]['nama_barang'] ?></td>
                                <td class="align-middle text-center"><?= $data[$i]['total_masuk'] ?></td>
                                <td class="align-middle text-center"><?= $data[$i]['total_keluar'] ?></td>
                                <td class="align-middle text-center"><?= $data[$i]['saldo_akhir'] ?></td>
                                <td class="align-middle text-center"><?= $data[$i]['current_stock'] ?></td>
                            </tr>
                        <?php endfor; ?>
                    <?php else: ?>
                      <tr><td colspan="6" class="align-middle text-center">Belum ada data</td></tr>
                    <?php endif; ?>
                  </tbody>

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