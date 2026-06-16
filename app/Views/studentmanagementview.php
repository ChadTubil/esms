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
            <div class="col-lg-4 col-sm-12">
                <div class="card">
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
                        <?= form_open('studentmanagement'); ?>
                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <label class="form-label" for="validationDefault01">STUDENT NO.</label>
                                    <input type="text" name="account" class="form-control">
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <label class="form-label" for="validationDefault01">USERNAME</label>
                                    <input type="text" name="username" class="form-control">
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <label class="form-label" for="validationDefault01">PASSWORD</label>
                                    <input type="text" name="password" class="form-control">
                                </div>
                            </div>
                            <br>
                            <button class="btn btn-success" type="submit" name="add" style="width: 100%;">SAVE</button>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">SEARCH STUDENT USERACCOUNT</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php echo form_open('students'); ?> 
                            <div class="row">
                                <div class="col-lg-9 col-sm-12">
                                    <!-- <label class="form-label" for="validationDefault01">SEARCH STUDENT</label> -->
                                    <input type="text" name="searchstud" class="form-control"
                                    placeholder="Search Student Number | Student Name">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <button class="btn btn-success" type="submit" name="add" style="width: 100%; height: 100%;">SEARCH STUDENT</button>
                                </div>
                            </div>
                        <?php echo form_close(); ?>
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