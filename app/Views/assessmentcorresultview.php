<?php $this->extend("layouts/base"); ?>

<?php $this->section("title"); ?>
    <?php echo $page_title; ?>
<?php $this->endSection(); ?>
<?php $this->section("page_heading"); ?>
    <?php echo $page_heading; ?>
<?php $this->endSection(); ?>
<?php $this->section("page_p"); ?>
    <?php echo $page_p; ?>
<?php $this->endSection(); ?>

<?php echo $this->section('content'); ?>
    <!-- ----------- SIDEBAR ------------------ -->
    <?php echo $this->include("partials/sidebar"); ?>  
    <!-- ----------- END OF SIDEBAR ------------------ --> 

    <!-- Begin Page Content -->

    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <?php foreach($ETDData as $etd): ?>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <button class="btn btn-success" style="width: 100%;">PROCESS</button>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <button class="btn btn-primary" style="width: 100%;"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="PRINT COR"
                                    onclick="window.location.href='<?= base_url(); ?>assessment-cor/print/<?= $etd['etdid']; ?>'">PRINT COR</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div style="text-align: center;"><h1>ENROLLMENT ASSESSMENT</h1></div>
                        <br>
                        <br>
                        <?php foreach($assessment as $ass): ?>
                            <?php foreach($students as $stud): ?>
                                <div class="row">
                                    <div class="col-lg-1 col-sm-12"></div>
                                    <div class="col-lg-6 col-sm-12">
                                        <h5 style="text-transform: uppercase;">STUDENT NO.: <strong><?= $stud['studentno'] ?></strong></h5>
                                        <h5 style="text-transform: uppercase;">STUDENT: <strong><?= $stud['studfullname']; ?></strong></h5>
                                        <h5 style="text-transform: uppercase;">COURSE: <strong><?php 
                                            foreach($course as $cour) {
                                                if($cour['courid'] == $ass['course']) {
                                                    echo $cour['course'];
                                                }
                                            }
                                        ?></strong></h5>
                                        <h5 style="text-transform: uppercase;">ADDRESS: <strong><?= 
                                            $stud['studstbarangay'] . ' ' . $stud['studcity'] . ' ' . $stud['studprovince']; 
                                        ?></strong></h5>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <h5 style="text-transform: uppercase;">SCHOOL YEAR: <strong><?= $ass['sy']; ?></strong></h5>
                                        <h5 style="text-transform: uppercase;">SEMESTER: <strong><?= $ass['sem']; ?></strong></h5>
                                        <h5 style="text-transform: uppercase;">LEVEL: <strong><?= $ass['level']; ?></strong></h5>
                                        <h5 style="text-transform: uppercase;">SECTION: <strong><?php 
                                            foreach($section as $sec) {
                                                if($sec['secid'] == $ass['course']) {
                                                    echo $sec['section'];
                                                }
                                            }
                                        ?></strong></h5>
                                    </div>
                                    <div class="col-lg-1 col-sm-12"></div>
                                </div>
                            <?php endforeach; ?>
                            <br>
                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center; ">CODE</th>
                                        <th style="text-align: center; ">SUBJECT</th>
                                        <th style="text-align: center; ">UNIT</th>
                                        <th style="text-align: center; ">HRS</th>
                                        <th style="text-align: center; ">SCHEDULE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($colgradesdata as $colgrades):?>
                                        <?php foreach($subject as $subj):?>
                                            <?php if($colgrades['subid'] == $subj['subid']): ?>
                                                <tr>
                                                    <td style="text-align: center; "><?= $subj['subcode']; ?></td>
                                                    <td><?= $subj['subject']; ?></td>
                                                    <td style="text-align: center; "><?= $subj['units']; ?></td>
                                                    <td style="text-align: center; "><?= $subj['hours']; ?></td>
                                                    <td style="text-align: center; "><?php
                                                        foreach($schedule as $sched){
                                                            if($sched['schedsecid'] == $colgrades['section'] && $sched['schedsubid'] == $colgrades['subid']){
                                                                
                                                                if($sched['schedtimeF2'] == '' || $sched['schedtimeF2'] == '00:00:00') {
                                                                    $TIMEF = date('h:i A', strtotime($sched['schedtimeF']));
                                                                    $TIMET = date('h:i A', strtotime($sched['schedtimeT']));
                                                                    echo $TIMEF . ' - ' . $TIMET . '  ' . $sched['schedday'];
                                                                } else {
                                                                    $TIMEF = date('h:i A', strtotime($sched['schedtimeF']));
                                                                    $TIMET = date('h:i A', strtotime($sched['schedtimeT']));
                                                                    $TIMEF2 = date('h:i A', strtotime($sched['schedtimeF2']));
                                                                    $TIMET2 = date('h:i A', strtotime($sched['schedtimeT2']));
                                                                    echo $TIMEF . ' - ' . $TIMET . ' / ' . $sched['schedday'] . '<br>' .$TIMEF2 . ' - ' . $TIMET2 . '  ' . $sched['schedday2'];
                                                                }
                                                                
                                                            }
                                                        }
                                                    ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </tbody>
                                </table>
                            </div>
                            <br>
                            <div style="text-align: center;"><h3>ASSESSMENT OF FEES</h3></div>
                            <br>
                            <div class="row">
                                <div class="col-lg-1 col-sm-12"></div>
                                <div class="col-lg-5 col-sm-12">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-striped" style="font-size: 11px">
                                            <thead>
                                                <tr>
                                                    <th>Tuition Fees</th>
                                                    <th>Subject</th>
                                                    <th>Total Units</th>
                                                    <th>Rate per Hour</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead> 
                                            <tbody>
                                                <tr>
                                                    <td>Regular Subjects</td>
                                                    <td>Major</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Regular Subjects</td>
                                                    <td>Minor</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Fixed Amount</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Total Tuition Fees</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Less Discount(0.00%)</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>TUITION FEES - NET</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>      
                                        </table>
                                    </div>
                                    <br>
                                    <div style="text-align: center;">
                                        <h5><strong>DUE DATES</strong></h5>
                                        <table class="table table-bordered" style="font-size: 12px">
                                            <tbody>
                                                <?php if(empty($duedata)): ?>
                                                    <tr>
                                                        <td>-</td>
                                                        <td>No due date set.</td>
                                                    </tr>
                                                <?php else : ?>
                                                    <?php foreach($duedata as $dued) :?>
                                                        <tr>
                                                            <td><?= $dued['name']; ?></td>
                                                            <td>₱<?= $dued['due']; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-sm-12">
                                    <h5><strong>OTHER FEES:</strong></h5>
                                    <h6><strong>PARTICULARS</strong></h6>
                                    <div style="text-align: left;">
                                        <table>
                                            <tbody>
                                                <?php if(empty($rofdata)): ?>
                                                    <tr>
                                                        <td>-</td>
                                                        <td>No other fees set.</td>
                                                    </tr>
                                                <?php else : ?>
                                                    <?php foreach($rofdata as $rofd) :?>
                                                        <tr>
                                                            <td><?= $rofd['name']; ?></td>
                                                            <td>₱<?= $rofd['otherfees']; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-sm-12"></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End of Page Content -->

    <!-- ----------- FOOTER ------------------ -->
    <?php echo $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?php echo $this->endSection(); ?>