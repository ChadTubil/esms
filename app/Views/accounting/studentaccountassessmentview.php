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
            <div class="col-lg-3 col-sm-12">
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
            <div class="col-lg-9 col-sm-12">
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
                            <!-- Student Account Assessment Summary Cards -->
                            <div class="row mt-4">
                                <?php foreach($studacctotalassessment as $satadata): ?>
                                    <div class="col-md-4">
                                        <div class="card" style="background-color: #f8f9fa;">
                                            <div class="card-body text-center">
                                                <h6>Total Assessment</h6>
                                                <h3 class="text-primary">₱<?= number_format($satadata['totalassessment'], 2) ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card" style="background-color: #f8f9fa;">
                                            <div class="card-body text-center">
                                                <h6>Total Payments</h6>
                                                <h3 class="text-success">₱<?= number_format($satadata['totalpayments'], 2) ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card" style="background-color: #f8f9fa;">
                                            <div class="card-body text-center">
                                                <h6>Total Balance</h6>
                                                <h3 class="text-danger">₱<?= number_format($satadata['totalbalance'], 2) ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php if(session()->getTempdata('message')) :?>
                                <div class="alert alert-info">
                                    <?= session()->getTempdata('message');?>
                                </div>
                            <?php endif; ?>
                            <label for="email" class="form-label">ADD FEE</label>
                            <?= form_open('student-accounts/view/details-add'); ?>
                            <div class="form-group" style="display: flex; gap: 10px; justify-content: center;">
                                <input type="hidden" name="studentno" value="<?= $studentd['studentno']; ?>">
                                <input type="hidden" name="accountno" value="<?= $studentaccountsd['said']; ?>">
                                <select id="feeStructureSelect" class="form-control" name="selectedfeeid" required style="width: 90%;" required>
                                    <option value="" disabled selected hidden>Select Fee to Add</option>
                                    <!-- Recommended Fees (based on filters) -->
                                    <?php if(!empty($filteredfeestructuredata)): ?>
                                    <optgroup label="📌 Recommended for this Student">
                                        <?php foreach($filteredfeestructuredata as $fee): ?>
                                        <option value="<?= $fee['feeid'] ?>" class="recommended-option">
                                            <?= $fee['feecode'] ?> - <?= $fee['feename'] ?> (₱<?= number_format($fee['amount'], 2) ?>)
                                            <?php if(!empty($fee['sy']) || !empty($fee['semester']) || !empty($fee['course'])): ?>
                                                <small>(<?= trim($fee['sy'] . ' ' . $fee['semester'] . ' ' . $fee['course']) ?>)</small>
                                            <?php endif; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                    <?php endif; ?>
                                    
                                    <!-- All Available Fees -->
                                    <optgroup label="📋 All Available Fees">
                                        <?php foreach($allfeestructuredata as $fee): ?>
                                        <option value="<?= $fee['feeid'] ?>">
                                            <?= $fee['feecode'] ?> - <?= $fee['feename'] ?> (₱<?= number_format($fee['amount'], 2) ?>)
                                            <?php if(!empty($fee['sy']) || !empty($fee['semester']) || !empty($fee['course'])): ?>
                                                <small>(<?= trim($fee['sy'] . ' ' . $fee['semester'] . ' ' . $fee['course']) ?>)</small>
                                            <?php endif; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                </select>
                                <button class="btn btn-m btn-icon btn-success" style="width: 10%;">ADD</button>
                            </div>
                            <?= form_close(); ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>CODE</th>
                                            <th>FEE</th>
                                            <th class="text-end">AMOUNT</th>
                                            <th class="text-end">DISCOUNT</th>
                                            <th class="text-end">NET AMOUNT</th>
                                            <th class="text-center">BILLED</th>
                                            <th class="text-center">ACTION</th>
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
                                                <td class="text-end">₱<?= number_format($studentaccountsassessmentd['amount'], 2); ?>
                                                    <a href="" class="btn btn-sm btn-icon btn-primary" title="Modify" data-bs-toggle="tooltip" data-bs-placement="top" 
                                                    <?php if($studentaccountsassessmentd['isbilled'] == 1) { echo 'hidden'; } else { echo '';} ?>>
                                                        <span class="btn-inner">
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>
                                                        </span>
                                                    </a></td>
                                                <td class="text-end">₱<?= number_format($studentaccountsassessmentd['discountamount'], 2); ?>
                                                    <a href="" class="btn btn-sm btn-icon btn-primary" title="Modify" data-bs-toggle="tooltip" data-bs-placement="top" 
                                                        <?php if($studentaccountsassessmentd['isbilled'] == 1) { echo 'hidden'; } else { echo '';} ?>>
                                                            <span class="btn-inner">
                                                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                </svg>
                                                            </span>
                                                        </a></td>
                                                <td class="text-end">₱<?= number_format($studentaccountsassessmentd['netamount'], 2); ?></td>
                                                <td class="text-center"><?php
                                                    if($studentaccountsassessmentd['isbilled'] == 1) {
                                                        echo '<span class="badge bg-success">BILLED</span>';
                                                    } else {
                                                        echo '<span class="badge bg-danger">NOT BILLED</span>';
                                                    }
                                                ?></td>
                                                <td class="text-center">
                                                    <a href="" class="btn btn-sm btn-icon btn-primary" title="Make Payment" data-bs-toggle="tooltip" data-bs-placement="top" 
                                                        <?php if($studentaccountsassessmentd['isbilled'] == 1) { echo 'hidden'; } else { echo '';} ?>>
                                                        <span class="btn-inner"> 
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M21.6389 14.3957H17.5906C16.1042 14.3948 14.8993 13.1909 14.8984 11.7045C14.8984 10.218 16.1042 9.01409 17.5906 9.01318H21.6389" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M18.049 11.6429H17.7373" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.74766 3H16.3911C19.2892 3 21.6388 5.34951 21.6388 8.24766V15.4247C21.6388 18.3229 19.2892 20.6724 16.3911 20.6724H7.74766C4.84951 20.6724 2.5 18.3229 2.5 15.4247V8.24766C2.5 5.34951 4.84951 3 7.74766 3Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M7.03516 7.5382H12.4341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>                            
                                                        </span>
                                                    </a>
                                                    <a href="" class="btn btn-sm btn-icon btn-info" title="Print Receipt" data-bs-toggle="tooltip" data-bs-placement="top" 
                                                        <?php if($studentaccountsassessmentd['isbilled'] == 1) { echo ''; } else { echo 'hidden';} ?>>
                                                        <span class="btn-inner">
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7379 2.76175H8.08493C6.00493 2.75375 4.29993 4.41175 4.25093 6.49075V17.2037C4.20493 19.3167 5.87993 21.0677 7.99293 21.1147C8.02393 21.1147 8.05393 21.1157 8.08493 21.1147H16.0739C18.1679 21.0297 19.8179 19.2997 19.8029 17.2037V8.03775L14.7379 2.76175Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M14.4751 2.75V5.659C14.4751 7.079 15.6231 8.23 17.0431 8.234H19.7981" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M14.2882 15.3584H8.88818" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M12.2432 11.606H8.88721" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>    
                                    </tbody>
                                    <tfoot>
                                            <tr>
                                                <th colspan="2" class="text-end"><strong>TOTALS:</strong></th>
                                                <th class="text-end" style="color: #007bff;">₱<?= number_format($totalAmount, 2); ?></th>
                                                <th class="text-end" style="color: #28a745;">₱<?= number_format($totalDiscount, 2); ?></th>
                                                <th class="text-end" style="color: #dc3545;">₱<?= number_format($totalNet, 2); ?></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                </table>
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

    <script>
    // Update hidden input when select changes
    document.getElementById('feestructureSelect').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var amount = selectedOption.getAttribute('data-amount');
        var discount = selectedOption.getAttribute('data-discount');
        document.getElementById('data-amount').value = amount;
        document.getElementById('data-discount').value = discount;
    });
    </script>

<?= $this->endSection(); ?>