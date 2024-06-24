<?= $this->extend('dashboard/layouts/app'); ?>

<?= $this->section('content'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">List Penjualan</h1>
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
                    <div class="btn-list">
                        <a href="<?= route_to('penjualan.form') ?>" class="btn btn-icon btn-outline-success">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                        </a>
                    </div>
                  </div>
                  <div class="card-tools">
                    <div class="input-group">
                      <input type="text" id="search-faktur" class="form-control" placeholder="Cari Faktur" value="">
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th scope="row">#</th>
                        <th scope="row">Faktur</th>
                        <th scope="row">Customer</th>
                        <th scope="row">Tanggal penjualan</th>
                        <th scope="row">Total</th>
                        <th scope="row">Status</th>
                        <th scope="row">Action</th>
                      </tr>
                    </thead>
                    <tbody  id="penjualan-table"></tbody>
                  </table>
                </div>
                <!-- end card-body-->
                <div class="card-footer clearfix">
                  <ul class="pagination" id="pagination-penjualan"></ul>
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

  <div class="modal fade" id="modal-show">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row col-lg-12">
            <div class="container-fluid">
              <div class="row gx-3 mb-3">
                <div class="col-md-6">
                    <label class="small mb-1">Nama</label>
                    <div class="form-control form-control-solid" id="nama-subcriber"></div>
                </div>
                <div class="col-md-6">
                    <label class="small mb-1">Email</label>
                    <div class="form-control form-control-solid" id="email-subcriber"></div>
                </div>
              </div>
              <div class="row gx-3 mb-3">
                <div class="col-md-6">
                    <label class="small mb-1">No WA</label>
                    <div class="form-control form-control-solid" id="wa-subcriber"></div>
                </div>
                <div class="col-md-6">
                    <label class="small mb-1">Type pembayaran</label>
                    <div class="form-control form-control-solid" id="payment"></div>
                </div>
              </div>
              <div class="row gx-3 mb-3">
                <div class="col-md-6">
                    <label class="small mb-1">Nama Toko/Persero/Yayasan/Organisasi</label>
                    <div class="form-control form-control-solid" id="toko-subcriber"></div>
                </div>
                <div class="col-md-6">
                    <label class="small mb-1">Alamat Toko/Persero/Yayasan/Organisasi</label>
                    <div class="form-control form-control-solid" id="alamat-toko-subcriber"></div>
                </div>
              </div>
              <div class="row gx-3 mb-3">
                <div class="col-md-6">
                    <label class="small mb-1">Tanggal</label>
                    <div class="form-control form-control-solid" id="tanggal-faktur-data"></div>
                </div>
                <div class="col-md-6">
                    <label class="small mb-1">Total</label>
                    <div class="form-control form-control-solid" id="total-data"></div>
                </div>
              </div>
              <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                  <tr>
                    <th scope="row" style="width: 50px;">#</th>
                    <th scope="row" class="align-middle text-center">Nama Produk</th>
                    <th scope="row" class="align-middle text-center">kode Produk</th>
                    <th scope="row" class="align-middle text-center">Stock digudang</th>
                    <th scope="row" class="align-middle text-center">Kuantitas</th>
                    <th scope="row" class="align-middle text-center">harga jual</th>
                    <th scope="row" class="align-middle text-center">total</th>
                  </tr>
                </thead>
                <tbody class="thead-dark" id="table-produk-data"></tbody>
                  <tfoot class="thead-dark">
                      <tr>
                          <td colspan="6" class="align-middle text-right">Dibuat oleh</td>
                          <td class="text-center" id="user-table"></td>
                      </tr>
                      <tr>
                          <th colspan="6" class="align-middle text-right">
                              Subtotal
                          </th>
                          <td class="text-center">
                              <div id="subtotal">Rp 0</div>
                          </td>
                      </tr>
                      <tr>
                          <th colspan="6" class="align-middle text-right">
                              Pajak
                          </th>
                          <td width="150" class="align-middle text-center">
                            <div id="pajak-persen"></div>
                            <div id="pajak-harga"></div>
                          </td>
                      </tr>
                      <tr>
                          <th colspan="6" class="align-middle text-right">
                              Diskon
                            </th>
                            <td width="150" class="align-middle text-center">
                            <div id="diskon-persen"></div>
                            <div id="diskon-harga"></div>
                          </td>
                      </tr>
                      <tr>
                          <th colspan="6" class="align-middle text-right">
                              Total
                          </th>
                          <td class="text-center">
                              <div id="total-harga">Rp 0</div>
                          </td>
                      </tr>
                      <tr>
                          <th colspan="6" class="align-middle text-right">Status</th>
                          <td class="text-center">
                            <div id="status"></div>
                          </td>
                      </tr>
                  </tfoot>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="btn-approve" data-faktur="">Aprrove</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal show -->


<?= $this->endSection(); ?>

<?= $this->section('script') ?>
<script>
  // target element yang tidak akan berubah
  const $inputSearch = $('#search-faktur');
  const $tableData = $('#penjualan-table');
  const $tablePagination = $('#pagination-penjualan');
  
  // modal show
  const $modalShow = new bootstrap.Modal(document.getElementById('modal-show'), {});
  const $modalTitle = $('#modal-title');
  const $namaSucriber = $('#nama-subcriber');
  const $emailSubcriber = $('#email-subcriber');
  const $waSubcriber = $('#wa-subcriber');
  const $payment = $('#payment');
  const $tokoSubcriber = $('#toko-subcriber');
  const $alamatTokoSubcriber = $('#alamat-toko-subcriber');
  const $tanggalFakturData = $('#tanggal-faktur-data');
  const $totalData = $('#total-data');
  const $tableProdukData = $('#table-produk-data');
  const $userTable = $('#user-table');
  const $subtotal = $('#subtotal');
  const $pajakPersen = $('#pajak-persen');
  const $pajakHarga = $('#pajak-harga');
  const $diskonPersen = $('#diskon-persen');
  const $diskonHarga = $('#diskon-harga');
  const $totalHarga = $('#total-harga');
  const $status = $('#status');
  const $btnApprove = $('#btn-approve');

  // penyimpanan data
  const jsonDataPenjualan = [];

  $(function () {
    fetchDataPenjualan((data) => {
      processDataPenjualan(data);
      generateData();
    });

    $inputSearch.on('input', function () { 
      let value = $(this).val();
      generateData(1, value);
    });// end $intputSearch

    $tableData.on('click', 'button.btn-show, button.btn-approve, button.btn-delete', function () {
      var clickedButton = $(this);
      var dataFaktur = clickedButton.data('faktur');
      if (clickedButton.hasClass('btn-show')) {
        setDataShow(dataFaktur);
      } else if (clickedButton.hasClass('btn-delete')) {
        for (let i = 0; i < jsonDataPenjualan.length; i++) {
            if (jsonDataPenjualan[i].faktur === dataFaktur) {

              $.ajax({
                  url: `<?= url_to('penjualan.index') ?>/delete/${dataFaktur}`,
                  type: 'POST',
                  data: {
                    '_method': 'DELETE',
                  },
                  dataType: 'JSON',
                  success: function (response) {
                      makeToast(response.bg, response.message);
                      if (response.bg == 'bg-success') {
                        jsonDataPenjualan.splice(i, 1); // Remove the item at index i
                        clickedButton.closest('tr').animate(
                          {
                            right: '-100%', // Adjust the distance as needed
                            opacity: 0,
                          },
                          1000, // Duration of the animation in milliseconds
                          function () {
                            // Callback function to remove the element from the DOM
                            $(this).remove();
                            let pageActive = $tablePagination.find('li.page-item.active').find('a.page-link').attr('data-page');
                            generateData(pageActive);
                          }
                        );
                      }
                  },
                  error: function (xhr, status, error) {
                      makeToast('bg-danger', `Error: ${error}`);
                  }
              });
                break; // Exit the loop
            }
        }
      } else if(clickedButton.hasClass('btn-approve')){
            ApproveTransaction(dataFaktur);
      }
    });//end $tableData

    $btnApprove.click(function (e) { 
      e.preventDefault();
      var dataFaktur = e.data('faktur');
      ApproveTransaction(dataFaktur);
      
    });

    $inputSearch.on('input', function(){
      let value = $(this).val();
      $(this).attr('data-search', value);
      generateData(1, value);
    });

    $tablePagination.on('click', 'a.page-link', function () {
        let clickedButton = $(this);
        let search = $inputSearch.attr('data-search');
        let page = clickedButton.attr('data-page');
        generateData(page, search);
    });

  }); // end document ready

  function fetchDataPenjualan(callback) {
      $.ajax({
          url: '<?= url_to('penjualan.penjualanjson') ?>',
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

  function processDataPenjualan(response) {
      for (let i = 0; i < response.length; i++) {
          let detailBarang = response[i].detail.map(e => ({
              nama: e.nama_barang,
              kode : e.kode_barang,
              stock : e.stock_barang,
              hargaJual: e.harga_jual,
              hargaBeli: e.harga_beli,
              kuantitas: e.jumlah,
              subtotal: e.subtotal
          }));

          jsonDataPenjualan.push({
              faktur: response[i].faktur,
              date: response[i].tanggal_faktur,
              subtotal: response[i].subtotal,
              pajakPersen: response[i].pajak_persen,
              pajakTotal: response[i].pajak_total,
              diskonPersen: response[i].diskon_persen,
              diskonTotal: response[i].diskon_total,
              totalHarga: response[i].total_harga,
              detailBarang: detailBarang,
              status  : response[i].status,
              detailStatus  : response[i].detail_status,
              note  : response[i].note,
              bukti  : response[i].bukti,
              user : response[i].user,
              customer  : response[i].customer,
              emailCustomer : response[i].email_customer,
              phoneCustomer : response[i].phone_customer,
              bankCustomer  : response[i].bank_customer,
              rekeningCustomer  : response[i].rekening_customer,
              tokoCustomer : response[i].toko_customer,
              alamatTokoCustomer  : response[i].alamat_toko_customer,
              gudang  : response[i].gudang,
          });
      }
  }

  function generateData(page = 1, search = null) {
    let dataPerPage = 10;
    let startIndex = (page - 1) * dataPerPage;
    let endIndex = startIndex + dataPerPage;
    $tableData.empty();

    let data = jsonDataPenjualan;

    if (search) {
        data = jsonDataPenjualan.filter(function (item) {
            return item.faktur.toLowerCase().includes(search.toLowerCase());
        });
    }

    if (data.length === 0) {
        $tableData.append('<tr><td colspan="7" class="text-center">Belum ada Transaksi</td></tr>');
        return;
    }

    for (let i = startIndex; i < endIndex && i < data.length; i++) {
        let row = `
            <tr>
                <td class="align-middle text-center">${i + 1}</td>
                <td class="align-middle text-center">${data[i].faktur}</td>
                <td class="align-middle text-center">${data[i].customer}(${data[i].tokoCustomer})</td>
                <td class="align-middle text-center">${ubahFormatTanggal(data[i].date)}</td>
                <td class="align-middle text-center">${formatRupiah(data[i].totalHarga)}</td>
                <td class="align-middle text-center">${data[i].status == 1 ? `
                  <span class="badge bg-green text-white text-uppercase">
                      APPROVED
                  </span>
                ` : `
                  <span class="badge bg-orange text-white text-uppercase">
                      PENDING
                  </span>  
                `}</td>
                <td class="align-middle text-center">
                    <div class="btn-group-sm">
                        <button type="button" class="btn btn-default btn-outline-info btn-icon btn-show" title="show" data-faktur="${data[i].faktur}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path></svg>
                        </button>
                        <a href="<?= base_url() ?>invoice/print/${data[i].faktur}" class="btn btn-primary btn btn-outline-warning btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"></path><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"></path></svg>
                        </a>
                        ${data[i].status == false ? `                            
                          <button type="button" class="btn btn-primary btn btn-outline-success btn-icon btn-approve" data-faktur="${data[i].faktur}">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
                          </button>
                          <button type="button" class="btn btn-default btn-outline-danger btn-icon btn-delete" data-faktur="${data[i].faktur}" title="delete">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 7l16 0"></path><path d="M10 11l0 6"></path><path d="M14 11l0 6"></path><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path></svg>
                          </button>
                        ` : ``}
                    </div>
                </td>
            </tr>
        `;
        $tableData.append(row);
    }

    let totalPages = Math.ceil(data.length / dataPerPage);
    generatePagerPagination(totalPages, page);
  }

  // function generate pagination page 
  function generatePagerPagination(totalPages = 1, page = 1){
    $tablePagination.empty();

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
      $tablePagination.append(`<li class="page-item ${i == page ? 'active' : ''}"><a class="page-link" href="javascript:void(0)" data-page="${i}">${i}</a></li>`);
    }
  }

  function formatRupiah(angka) {
        var reverse = angka.toString().split('').reverse().join('');
        var ribuan = reverse.match(/\d{1,3}/g);
        var formatted = ribuan.join('.').split('').reverse().join('');
        return 'Rp ' + formatted;
  }

  function setDataShow(faktur) {
        var data = jsonDataPenjualan.find(item => item.faktur === faktur);
        
        if (!data) {
            alert('Data not found!');
            return;
        }

        $modalShow.show();

        // set data
        $modalTitle.html(`Detail untuk transaksi: ${faktur}`);
        $namaSucriber.html(data.customer);
        $emailSubcriber.html(data.emailCustomer);
        $waSubcriber.html(data.phoneCustomer);
        $payment.html(data.detailStatus);
        $tokoSubcriber.html(data.tokoCustomer);
        $alamatTokoSubcriber.html(data.alamatTokoCustomer);
        $tanggalFakturData.html(data.date);
        $totalData.html(formatRupiah(data.totalHarga));
        $userTable.html(data.user);
        $subtotal.html(formatRupiah(data.subtotal));
        $pajakPersen.html((data.pajakPersen ?? 0) + '%');
        $pajakHarga.html(data.pajakTotal ? formatRupiah(data.pajakTotal) : 'Rp 0');
        $diskonPersen.html((data.diskonPersen ?? 0) + '%');
        $diskonHarga.html(data.diskonTotal ? formatRupiah(data.diskonTotal) : 'Rp 0');
        $totalHarga.html(formatRupiah(data.totalHarga));
        $status.html(data.status == 1 ? `
                        <span class="badge bg-green text-white text-uppercase">
                            APPROVED
                        </span>
                      ` : `
                        <span class="badge bg-orange text-white text-uppercase">
                            PENDING
                        </span>  
                      `);
        $btnApprove.attr('data-faktur', faktur);
        $btnApprove.show();
        if (data.status == 1) {
          $btnApprove.hide();
        }
        // Clear and populate $tableProdukData if needed
        // Assuming data.detailBarang is an array of product details
        $tableProdukData.empty();
        if (data.detailBarang && data.detailBarang.length > 0) {
            let i = 0;
            data.detailBarang.forEach(function(product) {
              i += 1;
                var row = `<tr>
                    <td class="align-middle text-center">${i}</td>
                    <td class="align-middle text-center">${product.nama}</td>
                    <td class="align-middle text-center">${product.kode}</td>
                    <td class="align-middle text-center">${product.stock}</td>
                    <td class="align-middle text-center">${product.kuantitas}</td>
                    <td class="align-middle text-center">${formatRupiah(product.hargaJual)}</td>
                    <td class="align-middle text-center">${formatRupiah(product.subtotal)}</td>
                </tr>`;
                $tableProdukData.append(row);
            });
        }
    }

    function ApproveTransaction(faktur) {
      var data = jsonDataPenjualan.find(f => f.faktur === faktur);
      if (!data) {
          makeToast('bg-danger', 'Data not found for the given faktur.');
          return;
      }

      var formData = new FormData();
      formData.append('produk', JSON.stringify(data.detailBarang));
      formData.append('_method', 'PUT');

      $.ajax({
          url: `<?= url_to('penjualan.index') ?>/approve/${faktur}`,
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {
              makeToast(response.bg, response.message);
              if (response.bg === 'bg-success') {
                  changeStatusByFaktur(faktur, 1);
                  let pageActive = $tablePagination.find('li.page-item.active').find('a.page-link').attr('data-page');
                  generateData(pageActive);
              }
          },
          error: function(xhr, status, error) {
              var errorMessage = 'Error: ' + xhr.responseText;
              try {
                  var response = JSON.parse(xhr.responseText);
                  if (response && response.message) {
                      errorMessage = response.message;
                  }
              } catch (e) {
                  // If responseText is not JSON, use the plain text
                  errorMessage = 'Error: ' + error;
              }
              makeToast('bg-danger', errorMessage);
          }
      });
  }


    function changeStatusByFaktur(faktur, status) {
        for (let i = 0; i < jsonDataPenjualan.length; i++) {
            if (jsonDataPenjualan[i].faktur === faktur) {
                jsonDataPenjualan[i].status = status;
                break; // Exit loop after finding and updating the data
            }
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
<?= $this->endSection() ?>