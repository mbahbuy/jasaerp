<?= $this->extend('dashboard/layouts/app'); ?>

<?= $this->section('content'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">List Barang</h1>
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
                  <div class="card-title">
                    <a href="<?= route_to('barang.form') ?>" class="btn btn-icon btn-outline-success">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                    </a>
                  </div>
                  <div class="card-tools">
                    <div class="input-group">
                      <input type="text" id="search-barang" class="form-control" placeholder="Cari Barang" value="<?= $search ?? '' ?>" data-search="">
                      <button type="button" class="btn btn-default d-none" id="reload-data-barang"><i class="fas fa-sync-alt"></i></button>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th scope="row" class="align-middle text-center">#</th>
                        <th scope="row" class="align-middle text-center">Gambar</th>
                        <th scope="row" class="align-middle text-center">Nama</th>
                        <th scope="row" class="align-middle text-center">Kode</th>
                        <th scope="row" class="align-middle text-center">Stock</th>
                        <th scope="row" class="align-middle text-center">Harga Jual</th>
                        <th scope="row" class="align-middle text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody  id="barang-table"></tbody>
                    <tfoot>
                      <tr>
                        <th scope="row" class="align-middle text-center">#</th>
                        <th scope="row" class="align-middle text-center">Gambar</th>
                        <th scope="row" class="align-middle text-center">Nama</th>
                        <th scope="row" class="align-middle text-center">Kode</th>
                        <th scope="row" class="align-middle text-center">Stock</th>
                        <th scope="row" class="align-middle text-center">Harga Jual</th>
                        <th scope="row" class="align-middle text-center">Action</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- end card-body-->
                <div class="card-footer clearfix">
                  <ul class="pagination" id="pagination-barang"></ul>
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

<?= $this->section('script') ?>
<script>
  $(function () {

    const jsonDataBarang = [];

    fetchBarangData(function(e) {processData(e); generateBarang();});

    $('#barang-table').on('click', 'button.button-delete, button.button-restore, button.save-stock, button.save-harga', function() { // 
      var clickedButton = $(this);
      
      let barang = clickedButton.data('barang');
      let barangSlug = clickedButton.data('slug');
      if (clickedButton.hasClass('button-delete')) {
          // Handle the case when a button with class 'button-delete' is clicked
          if (confirm(`anda ingin menghapus barang(${barang})?`)) {
            $.ajax({
                type: 'POST',
                url: "<?= base_url() ?>barang/delete/" + barangSlug,
                data: {
                  '_method': 'DELETE',
                },
                dataType: 'json',
                success: function(response) {
                  makeToast(response.bg, response.message);
                  changeStatusBySlug(barangSlug, false);
                  removeItemBySlug(barangSlug);
                  clickedButton.parent().parent().animate(
                    {
                      right: '-100%', // Adjust the distance as needed
                      opacity: 0,
                    },
                    1000, // Duration of the animation in milliseconds
                    function () {
                      // Callback function to remove the element from the DOM
                      $(this).remove();
                      let pageActive = $('#pagination-barang').find('li.page-item.active').find('a.page-link').attr('data-page');
                      generateBarang(pageActive);
                    }
                  );
                },
                error: function(xhr, status, error) {
                  makeToast('bg-danger', xhr.responseText);
                }
            });
          }
      } else if (clickedButton.hasClass('button-restore')){
            // Handle the case when a button with class 'button-restore' is clicked
            if (confirm(`anda ingin mengambil barang(${barang}) dari tempat sampah?`)) {
            $.ajax({
                type: 'POST',
                url: "<?= base_url() ?>barang/restore/" + barangSlug,
                data: {
                  '_method': 'PUT',
                },
                dataType: 'json',
                success: function(response) {
                  makeToast(response.bg, response.message);
                  changeStatusBySlug(barangSlug, true);
                  let pageActive = $('#pagination-barang').find('li.page-item.active').find('a.page-link').attr('data-page');
                  generateBarang(pageActive);
                },
                error: function(xhr, status, error) {
                  makeToast('bg-danger', xhr.responseText);
                }
            });
          }
      } else if (clickedButton.hasClass('save-stock')) {
        let stock = clickedButton.siblings('.stock');
        let oldStock = stock.data('value');
        let id = stock.data('id');
        if (stock.val() == oldStock) {
          clickedButton.addClass('d-none');
          return;
        }
        $.ajax({
            type: 'POST',
            url: "<?= url_to('barang.index') ?>/stock/" + id,
            data: {
              stock: stock.val(),
              '_method': 'PUT',
            },
            dataType: 'json',
            success: function(response) {
              makeToast(response.bg, response.message);
              if (response.bg == 'bg-success') {
                fetchBarangData(function(e) {processData(e); generateBarang();});
              }
            },
            error: function(xhr, status, error) {
                makeToast('bg-danger', `Error: ${error}`);
            }
        });
        
      } else if (clickedButton.hasClass('save-harga')) {
        let harga = clickedButton.siblings('.harga');
        let hargaNum = clickedButton.siblings('.harga-num');
        let oldHarga = hargaNum.data('value');
        let id = hargaNum.data('id');
        if (hargaNum.val() == oldHarga) {
          clickedButton.addClass('d-none');
          return;
        }
        $.ajax({
            type: 'POST',
            url: "<?= url_to('barang.index') ?>/harga/" + id,
            data: {
              harga: hargaNum.val(),
              '_method': 'PUT',
            },
            dataType: 'json',
            success: function(response) {
              makeToast(response.bg, response.message);
              if (response.bg == 'bg-success') {
                fetchBarangData(function(e) {processData(e); generateBarang();});
              }
            },
            error: function(xhr, status, error) {
                makeToast('bg-danger', `Error: ${error}`);
            }
        });
      }
    });

    $('#barang-table').on('input', 'input.stock, input.harga', function() {
      const formFocus = $(this);
      const invalidDiv = formFocus.closest('td.align-middle').find('.invalid-feedback');
      if (formFocus.hasClass('stock')) {
        var value = formFocus.val();
        var oldValue = formFocus.data('value');
        var btnSimpan = formFocus.siblings('.save-stock');
        btnSimpan.removeClass('d-none');
        formFocus.removeClass('is-invalid');
        invalidDiv.html('').hide();
        if (value == oldValue) {
          btnSimpan.addClass('d-none');
        }
        if (parseInt(value) < 0) {
          btnSimpan.addClass('d-none');
          formFocus.addClass('is-invalid');
          invalidDiv.html('Stock tidak wajar').show();
        }

      } else if (formFocus.hasClass('harga')) {
        var value = formFocus.val();
        var inpHargaNum = formFocus.siblings('.harga-num');
        var hargaNum = inpHargaNum.val();
        var oldHargaNum = inpHargaNum.data('value');
        var btnSimpan = formFocus.siblings('.save-harga');

        var sanitized = value.replace(/[^0-9]/g, '');
        if (sanitized === null || sanitized === '') {
            formFocus.val('');
            inpHargaNum.val('');
            btnSimpan.addClass('d-none');
            formFocus.addClass('is-invalid');
            invalidDiv.html('Input is invalid').show();
        } else {
            // Format to Rupiah
            var number = parseInt(sanitized, 10);
            formFocus.val(formatRupiah(number));
            inpHargaNum.val(number);
            btnSimpan.removeClass('d-none');
            formFocus.removeClass('is-invalid');
            invalidDiv.html('').hide();

            if (oldHargaNum == number) {
                btnSimpan.addClass('d-none');
            }
            if (number < 500) {
                btnSimpan.addClass('d-none');
                formFocus.addClass('is-invalid');
                invalidDiv.html('Harga tidak wajar').show();
            }
        }
      }
    });

    $('#search-barang').on('input', function(){
      let value = $(this).val();
      $(this).attr('data-search', value);
      generateBarang(1, value);
    });


    $('#pagination-barang').on('click', 'a.page-link', function () {
        let clickedButton = $(this);
        let search = $('#search-barang').attr('data-search');
        let page = clickedButton.attr('data-page');
        generateBarang(page, search);
    });

    $('#reload-data-barang').on('click', function() {
      if (!$(this).hasClass('d-none')) {
        $(this).toggleClass('d-none');
      }
      $('#search-barang').attr('data-search', '');
      $('#search-barang').val('');
      generateBarang();
    });

    function fetchBarangData(callback) {
        $.ajax({
            url: '<?= url_to('barang.json') ?>',
            type: 'POST',
            dataType: 'JSON',
            success: function(response) {
                callback(response);
            },
            error: function(xhr, status, error) {
                makeToast('bg-danger', `Error: ${error}`);
            }
        });
    }

    function processData(response) {
        jsonDataBarang.length = 0;
        for (let i = 0; i < response.length; i++) {
            jsonDataBarang.push({
                nama: response[i].nama_barang,
                kode: response[i].kode_barang,
                gambar: response[i].gambar_barang.startsWith('http') ? response[i].gambar_barang : "<?= base_url() ?>images/" + response[i].gambar_barang,
                harga: parseInt(response[i].harga_barang),
                stock: response[i].stock !== undefined && response[i].stock !== null ? parseInt(response[i].stock) : 0,
                slug: response[i].slug,
                status: response[i].status,
                id: response[i].id_barang,
            });
        }
    }

    function generateBarang(page = 1, search = null) {
      let dataPerPage = 10;
      let startIndex = (page - 1) * dataPerPage;
      let endIndex = startIndex + dataPerPage;
      let barangTable = $('#barang-table');
      barangTable.empty();
      
      let data = jsonDataBarang;
      let totalPages = Math.ceil(data.length / dataPerPage);
      generatePagerPagination(totalPages, page);

      if (search) {
          data = jsonDataBarang.filter(function (item) {
              return item.nama.toLowerCase().includes(search.toLowerCase());
          });
      }

      if (data.length === 0) {
          barangTable.append('<tr><td colspan="7" class="text-center">Barang tidak ditemukan</td></tr>');
          return;
      }

      for (let i = startIndex; i < endIndex && i < data.length; i++) {
          let row = `
              <tr ${data[i].status == false ? 'class="text-danger"' : ''}>
                  <td class="align-middle text-center">${i + 1}</td>
                  <td class="align-middle text-center" style="width: 50px;">
                      <img src="${data[i].gambar}" alt="" class="img-fluid">
                  </td>
                  <td class="align-middle text-center" style="max-width: 400px;">${data[i].nama}</td>
                  <td class="align-middle text-center">${data[i].kode}</td>
                  <td class="align-middle text-center">
                    <div class="input-group-append">
                      <input type="number" class="form-control stock" value="${data[i].stock}" data-id="${data[i].id}" data-value="${data[i].stock}"/>
                      <button type="button" class="btn btn-icon btn-outline-success save-stock d-none">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                      </button>
                    </div>
                    <div class="invalid-feedback"></div>
                  </td>
                  <td class="align-middle text-center">
                    <div class="input-group-append">
                      <input type="text" class="form-control harga" value="${formatRupiah(data[i].harga)}"/>
                      <input type="hidden" class="harga-num" value="${data[i].harga}" data-id="${data[i].id}" data-value="${data[i].harga}">
                      <button type="button" class="btn btn-icon btn-outline-success save-harga d-none">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                      </button>
                    </div>
                    <div class="invalid-feedback"></div>
                  </td>
                  <td class="align-middle text-center">
                      ${data[i].status == true ? `
                          <div class="btn-group">
                              <a href="<?= url_to('barang.index') . '/edit/' ?>${data[i].slug}" class="btn btn-default button-edit" title="edit">
                                  <i class="fas fa-pencil-alt"></i>
                              </a>
                              <button type="button" class="btn btn-default button-delete" data-barang="${data[i].nama}" data-slug="${data[i].slug}" title="delete">
                                  <i class="fas fa-trash"></i>
                              </button>
                          </div>
                      ` : `
                          <button type="button" class="btn btn-default button-restore" data-barang="${data[i].nama}" data-slug="${data[i].slug}" title="restore">
                              <i class="fas fa-sync-alt"></i>
                          </button>
                      `}
                  </td>
              </tr>
          `;
          barangTable.append(row);
      }
    }


    // Function to remove an item based on its slug
    function removeItemBySlug(slug) {
        for (let i = 0; i < jsonDataBarang.length; i++) {
            if (jsonDataBarang[i].slug === slug) {
                let data = jsonDataBarang.shift();
                jsonDataBarang.push(data);
                break; // Exit the loop
            }
        }
    }

    // function generate pagination page 
    function generatePagerPagination(totalPages = 1, page = 1){

      let $pagination = $('#pagination-barang');
      $pagination.empty();

      let startPagination = 1;
      let endPagination = totalPages;


      if (totalPages > 10) {
        if (page <= 6) {
          startPagination = 1;
          endPagination = 10;
        } else if (page >= totalPages - 5) {
          startPagination = totalPages - 9;
          endPagination = totalPages;
        } else {
          startPagination = page - 5;
          endPagination = parseInt(page) + 4;
        }
      }

      for (let i = startPagination; i <= endPagination; i++) {
          $pagination.append(`<li class="page-item ${i == page ? 'active' : ''}"><a class="page-link" href="javascript:void(0)" data-page="${i}">${i}</a></li>`);
      }
    }

    function formatRupiah(angka) {
      if (isNaN(angka)) {
        return '';
    }
      // Check if the number is negative
      var isNegative = angka < 0;
      // Convert the number to a positive one for formatting
      var positiveAngka = Math.abs(angka);
      // Reverse the number string
      var reverse = positiveAngka.toString().split('').reverse().join('');
      // Match groups of three digits
      var ribuan = reverse.match(/\d{1,3}/g);
      if (ribuan) {
          // Join the groups with a dot and reverse the string back
          var formatted = ribuan.join('.').split('').reverse().join('');
          // Add the negative sign back if the original number was negative
          return (isNegative ? '-Rp ' : 'Rp ') + formatted;
      } else {
          return (isNegative ? '-Rp ' : 'Rp ') + reverse;
      }
    }

    function changeStatusBySlug(slug, status) {
      for (let i = 0; i < jsonDataBarang.length; i++) {
          if (jsonDataBarang[i].slug === slug) {
              jsonDataBarang[i].status = status;
              break; // Hentikan loop setelah data ditemukan dan diubah
          }
      }
    };

  });
</script>
<?= $this->endSection() ?>