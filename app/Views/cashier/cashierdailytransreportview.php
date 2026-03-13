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
                            <h4 class="card-title">Daily Transaction Report</h4>
                        </div>
                        <!-- Change the print button section -->
                        <div class="d-flex gap-2">
                            <a href="<?= base_url('cashier-dailytransactions-pdf') . '?' . http_build_query($_GET); ?>" 
                            class="btn btn-danger btn-sm" target="_blank">
                                <i class="fas fa-file-pdf"></i> Generate PDF
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filter Form -->
                        <form method="get" action="<?= base_url('cashier-dailytransactions'); ?>" class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label for="date_filter" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="date_filter" name="date_filter" 
                                        value="<?= $selected_date ?? date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="payment_method" class="form-label">Payment Method</label>
                                    <select class="form-select" id="payment_method" name="payment_method">
                                        <option value="all">All Methods</option>
                                        <option value="Cash" <?= (isset($_GET['payment_method']) && $_GET['payment_method'] == 'Cash') ? 'selected' : ''; ?>>Cash</option>
                                        <option value="Check" <?= (isset($_GET['payment_method']) && $_GET['payment_method'] == 'Check') ? 'selected' : ''; ?>>Check</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="department" class="form-label">Department</label>
                                    <select class="form-select" id="department" name="department">
                                        <option value="all">All Departments</option>
                                        <?php foreach ($departments as $dept): ?>
                                            <option value="<?= $dept['studstatus']; ?>" 
                                                <?= (isset($_GET['department']) && $_GET['department'] == $dept['studstatus']) ? 'selected' : ''; ?>>
                                                
                                                <?php if($dept['studstatus'] == 'GS'){echo 'IBED';}elseif($dept['studstatus'] == 'SHS'){echo 'SHS';}else{echo 'COLLEGE';} ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                                </div>
                            </div>
                        </form>

                        <!-- Summary Cards -->
                        <div class="row mb-4">
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="bg-primary p-3 rounded">
                                                <i class="fas fa-money-bill-wave fa-2x text-white"></i>
                                            </div>
                                            <div class="text-end">
                                                <h2 class="counter">₱<?= number_format($total_amount ?? 0, 2); ?></h2>
                                                <p class="mb-0">Total Amount</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="bg-success p-3 rounded">
                                                <i class="fas fa-receipt fa-2x text-white"></i>
                                            </div>
                                            <div class="text-end">
                                                <h2 class="counter"><?= $total_count ?? 0; ?></h2>
                                                <p class="mb-0">Total Transactions</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-12 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="bg-info p-3 rounded">
                                                <i class="fas fa-check-circle fa-2x text-white"></i>
                                            </div>
                                            <div class="text-end">
                                                <h2 class="counter"><?= $paid_count ?? 0; ?></h2>
                                                <p class="mb-0">Paid Transactions</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Transactions Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" data-toggle="data-table">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Reference No.</th>
                                        <th>Student Name</th>
                                        <th>Department</th>
                                        <th>Payment Date</th>
                                        <th>Payment Method</th>
                                        <th>Amount</th>
                                        <th>OR Number</th>
                                        <th>Status</th>
                                        <th>Received By</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $counter = 1; ?>
                                    <?php foreach ($paymenttransactiondata as $paymenttransactiond): ?>
                                        <tr>
                                            <td>
                                                <a class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="REPRINT RECEIPT"
                                                    href="javascript:void(0);"
                                                    onclick="printReceipt('<?= base_url(); ?>cashier-onlineregistration-print/<?= $paymenttransactiond['paymentid']; ?>')">
                                                    <i class="icon-20 fas fa-print"></i>
                                                </a>
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
                                                                <h5 class="modal-title" id="staticBackdropLabel">UPDATE TRANSACTION</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <?= form_open('cashier-dailytransactions-update/'.$paymenttransactiond['paymentid']); ?>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-6 form-group">
                                                                        <label for="email" class="form-label">OR #:</label>
                                                                        <input type="text" name="ornumber" class="form-control" value="<?php echo $paymenttransactiond['ornumber']; ?>">
                                                                    </div>
                                                                    <div class="col-6 form-group">
                                                                        <label for="email" class="form-label">REFERENCE #:</label>
                                                                        <input type="text" name="paymentreference" class="form-control" value="<?php echo $paymenttransactiond['paymentreference']; ?>" disabled>
                                                                    </div>
                                                                    <div class="col-12 form-group">
                                                                        <label for="email" class="form-label">STUDENT NAME:</label>
                                                                        <input type="text" name="schoolyear" class="form-control" value="<?php echo $paymenttransactiond['studfullname']; ?>" disabled>
                                                                        <input type="hidden" name="fullname" class="form-control" value="<?php echo $paymenttransactiond['studfullname']; ?>">
                                                                    </div>
                                                                    <div class="col-6 form-group">
                                                                        <label for="email" class="form-label">PAYMENT DATE:</label>
                                                                        <input type="date" name="paymentdate" class="form-control" value="<?php echo $paymenttransactiond['paymentdate']; ?>">
                                                                    </div>
                                                                    <div class="col-6 form-group">
                                                                        <label for="email" class="form-label">PAYMENT TIME:</label>
                                                                        <input type="time" name="paymenttime" class="form-control" value="<?php echo $paymenttransactiond['paymenttime']; ?>">
                                                                    </div>
                                                                    <div class="col-6 form-group">
                                                                        <label for="email" class="form-label">DEPARTMENT:</label>
                                                                        <select class="form-select" id="department" name="departmentedit">
                                                                            <option value="<?= $paymenttransactiond['studstatus']; ?>" SELECTED>
                                                                                <?php if($paymenttransactiond['studstatus'] == 'GS'){echo 'IBED';}elseif($paymenttransactiond['studstatus'] == 'SHS'){echo 'SHS';}else{echo 'COLLEGE';} ?>
                                                                            </option>
                                                                            <option value="GS">IBED</option>
                                                                            <option value="SHS">SHS</option>
                                                                            <option value="COLLEGE">COLLEGE</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-6 form-group">
                                                                        <label for="email" class="form-label">AMOUNT:</label>
                                                                        <input type="text" name="amount" class="form-control" value="<?php echo $paymenttransactiond['amountpaid']; ?>">
                                                                    </div>
                                                                    <div class="col-12 form-group">
                                                                        <label for="email" class="form-label">DESCRIPTION:</label>
                                                                        <input type="text" name="particulars" class="form-control" value="<?php echo $paymenttransactiond['particulars']; ?>">
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
                                            <td><?= $paymenttransactiond['paymentreference']; ?></td>
                                            <td><?= $paymenttransactiond['studfullname']; ?></td>
                                            <td><?php if($paymenttransactiond['studstatus'] == 'GS'){echo 'IBED';}elseif($paymenttransactiond['studstatus'] == 'SHS'){echo 'SHS';}else{echo 'COLLEGE';} ?></td>
                                            <td><?= date('M d, Y', strtotime($paymenttransactiond['paymentdate'] )); ?> <?= $paymenttransactiond['paymenttime']; ?></td>
                                            <td>
                                                <span class="badge bg-info"><?= $paymenttransactiond['paymentmethod']; ?></span>
                                                <?php if ($paymenttransactiond['paymentmethod'] == 'Check'): ?>
                                                    <br>
                                                    <small>Check #: <?= $paymenttransactiond['checknumber']; ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end">₱<?= number_format($paymenttransactiond['amountpaid'], 2); ?></td>
                                            <td><?= $paymenttransactiond['ornumber'] ?? 'N/A'; ?></td>
                                            <td>
                                                <?php if ($paymenttransactiond['paymentstatus'] == 'Paid'): ?>
                                                    <span class="badge bg-success">Paid</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $paymenttransactiond['receivedby']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="table-dark">
                                    <tr>
                                        <td colspan="5" class="text-end"><strong>Total:</strong></td>
                                        <td class="text-end"><strong>₱<?= number_format($total_amount ?? 0, 2); ?></strong></td>
                                        <td colspan="4"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Report Summary -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Report Summary</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Report Date:</strong> <?= date('F d, Y', strtotime($selected_date ?? date('Y-m-d'))); ?></p>
                                                <p><strong>Generated On:</strong> <?= date('F d, Y h:i A'); ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Total Transactions:</strong> <?= $total_count ?? 0; ?></p>
                                                <p><strong>Total Amount Collected:</strong> ₱<?= number_format($total_amount ?? 0, 2); ?></p>
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
    </div>
    <!-- End of Page Content -->

    <!-- Print Styles -->
    <style>
        @media print {
            .card-header .btn,
            form,
            .sidebar,
            .navbar,
            .iq-navbar-header,
            .footer {
                display: none !important;
            }
            
            .card {
                border: none !important;
                box-shadow: none !important;
            }
            
            .table {
                font-size: 12px;
            }
            
            h4, h5 {
                color: #000 !important;
            }
            
            body {
                background-color: #fff !important;
            }
        }
    </style>
    <script>
        function printReceipt(url) {
            // Open in new window
            var printWindow = window.open(url, 'PrintReceipt', 'width=800,height=600');
            
            // Wait for window to load then trigger print
            printWindow.onload = function() {
                printWindow.focus();
                printWindow.print();
            };
        }
    </script>
    <!-- ----------- FOOTER ------------------ -->
    <?= $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->
<?= $this->endSection(); ?>