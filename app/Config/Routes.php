<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'DashboardController::index');

$routes->group('barang', function($routeBarang)
{
    $routeBarang->get('/', 'BarangController::index', ['as' => 'barang.index']);// list barang
    $routeBarang->get('form', 'BarangController::form', ['as' => 'barang.form']);// form barang
    $routeBarang->post('store', 'BarangController::store', ['as' => 'barang.store']);// store/save barang
    $routeBarang->get('edit/(:any)', 'BarangController::edit/$1', ['as' => 'barang.edit']);// edit form barang
    $routeBarang->put('update/(:any)', 'BarangController::update/$1', ['as' => 'barang.update']);// update barang
    $routeBarang->delete('delete/(:any)', 'BarangController::delete/$1', ['as' => 'barang.delete']);// delete barang
    $routeBarang->put('restore/(:any)', 'BarangController::restore/$1', ['as' => 'barang.restore']);// restore barang
    $routeBarang->post('json', 'BarangController::json', ['as' => 'barang.json']);// list barang JSON
    $routeBarang->put('stock/(:any)', 'BarangController::stock/$1', ['as' => 'barang.stock']);// stock form barang
    $routeBarang->put('harga/(:any)', 'BarangController::harga/$1', ['as' => 'barang.harga']);// harga form barang
});

$routes->group('pembelian', function($routePembelian)
{
    $routePembelian->get('/', 'PembelianController::index', ['as' => 'pembelian.index']);// list pembelian
    $routePembelian->get('form', 'PembelianController::form', ['as' => 'pembelian.form']);// form pembelian
    $routePembelian->post('produkjson', 'PembelianController::produkjson', ['as' => 'pembelian.produkjson']);// list barang JSON
    $routePembelian->post('pembelianjson', 'PembelianController::pembelianjson', ['as' => 'pembelian.pembelianjson']);// list pembelian JSON
    $routePembelian->post('store', 'PembelianController::store', ['as' => 'pembelian.store']);// store/save pembelian
    $routePembelian->put('approve/(:any)', 'PembelianController::approve/$1',['as' => 'pembelian.approve']);
    $routePembelian->delete('delete/(:any)', 'PembelianController::delete/$1', ['as' => 'pembelian.delete']);// delete pembelian
});

$routes->group('penjualan', function($routePenjualan)
{
    $routePenjualan->get('/', 'PenjualanController::index', ['as' => 'penjualan.index']);// list penjualan
    $routePenjualan->get('form', 'PenjualanController::form', ['as' => 'penjualan.form']);// form penjualan
    $routePenjualan->post('produkjson', 'PenjualanController::produkjson', ['as' => 'penjualan.produkjson']);// list barang JSON
    $routePenjualan->post('penjualanjson', 'PenjualanController::penjualanjson', ['as' => 'penjualan.penjualanjson']);// list penjualan JSON
    $routePenjualan->post('store', 'PenjualanController::store', ['as' => 'penjualan.store']);// store/save penjualan
    $routePenjualan->put('approve/(:any)', 'PenjualanController::approve/$1',['as' => 'penjualan.approve']);
    $routePenjualan->delete('delete/(:any)', 'PenjualanController::delete/$1', ['as' => 'penjualan.delete']);// delete penjualan
});

$routes->group('invoice', function($routeInvoice)
{
    $routeInvoice->get('create', 'InvoiceController::create', ['as' => 'invoice.create']);
    $routeInvoice->post('store', 'InvoiceController::store', ['as' => 'invoice.store']);
    $routeInvoice->get('print/(:any)', 'InvoiceController::print/$1', ['as' => 'invoice.print']);
});

