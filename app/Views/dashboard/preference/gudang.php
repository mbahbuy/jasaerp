<?= $this->extend('dashboard/layouts/app'); ?>

<?= $this->section('content'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Gudang</h1>
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
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="nama">Nama</label>
                          <input type="text" class="form-control" id="nama" value="">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                        <label for="kapasitas">Kapasitas</label>
                        <input type="number" class="form-control" min="0" id="kapasitas" value="0">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="alamat">Alamat</label>
                          <textarea class="form-control" id="alamat"></textarea>
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
                      <th scope="row">Nama Gudang</th>
                      <th scope="row" style="width: 50px;"></th>
                    </tr>
                  </thead>
                  <tbody id="gudang-table"></tbody>
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
    
    const btnTambah = $('#btn-tambah');
    const btnSimpan = $('#btn-simpan');
    const btnBatal = $('#btn-batal');
    const inputDiv = $('#input-section');
    const nama = $('#nama');
    const kapasitas = $('#kapasitas');
    const alamat = $('#alamat');

    const table = $('#gudang-table');

    const jsonData = [];
    $(function () {

      fetchData(e => {
        processData(e);
        generateData();
      });
      
      btnTambah.on('click', function(){
        toggleHide();
        nama.val("");
        kapasitas.val(0);
        alamat.val("");
        btnSimpan.attr('data-id', '');
        btnSimpan.prop('disabled', true);
      });
      
      btnBatal.on('click', function(){
        toggleHide();
        nama.val("");
        kapasitas.val(0);
        alamat.val("");
        btnSimpan.attr('data-id', '');
        btnSimpan.prop('disabled', true);
      });

      btnSimpan.on('click', () => {
        var id = btnSimpan.data('id');
        console.log(id);
        var formData = new FormData;
        formData.append('gudang', nama.val());
        formData.append('alamat', alamat.val());
        formData.append('kapasitas', kapasitas.val());

        var url = '';

        if (id) {
          url = `<?= url_to('preference.gudang') ?>/update/${id}`;
          formData.append('_method', 'PUT');
        } else {
          url = "<?= url_to('preference.gudang.store') ?>";
        }

        $.ajax({
          url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
              makeToast(response.bg, response.message);
              btnBatal.click();

              fetchData(e => {
                processData(e);
                generateData();
              });
            },
            error: function(xhr, status, error) {
              makeToast('bg-danger', xhr.responseText);
            }
        });

      });

      nama.on('input', function(){
        let dataVal = $(this).attr('data-value');
        let val = $(this).val();

        if (dataVal == val || val == "") {
            btnSimpan.prop('disabled', true);
        } else {
            btnSimpan.prop('disabled', false);
        }
      });

      table.on('click', 'button.button-edit, button.button-delete, button.button-restore, button.button-selected', function() { // 
          var clickedButton = $(this);
          
          let gudang = clickedButton.data('gudang');
          let gudangID = clickedButton.data('id');
          if (clickedButton.hasClass('button-edit')) {
              // Handle the case when a button with class 'button-edit' is clicked
              let dataEdit = jsonData.find(e => {return e.id == gudangID});
              nama.val(dataEdit.nama);
              nama.attr('data-nama', dataEdit.nama);
              kapasitas.val(dataEdit.kapasitas);
              alamat.val(dataEdit.alamat);
              btnSimpan.attr('data-id', gudangID);
              btnSimpan.prop('disabled', true);
              if (inputDiv.hasClass('d-none')) {toggleHide()} else {nama.focus()};
          } else if (clickedButton.hasClass('button-delete')) {
              // Handle the case when a button with class 'button-delete' is clicked
              if (confirm(`anda ingin menghapus gudang(${gudang})?`)) {
                $.ajax({
                    type: 'POST',
                    url: "<?= url_to('preference.gudang') ?>/delete/" + gudangID,
                    data: {
                      '_method': 'DELETE',
                    },
                    dataType: 'json',
                    success: function(response) {
                      makeToast(response.bg, response.message);
                      fetchData(e => {
                        processData(e);
                        generateData();
                      });
                    },
                    error: function(xhr, status, error) {
                      makeToast('bg-danger', xhr.responseText);
                    }
                });
              }
          } else if (clickedButton.hasClass('button-restore')){
                // Handle the case when a button with class 'button-restore' is clicked
                if (confirm(`anda ingin mengambil gudang(${gudang}) dari tempat sampah?`)) {
                  $.ajax({
                      type: 'POST',
                      url: "<?= url_to('preference.gudang') ?>/restore/" + gudangID,
                      data: {
                        '_method': 'PUT',
                      },
                      dataType: 'json',
                      success: function(response) {
                        makeToast(response.bg, response.message);
                        fetchData(e => {
                          processData(e);
                          generateData();
                        });
                      },
                      error: function(xhr, status, error) {
                        makeToast('bg-danger', xhr.responseText);
                      }
                  });
                }
          } else if (clickedButton.hasClass('button-selected')) {
              // Handle the case when a button with class 'button-delete' is clicked
              if (confirm(`anda ingin menjadikan gudang(${gudang}) menjadi gudang utama?`)) {
                $.ajax({
                    type: 'POST',
                    url: "<?= url_to('preference.gudang') ?>/selected/" + gudangID,
                    data: {
                      '_method': 'PUT',
                    },
                    dataType: 'json',
                    success: function(response) {
                      makeToast(response.bg, response.message);
                      fetchData(e => {
                        processData(e);
                        generateData();
                      });
                    },
                    error: function(xhr, status, error) {
                      makeToast('bg-danger', xhr.responseText);
                    }
                });
              }
          }
      });
      
    });

    function fetchData(callback) {
      $.ajax({
          url: '<?= url_to('preference.gudang.json') ?>',
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
        let data = {
          id : response[i].id_gudang,
          parent : response[i].parent_id,
          nama : response[i].nama_gudang,
          slug : response[i].slug,
          alamat : response[i].alamat,
          kapasitas : response[i].kapasitas,
          status : response[i].status,
          selected : response[i].selected,
          tanggal_selected : response[i].tanggal_selected,
        };
        
        jsonData.push(data);
      }
    }

    function generateData() {
      const data = jsonData;
      table.empty();

      if (data.length == 0) {
        table.append(`<tr><td colspan="3" class="text-center">Belum ada data Gudang</td></tr>`);
        return;
      }

      for (let i = 0; i < data.length; i++) {
        var row = `
          <tr class="${data[i].selected == true ? 'bg-primary' : ''}">
            <td style="width: 50px;" class="align-middle text-center">
              <div class="btn-group align-middle text-center">
                ${(data[i].selected == true) ? 'SELECTED' :
                    `${data[i].status == true ? 
                    `<button type="button" class="btn btn-default button-edit" data-gudang="${data[i].nama}" data-id="${data[i].id}" title="edit">
                    <i class="fas fa-pencil-alt"></i>
                      </button>
                      <button type="button" class="btn btn-default button-selected" data-gudang="${data[i].nama}" data-id="${data[i].id}" title="edit">
                      <i class="fas fa-check"></i></button>`
                : `Deleted` }`}
              </div>
            </td>
            <td class="align-middle text-left ${data[i].status == false ? "text-danger" : "" }">${data[i].nama}</td>
            <td style="width: 50px;" class="align-middle text-center">
                ${data[i].selected == true ? `SELECTED` : `                
                  ${(data[i].status == true) ?
                    `<button type="button" class="btn btn-default button-delete" data-gudang="${data[i].nama}" data-id="${data[i].id}" title="delete">
                      <i class="fas fa-trash"></i>
                    </button>`
                  :
                    `<button type="button" class="btn btn-default button-restore" data-gudang="${data[i].nama}" data-id="${data[i].id}" title="restore">
                      <i class="fas fa-sync-alt"></i>
                    </button>`
                  }
                `}
            </td>
          </tr> 
        `;
        table.append(row);
      }

    }

    function toggleHide()
    {
      btnTambah.toggleClass('d-none');
      btnSimpan.toggleClass('d-none');
      btnBatal.toggleClass('d-none');
      inputDiv.toggleClass('d-none');
      if (!inputDiv.hasClass('d-none')) {
        nama.focus();
      }
    }
  </script>
<?= $this->endSection(); ?>