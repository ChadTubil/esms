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
                                    </tr>
                                    <?php foreach($studentaccountdata as $studentaccountd): ?>
                                        <tr>
                                            <td style="text-align: center;"> <a class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Account Details"
                                                    onclick="window.location.href='<?= base_url(); ?>students/studentaccounts-details/<?= $studentaccountd['said']; ?>'">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M21.25 16.334V7.665C21.25 4.645 19.111 2.75 16.084 2.75H7.916C4.889 2.75 2.75 4.635 2.75 7.665L2.75 16.334C2.75 19.364 4.889 21.25 7.916 21.25H16.084C19.111 21.25 21.25 19.364 21.25 16.334Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M16.0861 12H7.91406" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M12.3223 8.25205L16.0863 12L12.3223 15.748" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                    </span><?= $studentaccountd['assessmentid']; ?>
                                                </a></td>
                                            <td style="text-align: left;"><?= $studentaccountd['sy']; ?> - <?= $studentaccountd['sem']; ?></td>
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
                            <h4 class="card-title">ACCOUNTS DETAILS - 
                                <?php foreach($accountdetailsdata as $accountdetailsd): ?>
                                    <?= $accountdetailsd['sy'];?> <?= $accountdetailsd['sem'];?> 
                                <?php endforeach; ?>
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mt-4">
                            <?php foreach($studacctotalassessment as $satadata): ?>
                                <div class="col-md-3">
                                    <div class="card" style="background-color: #f8f9fa;">
                                        <div class="card-body text-center">
                                            <h6>Total Assessment</h6>
                                            <h3 class="text-primary">₱<?= number_format($satadata['totalassessment'], 2) ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card" style="background-color: #f8f9fa;">
                                        <div class="card-body text-center">
                                            <h6>Total Discounts</h6>
                                            <h3 class="text-info">₱<?= number_format($satadata['totaldiscounts'], 2) ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card" style="background-color: #f8f9fa;">
                                        <div class="card-body text-center">
                                            <h6>Total Payments</h6>
                                            <h3 class="text-success">₱<?= number_format($satadata['totalpayments'], 2) ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card" style="background-color: #f8f9fa;">
                                        <div class="card-body text-center">
                                            <h6>Total Balance</h6>
                                            <h3 class="text-danger">₱<?= number_format($satadata['totalbalance'], 2) ?></h3>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>CODE</th>
                                            <!-- <th>FEE</th> -->
                                            <th class="text-end">AMOUNT</th>
                                            <th class="text-end">DISCOUNT</th>
                                            <th class="text-end">NET</th>
                                            <th class="text-end">PAID</th>
                                            <th class="text-end">BALANCE</th>
                                            <th class="text-center">BILLED</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $totalAmount = 0;
                                            $totalDiscount = 0;
                                            $totalNet = 0;
                                            $totalPaid = 0;
                                            $totalBalance = 0;
                                            foreach($studentaccountsassessmentdata as $studentaccountsassessmentd): 
                                                $totalAmount += $studentaccountsassessmentd['amount'];
                                                $totalDiscount += $studentaccountsassessmentd['discountamount'];
                                                $totalNet += $studentaccountsassessmentd['netamount'];
                                                $totalPaid += $studentaccountsassessmentd['paidamount'];
                                                $totalBalance += $studentaccountsassessmentd['balance'];
                                        ?>
                                            <tr>
                                                <td ><?= $studentaccountsassessmentd['feecode'] ?? 'N/A'; ?></td>
                                                <td class="text-end">₱<?= number_format($studentaccountsassessmentd['amount'], 2) ?></td>
                                                <td class="text-end">₱<?= number_format($studentaccountsassessmentd['discountamount'], 2); ?></td>
                                                <td class="text-end">₱<?= number_format($studentaccountsassessmentd['netamount'], 2); ?></td>
                                                <td class="text-end">₱<?= number_format($studentaccountsassessmentd['paidamount'], 2); ?></td>
                                                <td class="text-end">₱<?= number_format($studentaccountsassessmentd['balance'], 2); ?></td>
                                                <td class="text-center"><?php
                                                    if($studentaccountsassessmentd['balance'] == '0.00') {
                                                        echo '<span class="badge bg-success">BILLED</span>';
                                                    } else {
                                                        echo '<span class="badge bg-danger">NOT BILLED</span>';
                                                    }
                                                ?></td>
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
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="header-title">
                            <h4 class="card-title">SUMMARY OF ALL ACCOUNTS</h4>
                        </div>
                    </div>
                    <div class="card-body"> 
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>SY</th>
                                        <th class="text-end">TOTAL ASSESSMENT</th>
                                        <th class="text-end">TOTAL PAYMENTS</th>
                                        <th class="text-end">TOTAL BALANCE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $totalAmount = 0;
                                        $totalPaid = 0;
                                        $totalBalance = 0;
                                        foreach($studentaccountdata as $studaccalld): 
                                            $totalAmount += $studaccalld['totalassessment'];
                                            $totalPaid += $studaccalld['totalpayments'];
                                            $totalBalance += $studaccalld['totalbalance'];
                                        ?>
                                        <tr>
                                            <td><?= $studaccalld['sy']; ?> - <?= $studaccalld['sem']; ?></td>
                                            <td class="text-end">₱<?= number_format($studaccalld['totalassessment'], 2) ?></td>
                                            <td class="text-end">₱<?= number_format($studaccalld['totalpayments'], 2) ?></td>
                                            <td class="text-end">₱<?= number_format($studaccalld['totalbalance'], 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>TOTAL</th>
                                        <th class="text-end">₱<?= number_format($totalAmount, 2) ?></th>
                                        <th class="text-end">₱<?= number_format($totalPaid, 2) ?></th>
                                        <th class="text-end">₱<?= number_format($totalBalance, 2) ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="header-title">
                            <h4 class="card-title">PAYMENT HISTORY</h4>
                        </div>
                    </div>
                    <div class="card-body"> 
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>OR #</th>
                                        <th class="text-center">DATE</th>
                                        <th>PARTICULARS</th>
                                        <th class="text-end">AMOUNT</th>
                                        <th>CASHIER</th>
                                        <th class="text-center">STATUS</th>
                                        <th class="text-center">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($paymenthistorydata as $paymenthistoryd): ?>
                                        <tr>
                                            <td><?= $paymenthistoryd['ornumber']; ?></td>
                                            <td class="text-center"><?= date('F j, Y', strtotime($paymenthistoryd['paymentdate'])); ?></td>
                                            <td><?= $paymenthistoryd['particulars']; ?></td>
                                            <td class="text-end">₱<?= $paymenthistoryd['amountpaid']; ?></td>
                                            <td><?= $paymenthistoryd['receivedby']; ?></td>
                                            <td class="text-center"><?= $paymenthistoryd['paymentstatus']; ?></td>
                                            <td class="text-center">
                                                <?php if($paymenthistoryd['paymentstatus'] != 'Allocated'):?>
                                                <?php else:?>
                                                    <!--<a href="javascript:void(0);" class="btn btn-sm btn-icon btn-info" title="Print Receipt" data-bs-toggle="tooltip" data-bs-placement="top" -->
                                                    <!--    onclick="printReceipt('<?= base_url(); ?>student-accounts/receipt-print/<?= $paymenthistoryd['paymentid']; ?>')">-->
                                                    <!--    <span class="btn-inner">-->
                                                    <!--        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">-->
                                                    <!--            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7379 2.76175H8.08493C6.00493 2.75375 4.29993 4.41175 4.25093 6.49075V17.2037C4.20493 19.3167 5.87993 21.0677 7.99293 21.1147C8.02393 21.1147 8.05393 21.1157 8.08493 21.1147H16.0739C18.1679 21.0297 19.8179 19.2997 19.8029 17.2037V8.03775L14.7379 2.76175Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>-->
                                                    <!--            <path d="M14.4751 2.75V5.659C14.4751 7.079 15.6231 8.23 17.0431 8.234H19.7981" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>-->
                                                    <!--            <path d="M14.2882 15.3584H8.88818" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>-->
                                                    <!--            <path d="M12.2432 11.606H8.88721" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>-->
                                                    <!--        </svg>-->
                                                    <!--    </span>-->
                                                    <!--</a>-->
                                                <?php endif; ?>
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