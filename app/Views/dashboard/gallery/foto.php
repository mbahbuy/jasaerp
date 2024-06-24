<?= $this->extend('dashboard/layouts/app'); ?>

<?= $this->section('content'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Gallery</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <?php if(sizeof($fotos)) : ?>
                  <div class="filter-container row">
                    <?php foreach($fotos as $item) : ?>
                        <div class="filtr-item col-sm-2">
                          <img class="img-fluid" src="<?= url_to('/') . 'images/gallery/' . $item['picture'] ?>" alt="<?= $item['picture'] ?>">
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                  <div class="filter-container row col-12 text-center">Belum ada foto</div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->


<?= $this->endSection(); ?>