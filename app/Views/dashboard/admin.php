<!DOCTYPE html>
<html lang="en">
<?= $this->include('dashboard/header') ?>

<body class="mod-bg-1 mod-nav-link ">
    <?= $this->include('dashboard/script') ?>
    <!-- BEGIN Page Wrapper -->
    <div class="page-wrapper">
        <div class="page-inner">
            <!-- BEGIN Left Aside -->
            <?= $this->include('dashboard/wrapper-leftside') ?>
            <!-- END Left Aside -->
            <div class="page-content-wrapper">
                <!-- BEGIN Page Header -->
                <?= $this->include('dashboard/wrapper-headside') ?>
                <!-- END Page Header -->
                <!-- BEGIN Page Content -->
                <!-- the #js-page-content id is needed for some plugins to initialize -->
                <main id="js-page-content" role="main" class="page-content">
                    <?= $this->include('dashboard/wrapper-breadcumpside') ?>
                    <?= $this->include('dashboard/wrapper-content') ?>
                </main>
                <!-- this overlay is activated only when mobile menu is triggered -->
                <div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div> <!-- END Page Content -->
                <!-- BEGIN Page Footer -->
                <?= $this->include('dashboard/wrapper-footer') ?>
                <!-- END Page Footer -->
            </div>
        </div>
    </div>
    <!-- END Page Wrapper -->
</body>
<!-- END Body -->

</html>