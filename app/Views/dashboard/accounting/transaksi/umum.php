<?= $this->extend('dashboard/layouts/app'); ?>

<?= $this->section('style') ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="/template/adminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/template/adminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="/template/adminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
            <h1 class="m-0">Transaksi Umum</h1>
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
                <button type="button" id="btn-tambah" class="btn btn-success">Tambah</button>
                <button type="button" id="btn-simpan" class="btn btn-success d-none" data-id="0" disabled>Simpan</button>
                <button type="button" id="btn-batal" class="btn btn-secondary d-none">Batal</button>
                <div class="row">
                  <div class="col-md-12 d-none mt-3" id="input-section">
                    <div class="row gx-3 mb-3 col-md-12">
                      <label for="tanggal-transaksi" class="small my-1">
                      Tanggal
                      <span class="text-danger">*</span>
                      </label>

                      <input name="tanggal-transaksi" id="tanggal-transaksi" type="date"
                      class="form-control example-date-input "
                      value=""
                      required
                      >

                      <div class="invalid-feedback"></div>
                    </div>
                    <div class="row gx-3 mb-3 col-md-12">
                      <label class="small mb-1" for="kwitansi">
                        Kwitansi
                      </label>

                      <input type="text" class="form-control"
                      id="kwitansi"
                      name="kwitansi"
                      value=""
                      >

                      <div class="invalid-feedback"></div>
                    </div>
                    <div class="row gx-3 mb-3 col-md-12">
                      <label class="small mb-1" for="deskripsi">
                        Deskripsi
                      </label>

                      <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"></textarea>

                      <div class="invalid-feedback"></div>
                    </div>
                    <table class="table table-bordered">
                      <thead class="thead-dark">
                        <tr>
                          <th class="align-middle text-center">Type</th>
                          <th class="align-middle text-center">Debit</th>
                          <th class="align-middle text-center">Kredit</th>
                          <th class="align-middle text-center">
                            <button type="button" onclick="setForm()" class="btn btn-icon btn-success">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                              Tambah Baris
                            </button>
                          </th>

                        </tr>
                      </thead>

                      <tbody id="transaksi-form-table"></tbody>

                    </table>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <table id="table-data" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th scope="row" class="align-middle text-center" style="width: 50px;">#</th>
                      <th scope="row" class="align-middle text-center">Tanggal</th>
                      <th scope="row" class="align-middle text-center">Bukti/Kwitansi</th>
                      <th scope="row" class="align-middle text-center">Deskripsi</th>
                      <th scope="row" class="align-middle text-center">Debit</th>
                      <th scope="row" class="align-middle text-center">Kredit</th>
                      <th scope="row" class="align-middle text-center" style="width: 50px;">#</th>
                    </tr>
                  </thead>
                  <tbody id="transaksi-table"></tbody>

                </table>
              </div>
              <!-- end card-body-->
              <div class="card-footer clearfix">
                <ul class="pagination" id="pagination-data"></ul>
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
<!-- DataTables  & Plugins -->
<script src="/template/adminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/template/adminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/template/adminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/template/adminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/template/adminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/template/adminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/template/adminLTE/plugins/jszip/jszip.min.js"></script>
<script src="/template/adminLTE/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/template/adminLTE/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/template/adminLTE/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/template/adminLTE/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/template/adminLTE/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Select2 -->
<script src="/template/adminLTE/plugins/select2/js/select2.full.min.js"></script>
<script>
    // button/input header card
    const btnTambah = $('#btn-tambah');
    const btnSimpan = $('#btn-simpan');
    const btnBatal = $('#btn-batal');
    // form Transaksi
    const inputDiv = $('#input-section');
    const $tanggal = $('#tanggal-transaksi');
    const $kwitansi = $('#kwitansi');
    const $deskripsi = $('#deskripsi');
    const $tableForm = $('#transaksi-form-table');
    const jsonCategory = [];
    // tabel data transaksi
    const $table = $('#table-data');
    const $tableData = $('#transaksi-table');
    const jsonData = [];

    $(function () {

      fetchData((data) => {
        processData(data);
        generateData();
        $table.DataTable({
          "responsive": true, "lengthChange": false, "autoWidth": false,
          // "buttons": [
          //   "copy",
          //   "csv",
          //   "excel",
          //   "pdf",
          //   "print",
          //   // "colvis",
          // ]
        });// }).buttons().container().appendTo('#table-data_wrapper .col-md-6:eq(0)');
      });
      fetchCategory(data => processCategory(data));
        
        btnTambah.on('click', function(){
          var now = new Date();
          var day = ("0" + now.getDate()).slice(-2);
          var month = ("0" + (now.getMonth() + 1)).slice(-2);
          var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
          $tanggal.val(today);
          btnSimpan.prop('disabled', true);
          btnSimpan.attr('data-id', 0);
          toggleHide();
        });
        
        btnBatal.on('click', function(){
          $tanggal.val('');
          $kwitansi.val('');
          $deskripsi.val('');
          $tableForm.empty();
          btnSimpan.prop('disabled', true);
          toggleHide();
        });

        btnSimpan.on('click', () => {
          var dataForm = $tableForm.find('tr');
          var saveState = dataForm.toArray().every(tr => $(tr).attr('data-status') == 'save');
          if (!saveState) {
              $(this).attr('disabled', 'disabled');
              makeToast('bg-danger','siapkan data terlebih dahulu!!!');
              return;
          }

          var dataAccounting = [];
          dataForm.each(function () {
            dataAccounting.push({
              category3_kode: $(this).find('.category').val(),
              debit: $(this).find('.debit-num').val(),
              kredit: $(this).find('.kredit-num').val(),
            });
          });
          var url = '';
          var formData = new FormData();
          formData.append('tanggal', $tanggal.val());
          formData.append('kwitansi', $kwitansi.val());
          formData.append('deskripsi', $deskripsi.val());
          formData.append('accounting', JSON.stringify(dataAccounting));

          if (parseInt(btnSimpan.data('id')) > 0) {
            url = `<?= url_to('accounting.transaksi.umum') ?>/update/${btnSimpan.data('id')}`;
            formData.append('_method', 'PUT');
          } else {
            url = `<?= url_to('accounting.transaksi.umum.store') ?>`;
          }

          $.ajax({
              url: url,
              type: "POST",
              data: formData,
              contentType: false,
              processData: false,
              success: function(response) {
                  makeToast(response.bg, response.message);

                  if (response.bg == 'bg-success') {
                      fetchData((data) => {
                        jsonData.length = 0;
                        processData(data);
                        generateData();
                      });
                      
                      var now = new Date();
                      var day = ("0" + now.getDate()).slice(-2);
                      var month = ("0" + (now.getMonth() + 1)).slice(-2);
                      var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
                      $tanggal.val(today);
                      $kwitansi.val('');
                      $deskripsi.val('');
                      $tableForm.empty();
                      btnBatal.click();
                      btnSimpan.attr('data-id', 0);
                  }
              },
              error: function(xhr, status, error) {
                  makeToast('bg-danger', xhr.responseText);
              }
          });
          
        });//end btnSimpan onClick
        
        $tableData.on('click', 'button.btn-edit, button.btn-delete', function () {
            var clickedButton = $(this);
            var currentID = clickedButton.data('id');

            if (clickedButton.hasClass('btn-edit')) {
                if (inputDiv.hasClass('d-none')) {
                  toggleHide();
                }
                var dataEdit = jsonData.find(e => e.id == currentID);
                $tableForm.empty();
                btnSimpan.attr('data-id', currentID);
                $tanggal.val(dataEdit.tanggal);
                $kwitansi.val(dataEdit.bukti);
                $deskripsi.val(dataEdit.deskripsi);
                $kwitansi.focus();

                var dataEditDetail = dataEdit.detail;
                for (let i = 0; i < dataEditDetail.length; i++) {
                  
                  let option = jsonCategory.map(e => `<option value='${e.kode}' ${e.kode == dataEditDetail[i].kode ? "selected='selected'" : ''}>${e.kode+'|'+e.name}</option>`).join('');
  
                  let row = `
                      <tr data-status='save'>
                          <td class="align-middle text-center">
                              <div class="category-html">${dataEditDetail[i].name}</div>
                              <select class="form-control category d-none">${option}</select>
                              <em class="text-danger err-text hide"></em>
                          </td>
                          <td class="align-middle text-center">
                              <div class="debit-html">${formatRupiah(dataEditDetail[i].debit)}</div>
                              <input type="hidden" class="form-control debit" value="${formatRupiah(dataEditDetail[i].debit)}">
                              <input type="hidden" class="debit-num" value="${dataEditDetail[i].debit}">
                          </td>
                          <td class="align-middle text-center">
                              <div class="kredit-html">${formatRupiah(dataEditDetail[i].kredit)}</div>
                              <input type="hidden" class="form-control kredit" value="${formatRupiah(dataEditDetail[i].kredit)}">
                              <input type="hidden" class="kredit-num" value="${dataEditDetail[i].kredit}">
                          </td>
                          <td class="align-middle text-center">
                              <button type="button" class="btn btn-icon btn-outline-warning btn-edit">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg>
                              </button>
                              <button type="button" class="btn btn-icon btn-outline-success btn-save d-none">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                              </button>
                              <button type="button" class="btn btn-icon btn-outline-danger btn-delete">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                              </button>
                          </td>
                      </tr>
                  `;
                  $tableForm.append(row);
                }
                updateSimpanButtonState();
            } else if (clickedButton.hasClass('btn-delete')) {
              btnBatal.click();
              $.ajax({
                  url: `<?= url_to('accounting.transaksi.umum') ?>/delete/${currentID}`,
                  type: "POST",
                  data: {
                    '_method': 'DELETE',
                  },
                  dataType: 'JSON',
                  success: function(response) {
                      makeToast(response.bg, response.message);
                      if (response.bg == 'bg-success') {
                          fetchData((data) => {
                            jsonData.length = 0;
                            processData(data);
                            generateData();
                          });
                          
                          $tanggal.val('');
                          $kwitansi.val('');
                          $deskripsi.val('');
                          $tableForm.empty();
                          btnBatal.click();
                          btnSimpan.attr('data-id', 0);
                      }
                  },
                  error: function (xhr, status, error) {
                      makeToast('bg-danger', `Error: ${error}`);
                  }
              });
            }
        });// end $tableData onCLick

        $tableForm.on('click', 'button.btn-edit, button.btn-delete, button.btn-save', function() {
            var clickedButton = $(this);
            var currentRow = clickedButton.closest('tr[data-status]');
            var category = currentRow.find('.category');
            var debit = currentRow.find('.debit');
            var kredit = currentRow.find('.kredit');
            var btnSimpan = currentRow.find('.btn-save');
            var btnEdit = currentRow.find('.btn-edit');
            var select2 = currentRow.find('.select2-container');

            // Check if there are other rows with status "" or "edit"
            var unsavedRows = $tableForm.children('tr').not(currentRow).filter('[data-status=""], [data-status="edit"]');
            if (unsavedRows.length > 0) {
                let errText = unsavedRows.find('.err-text');
                errText.removeClass('hide').html('Baris ini harus disimpan dulu.');
                makeToast('bg-danger', 'Ada barisan data yang harus diselesaikan dahulu!!!');
                return; // Do not run any further commands
            } else {
                // Hide error message if there are no unsaved rows
                $tableForm.find('.err-text').addClass('hide').html('');
            }

            if (clickedButton.hasClass('btn-save')) {
                currentRow.attr('data-status', 'save');

                category.addClass('d-none').siblings('.category-html').removeClass('d-none');
                debit.attr('type', 'hidden').siblings('.debit-html').removeClass('d-none');
                kredit.attr('type', 'hidden').siblings('.kredit-html').removeClass('d-none');

                btnEdit.removeClass('d-none').removeAttr('disabled');
                clickedButton.addClass('d-none').attr('disabled', 'disabled');

                select2.hide();

                updateSimpanButtonState();
            } else if (clickedButton.hasClass('btn-delete')) {
                currentRow.animate(
                    {
                        right: '-100%', // Adjust the distance as needed
                        opacity: 0,
                    },
                    1000, // Duration of the animation in milliseconds
                    function () {
                        $(this).remove();
                        updateSimpanButtonState();
                    }
                );
            } else if (clickedButton.hasClass('btn-edit')) {
                currentRow.attr('data-status', 'edit');

                category.removeClass('d-none').siblings('.category-html').addClass('d-none');
                debit.attr('type', 'text').siblings('.debit-html').addClass('d-none');
                kredit.attr('type', 'text').siblings('.kredit-html').addClass('d-none');

                btnSimpan.removeClass('d-none').removeAttr('disabled');
                clickedButton.addClass('d-none').attr('disabled', 'disabled');

                if (select2.length == 0) {
                  category.select2();
                } else {
                  select2.show();
                }

                updateSimpanButtonState();
            }
        });// end $tableForm onClick

        $tableForm.on('input', 'input, select', function() {
            var currentRow = $(this).closest('tr[data-status]');
            var category = currentRow.find('.category');
            var debit = currentRow.find('.debit');
            var kredit = currentRow.find('.kredit');

            // Check if there are other rows with status "" or "edit"
            var unsavedRows = $tableForm.children('tr').not(currentRow).filter('[data-status=""], [data-status="edit"]');
            if (unsavedRows.length > 0) {
                let errText = unsavedRows.find('.err-text');
                errText.removeClass('hide').html('Baris ini harus disimpan dulu.');
                makeToast('bg-danger', 'Ada barisan data yang harus diselesaikan dahulu!!!');
                return; // Do not run any further commands
            } else {
                // Hide error message if there are no unsaved rows
                $tableForm.find('.err-text').addClass('hide').html('');
            }

            if ($(this).hasClass('category')) {
                $(this).siblings('.category-html').html($(this).children(':selected').text());
            } else if ($(this).hasClass('debit') || $(this).hasClass('kredit')) {
              // Sanitize input, allowing negative sign and digits
              var sanitized = $(this).val().replace(/[^0-9-]/g, '');
              $(this).addClass('is-invalid');
              if (sanitized !== '') {
                  $(this).removeClass('is-invalid');
                  var number = parseInt(sanitized, 10);
                  $(this).val(formatRupiah(number));
                  if ($(this).hasClass('debit')) {
                      $(this).siblings('.debit-html').html(formatRupiah(number));
                      $(this).siblings('.debit-num').val(number);
                  } else {
                      $(this).siblings('.kredit-html').html(formatRupiah(number));
                      $(this).siblings('.kredit-num').val(number);
                  }
              }
            }

            if (category.val() !== '') {
                if (debit.siblings('.debit-num').val() == '' && kredit.siblings('.kredit-num').val() == '') {
                  currentRow.find('.btn-save').addClass('d-none');
                } else {
                  currentRow.find('.btn-save').removeClass('d-none');
                }
            }
        });// end $tableForm onInput
        
    });// end document ready

    function toggleHide()
    {
        btnTambah.toggleClass('d-none');
        btnSimpan.toggleClass('d-none');
        btnBatal.toggleClass('d-none');
        inputDiv.toggleClass('d-none');
    }

    function updateSimpanButtonState() {
        var unsavedRows = $tableForm.children('tr').filter('[data-status=""], [data-status="edit"]');
        if ($tableForm.children('tr[data-status=save]').length > 0 && unsavedRows.length === 0 && $tanggal.val() !== '') {
            btnSimpan.removeAttr('disabled');
        } else {
            btnSimpan.attr('disabled', 'disabled');
        }
    }

    function setForm() {
      let child = $tableForm.children('tr');
      let option = jsonCategory.map(e => `<option value='${e.kode}' ${e.code == 111 ? 'selected="selected"' : ''}>${e.kode +'|'+ e.name}</option>`).join('');
      let row = `
          <tr data-status=''>
              <td class="align-middle text-center">
                <div class="category-html d-none">${jsonCategory[0].kode+'|'+jsonCategory[0].name}</div>
                <select class="form-control category" >${option}</select>
                <em class="text-danger err-text hide"></em>
              </td>

              <td class="align-middle text-center">
                  <div class="debit-html d-none">Rp 0</div>
                  <input type="text" class="form-control debit" value="Rp ">
                  <input type="hidden" class="debit-num" value="0">
              </td>

              <td class="align-middle text-center">
                  <div class="kredit-html d-none">Rp 0</div>
                  <input type="text" class="form-control kredit" value="Rp ">
                  <input type="hidden" class="kredit-num" value="0">
              </td>

              <td class="align-middle text-center">

                  <button type="button" class="btn btn-icon btn-outline-warning btn-edit d-none">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg>
                  </button>

                  <button type="button" class="btn btn-icon btn-outline-success btn-save d-none">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                  </button>

                  <button type="button" class="btn btn-icon btn-outline-danger btn-delete">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                  </button>
              </td>
          </tr>
      `;
      let allSaved = child.length === 0 || child.toArray().every(tr => $(tr).attr('data-status') == 'save');
      if (allSaved) {
          // Append row to the table
          $tableForm.append(row);
          updateSimpanButtonState();
          $tableForm.find('tr:last .category').select2();
      } else {
          let errText = child.filter('[data-status=""], [data-status="edit"]').find('.err-text');
          errText.removeClass('hide');
          errText.html('Baris ini harus disimpan dulu!!!');
          makeToast('bg-danger', 'Ada barisan data yang harus diselesaikan dahulu!!!');
      }
    }

  function fetchData(callback) {
      $.ajax({
          url: '<?= url_to('accounting.transaksi.umum.json') ?>',
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

  function processData(response) {
      for (let i = 0; i < response.length; i++) {
          let detail = response[i].detail.map(e => ({
              name: e.name,
              kode: e.kode,
              debit: parseInt(e.debit),
              kredit: parseInt(e.kredit),
          }));

          jsonData.push({
            id: response[i].id,
            tanggal: response[i].tanggal,
            bukti: response[i].bukti !== null ? response[i].bukti : '',
            deskripsi: response[i].deskripsi !== null ?response[i].deskripsi : '',
            status: response[i].status,
            detail: detail,
          });
      }
  }

  function generateData() {
    $tableData.empty();

    let data = jsonData;

    if (data.length === 0) {
        $tableData.append('<tr><td colspan="7" class="text-center">Belum ada Transaksi</td></tr>');
        return;
    }

    for (let i = 0; i < data.length; i++) {
        let debit = data[i].detail.filter(d => parseInt(d.debit) !== 0);
        let kredit = data[i].detail.filter(k => parseInt(k.kredit) !== 0);
        
        let dataDebit = debit.map(e => `
            <p>${e.name}(${formatRupiah(e.debit)})</p>
        `).join('');
        
        let dataKredit = kredit.map(e => `
            <p>${e.name}(${formatRupiah(e.kredit)})</p>
        `).join('');
        
        let row = `
            <tr>
                <td class="align-middle text-center">${i + 1}</td>
                <td class="align-middle text-center">${ubahFormatTanggal(data[i].tanggal)}</td>
                <td class="align-middle text-center">${data[i].bukti}</td>
                <td class="align-middle text-center">${data[i].deskripsi !== undefined ? data[i].deskripsi : ''}</td>
                <td class="align-middle text-center">${dataDebit}</td>
                <td class="align-middle text-center">${dataKredit}</td>
                <td class="align-middle text-center">
                    <div class="btn-list">
                        <button type="button" class="btn btn-icon btn-outline-warning btn-edit" data-id="${data[i].id}" title="edit">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg>
                        </button>
                        <button type="button" class="btn btn-icon btn-outline-danger btn-delete" data-id="${data[i].id}" title="delete">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                        </button>
                    </div>
                </td>
            </tr>
        `;
        
        $tableData.append(row);
    }
  }

  function formatRupiah(angka) {
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
        name: response[i].name,
        kode: response[i].kode,
        detail: response[i].detail !== null ? response[i].detail : '',
      };
      jsonCategory.push(data);
    }
  }

  function ubahFormatTanggal(tanggal) {
      const bulanIndonesia = [
          'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
          'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
      ];
      
      const tanggalSplit = tanggal.split('-');
      const tahun = tanggalSplit[0];
      const bulan = bulanIndonesia[parseInt(tanggalSplit[1], 10) - 1];
      const hari = tanggalSplit[2];
      
      return `${hari} ${bulan} ${tahun}`;
  }

</script>
<?= $this->endSection(); ?>