<?php $this->extend("layouts/base"); ?>

<?php $this->section("title"); ?>
    <?php echo $page_title; ?>
<?php $this->endSection(); ?>
<?php $this->section("page_heading"); ?>
    <?php echo $page_heading; ?>
<?php $this->endSection(); ?>
<?php $this->section("page_p"); ?>
    <?php echo $page_p; ?>
<?php $this->endSection(); ?>

<?php echo $this->section('content'); ?>
    <!-- ----------- SIDEBAR ------------------ -->
    <?php echo $this->include("partials/sidebar"); ?>  
    <!-- ----------- END OF SIDEBAR ------------------ --> 

    <!-- Begin Page Content -->

    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                            <?php if(session()->getTempdata('success')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('success');?>
                                </div>
                            <?php endif; ?>
                        <?php echo form_open('col-classlist'); ?> 
                            <div class="row">
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SELECT PROGRAM</label>
                                    <select name="course" class="form-select">
                                        <option>-</option>
                                        <?php foreach($coursesdata as $coursesd): ?>
                                            <option value="<?= $coursesd['courid']; ?>"><?= $coursesd['code']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SCHOOL YEAR</label>
                                    <select name="sy" class="form-select">
                                        <option>-</option>
                                        <?php foreach($sydata as $syd): ?>
                                            <option value="<?= $syd['syname']; ?>"><?= $syd['syname']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SEMESTER</label>
                                    <select name="sem" class="form-select">
                                        <option>-</option>
                                        <option value="1st Semester">1st Semester</option>
                                        <option value="2nd Semester">2nd Semester</option>
                                        <option value="Summer">Summer</option>
                                    </select>
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
    </div>

    <!-- End of Page Content -->

    <!-- ----------- FOOTER ------------------ -->
    <?php echo $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?php echo $this->endSection(); ?>