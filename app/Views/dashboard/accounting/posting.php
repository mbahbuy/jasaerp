<?= $this->extend('dashboard/layouts/app'); ?>

<?= $this->section('style') ?>
  <!-- Select2 -->
  <link rel="stylesheet" href="/template/adminLTE/plugins/select2/css/select2meta.css">
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Posting</h1>
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
                  <form class="row" action="<?= url_to('accounting.posting') ?>" method="get">
                    <div class="col">
                        <input type="date" id="awal" name="awal" class="form-control" value="<?= esc($awal) ?>">
                    </div>
                    <div class="col">
                        <input type="date" id="akhir" name="akhir" class="form-control" value="<?= esc($akhir) ?>">
                    </div>
                    <div class="col">
                      <select class="form-control" name="category" id="category" data-value="<?= esc($category) ?>">
                          <!-- Options go here -->
                      </select>
                    </div>
                    <div class="col">
                            <div class="button-list">
                                <button type="submit" class="btn btn-primary">Tampilkan</button>
                                <!-- <input type="submit" class="btn btn-success" value="Cetak PDF" formtarget="_blank" formaction="<?= url_to('accounting.posting.pdf') ?>" formmethod="post"> -->
                                </form>
                            </div>
                        </div>
                  </form>
              </div>
              <div class="card-body">
                <table class="table table-sm table-bordered">
                  <thead>
                    <tr>
                      <th class="align-middle text-center" rowspan="2">Tanggal</th>
                      <th class="align-middle text-center" rowspan="2">Kode Akun</th>
                      <th class="align-middle text-center" rowspan="2">Keterangan Jurnal</th>
                      <th class="align-middle text-center" rowspan="2">Debit</th>
                      <th class="align-middle text-center" rowspan="2">Kredit</th>
                      <th class="align-middle text-center" colspan="2">Saldo</th>
                    </tr>
                    <tr>
                        <th class="align-middle text-center">Debit</th>
                        <th class="align-middle text-center">Kredit</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                        $nilai = 0;
                    ?> 
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

                        <?php for ($i=0; $i < count($data); $i++): ?>
                            <?php 
                                $nilai = $data[$i]['debit'] != 0 ? $nilai + (int)$data[$i]['debit'] : $nilai - (int)$data[$i]['kredit'];
                                $debit = $nilai >= 0 ? $nilai : 0;    
                                $kredit = $nilai < 0 ? $nilai : 0;    
                            ?>
                            <?php if ($deskripsi !== $data[$i]['deskripsi']): ?>
                                <?php if ($deskripsi !== ''): ?>
                                    <tr>
                                        <td class="align-middle text-left bg-olive color-palette" colspan="6"><?= $deskripsi ?></td>
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
                                <td class="align-middle text-center"><?= 'Rp ' . number_format($debit, 0, '', '.') ?></td>
                                <td class="align-middle text-center"><?= 'Rp ' . number_format(abs($kredit), 0, '', '.') ?></td>
                            </tr>
                        <?php endfor; ?>
                        <tr><td class="align-middle text-left bg-olive color-palette" colspan="6"><?= $deskripsi ?></td></tr>
                    <?php else: ?>
                      <tr><td colspan="7" class="align-middle text-center">Belum ada data</td></tr>
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

<?= $this->section('script') ?>
<!-- Select2 -->
<script src="/template/adminLTE/plugins/select2/js/select2.full.min.js"></script>
<script>
    // form select category
    const category = $('#category');
    const jsonCategory = [];

    $(function () {
      category.select2();
        fetchCategory(data => {
            processCategory(data);
            generateCategory();
        });
        
    });// end document ready

  function fetchCategory(callback){
    $.ajax({
          url: `<?= url_to('accounting.category.json3') ?>`,
          type: 'POST',
          dataType: 'JSON',
          success: function (response) {
              callback(response);
          },
          error: function (xhr, status, error) {
              makeToast('bg-danger', `Error: ${error}`);
          }
      });
  }

  function processCategory(response) {
    for (let i = 0; i < response.length; i++) {
      let data = {
        id: response[i].id,
        kode: response[i].kode,
        name: response[i].name,
        detail: response[i].detail !== null ? response[i].detail : '',
      };
      jsonCategory.push(data);
    }
  }

  function generateCategory()
  {
        let dataCategory = category.data('value') !== '' ? parseInt(category.data('value')) : 111;

        let option = jsonCategory.map(e => `<option value='${e.kode}' ${e.kode == dataCategory ? 'selected' : ''}>${e.kode+'|'+e.name}</option>`).join('');
        category.empty().append(option);

  }

</script>
<?= $this->endSection(); ?>