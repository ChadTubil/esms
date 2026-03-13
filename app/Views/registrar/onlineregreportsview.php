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
    <div class="container-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-lg-12">
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
                        
                        <!-- Date Range Filter -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <form action="<?= base_url('registrar-onlineregistration-reports') ?>" method="GET" class="row g-3 align-items-end">
                                    <div class="col-md-4">
                                        <label for="from_date" class="form-label">From Date</label>
                                        <input type="date" class="form-control" id="from_date" name="from_date" value="<?= isset($from_date) ? $from_date : '' ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="to_date" class="form-label">To Date</label>
                                        <input type="date" class="form-control" id="to_date" name="to_date" value="<?= isset($to_date) ? $to_date : '' ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-filter"></i> Filter
                                        </button>
                                        <a href="<?= base_url('registrar-onlineregistration-reports') ?>" class="btn btn-secondary">
                                            <i class="fas fa-sync-alt"></i> Reset
                                        </a>
                                        <?php if(!empty($from_date) && !empty($to_date)): ?>
                                            <a href="<?= base_url('registrar-onlineregistration-reports/export?from_date='.$from_date.'&to_date='.$to_date) ?>" class="btn btn-success" target="_blank">
                                                <i class="fas fa-file-pdf"></i> Export PDF
                                            </a>
                                        <?php else: ?>
                                            <a href="<?= base_url('registrar-onlineregistration-reports/export') ?>" class="btn btn-success" target="_blank">
                                                <i class="fas fa-file-pdf"></i> Export PDF
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Summary Cards -->
                        <div class="row mb-4">
                            <div class="col-xl-4 col-md-6 mb-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="text-white">IBED</h6>
                                                <h3 class="text-white"><?= isset($total_gs) ? $total_gs : '0' ?></h3>
                                                <p class="mb-0 text-white">Total Number of GS Students</p>
                                            </div>
                                            <i class="fas fa-child fa-3x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 mb-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="text-white">SHS</h6>
                                                <h3 class="text-white"><?= isset($total_shs) ? $total_shs : '0' ?></h3>
                                                <p class="mb-0 text-white">Total Number of SHS Students</p>
                                            </div>
                                            <i class="fas fa-user-graduate fa-3x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 mb-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="text-white">COLLEGE</h6>
                                                <h3 class="text-white"><?= isset($total_college) ? $total_college : '0' ?></h3>
                                                <p class="mb-0 text-white">Total Number of College Students</p>
                                            </div>
                                            <i class="fas fa-university fa-3x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Recent Registered Students -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>Student Name</th>
                                                        <th>Department</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(!empty($paymenttransactiondata)): ?>
                                                        <?php foreach($paymenttransactiondata as $paymenttransactiond): ?>
                                                            <tr>
                                                                <td><?= $paymenttransactiond['studfullname']; ?></td>
                                                                <td><?php if($paymenttransactiond['studstatus'] == 'GS'){echo 'IBED';}elseif($paymenttransactiond['studstatus'] == 'SHS'){echo 'SHS';}else{echo 'COLLEGE';} ?></td>
                                                                <td>
                                                                    <a class="btn btn-sm btn-icon btn-info" title="Edit Transaction"
                                                                        href="#" data-bs-toggle="modal" data-bs-target="#editModal<?= $paymenttransactiond['paymentid']; ?>">
                                                                        <span class="btn-inner">
                                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                            <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        </svg>
                                                                        </span>
                                                                    </a>
                                                                    <div class="modal fade" id="editModal<?= $paymenttransactiond['paymentid']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content dark">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="staticBackdropLabel">UPDATE INFORMATION</h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <?= form_open('registrar-onlineregistration-update/'.$paymenttransactiond['paymentid']); ?>
                                                                                <div class="modal-body">
                                                                                    <div class="row">
                                                                                        <div class="col-12 form-group">
                                                                                            <label for="email" class="form-label">STUDENT NAME:</label>
                                                                                            <input type="text" name="schoolyear" class="form-control" value="<?php echo $paymenttransactiond['studfullname']; ?>" disabled>
                                                                                            <input type="hidden" name="fullname" class="form-control" value="<?php echo $paymenttransactiond['studfullname']; ?>">
                                                                                        </div>
                                                                                        <div class="col-6 form-group">
                                                                                            <label for="email" class="form-label">LAST NAME:</label>
                                                                                            <input type="text" name="ln" class="form-control" value="<?php echo $paymenttransactiond['studln']; ?>">
                                                                                        </div>
                                                                                        <div class="col-6 form-group">
                                                                                            <label for="email" class="form-label">FIRST NAME:</label>
                                                                                            <input type="text" name="fn" class="form-control" value="<?php echo $paymenttransactiond['studfn']; ?>">
                                                                                        </div>
                                                                                        <div class="col-6 form-group">
                                                                                            <label for="email" class="form-label">MIDDLE NAME:</label>
                                                                                            <input type="text" name="mn" class="form-control" value="<?php echo $paymenttransactiond['studmn']; ?>">
                                                                                        </div>
                                                                                        <div class="col-6 form-group">
                                                                                            <label for="email" class="form-label">EXTENSION:</label>
                                                                                            <input type="text" name="extension" class="form-control" value="<?php echo $paymenttransactiond['studextension']; ?>">
                                                                                        </div>
                                                                                    </div>
                                                                                    <br>
                                                                                    <div class="text-start">
                                                                                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                                                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                                                    </div>
                                                                                </div>
                                                                                <?= form_close(); ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="4" class="text-center">No registered students found for the selected date range</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
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