<?= $this->extend('dashboard/layouts/app'); ?>

<?= $this->section('content'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Jurnal Umum</h1>
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
                            <form action="<?= url_to('accounting.jurnalumum') ?>" method="get">
                            <input type="date" id="awal" name="awal" class="form-control" value="<?= $awal ?? '' ?>">
                        </div>
                        <div class="col">
                            <input type="date" id="akhir" name="akhir" class="form-control" value="<?= $akhir ?? '' ?>">
                        </div>
                        <div class="col">
                            <div class="button-list">
                                <button type="submit" class="btn btn-primary">Tampilkan</button>
                                <!-- <input type="submit" class="btn btn-success" value="Cetak PDF" formtarget="_blank" formaction="<?= url_to('accounting.jurnalumum.pdf') ?>" formmethod="post"> -->
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
                              <th scope="row" class="align-middle text-center">Kode Akun</th>
                              <th scope="row" class="align-middle text-center">Keterangan Jurnal</th>
                              <th scope="row" class="align-middle text-center">Debit</th>
                              <th scope="row" class="align-middle text-center">Kredit</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php if (count($data)): ?>
                              <?php
                              $dateCount = [];
                              $currentDate = '';
                              $deskripsi = '';

                              // First pass to count rows per date
                              foreach ($data as $row) {
                                  $date = $row['tanggal'];
                                  if (!isset($dateCount[$date])) {
                                      $dateCount[$date] = 0;
                                  }
                                  if ($deskripsi !== $row['deskripsi']) {
                                    $deskripsi = $row['deskripsi'];
                                    $dateCount[$date]++;
                                  }
                                  $dateCount[$date]++;
                              }
                              ?>

                              <?php $currentDate = ''; $deskripsi = ''; ?>

                              <!-- Second pass to display the rows -->
                              <?php for ($i = 0; $i < count($data); $i++): ?>
                                  <?php if ($deskripsi !== $data[$i]['deskripsi']): ?>
                                      <?php if ($deskripsi !== ''): ?>
                                          <tr>
                                              <td class="align-middle text-left bg-olive color-palette" colspan="4"><?= $deskripsi ?></td>
                                          </tr>
                                      <?php endif; ?>
                                      <?php $deskripsi = $data[$i]['deskripsi']; ?>
                                  <?php endif; ?>

                                  <tr>
                                      <?php if ($currentDate !== $data[$i]['tanggal']): ?>
                                          <?php $currentDate = $data[$i]['tanggal']; ?>
                                          <td class="align-middle text-center" rowspan="<?= $dateCount[$currentDate] ?>"><?= formatDateIndonesian($data[$i]['tanggal']) ?></td>
                                      <?php endif; ?>
                                      <td class="align-middle text-center"><?= $data[$i]['category3_kode'] ?></td>
                                      <td class="align-middle <?= $data[$i]['debit'] != 0 ? 'text-left' : 'text-right' ?>"><?= $data[$i]['category3_name'] ?></td>
                                      <td class="align-middle text-center"><?= 'Rp ' . number_format($data[$i]['debit'], 0, '', '.') ?></td>
                                      <td class="align-middle text-center"><?= 'Rp ' . number_format($data[$i]['kredit'], 0, '', '.') ?></td>
                                  </tr>
                              <?php endfor; ?>
                              <!-- Display the last deskripsi if it was not displayed in the loop -->
                              <?php if ($deskripsi !== ''): ?>
                                  <tr>
                                      <td class="align-middle text-left bg-olive color-palette" colspan="4"><?= $deskripsi ?></td>
                                  </tr>
                              <?php endif; ?>
                          <?php else: ?>
                              <tr><td colspan="5" class="align-middle text-center">Belum ada data</td></tr>
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