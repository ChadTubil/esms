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
                            <h5 class="card-title">PAYROLL CUT OFF DATE SET UP</h5>
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
                        <?= form_open_multipart('hrd-payslip'); ?>
                            <div class="row">
                                <div class="col-lg-2 col-sm-12">
                                    <label class="form-label" for="validationDefault01">CUT OFF DATE</label>
                                    <input type="date" name="cutoffdate" class="form-control">
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label" for="validationDefault01">DESCRIPTION</label>
                                    <input type="text" name="description" class="form-control">
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">PAYROLL CSV FILE</label>
                                    <input type="file" name="filecsv" accept=".csv" class="form-control" required>
                                </div>
                            </div>
                            <br>
                            <button class="btn btn-success" type="submit" name="add" style="width: 100%;">CREATE PAYSLIP</button>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h5 class="card-title">PAYROLL LIST</h5>
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
                                        <th>DATE</th>
                                        <th>DESCRIPTION</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($payslipdata as $payslipd):?>
                                        <tr>
                                            <td><?= $payslipd['cutoffdate']; ?></td>
                                            <td><?= $payslipd['description']; ?></td>
                                            <td>
                                                <div class="flex align-items-center list-user-action">
                                                    <button class="btn btn-sm btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="View Payroll"
                                                        onclick="window.location.href='<?= base_url(); ?>hrd-payslip-view/<?= $payslipd['cutoffdate']; ?>'">
                                                        <span class="btn-inner">
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.1614 12.0531C15.1614 13.7991 13.7454 15.2141 11.9994 15.2141C10.2534 15.2141 8.83838 13.7991 8.83838 12.0531C8.83838 10.3061 10.2534 8.89111 11.9994 8.89111C13.7454 8.89111 15.1614 10.3061 15.1614 12.0531Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.998 19.355C15.806 19.355 19.289 16.617 21.25 12.053C19.289 7.48898 15.806 4.75098 11.998 4.75098H12.002C8.194 4.75098 4.711 7.48898 2.75 12.053C4.711 16.617 8.194 19.355 12.002 19.355H11.998Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>                                                                                                                          
                                                        </span>
                                                    </button>
                                                </div>
                                            </td>
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