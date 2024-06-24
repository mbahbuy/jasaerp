<?= $this->extend('dashboard/layouts/app'); ?>

<?= $this->section('content'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Kategori Akuntansi</h1>
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
                <h3 class="card-title">Category</h3>
                <p class="card-text font-italic">Parent kode akun, tidak boleh dirubah.</p>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th scope="row">Kode Kategori</th>
                      <th scope="row">Nama Kategori</th>
                    </tr>
                  </thead>
                  <tbody id="rubrik-table">
                    <?php if(sizeof($category1)) : ?>
                      <?php foreach($category1 as $item) : ?>
                        <tr >
                          <td class=""><?= $item->kode ?></td>
                          <td class=""><?= $item->name ?></td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else : ?>
                      <tr><td colspan="2" class="text-center">Belum ada Kategori</td></tr>
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

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-6">
                        <button type="button" id="btn-tambah2" class="btn btn-success">Tambah</button>
                        <button type="button" id="btn-simpan2" class="btn btn-success d-none" disabled>Simpan</button>
                        <button type="button" id="btn-batal2" class="btn btn-secondary d-none">Batal</button>
                      </div>
                      <div class="col-6">
                        <h4>Subcategory</h4>
                      </div>
                    </div>

                  </div>
                  <div class="col-md-12 d-none mt-3" id="input-section2">
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="select-parent2">Parent</label>
                          <select class="form-control" id="select-parent2" data-value="">
                          <?php if(sizeof($category1)) : ?>
                            <?php foreach($category1 as $item) : ?>
                              <option value="<?= $item->kode ?>"><?= $item->kode.'|'.$item->name ?></option>
                            <?php endforeach; ?>
                          <?php else : ?>
                            <option value="">Tolong tambahkan parent category terlebih dahulu</option>
                          <?php endif; ?>
                          </select>
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label for="input-kategori2-kode">Kode</label>
                          <input class="form-control" type="number" id="input-kategori2-kode" min="1000" max="9999" value="1" data-value="" data-id="">
                        </div>
                      </div>
                      <div class="col">
                      <div class="form-group">
                          <label for="input-kategori2">Nama</label>
                          <input type="text" id="input-kategori2" class="form-control" placeholder="Kategori" value="" data-value="" data-id="">
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
                      <th scope="row">Nama Parent</th>
                      <th scope="row">Kode Kategori</th>
                      <th scope="row">Nama Kategori</th>
                      <th scope="row" style="width: 50px;"></th>
                    </tr>
                  </thead>
                  <tbody id="rubrik-table2">
                    <?php if(sizeof($category2)) : ?>
                      <?php foreach($category2 as $item) : ?>
                        <tr >
                          <td style="width: 50px;">
                            <button type="button" class="btn btn-default button-edit" data-parent1="<?= $item->category1_kode ?>" data-kategori="<?= $item->name ?>" data-id="<?= $item->id ?>" data-kode="<?= $item->kode ?>" title="edit">
                              <i class="fas fa-pencil-alt"></i>
                            </button>
                          </td>
                          <td class=""><?= $item->category1 ?></td>
                          <td class=""><?= $item->kode ?></td>
                          <td class=""><?= $item->name ?></td>
                          <td style="width: 50px;">
                            <button type="button" class="btn btn-default button-delete" data-kategori="<?= $item->name ?>" data-id="<?= $item->id ?>" title="delete">
                              <i class="fas fa-trash"></i>
                            </button>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else : ?>
                      <tr><td colspan="4" class="text-center">Belum ada Sub-kategory</td></tr>
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

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-6">
                        <button type="button" id="btn-tambah3" class="btn btn-success">Tambah</button>
                        <button type="button" id="btn-simpan3" class="btn btn-success d-none" disabled>Simpan</button>
                        <button type="button" id="btn-batal3" class="btn btn-secondary d-none">Batal</button>
                      </div>
                      <div class="col-6">
                        <h4>children Subcategory</h4>
                        <em><p>Category untuk penentuan akuntansi</p></em>
                      </div>
                    </div>

                  </div>
                  <div class="col-md-12 d-none mt-3" id="input-section3">
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="select-parent3">Parent</label>
                          <select class="form-control" id="select-parent3" data-value="">
                          <?php if(sizeof($category1)) : ?>
                            <?php foreach($category1 as $item) : ?>
                              <option value="<?= $item->kode ?>"><?= $item->kode .'|'. $item->name ?></option>
                            <?php endforeach; ?>
                          <?php else : ?>
                            <option value="">Tolong tambahkan parent category terlebih dahulu</option>
                          <?php endif; ?>
                          </select>
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label for="select-parent32">subParent</label>
                          <select class="form-control" id="select-parent32" data-value=""></select>
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label for="input-kategori3-kode">Kode</label>
                          <input class="form-control" type="number" id="input-kategori3-kode" min="1000" max="9999" value="11" data-value="" data-id="">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label for="input-kategori3">Nama</label>
                          <input type="text" id="input-kategori3" class="form-control" placeholder="Kategori" value="" data-value="" data-id="">
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
                      <th scope="row">Nama parent</th>
                      <th scope="row">Nama sub-parent</th>
                      <th scope="row">Kode Kategori</th>
                      <th scope="row">Nama Kategori</th>
                      <th scope="row" style="width: 50px;"></th>
                    </tr>
                  </thead>
                  <tbody id="rubrik-table3">
                    <?php if(sizeof($category3)) : ?>
                      <?php foreach($category3 as $item) : ?>
                        <tr >
                          <td style="width: 50px;">
                            <button type="button" class="btn btn-default button-edit" data-parent1="<?= $item->category1_kode ?>" data-parent2="<?= $item->category2_kode ?>" data-kategori="<?= $item->name ?>" data-id="<?= $item->id ?>" data-kode="<?= $item->kode ?>" title="edit">
                              <i class="fas fa-pencil-alt"></i>
                            </button>
                          </td>
                          <td class=""><?= $item->category1 ?></td>
                          <td class=""><?= $item->category2 ?></td>
                          <td class=""><?= $item->kode ?></td>
                          <td class=""><?= $item->name ?></td>
                          <td style="width: 50px;">
                            <button type="button" class="btn btn-default button-delete" data-kategori="<?= $item->name ?>" data-id="<?= $item->id ?>" title="delete">
                              <i class="fas fa-trash"></i>
                            </button>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else : ?>
                      <tr><td colspan="5" class="text-center">Belum ada Sub-kategory-child</td></tr>
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

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="card-title">Periode Akuntansi yang dijalankan</div>
              </div>
              <div class="card-body">
                <form action="<?= url_to('accounting.category.periode') ?>" method="post">
                  <div class="row">
                    <div class="col">
                      <input type="date" class="form-control" name="awal" id="" value="<?= $awal_periode->tanggal ?>">
                    </div>
                    <div class="col">
                      <input type="date" class="form-control" name="akhir" id="" value="<?= $akhir_periode->tanggal ?>">
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <button type="submit" class="btn btn-outline-success">
                          <i class="fas fa-save"></i>
                          Simpan
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
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
$(function() {

  // Common function to handle input changes
  function handleInputChange(input, inputKode, btnSave, btnParent = null, btnChild = null) {
      let dataVal = input.attr('data-value');
      let val = input.val();
      let dataKodeVal = inputKode.attr('data-value');
      let kodeVal = inputKode.val();
      let parentVal = btnParent ? btnParent.val() : null;
      let parentDataVal = btnParent ? btnParent.attr('data-value') : null;
      let childVal = btnChild ? btnChild.val() : null;
      let childDataVal = btnChild ? btnChild.attr('data-value') : null;

      let isValid = true;
      
      // Validation for inputKode when btnParent is not null
      if (btnParent) {
        kodeVal = inputKode.val();
        isValid = kodeVal.length === 4 && kodeVal.startsWith(parentVal.charAt(0));
        if (inputKode.is(':focus')) {
          inputKode.addClass('is-invalid');
          if (isValid) {
            inputKode.removeClass('is-invalid');
          }
        } else {
          inputKode.val(parentVal.charAt(0));
        }
      }
      
      // Validation for inputKode when btnChild is not null
      if (btnChild) {
        kodeVal = inputKode.val();
        isValid = kodeVal.length === 4 && kodeVal.startsWith(childVal.substr(0, 2));
        if (inputKode.is(':focus')) {
          inputKode.addClass('is-invalid');
          if (isValid) {
            inputKode.removeClass('is-invalid');
          }
        } else {
          inputKode.val(childVal.substr(0, 2));
        }
      }

      if (!isValid || ((parentVal === parentDataVal && childVal === childDataVal && val === dataVal && kodeVal === dataKodeVal) || (val === "" && kodeVal === ""))) {
          btnSave.prop('disabled', true);
      } else {
          btnSave.prop('disabled', false);
      }
  }

  // Toggle hide function
  function toggleHide(btnAdd, btnSave, btnCancel, inputDiv, input) {
    btnAdd.toggleClass('d-none');
    btnSave.toggleClass('d-none');
    btnCancel.toggleClass('d-none');
    inputDiv.toggleClass('d-none');
    if (!inputDiv.hasClass('d-none')) {
      input.focus();
    }
  }

  // Category2
  const btnTambah2 = $('#btn-tambah2');
  const btnSimpan2 = $('#btn-simpan2');
  const btnBatal2 = $('#btn-batal2');
  const inputDiv2 = $('#input-section2');
  const input2 = $('#input-kategori2');
  const input2Kode = $('#input-kategori2-kode');
  const select2 = $('#select-parent2');

  btnTambah2.on('click', function() {
    toggleHide(btnTambah2, btnSimpan2, btnBatal2, inputDiv2, input2Kode);
    input2.val("");
    input2.attr('data-value', '');
    input2.attr('data-id', '');
    input2Kode.val(1).removeClass('is-invalid');
    input2Kode.attr('data-value', '');
    input2Kode.attr('data-id', '');
    btnSimpan2.prop('disabled', true);
  });

  btnBatal2.on('click', function() {
    toggleHide(btnTambah2, btnSimpan2, btnBatal2, inputDiv2, input2Kode);
    btnSimpan2.prop('disabled', true);
  });

  btnSimpan2.on('click', () => {
    let value = input2.val();
    let parent1 = select2.val();
    let id = input2.attr('data-id');
    let formData = new FormData();
    formData.append('category1', parent1);
    formData.append('category2', value);
    formData.append('category2_kode', input2Kode.val());

    const ajaxSettings = {
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
        makeToast(response.bg, response.message);
        toggleHide(btnTambah2, btnSimpan2, btnBatal2, inputDiv2, input2);
        input2.val("");
        input2.attr('data-value', '');
        input2.attr('data-id', '');
        btnSimpan2.prop('disabled', true);
        $("#rubrik-table2").load(window.location.href + " #rubrik-table2>");
      },
      error: function(xhr, status, error) {
        makeToast('bg-danger', xhr.responseText);
      }
    };

    if (id) {
      formData.append('_method', 'PUT');
      ajaxSettings.url = "<?= url_to('accounting.category') ?>/updatec2/" + id;
    } else {
      ajaxSettings.url = "<?= url_to('accounting.category.storec2') ?>";
    }

    $.ajax(ajaxSettings);
  });

  select2.on('input', function() {
    handleInputChange(input2, input2Kode, btnSimpan2, select2);
  });

  input2.on('input', function() {
    handleInputChange(input2, input2Kode, btnSimpan2, select2);
  });

  input2Kode.on('input', function() {
    handleInputChange(input2, input2Kode, btnSimpan2, select2);
  });

  $('#rubrik-table2').on('click', 'button.button-edit, button.button-delete', function() {
    const clickedButton = $(this);
    const kategori = clickedButton.data('kategori');
    const kategoriID = clickedButton.data('id');
    const kategoriKode = clickedButton.data('kode');
    const parent1 = clickedButton.data('parent1');

    if (clickedButton.hasClass('button-edit')) {
      input2.val(kategori);
      input2.attr('data-value', kategori);
      input2.attr('data-id', kategoriID);
      input2Kode.val(kategoriKode);
      input2Kode.attr('data-value', kategoriKode);
      input2Kode.attr('data-id', kategoriID);
      select2.val(parent1);
      select2.attr('data-value', parent1);
      btnSimpan2.prop('disabled', true);
      if (inputDiv2.hasClass('d-none')) {
        toggleHide(btnTambah2, btnSimpan2, btnBatal2, inputDiv2, input2Kode);
      } else {
        input2Kode.focus();
      }
    } else if (clickedButton.hasClass('button-delete')) {
      if (confirm(`Anda ingin menghapus kategori(${kategori}) beserta turunannya?`)) {
        $.ajax({
          type: 'POST',
          url: "<?= url_to('accounting.category') ?>/deletec2/" + kategoriID,
          data: {
            '_method': 'DELETE'
          },
          dataType: 'json',
          success: function(response) {
            makeToast(response.bg, response.message);
            $("#rubrik-table2").load(window.location.href + " #rubrik-table2>");
            $("#rubrik-table3").load(window.location.href + " #rubrik-table3>");
          },
          error: function(xhr, status, error) {
            makeToast('bg-danger', xhr.responseText);
          }
        });
      }
    }
  });

  // Category3
  const btnTambah3 = $('#btn-tambah3');
  const btnSimpan3 = $('#btn-simpan3');
  const btnBatal3 = $('#btn-batal3');
  const inputDiv3 = $('#input-section3');
  const input3 = $('#input-kategori3');
  const input3Kode = $('#input-kategori3-kode');
  const parent3 = $('#select-parent3');
  const parent32 = $('#select-parent32');

  const dataParent32 = [];

  $.ajax({
      url: `<?= url_to('accounting.category.json2') ?>`,
      type: 'POST',
      dataType: 'JSON',
      success: function (response) {
        for (let i = 0; i < response.length; i++) {
          let data = {
            id: response[i].id,
            kode: response[i].kode,
            name: response[i].name,
            detail: response[i].detail !== null ? response[i].detail : '',
            category1: response[i].category1,
            category1Kode: response[i].category1_kode,
          };
          dataParent32.push(data);
        }
      },
      error: function (xhr, status, error) {
          makeToast('bg-danger', `Error: ${error}`);
      }
  });

  btnTambah3.on('click', function() {
    toggleHide(btnTambah3, btnSimpan3, btnBatal3, inputDiv3, input3Kode);
    input3.val("");
    input3.attr('data-value', '');
    input3.attr('data-id', '');
    input3Kode.val(11).removeClass('is-invalid');
    input3Kode.attr('data-value', '');
    input3Kode.attr('data-id', '');
    btnSimpan3.prop('disabled', true);
    parent3.attr('data-value', '');
    parent32.attr('data-value', '');
    parent32.empty();
    let filtered = dataParent32.filter(function(ftr) {
      return ftr.category1Kode == parent3.val();
    });

    if (filtered.length > 0) {
      for (let i = 0; i < filtered.length; i++) {
        let row = `<option value="${filtered[i].kode}">${filtered[i].kode + '|' + filtered[i].name}</option>`;
        parent32.append(row);
      }
    } else {
      parent32.append(`<option value="">Tolong tambahkan parent subcategory terlebih dahulu</option>`);
    }
  });

  btnBatal3.on('click', function() {
    toggleHide(btnTambah3, btnSimpan3, btnBatal3, inputDiv3, input3Kode);
    btnSimpan3.prop('disabled', true);
  });

  btnSimpan3.on('click', () => {
    let value = input3.val();
    let parent1 = parent3.val();
    let parent2 = parent32.val();
    let id = input3.attr('data-id');
    let formData = new FormData();
    formData.append('category1', parent1);
    formData.append('category2', parent2);
    formData.append('category3', value);
    formData.append('category3_kode', input3Kode.val());

    const ajaxSettings = {
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
        makeToast(response.bg, response.message);
        toggleHide(btnTambah3, btnSimpan3, btnBatal3, inputDiv3, input3Kode);
        input3.val("");
        input3.attr('data-value', '');
        input3.attr('data-id', '');
        btnSimpan3.prop('disabled', true);
        $("#rubrik-table3").load(window.location.href + " #rubrik-table3>");
      },
      error: function(xhr, status, error) {
        makeToast('bg-danger', xhr.responseText);
      }
    };

    if (id) {
      formData.append('_method', 'PUT');
      ajaxSettings.url = "<?= url_to('accounting.category') ?>/updatec3/" + id;
    } else {
      ajaxSettings.url = "<?= url_to('accounting.category.storec3') ?>";
    }

    $.ajax(ajaxSettings);
  });

  parent3.on('input', function() {
    let inpFocus = $(this);
    let dataFocus = parent32.data('value');
    parent32.empty();
    let filtered = dataParent32.filter(function(ftr) {
      return ftr.category1Kode == inpFocus.val();
    });

    if (filtered.length > 0) {
      for (let i = 0; i < filtered.length; i++) {
        let row = `<option value="${filtered[i].kode}" ${filtered[i].kode == dataFocus ? 'selected' : ''}>${filtered[i].kode+'|'+filtered[i].name}</option>`;
        parent32.append(row);
      }
    } else {
      parent32.append(`<option value="">Tolong tambahkan parent subcategory terlebih dahulu</option>`);
    }
    handleInputChange(input3,input3Kode, btnSimpan3, parent3, parent32);
  });

  parent32.on('input', function() {
    handleInputChange(input3, input3Kode, btnSimpan3, parent3, parent32);
  });

  input3.on('input', function() {
    handleInputChange(input3, input3Kode, btnSimpan3, parent3, parent32);
  });

  input3Kode.on('input', function() {
    handleInputChange(input3, input3Kode, btnSimpan3, parent3, parent32);
  });

  $('#rubrik-table3').on('click', 'button.button-edit, button.button-delete', function() {
    const clickedButton = $(this);
    const kategori = clickedButton.data('kategori');
    const kategoriID = clickedButton.data('id');
    const kategoriKode = clickedButton.data('kode');
    const parent1 = clickedButton.data('parent1');
    const parent2 = clickedButton.data('parent2');

    if (clickedButton.hasClass('button-edit')) {
      input3.val(kategori);
      input3.attr('data-value', kategori);
      input3.attr('data-id', kategoriID);

      input3Kode.val(kategoriKode);
      input3Kode.attr('data-value', kategoriKode);
      input3Kode.attr('data-id', kategoriID);

      parent3.val(parent1);
      parent3.attr('data-value', parent1);

      parent32.attr('data-value', parent2);
      parent32.empty();
      let filtered = dataParent32.filter(function(ftr) {
        return ftr.category1Kode == parent1;
      });

      if (filtered.length > 0) {
        for (let i = 0; i < filtered.length; i++) {
          let row = `<option value="${filtered[i].kode}" ${filtered[i].kode == parent2 ? 'selected' : ''}>${filtered[i].kode+'|'+filtered[i].name}</option>`;
          parent32.append(row);
        }
      } else {
        parent32.append(`<option value="">Tolong tambahkan parent subcategory terlebih dahulu</option>`);
      }
      btnSimpan3.prop('disabled', true);
      if (inputDiv3.hasClass('d-none')) {
        toggleHide(btnTambah3, btnSimpan3, btnBatal3, inputDiv3, input3Kode);
      } else {
        input3Kode.focus();
      }
    } else if (clickedButton.hasClass('button-delete')) {
      if (confirm(`Anda ingin menghapus kategori(${kategori})?`)) {
        $.ajax({
          type: 'POST',
          url: "<?= url_to('accounting.category') ?>/deletec3/" + kategoriID,
          data: {
            '_method': 'DELETE'
          },
          dataType: 'json',
          success: function(response) {
            makeToast(response.bg, response.message);
            $("#rubrik-table3").load(window.location.href + " #rubrik-table3>");
          },
          error: function(xhr, status, error) {
            makeToast('bg-danger', xhr.responseText);
          }
        });
      }
    }
  });

});
</script>
<?= $this->endSection(); ?>