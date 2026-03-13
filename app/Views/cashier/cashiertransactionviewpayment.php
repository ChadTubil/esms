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
                            <h4 class="card-title">CASHIER TRANSACTION - PAYMENT PROCESSING</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if(session()->getTempdata('updatesuccess')) :?>
                            <div class="alert alert-success">
                                <?= session()->getTempdata('updatesuccess');?>
                            </div>
                        <?php endif; ?>
                        <?php foreach($paymenttransactionsdata as $payment): ?>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card border" style="border-color: white;">
                                    <div class="card-header text-white" style="background-color: #263A56;">
                                        <h5 style="color: white;">TRANSACTION INFORMATION</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label" style="color: white;">Payment Reference:</label>
                                                <input type="text" class="form-control" style="color: white;" value="<?= $payment['paymentreference'] ?>" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label" style="color: white;">Student No:</label>
                                                <input type="text" class="form-control" style="color: white;" readonly>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label" style="color: white;">Student Name:</label>
                                                <input type="text" class="form-control" style="color: white;" value="<?= $payment['studfullname'] ?>" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label" style="color: white;">Account No:</label>
                                                <input type="text" class="form-control" style="color: white;" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label" style="color: white;">Amount Paid:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text" style="color: white;">₱</span>
                                                    <input type="text" class="form-control fw-bold text-success" style="color: white;" value="<?= number_format($payment['amountpaid'], 2) ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label" style="color: white;">Payment Status:</label>
                                                <span class="badge <?= $payment['paymentstatus'] == 'Paid' ? 'bg-success' : ($payment['paymentstatus'] == 'Pending' ? 'bg-warning' : 'bg-danger') ?> p-2 d-block">
                                                    <?= $payment['paymentstatus'] ?>
                                                </span>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label" style="color: white;">OR Number:</label>
                                                <input type="text" class="form-control" style="color: white;" value="<?= $payment['ornumber'] ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card border" style="border-color: white;">
                                    <div class="card-header text-white" style="background-color: #263A56;">
                                        <h5 style="color: white;">Process Payment</h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" action="<?= base_url('cashier/onlineregistration-process-payment/' . $payment['paymentid']) ?>">
                                            <div class="row">
                                                <!-- Payment Method -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Payment Method *</label>
                                                    <select class="form-select" name="paymentmethod" id="paymentMethod" required>
                                                        <option value="">Select Method</option>
                                                        <option value="Cash" <?= $payment['paymentmethod'] == 'Cash' ? 'selected' : '' ?>>Cash</option>
                                                        <option value="Check" <?= $payment['paymentmethod'] == 'Check' ? 'selected' : '' ?>>Check</option>
                                                        <option value="Bank Transfer" <?= $payment['paymentmethod'] == 'Bank Transfer' ? 'selected' : '' ?>>Bank Transfer</option>
                                                    </select>
                                                </div>
                                                
                                                <!-- Payment Date -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Payment Date *</label>
                                                    <input type="date" class="form-control" name="paymentdate" 
                                                        value="<?php if($payment['paymentdate'] == '0000-00-00'){ echo date('Y-m-d'); }else{echo $payment['paymentdate']; }?>" required>
                                                </div>

                                                <!-- Payment Time -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Payment Time *</label>
                                                    <input type="time" class="form-control" name="paymenttime" 
                                                        value="<?php if($payment['paymenttime'] == '00:00:00'){ echo date('H:i'); }else{echo $payment['paymenttime']; }?>" required>
                                                </div>
                                                
                                                <!-- Amount Paid -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Amount Paid *</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">₱</span>
                                                        <input type="number" class="form-control" name="amountpaid" step="0.01" min="0" value="<?= $payment['amountpaid'] ?>" required>
                                                    </div>
                                                </div>
                                                
                                                <!-- Check Details (Show only if Check is selected) -->
                                                <div id="checkDetails" style="display: none;">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Check Number</label>
                                                        <input type="text" class="form-control" name="checknumber" value="<?= $payment['checknumber'] ?? '' ?>">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Check Date</label>
                                                        <input type="date" class="form-control" name="checkdate" value="<?= $payment['checkdate'] ?? '' ?>">
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label">Bank Name</label>
                                                        <input type="text" class="form-control" name="bankname" value="<?= $payment['bankname'] ?? '' ?>">
                                                    </div>
                                                </div>
                                                
                                                <!-- Bank Details (Show only if Bank Transfer is selected) -->
                                                <div id="bankDetails" style="display: none;">
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label">Bank Name (for Bank Transfer)</label>
                                                        <input type="text" class="form-control" name="bankname" value="<?= $payment['bankname'] ?? '' ?>">
                                                    </div>
                                                </div>
                                                
                                                <!-- Particulars -->
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Particulars *</label>
                                                    <textarea class="form-control" name="particulars" rows="2" required><?= $payment['particulars'] ?? '' ?></textarea>
                                                </div>
                    
                                                
                                                <!-- OR Number -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">OR Number *</label>
                                                    <input type="text" class="form-control" name="ornumber" value="<?= $payment['ornumber'] ?? '' ?>" required>
                                                </div>
                                                                                                
                                                <!-- Action Buttons -->
                                                <div class="col-md-12">
                                                    <div class="d-flex justify-content-between">
                                                        <a href="<?= base_url('cashier-onlineregistration') ?>" class="btn btn-info">
                                                            <i class="fas fa-arrow-left me-2"></i>Back to List
                                                        </a>
                                                        <div>
                                                            <button type="submit" name="action" value="save" class="btn btn-success">
                                                                <i class="fas fa-save me-2"></i>SUBMIT
                                                            </button>
                                                            <?php if($payment['paymentstatus'] == "Paid"): ?>
                                                            <a class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="PRINT RECEIPT"
                                                                href="javascript:void(0);"
                                                                onclick="printReceipt('<?= base_url(); ?>cashier-onlineregistration-print/<?= $payment['paymentid']; ?>')">
                                                                <i class="fas fa-print me-2"></i>PRINT RECEIPT
                                                            </a>
                                                            <?php else : ?>
                                                            <?php endif;?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
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
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethod = document.getElementById('paymentMethod');
            const checkDetails = document.getElementById('checkDetails');
            const bankDetails = document.getElementById('bankDetails');
            
            function togglePaymentDetails() {
                const method = paymentMethod.value;
                
                // Hide all details first
                checkDetails.style.display = 'none';
                bankDetails.style.display = 'none';
                
                // Show relevant details
                if (method === 'Check') {
                    checkDetails.style.display = 'block';
                } else if (method === 'Bank Transfer') {
                    bankDetails.style.display = 'block';
                }
            }
            
            // Initial toggle based on current value
            togglePaymentDetails();
            
            // Toggle on change
            paymentMethod.addEventListener('change', togglePaymentDetails);
        });
    </script>
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
<?= $this->endSection(); ?>