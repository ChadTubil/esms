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
            <div class="col-lg-6 col-sm-12">
                <div class="card">
                    <div class="card-header" style="text-align: center;">
                        <div class="header-title">
                            <h4 class="card-title">REGISTRATION</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if(session()->getTempdata('success')) :?>
                            <div class="alert alert-success">
                                <?= session()->getTempdata('success');?>
                            </div>
                        <?php endif; ?>
                        <?php if(session()->getTempdata('error')) :?>
                            <div class="alert alert-danger">
                                <?= session()->getTempdata('error');?>
                            </div>
                        <?php endif; ?>
                        <?php if(isset($validation)): ?>
                            <div class="alert alert-danger">
                                <?php echo $validation->listErrors(); ?>
                            </div>
                        <?php endif; ?>
                        <?= form_open('college-enrollment'); ?>
                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SCHOOL YEAR</label>
                                    <select name="schoolyear" class="form-select" required>
                                        <option></option>
                                        <?php foreach ($schoolyear as $sy): ?>
                                            <option value="<?php echo $sy['syname']; ?>"><?php echo $sy['syname']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SEMESTER</label>
                                    <select name="semester" class="form-select" required>
                                        <option></option>
                                        <?php foreach ($semester as $sem): ?>
                                            <option value="<?php echo $sem['semester']; ?>"><?php echo $sem['semester']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">LEVEL</label>
                                    <select name="level" class="form-select" required>
                                        <option></option>
                                        <?php foreach ($level as $lev): ?>
                                            <option value="<?php echo $lev['level']; ?>"><?php echo $lev['level']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <button class="btn btn-success" type="submit" style="width: 100%;">RE-ENROLL</button>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="card">
                    <div class="card-header" style="text-align: center;">
                        <div class="header-title">
                            <h4 class="card-title">ENROLLMENT HISTORY</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>SCHOOL YEAR</th>
                                        <th>SEMESTER</th>
                                        <th>LEVEL</th>
                                        <th>STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($etddata as $etdd):?>
                                        <tr>
                                            <td><?= $etdd['sy']; ?></td>
                                            <td><?= $etdd['sem']; ?></td>
                                            <td><?= $etdd['level']; ?></td>
                                            <td><?= $etdd['status']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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