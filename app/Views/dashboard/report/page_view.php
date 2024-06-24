<?= $this->extend('dashboard/layouts/app'); ?>

<?= $this->section('content'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Report Page View</h1>
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
                    <form class="d-inline" action="<?= url_to('report.page_view') ?>" method="get">
                      <div class="input-group">
                        <input type="text" name="keyword" class="form-control float-right" placeholder="Cari Judul" value="<?= $search ?? '' ?>">
  
                        <div class="input-group-append">
                          <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="card-body">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th scope="row">
                          <button type="button" class="btn btn-tool d-inline" id="refresh">
                              <i class="fas fa-sync-alt"></i>
                          </button>
                        </th>
                        <th scope="row">Judul</th>
                        <th scope="row">view</th>
                      </tr>
                    </thead>
                    <tbody id="table-view">
                      <?php if(sizeof($article)) : ?>
                        <?php $i = 1 + (10 * ($page - 1)); 
                        foreach($article as $item) : ?>
                          <?php
                            $dateTime = new \DateTime($item->published_at);
                            $formattedDateTime = $dateTime->format('l, d F Y - H:i');
                          ?>
                          <tr>
                            <td><?= $i++ ?></td>
                            <td >
                                <div style="margin-bottom:10px">
                                    <a href="javascript:void(0)" style="color:white">
                                        <?= $item->judul ?>
                                    </a> &nbsp;
                                    <a href="javascript:void(0)">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
                                <i class="fas fa-lock"></i> <?= $item->initial ?> &nbsp; 
                                <i class="fas fa-user"></i> <?= $item->penulis ?> &nbsp; 
                                <i class="fas fa-tag"></i> <?= $item->kategori ?> &nbsp;
                                <i class="far fa-calendar-alt"></i> <?= $formattedDateTime ?>&nbsp;
                            </td>
                            <td class="text-center"><?= $item->view ?></td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else : ?>
                        <tr><td colspan="4">Belum ada berita</td></tr>
                      <?php endif; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th></th>
                        <th>Judul</th>
                        <th>View</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- end card-body-->
                <div class="card-footer clearfix">
                  <?= $pager ?>
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
        refreshBTN.on('click', () => $( "#table-view" ).load(window.location.href + " #table-view>" ) );
    });
</script>
<?= $this->endSection(); ?>