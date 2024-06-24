<?= $this->extend('dashboard/layouts/app'); ?>

<?= $this->section('content'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tag</h1>
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
                    <div class="col-md-12">
                      <button type="button" id="btn-tambah" class="btn btn-success">Tambah</button>
                      <button type="button" id="btn-simpan" class="btn btn-success d-none" disabled>Simpan</button>
                      <button type="button" id="btn-batal" class="btn btn-secondary d-none">Batal</button>
                    </div>
                    <div class="col-md-12 d-none mt-3" id="input-section">
                      <input type="text" id="input-meta" class="form-control" placeholder="Tag" value="" data-value="" data-slug="">
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th scope="row" style="width: 50px;"></th>
                        <th scope="row">Tag</th>
                        <th scope="row" style="width: 50px;"></th>
                      </tr>
                    </thead>
                    <tbody id="meta-table">
                      <?php if(sizeof($data)) : ?>
                        <?php foreach($data as $item) : ?>
                          <tr >
                            <td style="width: 50px;">
                              <button type="button" class="btn btn-default button-edit" data-meta="<?= $item->meta ?>" data-slug="<?= $item->slug ?>" title="edit">
                                <i class="fas fa-pencil-alt"></i>
                              </button>
                            </td>
                            <td><?= $item->meta ?></td>
                            <td style="width: 50px;">
                              <button type="button" class="btn btn-default button-delete" data-meta="<?= $item->meta ?>" data-slug="<?= $item->slug ?>" title="delete">
                                <i class="fas fa-trash"></i>
                              </button>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else : ?>
                        <tr><td colspan="3" class="text-center">Belum ada Tag</td></tr>
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
  <script>
    $(function () {

      const btnTambah = $('#btn-tambah');
      const btnSimpan = $('#btn-simpan');
      const btnBatal = $('#btn-batal');
      const inputDiv = $('#input-section');
      const input = $('#input-meta');
      
      btnTambah.on('click', function(){toggleHide(); input.val(""); input.attr('data-value', ''); input.attr('data-slug', ''); btnSimpan.prop('disabled', true);});
      
      btnBatal.on('click', function(){toggleHide(); btnSimpan.prop('disabled', true);});

      btnSimpan.on('click', () => {
        let value = input.val();
        let slug = input.attr('data-slug');

        if (slug) {
          $.ajax({
              type: 'POST',
              url: "<?= url_to('preference.tag') ?>/update/" + slug,
              data: {
                tag: value,
                '_method': 'PUT',
              },
              dataType: 'json',
              success: function(response) {
                makeToast(response.bg, response.message);
                toggleHide();
                input.val("");
                input.attr('data-value', '');
                input.attr('data-slug', '');
                btnSimpan.prop('disabled', true);
                $( "#meta-table" ).load(window.location.href + " #meta-table>" );
              },
              error: function(xhr, status, error) {
                makeToast('bg-danger', xhr.responseText);
              }
          });
        } else {
          $.ajax({
              type: 'POST',
              url: "<?= url_to('preference.tag.store') ?>",
              data: {
                tag: value
              },
              dataType: 'json',
              success: function(response) {
                makeToast(response.bg, response.message);
                toggleHide();
                input.val("");
                input.attr('data-value', '');
                input.attr('data-slug', '');
                btnSimpan.prop('disabled', true);
                $( "#meta-table" ).load(window.location.href + " #meta-table>" );
              },
              error: function(xhr, status, error) {
                makeToast('bg-danger', xhr.responseText);
              }
          });
        }

      });

      input.on('input', function(){
        let dataVal = input.attr('data-value');
        let val = input.val();

        if (dataVal == val || val == "") {
            btnSimpan.prop('disabled', true);
        } else {
            btnSimpan.prop('disabled', false);
        }

      });

      $('#meta-table').on('click', 'button.button-edit, button.button-delete', function() { // 
          var clickedButton = $(this);
          
          let kategori = clickedButton.attr('data-meta');
          let kategoriSlug = clickedButton.attr('data-slug');
          if (clickedButton.hasClass('button-edit')) {
              // Handle the case when a button with class 'button-edit' is clicked
              input.val(kategori);
              input.attr('data-value', kategori);
              input.attr('data-slug', kategoriSlug);
              btnSimpan.prop('disabled', true);
              if (inputDiv.hasClass('d-none')) {toggleHide()} else {input.focus()};
          } else if (clickedButton.hasClass('button-delete')) {
              // Handle the case when a button with class 'button-delete' is clicked
              if (confirm(`anda ingin menghapus tag(${kategori})?`)) {
                $.ajax({
                    type: 'POST',
                    url: "<?= url_to('preference.tag') ?>/delete/" + kategoriSlug,
                    data: {
                      '_method': 'DELETE',
                    },
                    dataType: 'json',
                    success: function(response) {
                      makeToast(response.bg, response.message);
                      $( "#meta-table" ).load(window.location.href + " #meta-table>" );
                    },
                    error: function(xhr, status, error) {
                      makeToast('bg-danger', xhr.responseText);
                    }
                });
              }
          }
      });
      
      function toggleHide()
      {
        btnTambah.toggleClass('d-none');
        btnSimpan.toggleClass('d-none');
        btnBatal.toggleClass('d-none');
        inputDiv.toggleClass('d-none');
        if (!inputDiv.hasClass('d-none')) {
          input.focus();
        }
      }

    });
  </script>
<?= $this->endSection(); ?>