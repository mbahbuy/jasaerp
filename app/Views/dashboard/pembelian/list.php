<?= $this->extend('dashboard/layouts/app'); ?>

<?= $this->section('content'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">List Pembelian</h1>
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
                        <a href="<?= route_to('pembelian.form') ?>" class="btn btn-icon btn-outline-success">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                        </a>
                    </div>
                  </div>
                  <div class="card-tools">
                    <div class="input-group">
                      <input type="text" id="search-faktur" class="form-control" placeholder="Cari Faktur/Kwitansi" value="">
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th scope="row" class="align-middle text-center">#</th>
                        <th scope="row" class="align-middle text-center">Faktur</th>
                        <th scope="row" class="align-middle text-center">Supplier</th>
                        <th scope="row" class="align-middle text-center">Tanggal pembelian</th>
                        <th scope="row" class="align-middle text-center">Total</th>
                        <th scope="row" class="align-middle text-center">Status</th>
                        <th scope="row" class="align-middle text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody  id="pembelian-table"></tbody>
                  </table>
                </div>
                <!-- end card-body-->
                <div class="card-footer clearfix">
                  <ul class="pagination" id="pagination-pembelian"></ul>
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
                    <label class="small mb-1">Kwitansi</label>
                    <div class="input-group-append">
                      <div class="form-control form-control-solid" id="kwitansi"></div>
                      <div class="input-group-prepend">
                        <button type="button" class="btn btn-outline-success" id="btn-bukti" data-show=""><i class="far fa-fw fa-image "></i></button>
                      </div>
                    </div>
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
                    <th scope="row" class="align-middle text-center">harga beli</th>
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
                              Pajak(persen/%)
                          </th>
                          <td width="150" class="align-middle text-center">
                              <div id="pajak-persen"></div>
                          </td>
                      </tr>
                      <tr>
                          <th colspan="6" class="align-middle text-right">
                              Pajak(harga/Rp)
                          </th>
                          <td width="150" class="align-middle text-center">
                              <div id="pajak-harga"></div>
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
          <button type="button" class="btn btn-primary" data-faktur="" id="btn-approve">Aprrove</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal show -->

  <div class="modal fade" id="modal-bukti" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered" style="height: 50vh;">
          <div class="modal-content" style="background-color: rgba(0, 0, 0, 0.1);
        border: none;">
              <img src="" id="img-bukti" class="img-fluid" alt="Image Detail">
          </div>
      </div>
  </div>

<?= $this->endSection(); ?>

<?= $this->section('script') ?>
<script>
  // target element yang tidak akan berubah
  const $inputSearch = $('#search-faktur');
  const $tableData = $('#pembelian-table');
  const $tablePagination = $('#pagination-pembelian');
  
  // modal show
  const $modalShow = new bootstrap.Modal(document.getElementById('modal-show'), {});
  const $modalTitle = $('#modal-title');
  const $namaSucriber = $('#nama-subcriber');
  const $emailSubcriber = $('#email-subcriber');
  const $waSubcriber = $('#wa-subcriber');
  const $tokoSubcriber = $('#toko-subcriber');
  const $alamatTokoSubcriber = $('#alamat-toko-subcriber');
  const $kwitansi = $('#kwitansi');
  const $tanggalFakturData = $('#tanggal-faktur-data');
  const $totalData = $('#total-data');
  const $tableProdukData = $('#table-produk-data');
  const $userTable = $('#user-table');
  const $subtotal = $('#subtotal');
  const $pajakPersen = $('#pajak-persen');
  const $pajakHarga = $('#pajak-harga');
  const $totalHarga = $('#total-harga');
  const $status = $('#status');
  const $btnApprove = $('#btn-approve');
  const $btnBukti = $('#btn-bukti');
  const $modalBukti = new bootstrap.Modal(document.getElementById('modal-bukti'), {});
  const $imgBukti = $('#img-bukti');

  // penyimpanan data
  const jsonDataPembelian = [];

  $(function () {
    fetchDataPembelian((data) => {
      processDataPembelian(data);
      generateData();
    });

    $inputSearch.on('input', function () { 
      let value = $(this).val();
      generateData(1, value);
    });// end $intputSearch

    $btnApprove.click(function() {
      const faktur = $(this).data('faktur');
      $tableData.find(`button.btn-approve[data-faktur='${faktur}']`).trigger('click');
    });

    $btnBukti.click(function(){
      const data = $(this).data('show');
      if (data == 1) {
        $modalBukti.show();
      } 
    });

    $tableData.on('click', 'button.btn-show, button.btn-approve, button.btn-delete', function () {
      var clickedButton = $(this);
      var dataFaktur = clickedButton.data('faktur');
      if (clickedButton.hasClass('btn-show')) {
        setDataShow(dataFaktur);
      } else if (clickedButton.hasClass('btn-delete')) {
        for (let i = 0; i < jsonDataPembelian.length; i++) {
            if (jsonDataPembelian[i].faktur === dataFaktur) {

              $.ajax({
                  url: `<?= url_to('pembelian.index') ?>/delete/${dataFaktur}`,
                  type: 'POST',
                  data: {
                    '_method': 'DELETE',
                  },
                  dataType: 'JSON',
                  success: function (response) {
                      makeToast(response.bg, response.message);
                      if (response.bg == 'bg-success') {
                        jsonDataPembelian.splice(i, 1); // Remove the item at index i
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
            var dataToSend = getDataForApproval(dataFaktur);
            var formData = new FormData();
            formData.append('produk', JSON.stringify(dataToSend));
            formData.append('_method', 'PUT');
            $.ajax({
                url: `<?= url_to('pembelian.index') ?>/approve/${dataFaktur}`,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    makeToast(response.bg, response.message);
                    if (response.bg === 'bg-success') {
                        changeStatusByFaktur(dataFaktur, 1);
                        let pageActive = $tablePagination.find('li.page-item.active').find('a.page-link').attr('data-page');
                        generateData(pageActive);
                        setDataShow(dataFaktur);
                    }
                },
                error: function(xhr, status, error) {
                    makeToast('bg-danger', `Error: ${error}`);
                }
            });
      }
    });//end $tableData

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

  });

  function fetchDataPembelian(callback) {
      $.ajax({
          url: '<?= url_to('pembelian.pembelianjson') ?>',
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

  function processDataPembelian(response) {
      for (let i = 0; i < response.length; i++) {
          let detailBarang = response[i].detail.map(e => ({
              nama: e.nama_barang,
              kode : e.kode_barang,
              stock : e.stock,
              hargaJual: e.harga_jual,
              hargaBeli: e.harga_beli,
              kuantitas: e.jumlah,
              subtotal: e.subtotal
          }));

          jsonDataPembelian.push({
              faktur: response[i].faktur,
              kwitansi: response[i].kwitansi !== null ? response[i].kwitansi : '-',
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
              supplier  : response[i].supplier,
              emailSupplier : response[i].email_supplier,
              phoneSupplier : response[i].phone_supplier,
              bankSupplier  : response[i].bank_supplier,
              rekeningSupplier  : response[i].rekening_supplier,
              tokoSupplier : response[i].toko_supplier,
              alamatTokoSupplier  : response[i].alamat_toko_supplier,
              gudang  : response[i].gudang,
          });
      }
  }

  function generateData(page = 1, search = null) {
      let dataPerPage = 10;
      let startIndex = (page - 1) * dataPerPage;
      let endIndex = startIndex + dataPerPage;
      $tableData.empty();

      let data = jsonDataPembelian;

      if (search) {
          data = jsonDataPembelian.filter(function (item) {
              return item.faktur.toLowerCase().includes(search.toLowerCase()) || item.kwitansi.toLowerCase().includes(search.toLowerCase());
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
                  <td class="align-middle text-center">${data[i].supplier}(${data[i].tokoSupplier})</td>
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
        var data = jsonDataPembelian.find(item => item.faktur === faktur);
        
        if (!data) {
            alert('Data not found!');
            return;
        }
        $modalShow.show();

        // set data
        $modalTitle.html(`Detail untuk transaksi: ${faktur}`);
        $namaSucriber.html(data.supplier);
        $emailSubcriber.html(data.emailSupplier);
        $waSubcriber.html(data.phoneSupplier);
        $kwitansi.html(data.kwitansi);
        $tokoSubcriber.html(data.tokoSupplier);
        $alamatTokoSubcriber.html(data.alamatTokoSupplier);
        $tanggalFakturData.html(data.date);
        $totalData.html(formatRupiah(data.totalHarga));
        $userTable.html(data.user);
        $subtotal.html(formatRupiah(data.subtotal));
        $pajakPersen.html(data.pajakPersen + '%');
        $pajakHarga.html(formatRupiah(data.pajakTotal));
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

        if (data.status == 1) {
          $btnApprove.hide();
        } else {
          $btnApprove.attr('data-faktur', faktur).show();
        }

        if (data.bukti !== null) {
          $imgBukti.attr('src', `/images/bukti/${data.bukti}`);
          $btnBukti.attr('data-show', 1).parent().show();
        } else {
          $imgBukti.attr('src', '');
          $btnBukti.attr('data-show', 0).parent().hide();
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
                    <td class="align-middle text-center">${formatRupiah(product.hargaBeli)}</td>
                    <td class="align-middle text-center">${formatRupiah(product.subtotal)}</td>
                </tr>`;
                $tableProdukData.append(row);
            });
        }
    }

    function getDataForApproval(faktur) {
        // Assuming jsonDataPembelian is a global variable holding the purchase data
        for (let i = 0; i < jsonDataPembelian.length; i++) {
            if (jsonDataPembelian[i].faktur === faktur) {
                return jsonDataPembelian[i].detailBarang;
            }
        }
        return null;
    }

    function changeStatusByFaktur(faktur, status) {
        for (let i = 0; i < jsonDataPembelian.length; i++) {
            if (jsonDataPembelian[i].faktur === faktur) {
                jsonDataPembelian[i].status = status;
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