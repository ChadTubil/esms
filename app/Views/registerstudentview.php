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
                        <?= form_open('registerstudent'); ?>
                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">LAST NAME</label><span style="color: red"> *</span>
                                    <input type="text" name="lname" class="form-control" value="<?php echo set_value('lname'); ?>">
                                </div>
                                <div class="col-lg-5 col-sm-12">
                                    <label class="form-label" for="validationDefault01">FIRST NAME</label><span style="color: red"> *</span>
                                    <input type="text" name="fname" class="form-control" value="<?php echo set_value('fname'); ?>">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">MIDDLE NAME</label>
                                    <input type="text" name="mname" class="form-control" value="<?php echo set_value('mname'); ?>">
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">EXTENSION NAME</label>
                                    <input type="text" name="extname" class="form-control" value="<?php echo set_value('extname'); ?>">
                                </div>
                                <div class="col-lg-8 col-sm-12">
                                    <label class="form-label" for="validationDefault01">FULL NAME</label>
                                    <input type="text" name="fullname" class="form-control" disabled>
                                </div>

                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">BIRTH DATE</label><span style="color: red"> *</span>
                                    <input type="date" name="birthdate" class="form-control" value="<?php echo set_value('birthdate'); ?>">
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">AGE</label>
                                    <input type="text" name="age" class="form-control" value="<?php echo set_value('age'); ?>">
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">GENDER</label>
                                    <select name="gender" class="form-select" id="exampleFormControlSelect1">
                                        <option value="<?php echo set_value('gender'); ?>" selected>
                                            <?php echo set_value('gender'); ?>
                                        </option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>

                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label" for="validationDefault01">STREET/BARANGAY</label>
                                    <input type="text" name="barangay" class="form-control" value="<?php echo set_value('barangay'); ?>">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">MUNICIPALITY/CITY</label><span style="color: red"> *</span>
                                    <input type="text" name="city" class="form-control" value="<?php echo set_value('city'); ?>">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">PROVINCE</label><span style="color: red"> *</span>
                                    <input type="text" name="province" class="form-control" value="<?php echo set_value('province'); ?>">
                                </div>

                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label" for="validationDefault01">BIRTH PLACE</label>
                                    <input type="text" name="birthplace" class="form-control" value="<?php echo set_value('birthplace'); ?>">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">CITIZENSHIP</label>
                                    <input type="text" name="citizenship" class="form-control" value="<?php echo set_value('citizenship'); ?>">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">RELIGION</label>
                                    <input type="text" name="religion" class="form-control" value="<?php echo set_value('religion'); ?>">
                                </div>

                                <div class="col-lg-5 col-sm-12">
                                    <label class="form-label" for="validationDefault01">CONTACT NO.</label><span style="color: red"> *</span>
                                    <input type="text" name="contact" class="form-control" value="<?php echo set_value('contact'); ?>">
                                </div>
                                <div class="col-lg-7 col-sm-12">
                                    <label class="form-label" for="validationDefault01">EMAIL</label>
                                    <input type="text" name="email" class="form-control" value="<?php echo set_value('email'); ?>">
                                </div>
                            </div>
                            <br>
                            <button class="btn btn-success" type="submit" name="add" style="width: 100%;">REGISTER</button>
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