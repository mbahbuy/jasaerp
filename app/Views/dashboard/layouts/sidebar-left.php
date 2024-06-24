  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= $title == 'dashboard' ? 'javascript:void(0)' : url_to('/') ?>" class="brand-link">
      <img src="/template/adminLTE/dist/img/logo3.svg" alt="Satu Media Digital Indonesia" class="brand-image img-fluid elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Logistik</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar os-host os-theme-light os-host-resize-disabled os-host-transition os-host-overflow os-host-overflow-y os-host-overflow-x">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?= $hal == 'dashboard/index' ? 'javascript:void(0)' : url_to('/') ?>" class="nav-link <?= $hal == 'dashboard/index' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-header">Activity</li>
          <li class="nav-item">
            <a href="<?= $hal == 'barang/index' ? 'javascript:void(0)' : url_to('barang.index') ?>" class="nav-link <?= strpos($hal, 'barang') !== false ? 'active' : '' ?>">
              <i class="nav-icon fas fa-cube"></i>
              <p>
                Barang
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= $hal == 'pembelian/index' ? 'javascript:void(0)' : url_to('pembelian.index') ?>" class="nav-link <?= strpos($hal, 'pembelian') !== false ? 'active' : '' ?>">
              <i class="nav-icon fas fa-cart-plus"></i>
              <p>
                Pembelian
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= $hal == 'penjualan/index' ? 'javascript:void(0)' : url_to('penjualan.index') ?>" class="nav-link <?= strpos($hal, 'penjualan') !== false ? 'active' : '' ?>">
              <i class="nav-icon fas fa-box"></i>
              <p>
                Penjualan
              </p>
            </a>
          </li>
          <li class="nav-header">Setting</li>
          <li class="nav-item  <?= strpos($hal, 'preference') !== false ? 'menu-open' : '' ?>">
            <a href="javascript:void(0)" class="nav-link <?= strpos($hal, 'preference') !== false ? 'active' : '' ?>">
              <i class="nav-icon fas fa-sliders-h"></i>
              <p>
                Preference
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= $hal == 'preference/gudang' ? 'javascript:void(0)' : url_to('preference.gudang') ?>" class="nav-link <?= $hal == 'preference/gudang' ? 'active' : '' ?>">
                  <p class="ml-4">Gudang</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= $hal == 'preference/customer' ? 'javascript:void(0)' : url_to('preference.customer') ?>" class="nav-link <?= $hal == 'preference/customer' ? 'active' : '' ?>">
                  <p class="ml-4">Customer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= $hal == 'preference/supplier' ? 'javascript:void(0)' : url_to('preference.supplier') ?>" class="nav-link <?= $hal == 'preference/supplier' ? 'active' : '' ?>">
                  <p class="ml-4">Supplier</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= $hal == 'preference/rubrik' ? 'javascript:void(0)' : url_to('preference.rubrik') ?>" class="nav-link <?= $hal == 'preference/rubrik' ? 'active' : '' ?>">
                  <p class="ml-4">Kategori</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= $hal == 'preference/satuan' ? 'javascript:void(0)' : url_to('preference.satuan') ?>" class="nav-link <?= $hal == 'preference/satuan' ? 'active' : '' ?>">
                  <p class="ml-4">Satuan</p>
                </a>
              </li>
              <?php if(in_groups(['admin', 'redaktur'], user_id())): ?>
                <li class="nav-item">
                  <a href="<?= $hal == 'preference/user' ? 'javascript:void(0)' : url_to('preference.user') ?>" class="nav-link <?= $hal == 'preference/user' ? 'active' : '' ?>">
                    <p class="ml-4">User</p>
                  </a>
                </li>
              <?php endif; ?>
            </ul>
          </li>
          <li class="nav-header">Accounting</li>
          <li class="nav-item">
                <a href="<?= $hal == 'accounting/jurnalumum' ? 'javascript:void(0)' : url_to('accounting.jurnalumum') ?>" class="nav-link <?= $hal == 'accounting/jurnalumum' ? 'active' : '' ?>">
                  <i class="nav-icon fas fa-book-open"></i>
                  <p>Jurnal Umum</p>
                </a>
          </li>
          <li class="nav-item">
                <a href="<?= $hal == 'accounting/jurnalpenyesuaian' ? 'javascript:void(0)' : url_to('accounting.jurnalpenyesuaian') ?>" class="nav-link <?= $hal == 'accounting/jurnalpenyesuaian' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-book"></i>
                  <p>Jurnal Penyesuaian</p>
                </a>
          </li>
          <li class="nav-item">
                <a href="<?= $hal == 'accounting/posting' ? 'javascript:void(0)' : url_to('accounting.posting') ?>" class="nav-link <?= $hal == 'accounting/posting' ? 'active' : '' ?>">
                  <i class="nav-icon fas fa-calendar"></i>
                  <p>Posting</p>
                </a>
          </li>
          <li class="nav-item">
                <a href="<?= $hal == 'accounting/neraca/saldo' ? 'javascript:void(0)' : url_to('accounting.neraca.saldo') ?>" class="nav-link <?= $hal == 'accounting/neraca/saldo' ? 'active' : '' ?>">
                  <i class="nav-icon fas fa-balance-scale"></i>
                  <p>Neraca Saldo</p>
                </a>
          </li>
          <li class="nav-item">
                <a href="<?= $hal == 'accounting/neraca/lajur' ? 'javascript:void(0)' : url_to('accounting.neraca.lajur') ?>" class="nav-link <?= $hal == 'accounting/neraca/lajur' ? 'active' : '' ?>">
                  <i class="nav-icon fas fa-laptop"></i>
                  <p>Neraca Lajur</p>
                </a>
          </li>
          <li class="nav-item  <?= strpos($hal, 'transaksi') !== false ? 'menu-open' : '' ?>">
            <a href="javascript:void(0)" class="nav-link <?= strpos($hal, 'transaksi') !== false ? 'active' : '' ?>">
              <!-- <i class="nav-icon fas fa-balance-scale"></i> -->
              <i class="nav-icon fas fa-pen"></i>
              <p>
                Transaksi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= $hal == 'transaksi/umum' ? 'javascript:void(0)' : url_to('accounting.transaksi.umum') ?>" class="nav-link <?= $hal == 'transaksi/umum' ? 'active' : '' ?>">
                  <p class="ml-4">Umum</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= $hal == 'transaksi/penyesuaian' ? 'javascript:void(0)' : url_to('accounting.transaksi.penyesuaian') ?>" class="nav-link <?= $hal == 'transaksi/penyesuaian' ? 'active' : '' ?>">
                  <p class="ml-4">Penyesuaian</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item  <?= strpos($hal, 'laporan') !== false ? 'menu-open' : '' ?>">
            <a href="javascript:void(0)" class="nav-link <?= strpos($hal, 'laporan') !== false ? 'active' : '' ?>">
              <!-- <i class="nav-icon fas fa-balance-scale"></i> -->
              <i class="nav-icon fas fa-print"></i>
              <p>
                Laporan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= $hal == 'laporan/persediaan' ? 'javascript:void(0)' : url_to('accounting.laporan.persediaan') ?>" class="nav-link <?= $hal == 'laporan/persediaan' ? 'active' : '' ?>">
                  <p class="ml-4">Arus Barang</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= $hal == 'laporan/labarugi' ? 'javascript:void(0)' : url_to('accounting.laporan.labarugi') ?>" class="nav-link <?= $hal == 'laporan/labarugi' ? 'active' : '' ?>">
                  <p class="ml-4">Laba Rugi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= $hal == 'laporan/modal' ? 'javascript:void(0)' : url_to('accounting.laporan.modal') ?>" class="nav-link <?= $hal == 'laporan/modal' ? 'active' : '' ?>">
                  <p class="ml-4">Perubahan Modal</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= $hal == 'laporan/neraca' ? 'javascript:void(0)' : url_to('accounting.laporan.neraca') ?>" class="nav-link <?= $hal == 'laporan/neraca' ? 'active' : '' ?>">
                  <p class="ml-4">Neraca</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= $hal == 'laporan/kas' ? 'javascript:void(0)' : url_to('accounting.laporan.kas') ?>" class="nav-link <?= $hal == 'laporan/kas' ? 'active' : '' ?>">
                  <p class="ml-4">Arus Kas</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
                <a href="<?= $hal == 'accounting/category' ? 'javascript:void(0)' : url_to('accounting.category') ?>" class="nav-link <?= $hal == 'accounting/category' ? 'active' : '' ?>">
                  <i class="nav-icon fas fa-list"></i>
                  <p>Kode Akun & Settings</p>
                </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>