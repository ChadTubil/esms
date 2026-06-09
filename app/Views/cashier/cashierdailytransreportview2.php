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
                            <h4 class="card-title">Export Daily Transaction Report</h4>
                        </div>
                    </div> 
                    <div class="card-body">
                        <?php foreach ($usersaccess as $uaccess):?>
                            <?php if($uaccess['uaccounting'] == 1 || $uaccess['uadmin'] == 1): ?>
                                <?= form_open('cashier-dailytransactions-export'); ?>
                                    <div class="row">
                                        <div class="col-lg-2 col-sm-6">
                                            <label for="start_date">Start Date</label>
                                            <input type="date" class="form-control" name="start_date" required>
                                        </div>
                                        <div class="col-lg-2 col-sm-6">
                                            <label for="end_date">End Date</label>
                                            <input type="date" class="form-control" name="end_date" required>
                                        </div>
                                        <div class="col-lg-2 col-sm-6">
                                            <label for="start_time">START TIME</label>
                                            <input type="time" class="form-control" name="start_time">
                                        </div>
                                        <div class="col-lg-2 col-sm-6">
                                            <label for="end_time">END TIME</label>
                                            <input type="time" class="form-control" name="end_time">
                                        </div>
                                        <div class="col-lg-2 col-sm-6">
                                            <label for="cashier">CASHIER</label>
                                            <select name="cashier" class="form-select" required>
                                                <option value="ALL">ALL</option>
                                                <?php foreach ($cashierdata as $cashier): ?>
                                                    <option value="<?= $cashier['empfullname']; ?>"><?= $cashier['empfullname']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-sm-6">
                                            <label>ACTION</label>
                                            <button class="btn btn-success" type="submit" style="width: 100%;">
                                                <i class="fas fa-file-excel"></i> Export to Excel
                                            </button>
                                        </div>
                                    </div>
                                <?= form_close(); ?>
                            <?php endif; ?>
                        <?php endforeach;?>
                        <?= form_open('cashier-dailytransactions-pdf', ['target' => '_blank']) ; ?>
                            <div class="row">
                                <div class="col-lg-2 col-sm-6">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" class="form-control" name="start_date" required>
                                </div>
                                <div class="col-lg-2 col-sm-6">
                                    <label for="end_date">End Date</label>
                                    <input type="date" class="form-control" name="end_date" required>
                                </div>
                                <div class="col-lg-2 col-sm-6">
                                    <label for="start_time">START TIME</label>
                                    <input type="time" class="form-control" name="start_time">
                                </div>
                                <div class="col-lg-2 col-sm-6">
                                    <label for="end_time">END TIME</label>
                                    <input type="time" class="form-control" name="end_time">
                                </div>
                                <div class="col-lg-2 col-sm-6">
                                    <label for="cashier">CASHIER</label>
                                    <select name="cashier" class="form-select" required>
                                        <?php if($uaccess['ucashierhead'] == 1): ?>
                                            <option value="ALL">ALL</option>
                                        <?php endif; ?>
                                        <option value="<?= $loggedcashierdata[0]['empfullname']; ?>"><?= $loggedcashierdata[0]['empfullname']; ?></option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-6">
                                    <label>ACTION</label>
                                    <button class="btn btn-success" type="submit" style="width: 100%;">
                                        <i class="fas fa-file-excel"></i> Export to Excel
                                    </button>
                                </div>
                            </div>
                        <?= form_close(); ?>
                    </div>       
                </div>
            </div>
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Daily Transaction Report</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <?= form_open('cashier-dailytransactions'); ?>
                            <div class="row">
                                <div class="col-lg-2 col-sm-6">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" class="form-control" name="start_date" 
                                        value="<?= esc(session()->get('start_date')) ?>" required>
                                </div>
                                <div class="col-lg-2 col-sm-6">
                                    <label for="end_date">End Date</label>
                                    <input type="date" class="form-control" name="end_date" 
                                        value="<?= esc(session()->get('end_date')) ?>" required>
                                </div>
                                <div class="col-lg-2 col-sm-6">
                                    <label for="start_time">START TIME</label>
                                    <input type="time" class="form-control" name="start_time" 
                                        value="<?= esc(session()->get('start_time')) ?>">
                                </div>
                                <div class="col-lg-2 col-sm-6">
                                    <label for="end_time">END TIME</label>
                                    <input type="time" class="form-control" name="end_time" 
                                        value="<?= esc(session()->get('end_time')) ?>">
                                </div>
                                <div class="col-lg-2 col-sm-6">
                                    <label for="cashier">CASHIER</label>
                                    <select name="cashier" class="form-select" required>
                                        <?php if($uaccess['ucashierhead'] == 1): ?>
                                            <option value="ALL">ALL</option>
                                        <?php endif; ?>
                                        <option value="<?= $loggedcashierdata[0]['empfullname']; ?>"><?= $loggedcashierdata[0]['empfullname']; ?></option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-6">
                                    <label>ACTION</label>
                                    <button class="btn btn-primary" type="submit" style="width: 100%;">
                                        <i class="fa-solid fa-filter"></i> Filter
                                    </button>
                                </div>
                            </div>
                            <br>
                        <?= form_close(); ?>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped" data-toggle="data-table" style="font-size: 11px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student No</th>
                                        <th>Student Name</th>
                                        <th>Level</th>
                                        <th>OR</th>
                                        <th>FEE</th>
                                        <th>TF</th>
                                        <?php foreach ($transactionsdata as $td): ?>
                                            <?php foreach($feedata as $fd): ?>
                                                <?php if($fd['feeid'] == $td['feeid'] &&  $fd['istf'] == 0): ?>
                                                    <th><?= $fd['feecode']; ?></th>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                        <th>Payment Method</th>
                                        <th>Total Amount Paid</th>
                                        <th>Particulars</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Cashier</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counter = 1; ?>
                                    <?php foreach ($transactionsdata as $td): ?>
                                        <tr>
                                            <td>
                                                <?php foreach ($usersaccess as $uheadcash):?>
                                                    <?php if($uheadcash['ucashierhead'] == 1):?>
                                                        <a class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="REPRINT RECEIPT"
                                                            href="javascript:void(0);"
                                                            onclick="printReceipt('<?= base_url(); ?>cashier-onlineregistration-print/<?= $td['paymentid']; ?>')">
                                                            <i class="icon-20 fas fa-print"></i>
                                                        </a>
                                                    <?php else:?>
                                                    <?php endif;?>
                                                <?php endforeach;?>

                                                <a class="btn btn-sm btn-icon btn-info" title="Edit Transaction"
                                                    href="#" data-bs-toggle="modal" data-bs-target="#editModal<?= $td['paymentid']; ?>">
                                                    <span class="btn-inner">
                                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
                                                    </span>
                                                </a>
                                                <div class="modal fade" id="editModal<?= $td['paymentid']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content dark">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">UPDATE TRANSACTION</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <?= form_open('cashier-dailytransactions-update/'.$td['paymentid']); ?>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-6 form-group">
                                                                        <label for="email" class="form-label">OR #:</label>
                                                                        <input type="text" name="ornumber" class="form-control" value="<?php echo $td['ornumber']; ?>">
                                                                    </div>
                                                                    <div class="col-6 form-group">
                                                                        <label for="email" class="form-label">REFERENCE #:</label>
                                                                        <input type="text" name="paymentreference" class="form-control" value="<?php echo $td['paymentreference']; ?>" disabled>
                                                                    </div>
                                                                    <div class="col-12 form-group">
                                                                        <label for="email" class="form-label">STUDENT NAME:</label>
                                                                        <input type="text" name="schoolyear" class="form-control" value="<?php echo $td['studfullname']; ?>" disabled>
                                                                        <input type="hidden" name="fullname" class="form-control" value="<?php echo $td['studfullname']; ?>">
                                                                    </div>
                                                                    <div class="col-6 form-group">
                                                                        <label for="email" class="form-label">PAYMENT DATE:</label>
                                                                        <input type="date" name="paymentdate" class="form-control" value="<?php echo $td['paymentdate']; ?>">
                                                                    </div>
                                                                    <div class="col-6 form-group">
                                                                        <label for="email" class="form-label">PAYMENT TIME:</label>
                                                                        <input type="time" name="paymenttime" class="form-control" value="<?php echo $td['paymenttime']; ?>">
                                                                    </div>
                                                                    <div class="col-6 form-group">
                                                                        <label for="email" class="form-label">AMOUNT:</label>
                                                                        <input type="text" name="amount" class="form-control" value="<?php echo $td['amountpaid']; ?>">
                                                                    </div>
                                                                    <div class="col-12 form-group">
                                                                        <label for="email" class="form-label">DESCRIPTION:</label>
                                                                        <input type="text" name="particulars" class="form-control" value="<?php echo $td['particulars']; ?>">
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
                                            <td><?= $td['studentno']; ?></td>
                                            <td><?= $td['studfullname']; ?></td>
                                            <td><?= $td['level']; ?></td>
                                            <td><?= $td['ornumber']; ?></td>
                                            <td><?php
                                                if($td['istf'] == 1){
                                                    echo $td['feecode'];
                                                }
                                            ?></td>
                                            <td><?php
                                                if($td['istf'] == 1){
                                                    echo $td['amountpaid'];
                                                }
                                            ?></td>
                                            
                                                <?php foreach($feedata as $fd): ?>
                                                    <?php if($fd['feeid'] == $td['feeid'] && $fd['istf'] == 0): ?>
                                                        <td>₱<?= number_format($td['amountpaid'], 2); ?></td>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            
                                            <td><?= $td['paymentmethod']; ?></td>
                                            <td>₱<?= number_format($td['amountpaid'], 2); ?></td>
                                            <td><?= $td['particulars']; ?></td>
                                            <td><?= date('Y-m-d', strtotime($td['paymentdate'])); ?></td>
                                            <td><?= date('H:i:s', strtotime($td['paymenttime'])); ?></td>
                                            <td><?= $td['receivedby']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php 
                                        $fee_totals = [];
                                        $tf_total = 0; // Add this for TF total
                                        
                                        foreach($feedata as $fd) {
                                            $fee_totals[$fd['feeid']] = 0;
                                        }
                                        
                                        $grand_total = 0;
                                        
                                        foreach($transactionsdata as $td) {
                                            // Calculate regular fee totals
                                            $feeId = isset($td['feeid']) ? $td['feeid'] : null;
                                            if($feeId !== null && isset($fee_totals[$feeId])) {
                                                $fee_totals[$feeId] += $td['amountpaid'];
                                            } elseif($feeId !== null) {
                                                $fee_totals[$feeId] = $td['amountpaid'];
                                            }
                                            
                                            // Calculate TF total (where istf == 1)
                                            if(isset($td['istf']) && $td['istf'] == 1) {
                                                $tf_total += $td['amountpaid'];
                                            }
                                            
                                            $grand_total += $td['amountpaid'];
                                        }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5" style="text-align:right">Totals:</th>
                                        <th>₱<?= number_format($tf_total, 2); ?></th>
                                        <?php foreach($feedata as $fd): ?>
                                            <?php if($fd['istf'] == 0) :?>
                                                <th>
                                                    ₱<?= number_format($fee_totals[$fd['feeid']], 2); ?>
                                                </th>
                                            <?php else: ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <th></th>
                                        <th>
                                            ₱<?= number_format($grand_total, 2); ?>
                                        </th>
                                        <th colspan="3"></th>
                                    </tr>
                                </tfoot>
                            </table>
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