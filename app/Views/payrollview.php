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
                            <?php foreach($payslipdata as $payslipd):?>
                                <h5 class="card-title"><?= $payslipd['description']; ?> PAYROLL</h5>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped" data-toggle="data-table" style="font-size: 11px">
                                <thead>
                                    <tr>
                                        <th>EMPLOYEE NO</th>
                                        <th>NAME</th>
                                        <th style="text-align: center;">BASIC PAY</th>
                                        <th style="text-align: center;">ABSENCES/TARDINESS</th>
                                        <th style="text-align: center;">UNPAID DAYS</th>
                                        <th style="text-align: center;">NET BASIC PAY</th>
                                        <th style="text-align: center;">ADVISORY</th>
                                        <th style="text-align: center;">SD</th>
                                        <th style="text-align: center;">GS</th>
                                        <th style="text-align: center;">JHS</th>
                                        <th style="text-align: center;">COLLEGE</th>
                                        <th style="text-align: center;">SHS</th>
                                        <th style="text-align: center;">ECONOMIC</th>
                                        <th style="text-align: center;">ADJUSTMENT OL</th>
                                        <th style="text-align: center;">MAKEUP CLASS</th>
                                        <th style="text-align: center;">CP LOAD</th>
                                        <th style="text-align: center;">ALLOWANCE</th>
                                        <th style="text-align: center;">THESIS</th>
                                        <th style="text-align: center;">OT</th>
                                        <th style="text-align: center;">GROSS INCOME</th>
                                        <th style="text-align: center;">SSS</th>
                                        <th style="text-align: center;">PHILHEALTH</th>
                                        <th style="text-align: center;">PAGIBIG</th>
                                        <th style="text-align: center;">PERAA</th>
                                        <th style="text-align: center;">ABSENCES</th>
                                        <th style="text-align: center;">TAX</th>
                                        <th style="text-align: center;">SSS SALARY</th>
                                        <th style="text-align: center;">SSS CALAMITY</th>
                                        <th style="text-align: center;">PAG-IBIG MPL</th>
                                        <th style="text-align: center;">PAG-IBIG CALAMITY</th>
                                        <th style="text-align: center;">PERAA LOAN</th>
                                        <th style="text-align: center;">ADVANCES TO EMPLOYEES</th>
                                        <th style="text-align: center;">BANK LOAN CBS</th>
                                        <th style="text-align: center;">OTHER DEDUCTION</th>
                                        <th style="text-align: center;">GROSS DEDUCTION</th>
                                        <th style="text-align: center;">NET PAY</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($payslipdatadata as $payslipdatad):?>
                                        <tr>
                                            <td><?= $payslipdatad['employeeno']; ?></td>
                                            <td><?= $payslipdatad['name']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['basicpay']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['unpaidabtard']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['unpaiddays']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['netbasicpay']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['advisoryclass']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['specialdesignation']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['gs']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['jhs']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['college']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['shs']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['economic']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['adjustmentOL']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['makeupclass']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['cpload']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['allowance']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['thesis']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['ot']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['grossincome']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['sss']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['philhealth']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['pagibig']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['peraa']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['absences']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['tax']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['ssssalary']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['ssscalamity']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['mpl']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['pagibigcalamity']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['peraaloan']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['advancestoemployees']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['cbsloan']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['otherdeduction']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['grossdeduction']; ?></td>
                                            <td style="text-align: center;">₱<?= $payslipdatad['netpay']; ?></td>
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