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
                        <div class="header-title">
                            <h4 class="card-title">ALL REGISTERED STUDENTS</h4>
                            <p>Select the old student from the registered list.</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <?php if(session()->getTempdata('error')) :?>
                                <div class="alert alert-danger">
                                    <?= session()->getTempdata('error');?>
                                </div>
                            <?php endif; ?>
                            <?php if(session()->getTempdata('success')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('success');?>
                                </div>
                            <?php endif; ?>
                            <p>Please enter the student number to continue the admission process.</p>
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>NAME</th>
                                        <th>STUDENT NO</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($registeredstudents as $rsd):?>
                                        <tr>
                                            <?= form_open('shs-oldstudent-process'); ?>
                                                <td>
                                                    <?= $rsd['studfullname']; ?>
                                                    <input type="hidden" name="fullname" class="form-control" value="<?= $rsd['studfullname']; ?>">
                                                </td>
                                                <td><input type="text" name="studnumber" class="form-control" placeholder="STUDENT NO" required></td>
                                                <td><button class="btn btn-primary" type="submit" name="add">PROCESS</button></td>
                                            <?= form_close(); ?>
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