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
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <?php if(session()->getTempdata('success')) :?>
                            <div class="alert alert-success">
                                <?= session()->getTempdata('success');?>
                            </div>
                        <?php endif; ?>
                        <?php foreach($assessment as $assess) : ?>
                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <h1><?php
                                        foreach($studdata as $sd) {
                                            if($sd['studid'] == $assess['studentno']){
                                                echo $sd['studfullname'];
                                            }
                                        }
                                    ?></h1>
                                </div>
                                <div class="col-lg-2">
                                    <br>
                                    <label class="form-label" for="validationDefault01">STUDENT NUMBER</label>
                                    <input type="text" class="form-control" value="<?php
                                        foreach($studdata as $sd) {
                                            if($sd['studid'] == $assess['studentno']){
                                                echo $sd['studentno'];
                                            }
                                        }
                                    ?>" disabled>
                                </div>
                                <div class="col-lg-4">
                                    <br>
                                    <label class="form-label" for="validationDefault01">COURSE</label>
                                    <input type="text" class="form-control" value="<?php
                                            foreach($course as $c) {
                                                if($c['courid'] == $assess['course']) {
                                                    echo $c['courcode']." - ".$c['course'];
                                                }
                                            }
                                        ?>" disabled>
                                </div>
                                <div class="col-lg-2">
                                    <br>
                                    <label class="form-label" for="validationDefault01">SCHOOL YEAR</label>
                                    <input type="text" class="form-control" value="<?= $assess['sy']; ?>" disabled>
                                </div>
                                <div class="col-lg-2">
                                    <br>
                                    <label class="form-label" for="validationDefault01">SEMESTER</label>
                                    <input type="text" class="form-control" value="<?= $assess['sem']; ?>" disabled>
                                </div>
                                <div class="col-lg-2">
                                    <br>
                                    <label class="form-label" for="validationDefault01">YEAR LEVEL</label>
                                    <input type="text" class="form-control" value="<?= $assess['level']; ?>" disabled>
                                </div>
                                <div class="col-lg-3">
                                    <br>
                                    <label class="form-label" for="validationDefault01">CURRICULUM</label>
                                    <input type="text" class="form-control" value="<?php
                                        foreach($curriculumdata as $curriculumd) {
                                            if($curriculumd['currid'] == $assess['curriculum']){
                                                echo $curriculumd['course']." - ".$curriculumd['sy'];
                                            }
                                        }
                                    ?>" disabled>
                                </div>
                                <div class="col-lg-3">
                                    <br>
                                    <label class="form-label" for="validationDefault01">SECTION</label>
                                    <input type="text" class="form-control" value="<?php
                                        foreach($secdata as $secd) {
                                            if($secd['secid'] == $assess['section']){
                                                echo $secd['section'];
                                            }
                                        }
                                    ?>" disabled>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="row" style="margin: 10px;">
                        <div class="col-lg-2 col-sm-12">
                            <button class="btn btn-primary" style="width: 100%;">ADD SUBJECT</button>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <button class="btn btn-success" style="width: 100%;"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Save Assessment"
                            onclick="window.location.href='<?= base_url(); ?>assessment/process/<?= $assess['studentno']; ?>'">SAVE</button>
                        </div>
                    </div>
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">SUBJECTS</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <?php if(session()->getTempdata('processsuccess')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('processsuccess');?>
                                </div>
                            <?php endif; ?>
                            <?php if(session()->getTempdata('processnotsuccess')) :?>
                                <div class="alert alert-danger">
                                    <?= session()->getTempdata('processnotsuccess');?>
                                </div>
                            <?php endif; ?>
                            <table id="datatable" class="table table-striped" style="font-size: 12px">
                                <thead>
                                    <tr>
                                        <th>CODE</th>
                                        <th>SUBJECT</th>
                                        <th style="text-align: center;">UNIT</th>
                                        <th style="text-align: center;">HOURS</th>
                                        <th style="text-align: center;">DAY</th>
                                        <th style="text-align: center;">TIME</th>
                                        <th style="text-align: center;">SECTION</th>
                                        <th style="text-align: center;">AVAILABILITY</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($colgradesdata as $colgradesd) : ?>
                                        <tr>
                                            <td><?php
                                                foreach($subdata as $subd) {
                                                    if($subd['subid'] == $colgradesd['subid']){
                                                        echo $subd['subcode'];
                                                    }
                                                }
                                            ?></td>
                                            <td><?php
                                                foreach($subdata as $subd) {
                                                    if($subd['subid'] == $colgradesd['subid']){
                                                        echo $subd['subject'];
                                                    }
                                                }
                                            ?></td>
                                            <td style="text-align: center;"><?php
                                                foreach($subdata as $subd) {
                                                    if($subd['subid'] == $colgradesd['subid']){
                                                        echo $subd['units'];
                                                    }
                                                }
                                            ?></td>
                                            <td style="text-align: center;"><?php
                                                foreach($subdata as $subd) {
                                                    if($subd['subid'] == $colgradesd['subid']){
                                                        echo $subd['hours'];
                                                    }
                                                }
                                            ?></td>
                                            <td style="text-align: center;"><?php
                                                foreach($scheddata as $schedd) {
                                                    if($schedd['schedsecid'] == $colgradesd['section'] && $schedd['schedsubid'] == $colgradesd['subid']){
                                                        if($schedd['schedday2'] == '') {
                                                            echo $schedd['schedday'];
                                                        }else{
                                                            echo $schedd['schedday']."<br>".$schedd['schedday2'];
                                                        }
                                                        
                                                    }
                                                }
                                            ?></td>
                                            <td style="text-align: center;"><?php
                                                foreach($scheddata as $schedd) {
                                                    if($schedd['schedsecid'] == $colgradesd['section'] && $schedd['schedsubid'] == $colgradesd['subid']){
                                                        if($schedd['schedtimeF2'] == '' || $schedd['schedtimeF2'] == '00:00:00') {
                                                            $TIMEF = date('h:i A', strtotime($schedd['schedtimeF']));
                                                            $TIMET = date('h:i A', strtotime($schedd['schedtimeT']));
                                                            echo $TIMEF." - ".$TIMET;
                                                        }else{
                                                            $TIMEF = date('h:i A', strtotime($schedd['schedtimeF']));
                                                            $TIMET = date('h:i A', strtotime($schedd['schedtimeT']));
                                                            $TIMEF2 = date('h:i A', strtotime($schedd['schedtimeF2']));
                                                            $TIMET2 = date('h:i A', strtotime($schedd['schedtimeT2']));
                                                            echo $TIMEF." - ".$TIMET."<br>".$TIMEF2." - ".$TIMET2;
                                                        }
                                                        
                                                    }
                                                }
                                            ?></td>
                                            <td style="text-align: center;"><?php
                                                foreach($secdata as $secd) {
                                                    if($secd['secid'] == $colgradesd['section']){
                                                        echo $secd['section'];
                                                    }
                                                }
                                            ?></td>
                                            <td style="text-align: center;"><?php
                                                foreach($scheddata as $schedd) {
                                                    if($schedd['schedsecid'] == $colgradesd['section'] && $schedd['schedsubid'] == $colgradesd['subid']){
                                                        echo $schedd['schedmaxstudent'];
                                                        
                                                    }
                                                }
                                            ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Change Schedule"
                                                    onclick="window.location.href='<?= base_url(); ?>assessment/viewsubjects/<?= $colgradesd['colgradeid']; ?>';">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7366 2.76175H8.08455C6.00455 2.75375 4.29955 4.41075 4.25055 6.49075V17.3397C4.21555 19.3897 5.84855 21.0807 7.89955 21.1167C7.96055 21.1167 8.02255 21.1167 8.08455 21.1147H16.0726C18.1416 21.0937 19.8056 19.4087 19.8026 17.3397V8.03975L14.7366 2.76175Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M14.4741 2.75V5.659C14.4741 7.079 15.6231 8.23 17.0431 8.234H19.7971" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M14.2936 12.9141H9.39355" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M11.8442 15.3639V10.4639" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                          
                                                        </svg>                       
                                                    </span>CHANGE
                                                </button>
                                                <button class="btn btn-sm btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Change Schedule"
                                                    onclick="window.location.href='<?= base_url(); ?>assessment/viewsubjects/<?= $colgradesd['colgradeid']; ?>';">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7366 2.76175H8.08455C6.00455 2.75375 4.29955 4.41075 4.25055 6.49075V17.3397C4.21555 19.3897 5.84855 21.0807 7.89955 21.1167C7.96055 21.1167 8.02255 21.1167 8.08455 21.1147H16.0726C18.1416 21.0937 19.8056 19.4087 19.8026 17.3397V8.03975L14.7366 2.76175Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M14.4741 2.75V5.659C14.4741 7.079 15.6231 8.23 17.0431 8.234H19.7971" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M14.2936 12.9141H9.39355" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M11.8442 15.3639V10.4639" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                          
                                                        </svg>                       
                                                    </span>DROP
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">ASSESSMENT</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-1 col-sm-12"></div>
                            <div class="col-lg-4 col-sm-12" style="text-align: center; font-size: 12px;">
                                <h5>MAJOR</h5>
                                <br>
                                <div style="text-align: left;">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>NO. OF UNITS: </td>
                                                <td><strong><?php 
                                                    foreach($totalmajorunits as $majorunits) {
                                                        echo $majorunits['totalmajorunits'];
                                                    }
                                                ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>NO. OF HOURS: </td>
                                                <td><strong><?php 
                                                    foreach($totalmajorhours as $majorhours) {
                                                        echo $majorhours['totalmajorhours'];
                                                    }
                                                ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>RATE: </td>
                                                <td><strong>₱<?php 
                                                    foreach($ratesdata as $ratesd) {
                                                        echo $ratesd['major'];
                                                    }
                                                ?></strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <h4>MINOR</h4>
                                <br>
                                <div style="text-align: left;">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>NO. OF UNITS: </td>
                                                <td><strong><?php 
                                                    foreach($totalminorunits as $minorunits) {
                                                        echo $minorunits['totalminorunits'];
                                                    }
                                                ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>NO. OF HOURS: </td>
                                                <td><strong><?php 
                                                    foreach($totalminorhours as $minorhours) {
                                                        echo $minorhours['totalminorhours'];
                                                    }
                                                ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>RATE: </td>
                                                <td><strong>₱<?php 
                                                    foreach($ratesdata as $ratesd) {
                                                        echo $ratesd['minor'];
                                                    }
                                                ?></strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>FIXED AMOUNT: </td>
                                                <td><strong>₱<?php 
                                                    foreach($ratesdata as $ratesd) {
                                                        if($ratesd['nstp02'] == '0.00' || $ratesd['nstp02'] == '') {
                                                            echo $ratesd['nstp01'];
                                                        } else {
                                                            echo $ratesd['nstp02'];
                                                        }
                                                    }
                                                ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>TUITION FEE: </td>
                                                <td><strong>₱<?php 
                                                    foreach($totalmajorhours as $majorhours) {
                                                        $TOTALMAJORHOURS = $majorhours['totalmajorhours'];
                                                    }
                                                    foreach($ratesdata as $ratesd) {
                                                        $MAJORRATE = $ratesd['major'];
                                                    }
                                                    $MAJORSUM = $TOTALMAJORHOURS * $MAJORRATE;
                                                    foreach($totalminorhours as $minorhours) {
                                                        $TOTALMINORHOURS = $minorhours['totalminorhours'];
                                                    }
                                                    foreach($ratesdata as $ratesd) {
                                                        $MINORRATE = $ratesd['minor'];
                                                    }
                                                    $MINORSUM = $TOTALMINORHOURS * $MINORRATE;
                                                    echo $TUITIONFEE = $MAJORSUM + $MINORSUM;
                                                ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>OTHER FEE TOTAL: </td>
                                                <td><strong>₱<?php 
                                                    foreach($totalotherfees as $tof) {
                                                        echo $tof['totalrof'];
                                                    }
                                                ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>GRAND TOTAL: </td>
                                                <td><strong><?php 
                                                    foreach($totalmajorhours as $majorhours) {
                                                        $TOTALMAJORHOURS = $majorhours['totalmajorhours'];
                                                    }
                                                    foreach($ratesdata as $ratesd) {
                                                        $MAJORRATE = $ratesd['major'];
                                                    }
                                                    $MAJORSUM = $TOTALMAJORHOURS * $MAJORRATE;
                                                    foreach($totalminorhours as $minorhours) {
                                                        $TOTALMINORHOURS = $minorhours['totalminorhours'];
                                                    }
                                                    foreach($ratesdata as $ratesd) {
                                                        $MINORRATE = $ratesd['minor'];
                                                    }
                                                    $MINORSUM = $TOTALMINORHOURS * $MINORRATE;
                                                    $TUITIONFEE = $MAJORSUM + $MINORSUM;

                                                    foreach($totalotherfees as $tof) {
                                                        $totalotherfees = $tof['totalrof'];
                                                    }

                                                    foreach($ratesdata as $ratesd) {
                                                        if($ratesd['nstp02'] == '0.00' || $ratesd['nstp02'] == '') {
                                                            $FIXEDTOTAL = $ratesd['nstp01'];
                                                        } else {
                                                            $FIXEDTOTAL = $ratesd['nstp02'];
                                                        }
                                                    }

                                                    echo '₱'.$GRANDTOTAL = $TUITIONFEE + $totalotherfees + $FIXEDTOTAL;
                                                ?></strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-1 col-sm-12"></div>
                            <div class="col-lg-1 col-sm-12"></div>
                            <div class="col-lg-4 col-sm-12" style="text-align: center; font-size: 12px;">
                                <h4>OTHER FEE</h4>
                                <br>
                                <div style="text-align: left;">
                                    <table class="table table-bordered">
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