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
                        <div class="header-title" >
                            <h4 class="card-title">ADVISING PROCESS</h4>
                        </div>
                    </div>
                    
                        <div class="card-body">
                            <div class="row">
                                <?php foreach($enrollmenthistoryshsdata as $stud): ?>
                                <div class="col-lg-12 col-sm-12">
                                    <h5>NAME: <strong><?= $stud['studfullname']; ?></strong></h5>
                                    <br>
                                    <div class="row">
                                        
                                        <div class="col-lg-3 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label">STUDENT NO.</label>
                                                <input type="text" name="studnum" class="form-control" value="<?= $stud['studentno']; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label">SCHOOL YEAR</label>
                                                <input type="text" name="sy" class="form-control" value="<?= $stud['sy']; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label">LEVEL</label>
                                                <input type="text" name="level" class="form-control" value="<?= $stud['level']; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label">CLUSTER</label>
                                                <input type="text" name="cluster" class="form-control" value="<?= $stud['code']; ?>" readonly>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-3 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label">CURRICULUM</label>
                                                <select name="curriculum" class="form-select" required>
                                                    <?php foreach($shscurriculumdata as $shscurriculumd): ?>
                                                        <option value="<?= $shscurriculumd['currid']; ?>"><?= $shscurriculumd['code']; ?> - <?= $shscurriculumd['sy']; ?> <?= $shscurriculumd['level']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label">SECTION</label>
                                                <select name="section" class="form-select" required>
                                                    <?php foreach($shssectiondata as $shssectiond): ?>
                                                        <option value="<?= $shssectiond['secid']; ?>"><?= $shssectiond['section']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
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