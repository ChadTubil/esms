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
                    <?php foreach($studentsshsdata as $stud): ?>
                        <div class="card-body">
                            <?= form_open('shs-admission/process/'.$stud['studid']); ?>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <h5>NAME: <strong><?= $stud['studfullname']; ?></strong></h5>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">STUDENT NO.</label>
                                                    <?php if($stud['studentno'] == ''): ?>
                                                        <a class="btn btn-info" style="width: 100%"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Generate Student Number"
                                                            onclick="window.location.href='<?= base_url(); ?>shs-admission/process-generate/<?= $stud['studid']; ?>'">
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
                                                    <label class="form-label">LEVEL</label>
                                                    <select name="level" class="form-select" required>
                                                        <option></option>
                                                        <option value="Grade 11">Grade 11</option>
                                                        <option value="Grade 12">Grade 12</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">CLUSTER</label>
                                                    <select name="cluster" class="form-select" required>
                                                        <option></option>
                                                        <?php foreach ($clusterdata as $clusterd): ?>
                                                            <option value="<?php echo $clusterd['cluid']; ?>"><?php echo $clusterd['code']; ?> - <?php echo $clusterd['name']; ?></option>
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
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <h3 style="text-align: center;"><strong>OTHER INFORMATION</strong></h3>
                                <br>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <h5><strong>PERMANENT RECORD</strong></h5>
                                        <br>
                                        <div class="row">
                                            <!-- ELEMENTARY  -->
                                            <div class="col-lg-8 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">GRADE SCHOOL</label>
                                                    <input type="text" name="eschool" class="form-control form-control-x" style="text-transform: uppercase;" value="<?= $stud['eschool']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">YEAR GRADUATED</label>
                                                    <input type="text" name="eyeargraduate" class="form-control form-control-x" style="text-transform: uppercase;" value="<?= $stud['eyeargraduate']; ?>">
                                                </div>
                                            </div>
                                            <!-- JUNIOR HIGH SCHOOL  -->
                                            <div class="col-lg-8 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">JUNIOR HIGH SCHOOL</label>
                                                    <input type="text" name="jhschool" class="form-control form-control-x" style="text-transform: uppercase;" value="<?= $stud['jhschool']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">YEAR GRADUATED</label>
                                                    <input type="text" name="jhyeargraduate" class="form-control form-control-x" style="text-transform: uppercase;" value="<?= $stud['jhyeargraduate']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <h5><strong>FAMILY BACKGROUND</strong></h5>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">FATHER'S NAME</label>
                                                    <input type="text" name="fname" class="form-control form-control-x" style="text-transform: uppercase;" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">FATHER'S CONTACT NUMBER</label>
                                                    <input type="text" name="fcontact" class="form-control form-control-x" style="text-transform: uppercase;" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">FATHER'S EMAIL ADDRESS</label>
                                                    <input type="text" name="femail" class="form-control form-control-x" style="text-transform: uppercase;">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">FATHER'S WORK</label>
                                                    <input type="text" name="fwork" class="form-control form-control-x" style="text-transform: uppercase;">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">FATHER'S OFFICE CONTACT NUMBER</label>
                                                    <input type="text" name="foffice" class="form-control form-control-x" style="text-transform: uppercase;">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">MOTHERS'S NAME</label>
                                                    <input type="text" name="mname" class="form-control form-control-x" style="text-transform: uppercase;" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">MOTHERS'S CONTACT NUMBER</label>
                                                    <input type="text" name="mcontact" class="form-control form-control-x" style="text-transform: uppercase;" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">MOTHERS'S EMAIL ADDRESS</label>
                                                    <input type="text" name="memail" class="form-control form-control-x" style="text-transform: uppercase;">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">MOTHERS'S WORK</label>
                                                    <input type="text" name="mwork" class="form-control form-control-x" style="text-transform: uppercase;">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">MOTHERS'S OFFICE CONTACT NUMBER</label>
                                                    <input type="text" name="moffice" class="form-control form-control-x" style="text-transform: uppercase;">
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
    <script>
        document.querySelectorAll('.form-control-x').forEach(input => {
            input.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        });
    </script>

<?= $this->endSection(); ?>