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
                            <h4 class="card-title">ADMISSION PROCESS</h4>
                        </div>
                    </div>
                    <?php foreach($students as $stud): ?>
                        <div class="card-body">
                            <?= form_open('admission/process/'.$stud['studid']); ?>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <h5>NAME: <strong><?= $stud['studfullname']; ?></strong></h5>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">STUDENT NO.</label>
                                                    <?php if($stud['studentno'] == ''): ?>
                                                        <a class="btn btn-info" style="width: 100%"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Generate Student Number"
                                                            onclick="window.location.href='<?= base_url(); ?>admission-generate/<?= $stud['studid']; ?>'">
                                                            GENERATE
                                                        </a>
                                                    <?php else: ?>
                                                        <input type="text" name="studnum" class="form-control" value="<?= $stud['studentno']; ?>" readonly>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">SCHOOL YEAR</label>
                                                    <select name="schoolyear" class="form-select" required>
                                                        <option></option>
                                                        <?php foreach ($schoolyear as $sy): ?>
                                                            <option value="<?php echo $sy['syname']; ?>"><?php echo $sy['syname']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">SEMESTER</label>
                                                    <select name="semester" class="form-select" required>
                                                        <option></option>
                                                        <?php foreach ($semester as $sem): ?>
                                                            <option value="<?php echo $sem['semester']; ?>"><?php echo $sem['semester']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">LEVEL</label>
                                                    <select name="level" class="form-select" required>
                                                        <option></option>
                                                        <?php foreach ($level as $lev): ?>
                                                            <option value="<?php echo $lev['level']; ?>"><?php echo $lev['level']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">STATUS</label>
                                                    <select name="status" class="form-select" required>
                                                        <option></option>
                                                        <option value="NEW">NEW</option>
                                                        <option value="OLD">OLD</option>
                                                        <option value="KICKED">KICKED-OUT</option>
                                                        <option value="TRANSFERRED">TRANSFERRED</option>
                                                        <option value="TRANSFEREE">TRANSFEREE</option>
                                                        <option value="INACTIVE">INACTIVE</option>
                                                        <option value="RETURNEE">RETURNEE</option>
                                                        <option value="WITH-CASES">WITH-CASES</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="irreg">
                                                    <span>IRREGULAR</span><span style="color: red;"> (Check if the student is not regular.)</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">COURSE</label>
                                                    <select name="course" class="form-select" style="text-transform: uppercase" required>
                                                        <option></option>
                                                        <?php foreach ($course as $cour): ?>
                                                            <option value="<?php echo $cour['courid']; ?>"><?php echo $cour['course']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">MAJOR</label>
                                                    <input type="text" name="major" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12" style="border-left: 1px solid;">
                                        <h5><strong>FAMILY BACKGROUND</strong></h5>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">FATHER'S NAME</label>
                                                    <input type="text" name="fname" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">FATHER'S CONTACT NUMBER</label>
                                                    <input type="text" name="fcontact" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">FATHER'S EMAIL ADDRESS</label>
                                                    <input type="text" name="femail" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">FATHER'S WORK</label>
                                                    <input type="text" name="fwork" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">FATHER'S OFFICE CONTACT NUMBER</label>
                                                    <input type="text" name="foffice" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">MOTHERS'S NAME</label>
                                                    <input type="text" name="mname" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">MOTHERS'S CONTACT NUMBER</label>
                                                    <input type="text" name="mcontact" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">MOTHERS'S EMAIL ADDRESS</label>
                                                    <input type="text" name="memail" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">MOTHERS'S WORK</label>
                                                    <input type="text" name="mwork" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">MOTHERS'S OFFICE CONTACT NUMBER</label>
                                                    <input type="text" name="moffice" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <br>
                                                <button type="submit" name="update" class="btn btn-primary" style="width: 100%">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?= form_close(); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Page Content -->

    <!-- ----------- FOOTER ------------------ -->
    <?= $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?= $this->endSection(); ?>