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
                            <?php if(session()->getTempdata('deletesuccess')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('deletesuccess');?>
                                </div>
                            <?php endif; ?>
                            <?php if(session()->getTempdata('activatesuccess')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('activatesuccess');?>
                                </div>
                            <?php endif; ?>
                            <?php if(session()->getTempdata('updatesuccess')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('updatesuccess');?>
                                </div>
                            <?php endif; ?>
                        <?php echo form_open('accounting-reports/entries'); ?> 
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label" for="validationDefault01">CHART OF ACCOUNTS</label>
                                    <select name="coa" class="form-select" required>
                                        <option value="" disabled>Select Chart of Account</option>
                                        <?php foreach($coadata as $coad): ?>
                                            <option value="<?= $coad['accountid']; ?>"><?= $coad['accountcode']; ?> - <?= $coad['accountname']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label class="form-label" for="validationDefault01">DATE FROM</label>
                                    <input type="date" class="form-control" name="start_date" required>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label class="form-label" for="validationDefault01">DATE TO</label>
                                    <input type="date" class="form-control" name="end_date" required>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <button class="btn btn-success" type="submit" name="add" style="width: 100%; height: 100%;">SEACH STUDENT</button>
                                </div>
                            </div>
                        <?php echo form_close(); ?>    
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>FEE</th>
                                        <th>AMOUNT</th>
                                        <th>OR NUMBER</th>
                                        <th>RECEIVED BY</th>
                                    </tr>
                                </thead>
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