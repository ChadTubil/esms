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
                        <?= form_open('cashier-dailytransactions-pdf'); ?>
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
                        <?php if(session()->getTempdata('error')) :?>
                            <div class="alert alert-danger">
                                <?= session()->getTempdata('error');?>
                            </div>
                        <?php endif; ?>
                        <?= form_open('cashier-dailytransactions'); ?>
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
                                    <button class="btn btn-primary" type="submit" style="width: 100%;">
                                        <i class="fa-solid fa-filter"></i> Filter
                                    </button>
                                </div>
                            </div>
                            <br>
                        <?= form_close(); ?>
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