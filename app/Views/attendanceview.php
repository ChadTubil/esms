<?php $this->extend("layouts/base"); ?>

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
                            <h5 class="card-title">SELECT CUTOFF DATE TO GENERATE ATTENDANCE</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if(session()->getTempdata('addsuccess')) :?>
                            <div class="alert alert-success">
                                <?= session()->getTempdata('addsuccess');?>
                            </div>
                        <?php endif; ?>
                        <?php if(isset($validation)): ?>
                            <div class="alert alert-danger">
                                <?php echo $validation->listErrors(); ?>
                            </div>
                        <?php endif; ?>
                        <?= form_open('hrd-attendance'); ?>
                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">STARTING DATE</label>
                                    <input type="date" name="startdate" class="form-control">
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">ENDING DATE</label>
                                    <input type="date" name="enddate" class="form-control">
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <button class="btn btn-success" type="submit" style="width: 100%; height: 100%;">GENERATE</button>
                                </div>
                            </div>
                            <br>
                            
                        <?= form_close(); ?>
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