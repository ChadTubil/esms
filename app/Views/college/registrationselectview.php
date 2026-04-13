<?= $this->extend("layouts/base"); ?>

<?= $this->section("title"); ?>
    <?= $page_title; ?>
<?= $this->endSection(); ?>
<?= $this->section("page_heading"); ?>
    <?= $page_heading; ?>
<?= $this->endSection(); ?>
<?= $this->section("page_p"); ?>
    <?= $page_p; ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
    <!-- ----------- SIDEBAR ------------------ -->
    <?= $this->include("partials/sidebar"); ?>  
    <!-- ----------- END OF SIDEBAR ------------------ --> 

    <!-- Begin Page Content -->

    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">REGISTRATION</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="RE-ENROLLMENT"
                                    onclick="window.location.href='<?= base_url(); ?>col-oldstudent-select'">
                                    <div class="card" style="border: 1px solid #ccc; background-color: #263A56; padding: 30px;">
                                        <div class="card-body" style="text-align: center;">
                                            <h1 style="color: white;"><strong>RE-ENROLLMENT</strong></h1>
                                            <p style="color: white;">FOR OLD STUDENTS</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Registered Student"
                                    onclick="window.location.href='<?= base_url(); ?>col-registeredstudent'">
                                    <div class="card" style="border: 1px solid #ccc; background-color: #263A56; padding: 30px;">
                                        <div class="card-body" style="text-align: center;">
                                            <h1 style="color: white;"><strong>EARLY | ONLINE REGISTRATION</strong></h1>
                                            <p style="color: white;">FOR NEW STUDENTS</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End of Page Content -->

    <!-- ----------- FOOTER ------------------ -->
    <?= $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?= $this->endSection(); ?>