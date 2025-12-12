<?php $this->extend("layouts/base"); ?>

<?= $this->section('title') ?>
    <?= $page_title; ?>
<?= $this->endSection() ?>
<?= $this->section('page_heading') ?>
    <?= $page_heading; ?>
<?= $this->endSection(); ?>
<?= $this->section("page_p"); ?>
    <?= $page_p; ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
    <!-- ----------- SIDEBAR ------------------ -->
    <?= $this->include("partials/sidebar"); ?>  
    <!-- ----------- END OF SIDEBAR ------------------ --> 
    
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <?php echo form_open('cashier-transaction'); ?>
                            <div class="row">
                                <div class="col-lg-9 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SEARCH STUDENT</label>
                                    <input type="text" name="searchstud" class="form-control"
                                    placeholder="Search Student Number | Student Name">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <button class="btn btn-success" type="submit" name="add" style="width: 100%; height: 100%;">SEACH</button>
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="header-title" style="text-align: center;">
                            <h5 class="card-title">ACCOUNTS</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" style="font-size: 12px">
                                <thead>
                                    <tr>
                                        <th>YEAR</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($assessmentData as $assessmentD):?>
                                        <tr>
                                            <td><?= $assessmentD['sy']; ?> - <?= $assessmentD['sem']; ?> (<?= $assessmentD['level']; ?>)</td>
                                            <td>
                                                <a class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View"
                                                    onclick="window.location.href='<?= base_url(); ?>cashier-transaction-view/open/<?= $assessmentD['assid']; ?>'">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M21.25 16.334V7.665C21.25 4.645 19.111 2.75 16.084 2.75H7.916C4.889 2.75 2.75 4.635 2.75 7.665L2.75 16.334C2.75 19.364 4.889 21.25 7.916 21.25H16.084C19.111 21.25 21.25 19.364 21.25 16.334Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M16.0861 12H7.91406" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M12.3223 8.25205L16.0863 12L12.3223 15.748" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                    </span> OPEN
                                                </a>
                                            </td>
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
                    <div class="card-body" style="text-align: center;">
                        <h4>ASSESSMENT OF FEES</h4>
                        <br>
                        <div style="display: flex; gap: 20px; margin-bottom: 5px;">
                            <?php foreach($studentInfo as $studentI): ?>
                                <h6><strong><?= $studentI['studentno']; ?></strong></h6>
                                <h6 style="text-transform: uppercase;"><strong><?= $studentI['studfullname']; ?></strong></h6>
                            <?php endforeach; ?>
                        </div>
                        <div style="display: flex; gap: 20px; margin-bottom: 10px;">
                            <?php foreach($assessmentData as $assessmentD): ?>
                                <h6><strong><?= $assessmentD['sy']; ?></strong></h6>
                                <h6><strong><?= $assessmentD['sem']; ?></strong></h6>
                                <h6><strong><?= $assessmentD['level']; ?></strong></h6>
                                <h6><strong><?php
                                    foreach($courseInfo as $courseI) {
                                        if($courseI['courid'] == $assessmentD['course']) {
                                            echo $courseI['course'];
                                        }
                                    }
                                ?></strong></h6>
                            <?php endforeach; ?>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="table-responsive">
                                    <table style="font-size: 12px; width: 100%; border: 1px solid">
                                        <thead>
                                            <tr style="border: 1px solid">
                                                <th style="border: 1px solid">Tuition Fees</th>
                                                <th style="border: 1px solid">Subject</th>
                                                <th style="border: 1px solid">Units</th>
                                                <th style="border: 1px solid">Hours</th>
                                                <th style="border: 1px solid">Rate</th>
                                                <th style="border: 1px solid">Amount</th>
                                            </tr>
                                        </thead> 
                                        <?php foreach($ratesData as $ratesD): ?>
                                            <tbody>
                                                <?php foreach($totalmajorunits as $tmu): ?>
                                                    <tr style="border: 1px solid">
                                                        <td style="border: 1px solid">Regular Subjects</td>
                                                        <td style="border: 1px solid">Major</td>
                                                        <td style="border: 1px solid"><?= $tmu['totalmajorunits']; ?></td>
                                                        <td style="border: 1px solid"><?= $tmu['totalmajorhours']; ?></td>
                                                        <td style="border: 1px solid"><?= $ratesD['major']; ?></td>
                                                        <td style="border: 1px solid"><?php
                                                            $amount = $tmu['totalmajorhours'] * $ratesD['major'];
                                                            echo '₱' . number_format($amount, 2);
                                                        ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                <?php foreach($totalminorunits as $tmu2): ?>
                                                    <tr style="border: 1px solid">
                                                        <td style="border: 1px solid">Regular Subjects</td>
                                                        <td style="border: 1px solid">Minor</td>
                                                        <td style="border: 1px solid"><?= $tmu2['totalminorunits']; ?></td>
                                                        <td style="border: 1px solid"><?= $tmu2['totalminorhours']; ?></td>
                                                        <td style="border: 1px solid"><?= $ratesD['minor']; ?></td>
                                                        <td style="border: 1px solid"><?php
                                                            $amount2 = $tmu2['totalminorhours'] * $ratesD['minor'];
                                                            echo '₱' . number_format($amount2, 2);
                                                        ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                <tr style="border: 1px solid">
                                                    <td style="border: 1px solid">Fixed Amount</td>
                                                    <td style="border: 1px solid"><?php
                                                        if($ratesD['nstp02'] == 0.00){
                                                            echo 'NSTP01';
                                                        } else {
                                                            echo 'NSTP02';
                                                        }
                                                    ?></td>
                                                    <td style="border: 1px solid"><?php
                                                        if($ratesD['nstp02'] == 0.00){
                                                            echo '3';
                                                        } else {
                                                            echo '3';
                                                        }
                                                    ?></td>
                                                    <td style="border: 1px solid"><?php
                                                        if($ratesD['nstp02'] == 0.00){
                                                            echo '3';
                                                        } else {
                                                            echo '3';
                                                        }
                                                    ?></td>
                                                    <td style="border: 1px solid">-</td>
                                                    <td style="border: 1px solid"><?php
                                                        if($ratesD['nstp02'] == 0.00){
                                                            echo '₱' . number_format($ratesD['nstp01'], 2);
                                                        } else {
                                                            echo '₱' . number_format($ratesD['nstp02'], 2);
                                                        }
                                                    ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid">Total Tuition Fees</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td style="border: 1px solid"><?php
                                                        $totalTuition = $amount + $amount2;
                                                        if($ratesD['nstp02'] == 0.00){
                                                            $totalTuition += $ratesD['nstp01'];
                                                        } else {
                                                            $totalTuition += $ratesD['nstp02'];
                                                        }
                                                        echo '₱' . number_format($totalTuition, 2);
                                                    ?></td>
                                                </tr>
                                                <tr style="border: 1px solid">
                                                    <td style="border: 1px solid">Less Discount(0.00%)</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td style="border: 1px solid">-</td>
                                                </tr>
                                                <tr style="border: 1px solid">
                                                    <td style="border: 1px solid">TUITION FEES - NET</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td style="border: 1px solid"><?php
                                                        echo '₱' . number_format($totalTuition, 2);
                                                    ?></td>
                                                </tr>
                                            </tbody> 
                                        <?php endforeach; ?> 
                                    </table>
                                </div>
                                <br>
                                <div style="text-align: center;">
                                    <table style="font-size: 14px; width: 100%; border: 1px solid">
                                        <tbody>
                                            <tr style="border: 1px solid">
                                                <td style="border: 1px solid"><strong>TOTAL OTHER FEES</strong></td>
                                                <td style="border: 1px solid"><strong><?php
                                                        $totalOtherFees = 0;
                                                        foreach($rofdata as $rofd) {
                                                            $totalOtherFees += $rofd['otherfees'];
                                                        }
                                                        echo '₱' . number_format($totalOtherFees, 2);
                                                ?></strong></td>
                                            </tr>
                                            <tr style="border: 1px solid">
                                                <td style="border: 1px solid"><strong>GRAND TOTAL</strong></td>
                                                <td style="border: 1px solid"><strong><?php
                                                    $grandTotal = $totalTuition + $totalOtherFees;
                                                    echo '₱' . number_format($grandTotal, 2);
                                                ?></strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <div style="text-align: center;">
                                    <h5><strong>DUE DATES</strong></h5>
                                    <table style="font-size: 12px; width: 100%; border: 1px solid">
                                        <tbody>
                                            <?php if(empty($duedata)): ?>
                                                <tr style="border: 1px solid">
                                                    <td style="border: 1px solid">-</td>
                                                    <td style="border: 1px solid">No due date set.</td>
                                                </tr>
                                            <?php else : ?>
                                                <?php foreach($duedata as $dued) :?>
                                                    <tr style="border: 1px solid">
                                                        <td style="border: 1px solid"><?= $dued['name']; ?></td>
                                                        <td style="border: 1px solid"><?= date('F j, Y', strtotime($dued['due'])); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div style="text-align: center;">
                                    <table style="font-size: 16px; width: 100%; border: 1px solid">
                                        <tbody>
                                            <tr style="border: 1px solid">
                                                <td style="border: 1px solid"><strong>TOTAL AMOUNT</strong></td>
                                                <td style="border: 1px solid"><?php
                                                    $grandTotal = $totalTuition + $totalOtherFees;
                                                    echo '₱' . number_format($grandTotal, 2);
                                                ?></td>
                                            </tr>
                                            <tr style="border: 1px solid">
                                                <td style="border: 1px solid"><strong>DISCOUNT</strong></td>
                                                <td style="border: 1px solid">-</td>
                                            </tr>
                                            <tr style="border: 1px solid">
                                                <td style="border: 1px solid"><strong>BALANCE</strong></td>
                                                <td style="border: 1px solid"><?php
                                                    $grandTotal = $totalTuition + $totalOtherFees;
                                                    echo '₱' . number_format($grandTotal, 2);
                                                ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                    <br>
                                    <input type="number" class="form-control" placeholder="Enter Pay Amount" style="border-color: white;">
                                    <br>
                                    <button class="btn btn-success" style="width: 100%; margin-bottom: 5px;">ALLOCATE</button>
                                    <button class="btn btn-primary" style="width: 100%">PRINT</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    <!-- ----------- FOOTER ------------------ -->
    <?= $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?= $this->endSection(); ?>
        