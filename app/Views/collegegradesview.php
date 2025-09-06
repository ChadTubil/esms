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
                    <div class="card-body">
                        <?= form_open('grades-college') ?>
                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SCHOOL YEAR</label>
                                    <select name="schoolyear" class="form-select" id="exampleFormControlSelect1" required>
                                        <option value="" selected disabled>Select School Year</option>
                                        <?php foreach ($schoolyeardata as $syd): ?>
                                            <option value="<?php echo $syd['syname']; ?>"><?php echo $syd['syname']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SEMESTER</label>
                                    <select name="semester" class="form-select" id="exampleFormControlSelect1" required>
                                        <option value="" selected disabled>Select Semester</option>
                                        <?php foreach ($semesterdata as $semd): ?>
                                            <option value="<?php echo $semd['semester']; ?>"><?php echo $semd['semester']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <button class="btn btn-success" type="submit" name="add" style="width: 100%; height: 100%;">VIEW GRADES</button>
                                </div>
                            </div>
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