<?= $this->extend('dashboard/layouts/app'); ?>

<?= $this->section('content'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">User</h1>
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
                    <button type="button" id="btn-simpan" data-simpan="new" data-id="" class="btn btn-success d-none" disabled>Simpan</button>
                    <button type="button" id="btn-batal" class="btn btn-secondary d-none">Batal</button>
                  </div>
                  <div class="col-md-12 d-none mt-3" id="input-section">
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <label for="u-name">Nama</label>
                          <input type="text" id="u-name" name="name" class="form-control" data-value="" placeholder="like: Abimanyu">
                          <div class="invalid-feedback d-none">
                            Nama harus unique(tidak boleh sama dengan yang lain).
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="u-username">Username</label>
                          <input type="text" id="u-username" name="username" class="form-control" data-value="" placeholder="like: abimanyu">
                          <div class="invalid-feedback d-none">
                            Username harus unique(tidak boleh sama dengan yang lain).
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="u-initial">Initial</label>
                          <input type="text" id="u-initial" name="initial" class="form-control" data-value="" placeholder="like: idk">
                          <div class="invalid-feedback d-none">
                            Initial harus unique(tidak boleh sama dengan yang lain).
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="u-pass">Password</label>
                          <input type="text" id="u-pass" name="password" class="form-control" data-value="" placeholder="password">
                          <div class="invalid-feedback d-none">
                            Password lemah.
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
                          <label for="u-phone">no HP/Whatsapp</label>
                          <input type="text" id="u-phone" name="phone" class="form-control" data-value="" placeholder="like: 08123456789">
                          <div class="invalid-feedback d-none">
                            invalid no Whatsapp.
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="u-role">Role</label>
                          <?php if(sizeof($role)): ?>
                            <select class="form-control" name="role" id="u-role" data-value="">
                              <?php foreach($role as $r): ?>
                                <?php if(in_groups('admin', user_id())): ?>
                                  <?php if ($r->name == 'redaktur'): ?>
                                    <option value="<?= $r->name ?>"><?= $r->description ?></option>
                                  <?php endif; ?>
                                <?php else : ?>
                                  <?php switch ($r->name) {
                                    case 'admin':
                                      # code...
                                      break;
                                    case 'redaktur':
                                      # code...
                                      break;
                                    default:
                                      # code...
                                      echo "<option value='$r->name'> $r->description</option>";
                                      break;
                                  } ?>
                                <?php endif; ?>
                              <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback d-none">
                              <?= $invaliteRole ?>
                            </div>
                          <?php else : ?>
                            <p class="text-center">Role akan didefaultkan pada kariawan</p>
                            <div class="invalid-feedback d-none">
                              invalid role(role hanya boleh di isi dengan kariawan).
                            </div>
                            <input type="hidden" class="u-role" value="kariawan" data-value="">
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th scope="row" style="width: 50px;">#</th>
                      <th scope="row">Nama</th>
                      <th scope="row">Initial</th>
                      <th scope="row">E-mail</th>
                      <th scope="row">Phone</th>
                      <th scope="row">Role</th>
                      <th scope="row" style="width: 50px;"></th>
                    </tr>
                  </thead>
                  <tbody id="user-table">
                    <?php if(sizeof($data)) : ?>
                      <?php foreach($data as $item) : ?>
                        <tr class="<?= $item->status == 'blocked' ? 'text-danger' : '' ?>">
                          <td style="width: 50px;">
                            <button type="button" class="btn btn-default button-edit" title="edit" data-name="<?= $item->name ?>" data-initial="<?= $item->initial ?>" data-email="<?= $item->email ?>" data-phone="<?= $item->phone ?>" data-role="<?= $item->role ?>" data-username="<?= $item->username ?>" data-id="<?= $item->id ?>">
                              <i class="fas fa-pencil-alt"></i>
                            </button>
                          </td>
                          <td><?= $item->name ?></td>
                          <td><?= $item->initial ?></td>
                          <td><?= $item->email ?></td>
                          <td><?= $item->phone ?></td>
                          <td><?= ucfirst($item->role) ?></td>
                          <td style="width: 50px;">
                            <button type="button" class="btn btn-default button-ban" title="<?= $item->status == 'blocked' ? 'unban user' : 'ban user' ?>" data-name="<?= $item->name ?>" data-initial="<?= $item->initial ?>" data-email="<?= $item->email ?>" data-phone="<?= $item->phone ?>" data-role="<?= $item->role ?>" data-username="<?= $item->username ?>" data-id="<?= $item->id ?>" data-status="<?= $item->status ?>">
                              <i class="fas <?= $item->status == 'blocked' ? 'fa-lock-open' : 'fa-ban' ?>"></i>
                            </button>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else : ?>
                      <tr><td colspan="7" class="text-center">Belum ada User selain kamu</td></tr>
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
        // data check unique value
        const name = [];
        const username = [];
        const initial = [];
        const email = [];

      // group button
        const btnTambah = $('#btn-tambah');
        const btnSimpan = $('#btn-simpan');
        const btnBatal = $('#btn-batal');

        // group input
        const inputDiv = $('#input-section');
        const inpName = $('#u-name');
        const inpUsername = $('#u-username');
        const inpInitial = $('#u-initial');
        const inpEmail = $('#u-email');
        const inpPhone = $('#u-phone');
        const inpRole = $('#u-role');
        const inpPass = $('#u-pass');
        inpRole.val('editor');

        // validation
        const emailPattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        const usernamePattern = /^[a-zA-Z0-9_]{4,25}$/; // Example pattern for usernames
        const phoneNumberPattern = /^(\+62|0)[1-9][0-9]{9,15}$/;
        // const passwordPattern = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/; //dengan spesial karakter
        const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/; // tanpa spesial karakter

        // ajax data unique value
        getDataUniqueValue();

        function getDataUniqueValue()
        {
          name.length = 0;
          username.length = 0;
          initial.length = 0;
          email.length = 0;

          $.ajax({
            url: "<?= url_to('preference.user.json') ?>",
            type: "POST",
            dataType: "json",
            success: function (response) {
              if (response.lenght !== 0) {
                for (let i = 0; i < response.length; i++) {
                  name.push(response[i].name);
                  username.push(response[i].username);
                  initial.push(response[i].initial);
                  email.push(response[i].email);
                }
              }
            }
          });
        }

        btnTambah.on('click', function(){
          toggleHide();
          btnSimpan.prop('disabled', true);
          btnSimpan.attr('data-simpan', 'new');
          btnSimpan.attr('data-id', '');
          inpRole.attr('data-value', '');
          inpName.val('');
          inpUsername.val('');
          inpInitial.val('');
          inpEmail.val('');
          inpPhone.val('');
          inpRole.val('editor');
          inpPass.val('');
          inpName.attr('data-value','');
          inpUsername.attr('data-value','');
          inpInitial.attr('data-value','');
          inpEmail.attr('data-value','');
          inpPhone.attr('data-value','');
        });
        
        btnBatal.on('click', function(){
          toggleHide();
          btnSimpan.prop('disabled', true);
          btnSimpan.attr('data-simpan', 'new');
          btnSimpan.attr('data-id', '');
          inpName.val('');
          inpUsername.val('');
          inpInitial.val('');
          inpEmail.val('');
          inpPhone.val('');
          inpRole.val('editor');
          inpRole.attr('data-value', '');
          inpPass.val('');
          inpName.attr('data-value','');
          inpUsername.attr('data-value','');
          inpInitial.attr('data-value','');
          inpEmail.attr('data-value','');
          inpPhone.attr('data-value','');
        });

        function toggleHide()
        {
            btnTambah.toggleClass('d-none');
            btnSimpan.toggleClass('d-none');
            btnBatal.toggleClass('d-none');
            inputDiv.toggleClass('d-none');
        }

        $('.form-control').on('input', function() {
          let inputFocus = $(this);
          let typeInput = inputFocus.attr('type');
          let nameInput = inputFocus.attr('name');
          let oldInput = inputFocus.attr('data-value');
          let feedbackDiv = inputFocus.parent().find('.invalid-feedback');
          let typeSimpan = btnSimpan.attr('data-simpan');
          let dataRole = ['redaktur','contributor','kariawan'];
          
          if (typeSimpan == 'update') {
            switch (nameInput) {
                case 'email':
                    let isEmail = emailPattern.test(inputFocus.val());
    
                    inputFocus.toggleClass('is-invalid', !isEmail);
                    feedbackDiv.toggleClass('d-none', isEmail);
                    feedbackDiv.html('Invalid email.');

                    
                    if (inputFocus.val() !== oldInput){                    
                      // Check if the input value exists in the array
                      if ($.inArray(inputFocus.val(), email) !== -1) {
                        inputFocus.toggleClass('is-invalid', true);
                        feedbackDiv.toggleClass('d-none', false);
                        feedbackDiv.html('Email harus unique(tidak boleh sama dengan yang lain atau masukkan email lama).');
                      }
                    }
                    break;
                case 'name':
                    if (inputFocus.val() !== oldInput) {                
                      // Check if the input value exists in the array
                      if ($.inArray(inputFocus.val(), name) !== -1) {
                        inputFocus.toggleClass('is-invalid', true);
                        feedbackDiv.toggleClass('d-none', false);
                        feedbackDiv.html('Nama harus unique(tidak boleh sama dengan yang lain atau masukkan nama lama).');
                      } else {
                        inputFocus.toggleClass('is-invalid', false);
                        feedbackDiv.toggleClass('d-none', true);
                      }
                    } else {
                      inputFocus.toggleClass('is-invalid', false);
                      feedbackDiv.toggleClass('d-none', true);
                    }
                    break;
                case 'username':
                    if (inputFocus.val() !== oldInput) {
                      let isUsername = usernamePattern.test(inputFocus.val());
      
                      inputFocus.toggleClass('is-invalid', !isUsername);
                      feedbackDiv.toggleClass('d-none', isUsername);
                      feedbackDiv.html('Invalid username.');

                      // Check if the input value exists in the array
                      if ($.inArray(inputFocus.val(), username) !== -1) {
                        inputFocus.toggleClass('is-invalid', true);
                        feedbackDiv.toggleClass('d-none', false);
                        feedbackDiv.html('Username harus unique(tidak boleh sama dengan yang lain atau masukkan username lama).');
                      }
                    } else {
                      inputFocus.toggleClass('is-invalid', false);
                      feedbackDiv.toggleClass('d-none', true);
                    }
                    break;
                case 'initial':
                    if (inputFocus.val() !== oldInput) {                
                      // Check if the input value exists in the array
                      if ($.inArray(inputFocus.val(), initial) !== -1) {
                        inputFocus.toggleClass('is-invalid', true);
                        feedbackDiv.toggleClass('d-none', false);
                        feedbackDiv.html('Initial harus unique(tidak boleh sama dengan yang lain atau masukkan initial lama).');
                      } else {
                        inputFocus.toggleClass('is-invalid', false);
                        feedbackDiv.toggleClass('d-none', true);
                      }
                    } else {
                      inputFocus.toggleClass('is-invalid', false);
                        feedbackDiv.toggleClass('d-none', true);
                    }
                    break;
                case 'role':
                    if ($.inArray(inputFocus.val(), dataRole) !== -1) {
                      inputFocus.toggleClass('is-invalid', false);
                      feedbackDiv.toggleClass('d-none', true);
                    } else {
                      inputFocus.toggleClass('is-invalid', true);
                      feedbackDiv.toggleClass('d-none', false);
                    }
                    break;
                case 'phone':
                    if (inputFocus.val() !== '') {   
                      if (inputFocus.val() !== oldInput) {                  
                        let isNumberPhone = phoneNumberPattern.test(inputFocus.val());
            
                        inputFocus.toggleClass('is-invalid', !isNumberPhone);
                        feedbackDiv.toggleClass('d-none', isNumberPhone);
                        feedbackDiv.html('invalid no Whatsapp.');
                      }
                    } else {
                      inputFocus.toggleClass('is-invalid', false);
                      feedbackDiv.toggleClass('d-none', true);
                    }
                    break;
                case 'password':
                    if (inputFocus.val() !== '') {                
                      let isStandarPassword = passwordPattern.test(inputFocus.val());
          
                      inputFocus.toggleClass('is-invalid', !isStandarPassword);
                      feedbackDiv.toggleClass('d-none', isStandarPassword);
                      feedbackDiv.html('Password terlalu lemah(minimal 8 karakter, satu huruf besar, satu huruf kecil, dan satu angka).');
                    } else {
                      inputFocus.toggleClass('is-invalid', false);
                      feedbackDiv.toggleClass('d-none', true);
                    }
                    break;
                default:
                    break;
            }

            btnSimpan.prop('disabled', !(
              inpName.val() && !inpName.hasClass('is-invalid') &&
              inpUsername.val() && !inpUsername.hasClass('is-invalid') &&
              inpEmail.val() && !inpEmail.hasClass('is-invalid') &&
              inpInitial.val() && !inpInitial.hasClass('is-invalid')
            ));

          } else {
            switch (nameInput) {
                case 'email':
                    let isEmail = emailPattern.test(inputFocus.val());
    
                    inputFocus.toggleClass('is-invalid', !isEmail);
                    feedbackDiv.toggleClass('d-none', isEmail);
                    feedbackDiv.html('Invalid email.');

                    // Check if the input value exists in the array
                    if ($.inArray(inputFocus.val(), email) !== -1) {
                        inputFocus.toggleClass('is-invalid', true);
                        feedbackDiv.toggleClass('d-none', false);
                        feedbackDiv.html('Email harus unique(tidak boleh sama dengan yang lain).');
                    }
                    break;
                case 'name':
                    // Check if the input value exists in the array
                    if ($.inArray(inputFocus.val(), name) !== -1) {
                      inputFocus.toggleClass('is-invalid', true);
                      feedbackDiv.toggleClass('d-none', false);
                      feedbackDiv.html('Nama harus unique(tidak boleh sama dengan yang lain).');
                    } else {
                      inputFocus.toggleClass('is-invalid', false);
                      feedbackDiv.toggleClass('d-none', true);
                    }
                    break;
                case 'username':
                    let isUsername = usernamePattern.test(inputFocus.val());
    
                    inputFocus.toggleClass('is-invalid', !isUsername);
                    feedbackDiv.toggleClass('d-none', isUsername);
                    feedbackDiv.html('Invalid username.');

                    // Check if the input value exists in the array
                    if ($.inArray(inputFocus.val(), username) !== -1) {
                      inputFocus.toggleClass('is-invalid', true);
                      feedbackDiv.toggleClass('d-none', false);
                      feedbackDiv.html('Username harus unique(tidak boleh sama dengan yang lain).');
                    }
                    break;
                case 'initial':
                    // Check if the input value exists in the array
                    if ($.inArray(inputFocus.val(), initial) !== -1) {
                      inputFocus.toggleClass('is-invalid', true);
                      feedbackDiv.toggleClass('d-none', false);
                      feedbackDiv.html('Initial harus unique(tidak boleh sama dengan yang lain).');
                    } else {
                      inputFocus.toggleClass('is-invalid', false);
                      feedbackDiv.toggleClass('d-none', true);
                    }
                    break;
                case 'role':
                    if ($.inArray(inputFocus.val(), dataRole) !== -1) {
                      inputFocus.toggleClass('is-invalid', false);
                      feedbackDiv.toggleClass('d-none', true);
                    } else {
                      inputFocus.toggleClass('is-invalid', true);
                      feedbackDiv.toggleClass('d-none', false);
                    }
                    break;
                case 'phone':
                    if (inputFocus.val() !== '') {   
                      let isNumberPhone = phoneNumberPattern.test(inputFocus.val());
          
                      inputFocus.toggleClass('is-invalid', !isNumberPhone);
                      feedbackDiv.toggleClass('d-none', isNumberPhone);
                      feedbackDiv.html('invalid no Whatsapp.(boleh kosong)');
                    } else {
                      inputFocus.toggleClass('is-invalid', false);
                      feedbackDiv.toggleClass('d-none', true);
                    }
                    break;
                case 'password':
                    let isStandarPassword = passwordPattern.test(inputFocus.val());
                    
                    inputFocus.toggleClass('is-invalid', !isStandarPassword);
                    feedbackDiv.toggleClass('d-none', isStandarPassword);
                    feedbackDiv.html('Password terlalu lemah(minimal 8 karakter, satu huruf besar, satu huruf kecil, dan satu angka).');
                    break;
                default:
                    break;
            }

            btnSimpan.prop('disabled', !(
              inpName.val() && !inpName.hasClass('is-invalid') &&
              inpUsername.val() && !inpUsername.hasClass('is-invalid') &&
              inpEmail.val() && !inpEmail.hasClass('is-invalid') &&
              inpInitial.val() && !inpInitial.hasClass('is-invalid') &&
              inpPass.val() && !inpPass.hasClass('is-invalid')
            ));
          }
        });

        $('#user-table').on('click', 'button.button-edit,button.button-ban', function (){
          let clickedButton = $(this);

          let uName = clickedButton.attr('data-name');
          let uUsername = clickedButton.attr('data-username');
          let uInitial = clickedButton.attr('data-initial');
          let uEmail = clickedButton.attr('data-email');
          let uRole = clickedButton.attr('data-role');
          let uPhone = clickedButton.attr('data-phone');
          let uID = clickedButton.attr('data-id');
          let uStatus = clickedButton.attr('data-status');
          if (clickedButton.hasClass('button-edit')) {
            btnSimpan.attr('data-simpan', 'update');
            btnSimpan.attr('data-id', uID);
            inpName.val(uName);
            inpUsername.val(uUsername);
            inpInitial.val(uInitial);
            inpEmail.val(uEmail);
            inpPhone.val(uPhone);
            inpRole.val(uRole);
            inpName.attr('data-value', uName);
            inpUsername.attr('data-value', uUsername);
            inpInitial.attr('data-value', uInitial);
            inpEmail.attr('data-value', uEmail);
            inpPhone.attr('data-value', uPhone);
            inpRole.attr('data-value', uRole);
            if (inputDiv.hasClass('d-none')) {toggleHide()}
          } else if(clickedButton.hasClass('button-ban')){
            let dataURL = uStatus == 'blocked' ? `<?= url_to('preference.user') ?>/unblock/${uID}` : `<?= url_to('preference.user') ?>/block/${uID}`;
            let formData = new FormData();
            formData.append('_method', 'PUT');

            $.ajax({
                url: dataURL,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                  makeToast(response.bg, response.message);
                  $( "#user-table" ).load(window.location.href + " #user-table>" );
                  getDataUniqueValue();
                },
                error: function (error) {
                    console.error("Error:", error);
                }
            });
          }
        });

        btnSimpan.on('click', function (){
          let typeSimpan = $(this).attr('data-simpan');
          let userID = $(this).attr('data-id');
          let formData = new FormData();
          let urlSimpan = '<?= url_to('preference.user.store') ?>';

          if (typeSimpan == 'update') {
              urlSimpan = `<?= url_to('preference.user') ?>/update/${userID}`;
            
              formData.append('name', inpName.val());
              formData.append('username', inpUsername.val());
              formData.append('initial', inpInitial.val());
              formData.append('email', inpEmail.val());
              formData.append('role', inpRole.val());
              formData.append('_method', 'PUT');

              // Check if the phone is not empty before adding to data
              if (inpPhone.val() !== '') {
                formData.append('phone', inpPhone.val());
              }

              // Check if the password is not empty before adding to data
              if (inpPass.val() !== '') {
                  formData.append('pass', inpPass.val());
              }
          } else {
            formData.append('name', inpName.val());
            formData.append('username', inpUsername.val());
            formData.append('initial', inpInitial.val());
            formData.append('email', inpEmail.val());
            formData.append('phone', inpPhone.val());
            formData.append('role', inpRole.val());
            formData.append('pass', inpPass.val());
          }

          $.ajax({
              url: urlSimpan,
              type: "POST",
              data: formData,
              contentType: false,
              processData: false,
              success: function (response) {
                makeToast(response.bg, response.message);
                btnBatal.click();
                $( "#user-table" ).load(window.location.href + " #user-table>" );
                getDataUniqueValue();
              },
              error: function (error) {
                  console.error("Error:", error);
              }
          });

          
        });
        
        // Function to add data to the array if the value has changed
        function addToDataIfChanged(dataArray, key, inputElement) {
            if (inputElement.val() !== inputElement.attr('data-value')) {
                let dataObject = {};
                dataObject[key] = inputElement.val();
                dataArray.push(dataObject);
            }
        }

    });
</script>
<?= $this->endSection(); ?>