<?= $this->extend('dashboard/layouts/app'); ?>

<?= $this->section('content'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Customer</h1>
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
                  <button type="button" id="btn-tambah" class="btn btn-success">Tambah</button>
                  <button type="button" id="btn-simpan" data-simpan="new" data-id="" class="btn btn-success d-none" disabled>Simpan</button>
                  <button type="button" id="btn-batal" class="btn btn-secondary d-none">Batal</button>
                </div>
                <div class="card-tools">
                  <div class="input-group">
                    <input type="text" id="search" class="form-control" placeholder="Cari Nama/Toko/PT" value="">
                  </div>
                </div>
              </div>
              <div class="card-body" >
                <div class="row">
                  <div class="col-md-12 d-none mt-3" id="input-section">
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <label for="u-name">Nama<span class="text-danger">*</span></label>
                          <input type="text" id="u-name" name="name" class="form-control" data-value="" placeholder="like: Abimanyu">
                          <div class="invalid-feedback d-none">
                            Nama harus unique(tidak boleh sama dengan yang lain).
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="u-alamat">Alamat</label>
                          <input type="text" id="u-alamat" name="alamat" placeholder="Alamat" class="form-control" data-value="">
                        </div>
                        <div class="form-group">
                          <label for="u-toko">Nama toko/PT<span class="text-danger">*</span></label>
                          <input type="text" id="u-toko" name="toko" class="form-control" data-value="" placeholder="like: UD Jaya Abadi">
                          <div class="invalid-feedback d-none">
                            Nama toko harus di isi.
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="u-bank">Bank</label>
                          <input type="text" name="bank" id="u-bank" class="form-control" placeholder="like: Bank Central Asia (BCA)">
                          <div class="invalid-feedback d-none">
                            Nama bank harus di isi.
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label for="u-email">Email</label>
                          <input type="email" id="u-email" name="email" class="form-control" data-value="" placeholder="like: abimanyu@gmail.com">
                          <div class="invalid-feedback d-none">
                            invalid email.
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="u-phone">no HP/Whatsapp<span class="text-danger">*</span></label>
                          <input type="text" id="u-phone" name="phone" class="form-control" data-value="" placeholder="like:+62 857 3689 7503,+62-857-3689-7503,(+62)857 3689 7503,0857-3689-7503,(+62)85736897503,085736897503,+62 85 736 897 503,085 736 897 503,(+62)85 736897503,085-736-897-503,">
                          <div class="invalid-feedback d-none">
                            invalid no Whatsapp.
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="u-alamat-toko">Alamat toko/PT<span class="text-danger">*</span></label>
                          <input type="text" id="u-alamat-toko" name="alamat_toko" class="form-control" data-value="" placeholder="Alamat Toko/PT">
                          <div class="invalid-feedback d-none">
                            Alamat toko harus di isi.
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="u-no-rekening">No Rekening</label>
                          <input type="text" id="u-no-rekening" name="no_rekening" class="form-control" data-value="" placeholder="No Rekening">
                          <div class="invalid-feedback d-none">
                            No rekening harus di isi.
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="table-responsive" style="height: 350px;">                
                      <table class="table table-head-fixed">
                        <thead>
                          <tr>
                            <th scope="row">#</th>
                            <th scope="row">Nama</th>
                            <th scope="row">No Whatsapp</th>
                            <th scope="row">Nama Toko/PT</th>
                            <th scope="row">#</th>
                          </tr>
                        </thead>
                        <tbody id="table-data"></tbody>
                      </table>
                    </div>
                  </div>
                </div>
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
  // data check unique value
    const toko = [];
    const jsonData = [];
    const $tableData = $('tbody#table-data');

  // group button
    const btnTambah = $('#btn-tambah');
    const btnSimpan = $('#btn-simpan');
    const btnBatal = $('#btn-batal');
    const search = $('#search');

    // group input
    const inputDiv = $('#input-section');
    const inpName = $('#u-name');
    const inpEmail = $('#u-email');
    const inpPhone = $('#u-phone');
    const inpAlamat = $('#u-alamat');
    const inpToko = $('#u-toko');
    const inpAlamatToko = $('#u-alamat-toko');
    const inpBank = $('#u-bank');
    const inpNoRekening = $('#u-no-rekening');

    // validation
    const emailPattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    const phoneNumberPattern = /^(?:\+62|0)(?:\s*\(?\d{2,3}\)?\s*|\-?\d\s*){9,15}$/;


    $(function () {
        fetchData((data) => {
          processData(data);
          generateData();
        });

        search.on('input', function () { 
          let value = $(this).val();
          generateData(value);
        });// end $intputSearch

        btnTambah.on('click', function(){
          toggleHide();
          btnSimpan.prop('disabled', true);
          btnSimpan.attr('data-simpan', 'new');
          btnSimpan.attr('data-id', '');
          inpName.val('');
          inpEmail.val('');
          inpPhone.val('');
          inpAlamat.val('');
          inpToko.val('');
          inpAlamatToko.val('');
          inpBank.val('');
          inpNoRekening.val('');
          inpName.attr('data-value','');
          inpEmail.attr('data-value','');
          inpPhone.attr('data-value','');
          inpAlamat.attr('data-value','');
          inpToko.attr('data-value','');
          inpAlamatToko.attr('data-value','');
          inpBank.attr('data-value','');
          inpNoRekening.attr('data-value','');
        });
        
        btnBatal.on('click', function(){
          toggleHide();
          btnSimpan.prop('disabled', true);
          btnSimpan.attr('data-simpan', 'new');
          btnSimpan.attr('data-id', '');
          inpName.val('');
          inpEmail.val('');
          inpPhone.val('');
          inpAlamat.val('');
          inpToko.val('');
          inpAlamatToko.val('');
          inpBank.val('');
          inpNoRekening.val('');
          inpName.attr('data-value','');
          inpEmail.attr('data-value','');
          inpPhone.attr('data-value','');
          inpAlamat.attr('data-value','');
          inpToko.attr('data-value','');
          inpAlamatToko.attr('data-value','');
          inpBank.attr('data-value','');
          inpNoRekening.attr('data-value','');
        });

        $('.form-control').on('input', function() {
          let inputFocus = $(this);
          let typeInput = inputFocus.attr('type');
          let nameInput = inputFocus.attr('name');
          let oldInput = inputFocus.attr('data-value');
          let feedbackDiv = inputFocus.parent().find('.invalid-feedback');
          let typeSimpan = btnSimpan.attr('data-simpan');
          
          if (typeSimpan == 'update') {
            switch (nameInput) {
                case 'email':
                    let isEmail = emailPattern.test(inputFocus.val());
    
                    inputFocus.toggleClass('is-invalid', !isEmail);
                    feedbackDiv.toggleClass('d-none', isEmail);
                    feedbackDiv.html('Invalid email.');
                    break;
                case 'toko':
                    if (inputFocus.val() !== oldInput) {
      
                      inputFocus.toggleClass('is-invalid', false);
                      feedbackDiv.toggleClass('d-none', true);
                      feedbackDiv.html('Invalid nama toko.');

                      // Check if the input value exists in the array
                      if ($.inArray(inputFocus.val(), toko) !== -1) {
                        inputFocus.toggleClass('is-invalid', true);
                        feedbackDiv.toggleClass('d-none', false);
                        feedbackDiv.html('Toko harus unique(tidak boleh sama dengan yang lain atau masukkan Toko lama).');
                      }
                    } else {
                      inputFocus.toggleClass('is-invalid', false);
                      feedbackDiv.toggleClass('d-none', true);
                    }
                    break;
                case 'phone':
                    let isNumberPhone = phoneNumberPattern.test(inputFocus.val());
        
                    inputFocus.toggleClass('is-invalid', !isNumberPhone);
                    feedbackDiv.toggleClass('d-none', isNumberPhone);
                    feedbackDiv.html('invalid no Whatsapp.');
                    break;
                default:
                    break;
            }

            btnSimpan.prop('disabled', !(
              inpName.val() && !inpName.hasClass('is-invalid') &&
              inpPhone.val() && !inpPhone.hasClass('is-invalid') &&
              inpToko.val() && !inpToko.hasClass('is-invalid') &&
              inpAlamatToko.val() && !inpAlamatToko.hasClass('is-invalid')
            ));

          } else {
            switch (nameInput) {
                case 'email':
                    let isEmail = emailPattern.test(inputFocus.val());
    
                    inputFocus.toggleClass('is-invalid', !isEmail);
                    feedbackDiv.toggleClass('d-none', isEmail);
                    feedbackDiv.html('Invalid email.');
                    break;
                case 'toko':
                    // Check if the input value exists in the array
                    if ($.inArray(inputFocus.val(), toko) !== -1) {
                      inputFocus.toggleClass('is-invalid', true);
                      feedbackDiv.toggleClass('d-none', false);
                      feedbackDiv.html('Toko harus unique(tidak boleh sama dengan yang lain).');
                    } else {
                      inputFocus.toggleClass('is-invalid', false);
                      feedbackDiv.toggleClass('d-none', true);
                    }
                    break;
                case 'phone':
                    let isNumberPhone = phoneNumberPattern.test(inputFocus.val());
        
                    inputFocus.toggleClass('is-invalid', !isNumberPhone);
                    feedbackDiv.toggleClass('d-none', isNumberPhone);
                    feedbackDiv.html('invalid no Whatsapp.(Wajib di isi)');
                    break;
                default:
                    break;
            }

            btnSimpan.prop('disabled', !(
              inpName.val() && !inpName.hasClass('is-invalid') &&
              inpPhone.val() && !inpPhone.hasClass('is-invalid') &&
              inpToko.val() && !inpToko.hasClass('is-invalid') &&
              inpAlamatToko.val() && !inpAlamatToko.hasClass('is-invalid')
            ));
          }
        });

        $tableData.on('click', 'button.btn-edit,button.btn-delete', function (){
          let clickedButton = $(this);

          let uName = clickedButton.attr('data-nama');
          let uEmail = clickedButton.attr('data-email');
          let uPhone = clickedButton.attr('data-phone');
          let uAlamat = clickedButton.attr('data-alamat');
          let uNamaToko = clickedButton.attr('data-nama_toko');
          let uAlamatToko = clickedButton.attr('data-alamat_toko');
          let uBank = clickedButton.attr('data-bank');
          let uNoRekening = clickedButton.attr('data-no_rekening');
          let uID = clickedButton.attr('data-id');
          if (clickedButton.hasClass('btn-edit')) {
            btnSimpan.attr('data-simpan', 'update');
            btnSimpan.attr('data-id', uID);
            inpName.val(uName);
            inpEmail.val(uEmail);
            inpPhone.val(uPhone);
            inpAlamat.val(uAlamat);
            inpToko.val(uNamaToko);
            inpAlamatToko.val(uAlamatToko);
            inpBank.val(uBank);
            inpNoRekening.val(uNoRekening);
            inpName.attr('data-value', uName);
            inpEmail.attr('data-value',uEmail);
            inpPhone.attr('data-value',uPhone);
            inpAlamat.attr('data-value',uAlamat);
            inpToko.attr('data-value', uNamaToko);
            inpAlamatToko.attr('data-value',uAlamatToko);
            inpBank.attr('data-value',uBank);
            inpNoRekening.attr('data-value',uNoRekening);
            if (inputDiv.hasClass('d-none')) {toggleHide()}
          } else if(clickedButton.hasClass('btn-delete')){
            let formData = new FormData();
            formData.append('_method', 'DELETE');

            if (confirm(`Apakah anda ingin menghapus data customer(${uName})?`)) {              
              $.ajax({
                  url: `<?= url_to('preference.customer') ?>/delete/${uID}`,
                  type: "POST",
                  data: formData,
                  contentType: false,
                  processData: false,
                  success: function (response) {
                    makeToast(response.bg, response.message);
                    fetchData((data) => {
                      processData(data);
                      generateData();
                    });
                  },
                  error: function(xhr, status, error) {
                      makeToast('bg-danger', `Error: ${error}`);
                  }
              });
            }

          }
        });

        btnSimpan.on('click', function (){
          let typeSimpan = $(this).attr('data-simpan');
          let formData = new FormData();
          let urlSimpan = '<?= url_to('preference.customer.store') ?>';
          
          if (typeSimpan == 'update') {
              let SID = $(this).attr('data-id');
              urlSimpan = `<?= url_to('preference.customer') ?>/update/${SID}`;
              formData.append('_method', 'PUT');
          }

          formData.append('nama', inpName.val());
          formData.append('email', inpEmail.val());
          formData.append('phone', inpPhone.val());
          formData.append('alamat', inpAlamat.val());
          formData.append('nama_toko', inpToko.val());
          formData.append('alamat_toko', inpAlamatToko.val());
          formData.append('bank', inpBank.val());
          formData.append('no_rekening', inpNoRekening.val());

          $.ajax({
              url: urlSimpan,
              type: "POST",
              data: formData,
              contentType: false,
              processData: false,
              success: function (response) {
                makeToast(response.bg, response.message);
                btnBatal.click();
                fetchData((data) => {
                  processData(data);
                  generateData();
                });
              },
              error: function(xhr, status, error) {
                    makeToast('bg-danger', `Error: ${error}`);
                }
          });

          
        });

    });

    function fetchData(callback) {
      $.ajax({
          url: '<?= url_to('preference.customer.json') ?>',
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
      jsonData.length = 0;
      for (let i = 0; i < response.length; i++) {
          jsonData.push({
            id: response[i].id,
            nama: response[i].nama,
            email: response[i].email,
            phone: response[i].phone,
            alamat: response[i].alamat,
            toko: response[i].nama_toko,
            alamatToko: response[i].alamat_toko,
            bank: response[i].bank,
            noRekening: response[i].no_rekening,
          });
          toko.push(response[i].nama_toko);
      }
  }

  function generateData(search = null) {
      $tableData.empty();

      let data = jsonData;

      if (search) {
          data = jsonData.filter(function (item) {
              return item.nama.toLowerCase().includes(search.toLowerCase()) || item.toko.toLowerCase().includes(search.toLowerCase());
          });
      }

      if (data.length === 0) {
          $tableData.append('<tr><td colspan="4" class="text-center">Belum ada Customer tercantum</td></tr>');
          return;
      }

      for (let i = 0; i < data.length; i++) {
          let row = `
              <tr>
                  <td>
                      <div class="button-group">
                          <button type="button" class="btn btn-default btn-edit" title="edit" data-nama="${data[i].nama}" data-email="${data[i].email}" data-phone="${data[i].phone}" data-alamat="${data[i].alamat}" data-nama_toko="${data[i].toko}" data-alamat_toko="${data[i].alamatToko}" data-bank="${data[i].bank}" data-no_rekening="${data[i].noRekening}" data-id="${data[i].id}">
                              <i class="fas fa-pencil-alt"></i>
                          </button>
                      </div>
                  </td>
                  <td>${data[i].nama}</td>
                  <td>${data[i].phone}</td>
                  <td>${data[i].toko}</td>
                  <td>
                      <div class="button-group">
                          <button type="button" class="btn btn-default btn-delete" title="delete" data-nama="${data[i].nama}" data-email="${data[i].email}" data-phone="${data[i].phone}" data-alamat="${data[i].alamat}" data-nama_toko="${data[i].toko}" data-alamat_toko="${data[i].alamatToko}" data-bank="${data[i].bank}" data-no_rekening="${data[i].noRekening}" data-id="${data[i].id}">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 7l16 0"></path><path d="M10 11l0 6"></path><path d="M14 11l0 6"></path><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path></svg>
                          </button>
                      </div>
                  </td>
              </tr>
          `;
          $tableData.append(row);
      }
  }

  function toggleHide()
  {
      btnTambah.toggleClass('d-none');
      btnSimpan.toggleClass('d-none');
      btnBatal.toggleClass('d-none');
      inputDiv.toggleClass('d-none');
      search.toggleClass('d-none');
  }
</script>
<?= $this->endSection(); ?>