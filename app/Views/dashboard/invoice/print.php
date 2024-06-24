<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= ucfirst($title) ?> | Panel Logistik</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/invoice/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet"
        href="<?= base_url() ?>assets/invoice/fonts/font-awesome/css/font-awesome.min.css">
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/invoice/css/style.css">
</head>
<?php $formatter = new \NumberFormatter('id_ID', \NumberFormatter::CURRENCY); ?>
<body>
    <div class="invoice-16 invoice-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-inner-9" id="invoice_wrapper">
                        <div class="invoice-top">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <div class="logo">
                                        <h1><?= $gudang['nama_gudang']; ?></h1>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="invoice">
                                        <h1>
                                            Invoice # <span><?= $data['faktur'] ?></span>
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-info">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <div class="invoice-number">
                                        <h4 class="inv-title-1">
                                            Invoice date:
                                        </h4>
                                        <p class="invo-addr-1">
                                            <?= $data['tanggal_faktur'] ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="inv-title-1"><?= $subscriber['type'] ?></h4>
                                    <p class="inv-from-1"><?= $subscriber['data']['nama'] ?></p>
                                    <p class="inv-from-1"><?= $subscriber['data']['phone'] ?? '-' ?></p>
                                    <p class="inv-from-1"><?= $subscriber['data']['email'] ?? '-' ?></p>
                                    <p class="inv-from-2"><?= $subscriber['data']['alamat'] ?? '-' ?></p>
                                </div>
                                <div class="col-sm-6 text-end">
                                    <h4 class="inv-title-1">Store</h4>
                                    <p class="inv-from-1"><?= $subscriber['data']['nama_toko'] ?? '-' ?></p>
                                    <p class="inv-from-1"><?= $subscriber['data']['phone'] ?? '-' ?></p>
                                    <p class="inv-from-1"><?= $subscriber['data']['email'] ?? '-' ?></p>
                                    <p class="inv-from-2"><?= $subscriber['data']['alamat_toko'] ?? '-' ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="order-summary">
                            <div class="table-outer">
                                <table class="default-table invoice-table">
                                    <thead>
                                        <tr>
                                            <th class="align-middle">Produk</th>
                                            <th class="align-middle text-center">Harga</th>
                                            <th class="align-middle text-center">Kuantitas</th>
                                            <th class="align-middle text-center">Subtotal</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach($produk as $p): ?>
                                            <tr>
                                                <td class="align-middle">
                                                    <?= $p['nama_barang'] ?>
                                                </td>
                                                    <td class="align-middle text-center">
                                                    <?= $formatter->formatCurrency($p['harga'], 'IDR') ?>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <?= $p['jumlah'] ?>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <?= $formatter->formatCurrency($p['subtotal'], 'IDR') ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>

                                        <tr>
                                            <td colspan="3" class="text-end">
                                                <strong>
                                                    Subtotal
                                                </strong>
                                            </td>
                                            <td class="align-middle text-center">
                                                <strong>
                                                    <?= $formatter->formatCurrency($data['subtotal'], 'IDR') ?>
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end">
                                                <strong>Pajak(<?= $data['pajak_persen'] ?? 0 ?>%)</strong>
                                            </td>
                                            <td class="align-middle text-center">
                                                <strong>
                                                    <?= $formatter->formatCurrency($data['pajak_total'], 'IDR') ?>
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end">
                                                <strong>Diskon(<?= $data['diskon_persen'] ?? 0 ?>%)</strong>
                                            </td>
                                            <td class="align-middle text-center">
                                                <strong>
                                                    <?= $formatter->formatCurrency($data['diskon_total'], 'IDR') ?>
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end">
                                                <strong>Total</strong>
                                            </td>
                                            <td class="align-middle text-center">
                                                <strong>
                                                    <?= $formatter->formatCurrency($data['total_harga'], 'IDR') ?>
                                                </strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="invoice-btn-section clearfix d-print-none">
                        <a href="javascript:window.print()" class="btn btn-lg btn-print">
                            <i class="fa fa-print"></i>
                            Print Invoice
                        </a>
                        <a id="invoice_download_btn" class="btn btn-lg btn-download">
                            <i class="fa fa-download"></i>
                            Download Invoice
                        </a>
                    </div>

                    <div class="invoice-btn-section clearfix d-print-none">
                        <a href="javascript:void(0)" onclick="window.history.go(-1); return false;" class="btn btn-lg btn-print">
                            <i class="fa fa-arrow-left"></i>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url() ?>assets/invoice/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/invoice/js/jspdf.min.js"></script>
    <script src="<?= base_url() ?>assets/invoice/js/html2canvas.js"></script>
    <script src="<?= base_url() ?>assets/invoice/js/app.js"></script>
</body>

</html>
