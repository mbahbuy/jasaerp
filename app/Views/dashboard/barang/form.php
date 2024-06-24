<?= $this->extend('dashboard/layouts/app'); ?>

<?= $this->section('style') ?>
  <!-- Select2 -->
  <!-- <link rel="stylesheet" href="/template/adminLTE/plugins/select2/css/select2meta.css"> -->
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Form Barang</h1>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-body">

            <div class="row mb-3">
              <div class="col-12">
                <label class="mb-1 fw-medium text-muted">Kategori</label>
                <select class="form-control" id="kategori" data-placeholder="Pilih kategori" style="width: 100%">
                  <?php if(sizeof($categories)): ?>
                    <?php foreach($categories as $k): ?>
                      <option value="<?= $k['id_kategori'] ?>"><?= $k['nama_kategori'] ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>
              <!-- end col -->
            </div>
            <!-- end row -->

            <div class="row mb-3">
              <div class="col-12">
                <label class="fw-medium text-muted">Kode/Barcode</label>
                <input id="inpkode" type="text" class="form-control" maxlength="100" name="kode" />
              </div>
              <!-- end col -->
            </div>
            <!-- end row -->

            <div class="row mb-3">
              <div class="col-12">
                <label class="fw-medium text-muted">Nama</label>
                <input id="inpnama" type="text" class="form-control" name="nama" />
              </div>
              <!-- end col -->
            </div>
            <!-- end row -->

            <div class="row mb-3" >
              <div class="col-md-12 text-center">
                <img src="" alt="" class="img-fluid">
              </div>
              <div class="col-md-12">
                <label class="fw-medium text-muted">Gambar</label>
                <input class="form-control" type="file" onchange="showImg(this)" name="inpupload" id="inpupload" accept="image/png, image/jpeg">
                <small>&nbsp;</small>
              </div>
              <!-- end col -->
            </div>
            <!-- end row -->

            <div class="row mb-3">
              <div class="col-12">
                <label class="fw-medium text-muted">Harga</label>
                <input id="harga" type="text" class="form-control"/>
                <input type="hidden" name="inpharga" id="inpharga" value="">
              </div>
              <!-- end col -->
            </div>
            <!-- end row -->

            <div class="row mb-3">
              <div class="col-12">
                <label class="mb-1 fw-medium text-muted">Satuan</label>
                <select class="form-control" id="select-satuan" data-placeholder="Pilih satuan" style="width: 100%">
                  <?php if(sizeof($satuan)): ?>
                    <?php foreach($satuan as $s): ?>
                      <option value="<?= $s['id_satuan'] ?>"><?= $s['nama_satuan'] ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>
              <!-- end col -->
            </div>
            <!-- end row -->

            <div class="row mb-3">
              <div class="col-12">
                <label class="fw-medium text-muted">Stock</label>
                <input id="stock" type="number" class="form-control" min="0" value="0"/>
                <em>stock boleh kosong</em>
              </div>
              <!-- end col -->
            </div>
            <!-- end row -->

          </div>
          <!-- end card-body -->

          <div class="card-footer text-center">
            <button type="button" onclick="simpanclick()" class="btn btn-success waves-effect waves-light" title="Save">
              <i class="fas fa-save"></i>
              Simpan
            </button>
          </div>

        </div>
        <!-- end card -->

      </div>
      <!-- container -->
    </section>
    <!-- content -->
  </div>
  <!-- /.content-wrapper -->

<?= $this->endSection(); ?>

<?= $this->section('script') ?>
  <!-- Select2 -->
  <!-- <script src="/template/adminLTE/plugins/select2/js/select2.full.min.js"></script> -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/scannerdetection/1.2.0/jquery.scannerdetection.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/scannerdetection/1.2.0/jquery.scannerdetection.compatibility.min.js"></script> -->
  <script>

    $('#kode').focus();

    $('#harga').on('input', function() {
      // Hilangkan karakter selain angka
      var sanitized = $(this).val().replace(/[^0-9]/g, '');
      if($(this).val() !== null){
        // Format ke dalam Rupiah
        var number = parseInt(sanitized, 10);
        $(this).val(formatRupiah(number));
        $('#inpharga').val(number);
      }
    });

    // Function untuk format ke Rupiah
    function formatRupiah(angka) {
        var reverse = angka.toString().split('').reverse().join('');
        var ribuan = reverse.match(/\d{1,3}/g);
        var formatted = ribuan.join('.').split('').reverse().join('');
        return 'Rp ' + formatted;
    }

    function showImg(img)
    {
        let imagePre = $(img).closest(".row").find(".img-fluid");

        let oFReader = new FileReader();
        oFReader.readAsDataURL(img.files[0]);
    
        oFReader.onload = function(oFREvent)
        {
            imagePre.attr('src', oFREvent.target.result);
            imagePre.css('height', '250px');
        }
    }

    function simpanclick(){
      let kategori = $('#kategori').val();
      let kode= $("#inpkode").val();
      let nama= $("#inpnama").val();
      let harga= $("#inpharga").val();
      let gambar= $("#inpupload")[0].files[0];
      let satuan= $("#select-satuan").val();
      let stock = $('#stock').val();

      let uploadStatus = 1;
      if(nama == ""){
        makeToast("bg-danger", "nama belum terisi!!!");
        uploadStatus = 0;
      }
      else if(harga==""){
        makeToast("bg-danger", "harga harus di Isi");
        uploadStatus=0;
      }
      else if(kode==""){
        makeToast("bg-danger", "kode belum terisi!!!");
        uploadStatus = 0;
      }
      else if(kategori=="0"){
        uploadStatus = 0;
        makeToast("bg-danger", "Kategori belum ditentukan!");
      }
      else if(satuan=="0"){
        uploadStatus = 0;
        makeToast("bg-danger", "Satuan belum ditentukan!");
      }

      if(uploadStatus !== 1 ){}
      else {
        var formData = new FormData();
        formData.append('kategori', kategori);
        formData.append('kode', kode);
        formData.append('nama', nama);
        formData.append('harga', harga);
        formData.append('satuan', satuan);
        formData.append('stock', stock);
        if (gambar) {
          formData.append('gambar', gambar);
        }

        $.ajax({
            type: 'POST',
            url: "<?= url_to('barang.store') ?>",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
              makeToast(response.bg, response.message);
              if (response.bg == 'bg-success') {
                location.href= "<?= url_to('barang.index') ?>";
              }
            },
            error: function(xhr, status, error) {
              makeToast('bg-danger', xhr.responseText);
            }
        });
      }

    }

  // $(document).ready(function() {
  //   $(document).scannerDetection({
  //       timeBeforeScanTest: 200, // wait for the next character for upto 200ms
  //       avgTimeByChar: 40, // it's not a barcode if a character takes longer than 40ms
  //       preventDefault: true,
  //       // endChar: [13], // character code for enter key
  //       onComplete: function(barcode, qty) {
  //           $("#inpkode").val(barcode); // Optionally, display the scanned barcode
  //       },
  //       onError: function(string, qty) {
  //           makeToast('bg-danger','Scanning error, please try again.');
  //       }
  //   });
  // });

  </script>
<?= $this->endSection() ?>