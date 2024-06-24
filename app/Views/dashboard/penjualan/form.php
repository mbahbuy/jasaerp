<?= $this->extend('dashboard/layouts/app'); ?>

<?= $this->section('style') ?>
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
            <h1 class="m-0">Form Penjualan</h1>
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
          <div class="row">
              <div class="col-6">
                  <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Form produk</h3>
                    </div>
                    <div class="card-body">
                        <div class="row gx-3 mb-3">
                            <div class="col-12">
                                <label class="small mb-1" for="barcode">Barcode</label>
                                <div class="input-group-append">
                                    <input class="form-control" type="text" id="barcode" value="">
                                    <select class="form-control"  id="select-barang"></select>
                                </div>
                            </div>

                        </div>
                    </div>
                  </div>
              </div>
              <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Form faktur</h3>
                    </div>
                    <div class="card-body">
                        <div class="row gx-3 mb-3">
                            <div class="col-12">
                                <label for="tanggal-faktur" class="small my-1">
                                      Tanggal
                                      <span class="text-danger">*</span>
                                  </label>
          
                                  <input name="tanggal-faktur" id="tanggal-faktur" type="date"
                                          class="form-control example-date-input "
                                          value="<?= date('Y-m-d') ?>"
                                          required
                                  >
          
                                  <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-12">
                                <label class="small mb-1" for="faktur">
                                      Faktur
                                      <span class="text-danger">*</span>
                                  </label>
          
                                  <input type="text" class="form-control"
                                          id="faktur"
                                          name="faktur"
                                          value=""
                                          readonly
                                  >
          
                                  <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-12">
                                <label class="small mb-1" for="customer-id">
                                      Customer
                                      <span class="text-danger">*</span>
                                  </label>
          
                                  <select class="form-select form-control" id="customer-id" name="customer-id" style="width: 100%;">
                                      <option value="" class="text-center" selected="" disabled="">-- pilih customer --</option>
                                  </select>
          
                                  <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-12">
                                <label class="small mb-1" for="pembayaran">
                                      Tipe pembayaran
                                      <span class="text-danger">*</span>
                                  </label>
                                  <select class="form-select form-control" id="pembayaran" name="pembayaran">
                                      <option selected="" disabled="" value="">
                                          Pilih pembayaran:
                                      </option>
                                      <option value="cash">Uang tunai</option>
                                      <option value="tf">Transfer bank</option>
                                      <option value="due">Bayar tempo</option>
                                  </select>
          
                                  <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
          </div>
          <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tabel detail penjualan</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="align-middle">Product</th>
                                    <th class="align-middle text-center">Kuantitas</th>
                                    <th class="align-middle text-center">Harga Jual</th>
                                    <th class="align-middle text-center">Subtotal Produk</th>
                                </tr>
                            </thead>
        
                            <tbody id="penjualan_table"></tbody>

                            <tfoot class="thead-dark">
                                <tr>
                                    <th colspan="3" class="align-middle text-right">
                                        Subtotal
                                    </th>
                                    <td class="text-center">
                                        <div id="subtotal">Rp 0</div>
                                        <input type="hidden" id="subtotal-num" value="">
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="align-middle text-right">
                                        Pajak
                                    </th>
                                    <td width="150" class="align-middle text-center">
                                        <input type="number" id="taxes" class="form-control w-75 d-inline" min="0" max="100" value="0">
                                        %
        
                                        <em class="invalid-feedback"></em>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="align-middle text-right">
                                        Diskon
                                    </th>
                                    <td width="150" class="align-middle text-center">
                                        <input type="number" id="diskon" class="form-control w-75 d-inline" min="0" max="100" value="0">
                                        %
        
                                        <em class="invalid-feedback"></em>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="align-middle text-right">
                                        Total
                                    </th>
                                    <td class="text-center">
                                        <div id="total-harga">Rp 0</div>
                                        <input type="hidden" id="total-harga-num" value="">
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="3"></th>
                                    <td>
                                        <button type="submit" id="btn-create-invoice" class="btn btn-success float-right add-list mx-1" disabled="disabled">
                                            Create Invoice
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
          </div>

      </div>
      <!-- container -->
    </section>
    <!-- content -->
  </div>
  <!-- /.content-wrapper -->

  <div class="modal fade" id="modal-customer">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
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
            </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" id="btn-create-customer">Simpan</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal show -->


<?= $this->endSection(); ?>

