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
                    <div class="card-body">
                            <?php if(session()->getTempdata('deletesuccess')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('deletesuccess');?>
                                </div>
                            <?php endif; ?>
                            <?php if(session()->getTempdata('activatesuccess')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('activatesuccess');?>
                                </div>
                            <?php endif; ?>
                            <?php if(session()->getTempdata('updatesuccess')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('updatesuccess');?>
                                </div>
                            <?php endif; ?>
                        <?php echo form_open('old-student-accounts'); ?> 
                            <div class="row">
                                <div class="col-lg-9 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SEARCH STUDENT</label>
                                    <input type="text" name="searchstud" class="form-control"
                                    placeholder="Search Student Number | Student Name">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <button class="btn btn-success" type="submit" name="add" style="width: 100%; height: 100%;">SEACH STUDENT</button>
                                </div>
                            </div>
                        <?php echo form_close(); ?>    
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">ADD STUDENT</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if(session()->getTempdata('addsuccess')) :?>
                            <div class="alert alert-success">
                                <?= session()->getTempdata('addsuccess');?>
                            </div>
                        <?php endif; ?>
                        <?php echo form_open('old-student-accounts/add-student'); ?> 
                            <div class="row">
                                <div class="col-lg-2 col-sm-12">
                                    <label class="form-label" for="validationDefault01">STUDENT NUMBER</label>
                                    <input type="text" name="studentno" class="form-control">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label class="form-label" for="validationDefault01">LAST NAME</label>
                                    <input type="text" name="studln" class="form-control">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label class="form-label" for="validationDefault01">FIRST NAME</label>
                                    <input type="text" name="studfn" class="form-control">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label class="form-label" for="validationDefault01">MIDDLE NAME</label>
                                    <input type="text" name="studmn" class="form-control">
                                </div>
                                <div class="col-lg-1 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SUFFIX</label>
                                    <input type="text" name="studsuffix" class="form-control">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label class="form-label" for="validationDefault01">DEPARTMENT</label>
                                    <select class="form-select" name="department" required>
                                        <option value="IBED">IBED</option>
                                        <option value="SHS">SHS</option>
                                        <option value="COLLEGE">COLLEGE</option>
                                    </select>
                                </div>
                                <div class="col-lg-1 col-sm-12">
                                    <button class="btn btn-success" type="submit" name="add" style="width: 100%; height: 100%;">ADD</button>
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