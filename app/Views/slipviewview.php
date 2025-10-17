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
            <div class="col-lg-6 col-sm-12">
                <div class="card">
                    <div class="card-body" >
                        <div style="text-align: center;">
                            <h5>PAYSLIP</h5>
                            <?php foreach($payslipdata as $payslipd): ?>
                                <h5><?= $payslipd['description']; ?></h5>
                            <?php endforeach; ?>
                        </div>
                        <br>
                        <br>
                        <?php foreach($payslipdatadata as $payslipdatad): ?>
                            <div class="row">
                                <div class="col-3" style="text-align: left;">
                                    <h6>NAME:</h6>
                                </div>
                                <div class="col-9" style="text-align: right;">
                                    <h6><?= $payslipdatad['name']; ?></h6>
                                </div>
                                <br>
                                <br>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Basic Pay</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['basicpay']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Unpaid Absences/Tardiness</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['unpaidabtard']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Unpaid Days</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['unpaiddays']; ?></h6>
                                </div>
                                <br>
                                <br>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Net Basic Pay</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['netbasicpay']; ?></h6>
                                </div>
                                <br>
                                <br>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Adv. Class</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['advisoryclass']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Special Designation</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['specialdesignation']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Overload Pay(GS)</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['gs']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Overload Pay(JHS)</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['jhs']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Overload Pay(Col)</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['college']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Overload Pay(SHS)</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['shs']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Economic Relief Allowance</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['economic']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>OTHER EARNINGS:</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Adjustment (Overload)</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['adjustmentOL']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Make-up Class</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['makeupclass']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>CP Load</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['cpload']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Allowance</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['allowance']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Thesis/Panelist/Feasib</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['thesis']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>OT</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['ot']; ?></h6>
                                </div>
                                <hr>
                                <div class="col-6" style="text-align: left;">
                                    <h6>GROSS INCOME</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['grossincome']; ?></h6>
                                </div>
                                <hr>
                                <div class="col-6" style="text-align: left;">
                                    <h6>SSS</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['sss']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Philhealth</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['philhealth']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Pag-ibig</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['pagibig']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>PERAA</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['peraa']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Absences/Tardiness</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['absences']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Withholding Tax</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['tax']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Loan-SSS-Salary</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['ssssalary']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Loan-SSS-Calamity</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['ssscalamity']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Loan-Pag-ibig-MPL</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['mpl']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Loan-Pag-ibig-Calamity</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['pagibigcalamity']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Loan-PERAA</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['peraaloan']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Advances</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['advancestoemployees']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Bank Loan - CBS</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['cbsloan']; ?></h6>
                                </div>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Other Deductions</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['otherdeduction']; ?></h6>
                                </div>
                                <hr>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Gross Deductions</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['grossdeduction']; ?></h6>
                                </div>
                                <hr>
                                <div class="col-6" style="text-align: left;">
                                    <h6>Net Pay</h6>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h6>₱<?= $payslipdatad['netpay']; ?></h6>
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

<?= $this->endSection(); ?>