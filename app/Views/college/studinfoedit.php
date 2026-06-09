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
                        <?php if(session()->getTempdata('success')) :?>
                            <div class="alert alert-success">
                                <?= session()->getTempdata('success');?>
                            </div>
                        <?php endif; ?>
                        <?php if(isset($validation)): ?>
                            <div class="alert alert-danger">
                                <?php echo $validation->listErrors(); ?>
                            </div>
                        <?php endif; ?>
                        <?php foreach($studentdata as $sdata): ?>
                            <?= form_open('col-student-infoupdate/'.$sdata['studid']); ?>
                                <div class="row">
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="validationDefault01">STUDENT NUMBER</label>
                                        <input type="text" name="studno" class="form-control" value="<?= $sdata['studentno']; ?>" disabled>
                                    </div>
                                    <div class="col-lg-5 col-sm-12">
                                        <label class="form-label" for="validationDefault01">STUDENT FULLNAME</label>
                                        <input type="text" name="studfulln" class="form-control" value="<?= $sdata['studfullname']; ?>" readonly>
                                        
                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <label class="form-label" for="validationDefault01">COURSE</label>
                                        <select name = "cluster" class="form-select" disabled>
                                            <option value="<?= $sdata['code'] ?>" selected> <?= $sdata['code'] ?>
                                                <?php foreach($clusters as $clu):?>
                                                    <option value="<?= $clu['courid'] ?>">
                                                        <?= $clu['code'] ?>
                                                    </option>
                                                <?php endforeach;?>
                                            </option>
                                        </select>
                                        <br>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="validationDefault01">YEAR LEVEL</label>
                                        <select name = "level" class="form-select" disabled>
                                            <option value="<?= $sdata['level'] ?>" selected> <?= $sdata['level'] ?></option>
                                        </select>
                                        <br>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="validationDefault01">SEMESTER</label>
                                        <select name = "sem" class="form-select" disabled>
                                            <option value="<?= $sdata['sem'] ?>" selected> <?= $sdata['sem'] ?></option>
                                        </select>
                                        <br>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="validationDefault01">STUDENT FIRST NAME</label><span style="color: red"> *</span>
                                        <input type="text" name="studfn" class="form-control" value="<?= $sdata['studfn']; ?>">
                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <label class="form-label" for="validationDefault01">STUDENT MIDDLE NAME</label><span style="color: red"> *</span>
                                        <input type="text" name="studmn" class="form-control" value="<?= $sdata['studmn']; ?>">
                                        <br>
                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <label class="form-label" for="validationDefault01">STUDENT LAST NAME</label><span style="color: red"> *</span>
                                        <input type="text" name="studln" class="form-control" value="<?= $sdata['studln']; ?>">
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label class="form-label" for="validationDefault01">EXTENSION</label><span style="color: red"> *</span>
                                        <select name = "extension" class="form-select">
                                            <option value="<?= $sdata['studextension'] ?>" selected> <?= $sdata['studextension'] ?>
                                                <option value="Jr.">Jr.</option>
                                                <option value="Sr.">Sr.</option>
                                                <option value="III.">III</option>
                                                <option value="IV.">IV</option>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="validationDefault01">EMAIL</label><span style="color: red"> *</span>
                                        <input type="text" name="email" class="form-control" value="<?= $sdata['studemail']; ?>">
                                        <br>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="validationDefault01">CONTACT NUMBER</label><span style="color: red"> *</span>
                                        <input type="number" name="contactno" class="form-control" value="<?= $sdata['studcontact']; ?>">
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="validationDefault01">GENDER</label><span style="color: red"> *</span>
                                        <select name = "gender" class="form-select">
                                            <option value="<?= $sdata['studgender'] ?>" selected> <?= $sdata['studgender'] ?>
                                                <option value="Female">Female</option>
                                                <option value="Male">Male</option>
                                                <option value="Other">Other</option>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="validationDefault01">RELIGION</label><span style="color: red"> *</span>
                                        <input type="text" name="religion" class="form-control" value="<?= $sdata['studreligion']; ?>">
                                        <br>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="validationDefault01">AGE</label><span style="color: red"> *</span>
                                        <input type="number" name="age" class="form-control" value="<?= $sdata['studage']; ?>">
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="validationDefault01">BIRTHDAY</label><span style="color: red"> *</span>
                                        <input type="date" name="bday" class="form-control" value="<?= $sdata['studbirthday']; ?>">
                                        <br>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="validationDefault01">BIRTH PLACE</label><span style="color: red"> *</span>
                                        <input type="text" name="birthplace" class="form-control" value="<?= $sdata['studbirthplace']; ?>">
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="validationDefault01">CITIZENSHIP</label><span style="color: red"> *</span>
                                        <input type="text" name="citizen" class="form-control" value="<?= $sdata['studcitizenship']; ?>">
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="validationDefault01">BARANGAY</label><span style="color: red"> *</span>
                                        <input type="text" name="barangay" class="form-control" value="<?= $sdata['studstbarangay']; ?>">
                                        <br>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label class="form-label" for="validationDefault01">CITY</label><span style="color: red"> *</span>
                                        <input type="text" name="city" class="form-control" value="<?= $sdata['studcity']; ?>">
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <label class="form-label" for="validationDefault01">PROVINCE</label><span style="color: red"> *</span>
                                        <input type="text" name="province" class="form-control" value="<?= $sdata['studprovince']; ?>">
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label" for="validationDefault01">ELEMENTARY SCHOOL</label><span style="color: red"> *</span>
                                        <input type="text" name="eshool" class="form-control" value="<?= $sdata['eschool']; ?>">
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label" for="validationDefault01">ELEMENTARY YEAR GRADUATED</label><span style="color: red"> *</span>
                                        <input type="text" name="eshoolyr" class="form-control" value="<?= $sdata['eyeargraduate']; ?>">
                                        <br>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label" for="validationDefault01">JUNIOR HIGH SCHOOL</label><span style="color: red"> *</span>
                                        <input type="text" name="jshool" class="form-control" value="<?= $sdata['jhschool']; ?>">
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label" for="validationDefault01">JUNIOR HIGH GRADUATED</label><span style="color: red"> *</span>
                                        <input type="text" name="jshoolyr" class="form-control" value="<?= $sdata['jhyeargraduate']; ?>">
                                        <br>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label" for="validationDefault01">SENIOR HIGH SCHOOL</label><span style="color: red"> *</span>
                                        <input type="text" name="sshool" class="form-control" value="<?= $sdata['shschool']; ?>">
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label" for="validationDefault01">SENIOR HIGH GRADUATED</label><span style="color: red"> *</span>
                                        <input type="text" name="sshoolyr" class="form-control" value="<?= $sdata['shyeargraduate']; ?>">
                                        <br>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label" for="validationDefault01">GUARDIAN</label><span style="color: red"> *</span>
                                        <input type="text" name="guardian" class="form-control" value="<?= $sdata['nameg']; ?>">
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <label class="form-label" for="validationDefault01">GUARDIAN CONTACT NO.</label><span style="color: red"> *</span>
                                        <input type="number" name="guardianno" class="form-control" value="<?= $sdata['contactg']; ?>">
                                        <br>
                                    </div>
                                </div>
                                <button class="btn btn-success" type="submit" name="add" style="width: 100%;">UPDATE</button>
                            <?= form_close(); ?>
                        <?php endforeach; ?>
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