$routes->group('preference', function ($routePrefe) 
{
    $routePrefe->group('gudang', function ($routeGudang)
    {
        $routeGudang->post('json', 'Preference\GudangController::json', ['as' => 'preference.gudang.json']);
        $routeGudang->get('', 'Preference\GudangController::index', ['as' => 'preference.gudang']);
        $routeGudang->post('store', 'Preference\GudangController::store', ['as' => 'preference.gudang.store']);// store gudang
        $routeGudang->put('update/(:any)', 'Preference\GudangController::update/$1', ['as' => 'preference.gudang.update']);// update gudang
        $routeGudang->delete('delete/(:any)', 'Preference\GudangController::delete/$1', ['as' => 'preference.gudang.delete']);// delete gudang
        $routeGudang->put('restore/(:any)', 'Preference\GudangController::restore/$1', ['as' => 'preference.gudang.restore']);// restore gudang
        $routeGudang->put('selected/(:any)', 'Preference\GudangController::selected/$1', ['as' => 'preference.gudang.selected']);// selected gudang
    });

    $routePrefe->group('supplier', function ($routeSupplier)
    {
        $routeSupplier->get('/', 'Preference\SupplierController::index', ['as' => 'preference.supplier']);
        $routeSupplier->post('json', 'Preference\SupplierController::json', ['as' => 'preference.supplier.json']);
        $routeSupplier->post('store', 'Preference\SupplierController::store', ['as' => 'preference.supplier.store']);
        $routeSupplier->put('update/(:any)', 'Preference\SupplierController::update/$1', ['as' => 'preference.supplier.update']);
        $routeSupplier->delete('delete/(:any)', 'Preference\SupplierController::delete/$1', ['as' => 'preference.supplier.delete']);
    });

    $routePrefe->group('customer', function ($routeCustomer)
    {
        $routeCustomer->get('/', 'Preference\CustomerController::index', ['as' => 'preference.customer']);
        $routeCustomer->post('json', 'Preference\CustomerController::json', ['as' => 'preference.customer.json']);
        $routeCustomer->post('store', 'Preference\CustomerController::store', ['as' => 'preference.customer.store']);
        $routeCustomer->put('update/(:any)', 'Preference\CustomerController::update/$1', ['as' => 'preference.customer.update']);
        $routeCustomer->delete('delete/(:any)', 'Preference\CustomerController::delete/$1', ['as' => 'preference.customer.delete']);
    });

    $routePrefe->group('category', function ($routeRubrik)
    {
        $routeRubrik->get('/', 'Preference\CategoryController::index', ['as' => 'preference.rubrik']);// list kategori
        $routeRubrik->post('store', 'Preference\CategoryController::store', ['as' => 'preference.rubrik.store']);// store kategori
        $routeRubrik->put('update/(:any)', 'Preference\CategoryController::update/$1', ['as' => 'preference.rubrik.update']);// update kategori
        $routeRubrik->delete('delete/(:any)', 'Preference\CategoryController::delete/$1', ['as' => 'preference.rubrik.delete']);// delete kategori
        $routeRubrik->put('restore/(:any)', 'Preference\CategoryController::restore/$1', ['as' => 'preference.rubrik.restore']);// restore kategori
    });

    $routePrefe->group('Satuan', function ($routeSatuan)
    {
        $routeSatuan->get('/', 'Preference\SatuanController::index', ['as' => 'preference.satuan']);// list satuan
        $routeSatuan->post('store', 'Preference\SatuanController::store', ['as' => 'preference.satuan.store']);// store satuan
        $routeSatuan->put('update/(:any)', 'Preference\SatuanController::update/$1', ['as' => 'preference.satuan.update']);// update satuan
        $routeSatuan->delete('delete/(:any)', 'Preference\SatuanController::delete/$1', ['as' => 'preference.satuan.delete']);// delete satuan
        $routeSatuan->put('restore/(:any)', 'Preference\SatuanController::restore/$1', ['as' => 'preference.satuan.restore']);// restore satuan
    });

    $routePrefe->group('users', function ($routeUser)
    {
        $routeUser->get('/', 'Preference\UserController::index', ['as' => 'preference.user']);
        $routeUser->post('json', 'Preference\UserController::json', ['as' => 'preference.user.json']);
        $routeUser->post('store', 'Preference\UserController::store', ['as' => 'preference.user.store']);
        $routeUser->put('update/(:any)', 'Preference\UserController::update/$1', ['as' => 'preference.user.update']);
        $routeUser->put('block/(:any)', 'Preference\UserController::block/$1', ['as' => 'preference.user.block']);
        $routeUser->put('unblock/(:any)', 'Preference\UserController::unblock/$1', ['as' => 'preference.user.unblock']);

    });
});

