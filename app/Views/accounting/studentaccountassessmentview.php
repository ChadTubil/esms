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
                        <?php echo form_open('student-accounts'); ?> 
                            <div class="row">
                                <div class="col-lg-9 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SEARCH STUDENT</label>
                                    <input type="text" name="searchstud" class="form-control"
                                    placeholder="Search Student Number | Student Name">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <button class="btn btn-success" type="submit" name="add" style="width: 100%; height: 100%;">SEACH STUDENT</button>
                                </div>
                            </div>
                        <?php echo form_close(); ?>    
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <?php foreach($studentdata as $studentd): ?>
                            <div class="row">
                                <div class="col-md-8">
                                    <h2 style="text-transform: uppercase;"><?= $studentd['studfullname']; ?></h2>
                                    <h4><strong>Student No: <?= $studentd['studentno']; ?></strong></h4>
                                </div>
                                <div class="col-md-4 text-end">
                                    <a href="<?= base_url(); ?>student-accounts/view/<?= $studentd['studentno']; ?>" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i> Back to Accounts
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">ACCOUNTS</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td style="text-align: center;">NO</td>
                                        <td style="text-align: center;">SY</td>
                                        <td style="text-align: center;">SEM</td>
                                    </tr>
                                    <?php foreach($studentaccountsdata as $studentaccountsd): ?>
                                        <tr>
                                            <td style="text-align: center;"> <a class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Account Details"
                                                    onclick="window.location.href='<?= base_url(); ?>student-accounts/view/details/<?= $studentaccountsd['studentno']; ?>/<?= $studentaccountsd['said']; ?>'">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M21.25 16.334V7.665C21.25 4.645 19.111 2.75 16.084 2.75H7.916C4.889 2.75 2.75 4.635 2.75 7.665L2.75 16.334C2.75 19.364 4.889 21.25 7.916 21.25H16.084C19.111 21.25 21.25 19.364 21.25 16.334Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M16.0861 12H7.91406" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M12.3223 8.25205L16.0863 12L12.3223 15.748" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                    </span><?= $studentaccountsd['accountno']; ?>
                                                </a></td>
                                            <td style="text-align: center;"><?= $studentaccountsd['sy']; ?></td>
                                            <td style="text-align: center;"><?= $studentaccountsd['sem']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">ACCOUNTS DETAILS</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if(empty($studentaccountsassessmentdata)): ?>
                            <div class="alert alert-info">
                                No assessment found for this account.
                            </div>
                        <?php else: ?>
                            <div class="form-group">
                                <label for="email" class="form-label">CODE</label>
                                <select name="" id="">
                                    <?php foreach($feestructuredata as $feestructured): ?>
                                        <option value="<?= $feestructured['feecode']; ?>"><?= $feestructured['feecode']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>CODE</th>
                                            <th>FEE</th>
                                            <th class="text-end">AMOUNT</th>
                                            <th class="text-end">DISCOUNT</th>
                                            <th class="text-end">NET AMOUNT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $totalAmount = 0;
                                            $totalDiscount = 0;
                                            $totalNet = 0;
                                            foreach($studentaccountsassessmentdata as $studentaccountsassessmentd): 
                                                $totalAmount += $studentaccountsassessmentd['amount'];
                                                $totalDiscount += $studentaccountsassessmentd['discountamount'];
                                                $totalNet += $studentaccountsassessmentd['netamount'];
                                            ?>
                                            <tr>
                                                <td ><?= $studentaccountsassessmentd['feecode'] ?? 'N/A'; ?></td>
                                                <td><?= $studentaccountsassessmentd['feename'] ?? 'Unknown Fee'; ?></td>
                                                <td class="text-end">₱<?= number_format($studentaccountsassessmentd['amount'], 2); ?></td>
                                                <td class="text-end">₱<?= number_format($studentaccountsassessmentd['discountamount'], 2); ?></td>
                                                <td class="text-end">₱<?= number_format($studentaccountsassessmentd['netamount'], 2); ?></td>
                                            </tr>
                                        <?php endforeach; ?>    
                                    </tbody>
                                    <tfoot>
                                            <tr>
                                                <th colspan="2" class="text-end"><strong>TOTALS:</strong></th>
                                                <th class="text-end" style="color: #007bff;">₱<?= number_format($totalAmount, 2); ?></th>
                                                <th class="text-end" style="color: #28a745;">₱<?= number_format($totalDiscount, 2); ?></th>
                                                <th class="text-end" style="color: #dc3545;">₱<?= number_format($totalNet, 2); ?></th>
                                            </tr>
                                        </tfoot>
                                </table>
                            </div>
                            <!-- Assessment Summary Cards -->
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="card" style="background-color: #f8f9fa;">
                                        <div class="card-body text-center">
                                            <h6>Total Assessment</h6>
                                            <h3 class="text-primary">₱<?= number_format($totalAmount, 2); ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card" style="background-color: #f8f9fa;">
                                        <div class="card-body text-center">
                                            <h6>Total Discount</h6>
                                            <h3 class="text-success">₱<?= number_format($totalDiscount, 2); ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card" style="background-color: #f8f9fa;">
                                        <div class="card-body text-center">
                                            <h6>Net Amount Due</h6>
                                            <h3 class="text-danger">₱<?= number_format($totalNet, 2); ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
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