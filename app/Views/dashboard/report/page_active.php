<?= $this->extend('dashboard/layouts/app'); ?>

<?= $this->section('content'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Report Page Active</h1>
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
                        <th scope="row"></th>
                        <th scope="row">Nama</th>
                        <th scope="row">Inisial</th>
                        <th scope="row">Artikel(published)</th>
                        <th scope="row">Views Artikel</th>
                        <th scope="row">Kontribusi</th>
                      </tr>
                    </thead>
                    <tbody id="table-active">
                      <?php if(sizeof($users)) : ?>
                        <?php $i = 1; 
                        foreach($users as $item) : ?>
                          <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $item->name?></td>
                            <td><?= $item->initial ?></td>
                            <td class="text-center"><?= $item->articles ?></td>
                            <td class="text-center"><?= $item->articles_view ?></td>
                            <td class="text-center"><?= $item->kontribusi ?></td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else : ?>
                        <tr><td colspan="4">Belum ada user</td></tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
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
        refreshBTN.on('click', () => $( "#table-active" ).load(window.location.href + " #table-active>" ) );
    });
</script>
<?= $this->endSection(); ?>