<?= $this->section('script') ?>
    <!-- Select2 -->
    <script src="/template/adminLTE/plugins/select2/js/select2.full.min.js"></script>
    <script>
        const $tablePenjualan = $('#penjualan_table');// table untuk penjualan (didalam div form penjualan)

        // list form input tetap
        const barcode = $('#barcode');
        const selectBarang = $('#select-barang');

        const $faktur = $('#faktur');// inp faktur
        const $dateFaktur = $('#tanggal-faktur');// inp tanggal faktur
        const $customer = $('#customer-id')// inp select customer
        const $pembayaran = $('#pembayaran')// inp select pembayaran

        const $modalShow = new bootstrap.Modal(document.getElementById('modal-customer'), {});
        const inpName = $('#u-name');
        const inpEmail = $('#u-email');
        const inpPhone = $('#u-phone');
        const inpAlamat = $('#u-alamat');
        const inpToko = $('#u-toko');
        const inpAlamatToko = $('#u-alamat-toko');
        const inpBank = $('#u-bank');
        const inpNoRekening = $('#u-no-rekening');
        const btnSimpanModal = $('#btn-create-customer');

        const $subtotal = $('#subtotal');// div subtotal
        const $subtotalNum = $('#subtotal-num');// inp hidden subtotal berupa angka saja
        const $taxes = $('#taxes');// inp persentase pajak
        const $diskon = $('#diskon');// inp persentase diskon
        const $totalHarga = $('#total-harga');// div total harga
        const $totalHargaNum = $('#total-harga-num');// inp hidden total harga berupa angka saja
        const $btnInvoice = $('#btn-create-invoice'); // tombol create invoice

        const jsonDataBarang = [];// tempat menyimpan data Produk
        const jsonDataPenjualan = [];// tempat menyimpan list Penjualan
        const jsonDataCustomer = [];// tempat menyimpan list customer
        const jsonFormPenjualan = [];// tempat menyimpan data form penjualan

        $(function () {
            fetchDataCustomer(e => {
                processDataCustomer(e);
                generateSelectCustomer();
                $customer.select2({
                    placeholder: '-- Pilih Customer --',
                    tags: true,
                    createTag: function (params) {
                        var term = $.trim(params.term);
                        if (term === "") {
                        return null;
                        }
                        return {
                        id: term,
                        text: term,
                        newTag: true
                        };
                    }
                }).on('select2:select', function (e) {
                    // Check if the selected option is a new tag
                    if (e.params.data.newTag) {
                        inpName.val(e.params.data.text);
                        btnSimpanModal.prop('disabled', true);
                        $modalShow.show();
                    }
                });
            });// masukkan data customer pada tempatnya

            fetchDataBarang(e => {
                processDataBarang(e);
                generataDataBarang();
                selectBarang.select2();
                barcode.focus();
            });

            fetchDataPenjualan(e => {
                processDataPenjualan(e);
                let fakturNumber = (jsonDataPenjualan.length + 1).toString().padStart(6, '0');
                $faktur.val(`JL-${fakturNumber}`);
            });

            selectBarang.on('input', function () {
                barcode.val(selectBarang.val()).trigger('input');
            });

            barcode.on('input', function() {
                const value = barcode.val();

                // check if barcode length is equal to 13
                barcode.removeClass('is-invalid');
                if (value.length < 13) {
                    barcode.addClass('is-invalid');
                    return;
                }
                // check if barcode was saved in the database barang
                var findData = jsonDataBarang.find(e => e.kode == value);
                
                if (!findData) {
                    return;
                }

                let data = {
                    nama: findData.nama,
                    kode_produk: barcode.val(),
                    jumlah: 1,
                    harga_jual: parseInt(findData.harga),
                    subtotal: parseInt(findData.harga),
                };

                let existingIndex = jsonFormPenjualan.findIndex(e => e.kode_produk === barcode.val());

                if (existingIndex !== -1) {
                    for (let i = 0; i < jsonFormPenjualan.length; i++) {
                        if (jsonFormPenjualan[i].kode_produk == barcode.val()) {
                            let oldJumlah = jsonFormPenjualan[i].jumlah;
                            let newJumlah = oldJumlah + data.jumlah;
                            let newSubtotal = newJumlah * data.harga_jual;

                            jsonFormPenjualan[i].jumlah = newJumlah;
                            jsonFormPenjualan[i].harga_jual = data.harga_jual;
                            jsonFormPenjualan[i].subtotal = newSubtotal;
                        }
                    }
                } else {
                    jsonFormPenjualan.push(data);
                }
                setForm(jsonFormPenjualan);
                updateInvoiceButtonState();
                updateTotals();

                selectBarang.val('').trigger('change');
                barcode.val('').focus();

            });

            $dateFaktur.on('input', function () { // check input tanggal faktur
                $dateFaktur.removeClass('is-invalid');
                $dateFaktur.siblings('.invalid-feedback').html('');
                if ($(this).val() == '' ) {
                    $dateFaktur.addClass('is-invalid');
                    $dateFaktur.siblings('.invalid-feedback').html('Tolong isi tanggal penjualan');
                }
                updateInvoiceButtonState();
            });

            $customer.on('input', function () { // check input customer
                $customer.next('.select2').find('.select2-selection').removeClass('border border-danger');
                $customer.siblings('.invalid-feedback').html('').hide();
                if ($(this).val() == '' ) {
                    $customer.next('.select2').find('.select2-selection').addClass('border border-danger');
                    $customer.siblings('.invalid-feedback').html('Tolong pilih pembeli').show();
                }
                updateInvoiceButtonState();
            });

            $faktur.on('input', function () { // check input faktur
                $faktur.removeClass('is-invalid');
                $faktur.siblings('.invalid-feedback').html('');
                if ($(this).val() == '' ) {
                    $faktur.addClass('is-invalid');
                    $faktur.siblings('.invalid-feedback').html('Tolong isi faktur penjualan');
                }
                updateInvoiceButtonState();
            });


            $tablePenjualan.on('input', 'input, select', function() {
                var currentRow = $(this).closest('tr[data-status]');
                var productInput = currentRow.find('.kode');
                var quantityInput = currentRow.find('.jumlah-form');
                var priceInput = currentRow.find('.harga-jual');
                var subtotalElement = currentRow.find('.subtotal-produk');

                var changeSubtotalProduk = true;

                if ($(this).hasClass('jumlah-form')) {
                    $(this).removeClass('is-invalid');
                    $(this).siblings('.jumlah-form-html').html($(this).val());
                    if ($(this).val() < 1) {
                        $(this).addClass('is-invalid');
                        changeSubtotalProduk = false;
                    }
                }

                if (changeSubtotalProduk) {
                    var subtotalProdukNumber = parseInt(quantityInput.val(), 10) * parseInt(priceInput.siblings('.harga-penjualan').val(), 10);
                    subtotalElement.html(formatRupiah(subtotalProdukNumber));

                    for (let i = 0; i < jsonFormPenjualan.length; i++) {
                        if (jsonFormPenjualan[i].kode_produk == productInput.val()) {
                            jsonFormPenjualan[i].jumlah = parseInt(quantityInput.val(), 10);
                            jsonFormPenjualan[i].subtotal = subtotalProdukNumber;
                        }
                    }

                } else {
                    subtotalElement.html('Rp 0');
                }
                updateInvoiceButtonState();
                updateTotals();
            }); // end $tablePenjualan input

            $taxes.on('input',() => updateTotals());
            $diskon.on('input',() => updateTotals());
            $pembayaran.on('input', () => updateInvoiceButtonState());

            $btnInvoice.click(function () {
                var dataProduk = jsonFormPenjualan;
                if (dataProduk.length < 1) {
                    $(this).attr('disabled', 'disabled');
                    makeToast('belum ada data produk!!!');
                    return;
                }

                var formData = new FormData();
                formData.append('tanggal_faktur', $dateFaktur.val());
                formData.append('faktur', $faktur.val());
                formData.append('customer', $customer.val());
                formData.append('produk', JSON.stringify(dataProduk));
                formData.append('subtotal', $subtotalNum.val());
                formData.append('pajak_persen', $taxes.val());
                formData.append('diskon_persen', $diskon.val());
                formData.append('total_harga', $totalHargaNum.val());
                formData.append('pembayaran', $pembayaran.val());

                $.ajax({
                    url: "<?= url_to('penjualan.store') ?>",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        makeToast(response.bg, response.message);
                        if (response.bg == 'bg-success') {    
                            updateStockProduct(dataProduk);
                            fetchDataPenjualan(e => {
                                processDataPenjualan(e);
                                let fakturNumber = (jsonDataPenjualan.length + 1).toString().padStart(6, '0');
                                $faktur.val(`JL-${fakturNumber}`);
                            });
                            
                            var now = new Date();
                            var day = ("0" + now.getDate()).slice(-2);
                            var month = ("0" + (now.getMonth() + 1)).slice(-2);
                            var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

                            $dateFaktur.val(today);
                            $faktur.val('');
                            $customer.val('').trigger('change');
                            $subtotalNum.val('');
                            $taxes.val(0);
                            $diskon.val(0)
                            $totalHargaNum.val('');
                            // Clear table
                            $tablePenjualan.empty();
                            $btnInvoice.attr('disabled', 'disabled');
                        }
                    },
                    error: function(xhr, status, error) {
                        makeToast('bg-danger', xhr.responseText);
                    }
                });
            });// end $btnInvoice

            $('#modal-customer').on('hidden.bs.modal', function(){deleteFormCustomer();}); // if modalShow was closed

            $('#modal-customer').on('input', '.form-control', function(){// $modalShow onInput
                // validation
                const emailPattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                const phoneNumberPattern = /^(?:\+62|0)(?:\s*\(?\d{2,3}\)?\s*|\-?\d\s*){9,15}$/;

                let inputFocus = $(this);
                let typeInput = inputFocus.attr('type');
                let nameInput = inputFocus.attr('name'); 
                let feedbackDiv = inputFocus.parent().find('.invalid-feedback');    
                
                switch (nameInput) {
                    case 'email':
                        let isEmail = emailPattern.test(inputFocus.val());
        
                        inputFocus.toggleClass('is-invalid', !isEmail);
                        feedbackDiv.toggleClass('d-none', isEmail);
                        feedbackDiv.html('Invalid email.');
                        break;
                    case 'phone':
                        let isNumberPhone = phoneNumberPattern.test(inputFocus.val());
            
                        inputFocus.toggleClass('is-invalid', !isNumberPhone);
                        feedbackDiv.toggleClass('d-none', isNumberPhone);
                        feedbackDiv.html('invalid no Whatsapp.(Wajib di isi)');
                        break;
                    default:
                        inputFocus.toggleClass('is-invalid', true);
                        feedbackDiv.toggleClass('d-none', false);
                        feedbackDiv.html(`${nameInput} wajib di isi.`);
                        if (inputFocus.val() !== null) {
                            inputFocus.toggleClass('is-invalid', false);
                            feedbackDiv.toggleClass('d-none', true);
                            feedbackDiv.html(``);
                        }
                        break;
                }

                btnSimpanModal.prop('disabled', !(
                    inpName.val() && !inpName.hasClass('is-invalid') &&
                    inpPhone.val() && !inpPhone.hasClass('is-invalid') &&
                    inpToko.val() && !inpToko.hasClass('is-invalid') &&
                    inpAlamatToko.val() && !inpAlamatToko.hasClass('is-invalid')
                ));
            }); // end $modalShow onInput

            btnSimpanModal.on('click', function() {
                let formData = new FormData();
                let urlSimpan = '<?= url_to('preference.customer.store') ?>';

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
                    success: function(response) {
                        makeToast(response.bg, response.message);
                        if (response.bg === 'bg-success') {
                            fetchDataCustomer(function(e) {
                                processDataCustomer(e);
                                generateSelectCustomer();

                                let selectedData = jsonDataCustomer.find(e => e.name === inpName.val());
                                $('#modal-customer').find('button.close').trigger('click');
                                $customer.val(selectedData.id).trigger('change');

                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        makeToast('bg-danger', `Error: ${error}`);
                    }
                }); 
            }); // end btnSimpanModal

        });// end document ready

        function deleteFormCustomer() {
            const data = inpName.val();
            const target = $customer.find(`option[value='${data}']`); // Corrected here
            target.remove(); // target self delete
            $customer.val('').trigger('change');
            inpName.val('');
            inpEmail.val('');
            inpPhone.val('');
            inpAlamat.val('');
            inpToko.val('');
            inpAlamatToko.val('');
            inpBank.val('');
            inpNoRekening.val('');
        }

        function fetchDataBarang(callback) {
            $.ajax({
                url: '<?= url_to('penjualan.produkjson') ?>',
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

        function processDataBarang(response) {
            jsonDataBarang.length = 0;
            for (let i = 0; i < response.length; i++) {
                let stock = response[i].stock !== undefined ? parseInt(response[i].stock) : 0;
                if (stock > 0) {
                    jsonDataBarang.push({
                        nama: response[i].nama_barang,
                        kode: response[i].kode_barang,
                        gambar: (response[i].gambar_barang.startsWith('http')) ? response[i].gambar_barang : "<?= base_url() ?>images/" + response[i].gambar_barang,
                        harga: response[i].harga_barang,
                        slug: response[i].slug,
                        status: response[i].status,
                        stock: stock,
                        satuan: response[i].satuan,
                    });
                }
            }
        }

        function generataDataBarang() {
            let options = jsonDataBarang.map(e => `<option value='${e.kode}'>${e.nama}</option>`).join('');
            if (options.length < 1) {
                makeToast('bg-danger', 'Belum ada stock barang di gudang');
                return;
            }
            selectBarang.append(`<option value="" class="text-center" selected="" disabled="">-- barcode --</option>${options}`);
        }
        
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
            jsonDataPenjualan.length = 0;
            for (let i = 0; i < response.length; i++) {
                let detailBarang = response[i].detail.map(e => ({
                    nama: e.nama_barang,
                    hargaJual: e.harga_jual,
                    hargaBeli: e.harga_jual,
                    jumlah: e.jumlah,
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
                    detailBarang: detailBarang
                });
            }
        }

        function fetchDataCustomer(callback)
        {
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
        }// end fetchDataCustomer

        function processDataCustomer(response)
        {
            jsonDataCustomer.length = 0;
            for (let i = 0; i < response.length; i++) {
                jsonDataCustomer.push({
                    id      : response[i].id,
                    nama    : response[i].nama,
                    toko    : response[i].nama_toko,
                });
            }    
        }// end processDataCustomer

        function generateSelectCustomer()
        {
            for (let i = 0; i < jsonDataCustomer.length; i++) {                
                let row = `
                    <option value="${jsonDataCustomer[i].id}">${jsonDataCustomer[i].nama}(${jsonDataCustomer[i].toko})</option>
                `;
                $customer.append(row);
            }    
        }// end generateSelectCustomer

        function formatRupiah(angka) {
            var reverse = angka.toString().split('').reverse().join('');
            var ribuan = reverse.match(/\d{1,3}/g);
            var formatted = ribuan.join('.').split('').reverse().join('');
            return 'Rp ' + formatted;
        }

        function setForm(data) {
            $tablePenjualan.empty();
            for (let i = 0; i < data.length; i++) {
                let row = `
                    <tr data-status='save'>
                        <td class="align-middle">
                            ${data[i].nama}
                            <input type="hidden" value="${data[i].kode_produk}" class="kode"/>
                        </td>

                        <td class="align-middle text-center">
                            <input type="number" value="${data[i].jumlah}" min="1" class="form-control jumlah-form"/>
                        </td>

                        <!-- Harga Jual -->
                        <td class="align-middle text-center">
                            <div class="form-control form-control-solid harga-jual">${formatRupiah(data[i].harga_jual)}</div>
                            <input type="hidden" class="harga-penjualan" value="${data[i].harga_jual}">
                        </td>

                        <!-- Total -->
                        <td class="align-middle text-center">
                            <div class="subtotal-produk form-control">${formatRupiah(data[i].subtotal)}</div>
                        </td>

                    </tr>
                `;
                $tablePenjualan.append(row);
            }
        }

        function updateInvoiceButtonState() {
            if (jsonFormPenjualan.length > 0 && $pembayaran.val() !== null && $customer.val() !== null) {
                $btnInvoice.removeAttr('disabled');
            } else {
                $btnInvoice.attr('disabled', 'disabled');
            }
        }


        function updateTotals() {
            // Calculate subtotal
            var dataInputan = jsonFormPenjualan;
            $subtotalNum.val(0);
            $subtotal.html('Rp 0');
            $totalHargaNum.val(0);
            $totalHarga.html('Rp 0');
            
            // Check length of data inputan
            if (dataInputan.length > 0) {                
                let inpSubtotal = 0;
                dataInputan.forEach(e => {
                    inpSubtotal += parseInt(e.subtotal, 10);
                });
                $subtotalNum.val(inpSubtotal);
                $subtotal.html(formatRupiah(inpSubtotal));

                // Calculate tax and total
                let taxValue = parseInt($taxes.val(), 10);
                if (isNaN(taxValue)) {
                    console.error('Nilai pajak tidak valid:', $taxes.val());
                    taxValue = 0; // Default value if tax is not valid
                }

                let diskonValue = parseInt($diskon.val(), 10);
                if (isNaN(diskonValue)) {
                    console.error('Nilai diskon tidak valid:', $diskon.val());
                    diskonValue = 0; // Default value if discount is not valid
                }

                let pajakPlusDiskonPlusSubtotal = inpSubtotal + (inpSubtotal * taxValue / 100) - (inpSubtotal * diskonValue / 100);
                $totalHargaNum.val(pajakPlusDiskonPlusSubtotal);
                $totalHarga.html(formatRupiah(pajakPlusDiskonPlusSubtotal));
            }
        }

        // Function to update product stock
        function updateStockProduct(dataProduk) {
            dataProduk.forEach(product => {
                jsonDataBarang.forEach(item => {
                    if (item.kode === product.kode_produk) {
                        item.stock -= parseInt(product.jumlah);
                    }
                });
            });
        }
    </script>
<?= $this->endSection() ?>