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
            <div class="col-lg-4 col-sm-12">
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
                        <?= form_open('chartofaccounts'); ?>
                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <label class="form-label" for="validationDefault01">CODE</label>
                                    <input type="text" name="code" class="form-control">
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <label class="form-label" for="validationDefault01">NAME</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <label class="form-label" for="validationDefault01">DESCRIPTION</label>
                                    <textarea name="description" class="form-control"></textarea>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SCHOOL YEAR</label>
                                    <select name="sy" class="form-select">
                                        <?php foreach($sydata as $syd): ?>
                                            <option value="<?= $syd['syname']; ?>"><?= $syd['syname']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SEMESTER</label>
                                    <select name="sem" class="form-select">
                                        <?php foreach($semdata as $semd): ?>
                                            <option value="<?= $semd['semester']; ?>"><?= $semd['semester']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <label class="form-label" for="validationDefault01">COURSE</label>
                                    <select name="course" class="form-select">
                                        <?php foreach($coursedata as $coursed): ?>
                                            <option value="<?= $coursed['courcode']; ?>"><?= $coursed['course']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <label class="form-label" for="validationDefault01">CHART OF ACCOUNT</label>
                                    <select name="coa" class="form-select">
                                        <?php foreach($coadata as $coad):?>
                                            <option value="<?= $coad['accountid']; ?>"><?= $coad['accountcode']; ?> - <?= $coad['accountname']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label" for="validationDefault01">AMOUNT</label>
                                    <input type="text" name="amount" class="form-control">
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label" for="validationDefault01">IS MANDATORY</label>
                                    <select name="mandatory" class="form-select">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <button class="btn btn-success" type="submit" name="add" style="width: 100%;">SAVE</button>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <?php if(session()->getTempdata('deletesuccess')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('deletesuccess');?>
                                </div>
                            <?php endif; ?>
                            <?php if(session()->getTempdata('endedsuccess')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('endedsuccess');?>
                                </div>
                            <?php endif; ?>
                            <?php if(session()->getTempdata('updatesuccess')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('updatesuccess');?>
                                </div>
                            <?php endif; ?>
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>CODE</th>
                                        <th>FEE</th>
                                        <th>AMOUNT</th>
                                        <th>SY</th>
                                        <th>SEM</th>
                                        <th>STATUS</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($feestructuredata as $feestructured):?>
                                        <tr>
                                            <td><?= $feestructured['feecode']; ?></td>
                                            <td><?= $feestructured['feename']; ?></td>
                                            <td><?= $feestructured['amount']; ?></td>
                                            <td><?= $feestructured['sy']; ?></td>
                                            <td><?= $feestructured['semester']; ?></td>
                                            <td>
                                                <?php if($feestructured['isactive'] == 1): ?>
                                                    <?= "Not Active"; ?>
                                                <?php else: ?>
                                                    <?= "Active"; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td></td>
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