$routes->group('accounting', function ($rAccounting)
{
    $rAccounting->group('category', function($rACategory)
    {
       $rACategory->get('/', 'Accounting\CategoryController::index', ['as' => 'accounting.category']);
       
        //    category1
       $rACategory->post('storec1', 'Accounting\CategoryController::storec1', ['as' => 'accounting.category.storec1']);
       $rACategory->post('json1', 'Accounting\CategoryController::json1', ['as' => 'accounting.category.json1']);
       $rACategory->put('updatec1/(:any)', 'Accounting\CategoryController::updatec1/$1', ['as' => 'accounting.category.updatec1']);
       $rACategory->delete('deletec1/(:any)', 'Accounting\CategoryController::deletec1/$1', ['as' => 'accounting.category.deletec1']);

        //    category2
        $rACategory->post('storec2', 'Accounting\CategoryController::storec2', ['as' => 'accounting.category.storec2']);
       $rACategory->post('json2', 'Accounting\CategoryController::json2', ['as' => 'accounting.category.json2']);
        $rACategory->put('updatec2/(:any)', 'Accounting\CategoryController::updatec2/$1', ['as' => 'accounting.category.updatec2']);
        $rACategory->delete('deletec2/(:any)', 'Accounting\CategoryController::deletec2/$1', ['as' => 'accounting.category.deletec2']);

        // category3
        $rACategory->post('storec3', 'Accounting\CategoryController::storec3', ['as' => 'accounting.category.storec3']);
       $rACategory->post('json3', 'Accounting\CategoryController::json3', ['as' => 'accounting.category.json3']);
        $rACategory->put('updatec3/(:any)', 'Accounting\CategoryController::updatec3/$1', ['as' => 'accounting.category.updatec3']);
        $rACategory->delete('deletec3/(:any)', 'Accounting\CategoryController::deletec3/$1', ['as' => 'accounting.category.deletec3']);

        $rACategory->post('periode', 'Accounting\CategoryController::periode', ['as' => 'accounting.category.periode']);
    });

    $rAccounting->group('transaksi', function($rATransaksi)
    {
        $rATransaksi->group('umum', function($rATUmum)
        {
            $rATUmum->post('json', 'Accounting\JurnalController::json', ['as' => 'accounting.transaksi.umum.json']);
            $rATUmum->get('', 'Accounting\JurnalController::index', ['as' => 'accounting.transaksi.umum']);
            $rATUmum->post('store', 'Accounting\JurnalController::store', ['as' => 'accounting.transaksi.umum.store']);
            $rATUmum->put('update/(:any)', 'Accounting\JurnalController::update/$1', ['as' => 'accounting.transaksi.umum.update']);
            $rATUmum->delete('delete/(:any)', 'Accounting\JurnalController::delete/$1', ['as' => 'accounting.transaksi.umum.delete']);
        });

        $rATransaksi->group('penyesuaian', function($rATPenyesuaian)
        {
            $rATPenyesuaian->post('json', 'Accounting\PenyesuaianController::json', ['as' => 'accounting.transaksi.penyesuaian.json']);
            $rATPenyesuaian->get('', 'Accounting\PenyesuaianController::index', ['as' => 'accounting.transaksi.penyesuaian']);
            $rATPenyesuaian->post('store', 'Accounting\PenyesuaianController::store', ['as' => 'accounting.transaksi.penyesuaian.store']);
            $rATPenyesuaian->put('update/(:any)', 'Accounting\PenyesuaianController::update/$1', ['as' => 'accounting.transaksi.penyesuaian.update']);
            $rATPenyesuaian->delete('delete/(:any)', 'Accounting\PenyesuaianController::delete/$1', ['as' => 'accounting.transaksi.penyesuaian.delete']);
        });

        
    });
    
    $rAccounting->get('jurnalumum', 'Accounting\AccountingController::jurnalumum', ['as' => 'accounting.jurnalumum']);
    $rAccounting->post('jurnalumum/pdf', 'Accounting\AccountingController::jurnalumumpdf', ['as' => 'accounting.jurnalumum.pdf']);

    $rAccounting->group('jurnalpenyesuaian', function($rATJPenyesuaian)
    {
        $rATJPenyesuaian->get('', 'Accounting\PenyesuaianController::jurnal', ['as' => 'accounting.jurnalpenyesuaian']);
        $rATJPenyesuaian->post('pdf', 'Accounting\PenyesuaianController::jurnalpdf', ['as' => 'accounting.jurnalpenyesuaian.pdf']);
    });
    
    $rAccounting->get('posting', 'Accounting\AccountingController::posting', ['as' => 'accounting.posting']);
    $rAccounting->post('posting/pdf', 'Accounting\AccountingController::postingpdf', ['as' => 'accounting.posting.pdf']);

    $rAccounting->group('neraca', function($rANeraca)
    {
        $rANeraca->get('saldo', 'Accounting\NeracaController::saldo', ['as' => 'accounting.neraca.saldo']);
        $rANeraca->post('saldo/pdf', 'Accounting\NeracaController::saldopdf', ['as' => 'accounting.neraca.saldo.pdf']);

        $rANeraca->get('lajur', 'Accounting\NeracaController::lajur', ['as' => 'accounting.neraca.lajur']);
        $rANeraca->post('lajur/pdf', 'Accounting\NeracaController::lajurpdf', ['as' => 'accounting.neraca.lajur.pdf']);
    });

    $rAccounting->group('laporan', function($rALaporan)
    {
        $rALaporan->get('persediaan', 'Accounting\LaporanController::persediaan', ['as' => 'accounting.laporan.persediaan']);
        $rALaporan->post('persediaan/pdf', 'Accounting\LaporanController::persediaanpdf', ['as' => 'accounting.laporan.persediaan.pdf']);

        $rALaporan->get('labarugi', 'Accounting\LaporanController::labarugi', ['as' => 'accounting.laporan.labarugi']);
        $rALaporan->post('labarugi/pdf', 'Accounting\LaporanController::labarugipdf', ['as' => 'accounting.laporan.labarugi.pdf']);

        $rALaporan->get('modal', 'Accounting\LaporanController::modal', ['as' => 'accounting.laporan.modal']);
        $rALaporan->post('modal', 'Accounting\LaporanController::modalpdf', ['as' => 'accounting.laporan.modal.pdf']);

        $rALaporan->get('neraca', 'Accounting\LaporanController::neraca', ['as' => 'accounting.laporan.neraca']);
        $rALaporan->post('neraca/pdf', 'Accounting\LaporanController::neracapdf', ['as' => 'accounting.laporan.neraca.pdf']);

        $rALaporan->get('kas', 'Accounting\LaporanController::kas', ['as' => 'accounting.laporan.kas']);
        $rALaporan->post('kas/pdf', 'Accounting\LaporanController::kaspdf', ['as' => 'accounting.laporan.kas.pdf']);
    });

});
