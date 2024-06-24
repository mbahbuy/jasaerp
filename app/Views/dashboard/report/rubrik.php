<?= $this->extend('dashboard/layouts/app'); ?>

<?= $this->section('content'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Report Rubrik</h1>
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
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" id="refresh">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th scope="row" style="width: 50px;"></th>
                        <th scope="row">Nama Kategori</th>
                        <th scope="row">Artikel</th>
                        <th scope="row">views</th>
                      </tr>
                    </thead>
                    <tbody id="table-rubrik">
                      <?php if(sizeof($rubriks)) : ?>
                        <?php $i = 1; 
                        foreach($rubriks as $item) : ?>
                          <tr>
                            <td style="width: 50px;"><?= $i++ ?></td>
                            <td><?= $item->nama ?></td>
                            <td class="text-center" style="width: 50px;"><?= $item->articles ?></td>
                            <td class="text-center" style="width: 50px;"><?= $item->views ?></td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else : ?>
                        <tr><td colspan="4">Belum ada kategori</td></tr>
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

<?= $this->section('script'); ?>
<script>
    $(function () {
        const refreshBTN = $('#refresh');
        refreshBTN.on('click', () => $( "#table-rubrik" ).load(window.location.href + " #table-rubrik>" ) );
    });
</script>
<?= $this->endSection(); ?>