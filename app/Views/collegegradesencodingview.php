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
                    <div class="card-body">
                        <?= form_open('grades-college') ?>
                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SCHOOL YEAR</label>
                                    <select name="schoolyear" class="form-select" id="exampleFormControlSelect1" required>
                                        <?php foreach ($selectedsy as $ssy): ?>
                                            <option value="<?php echo $ssy['syname']; ?>" selected><?php echo $ssy['syname']; ?></option>
                                        <?php endforeach; ?>
                                        <?php foreach ($schoolyeardata as $syd): ?>
                                            <option value="<?php echo $syd['syname']; ?>"><?php echo $syd['syname']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SEMESTER</label>
                                    <select name="semester" class="form-select" id="exampleFormControlSelect1" required>
                                        <?php foreach ($selectedsem as $ssem): ?>
                                            <option value="<?php echo $ssem['semester']; ?>" selected><?php echo $ssem['semester']; ?></option>
                                        <?php endforeach; ?>
                                        <?php foreach ($semesterdata as $semd): ?>
                                            <option value="<?php echo $semd['semester']; ?>"><?php echo $semd['semester']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <button class="btn btn-success" type="submit" name="add" style="width: 100%; height: 100%;">VIEW GRADES</button>
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
                            <h4 class="card-title"></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <?php if(session()->getTempdata('error')) :?>
                                <div class="alert alert-danger">
                                    <?= session()->getTempdata('error');?>
                                </div>
                            <?php endif; ?>
                            <?php if(session()->getTempdata('updatesuccess')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('updatesuccess');?>
                                </div>
                            <?php endif; ?>
                            <table id="datatable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>STUDENT NO</th>
                                        <th>NAME</th>
                                        <th style="text-align: center;">PRELIM</th>
                                        <th style="text-align: center;">MIDTERM</th>
                                        <th style="text-align: center;">FINAL</th>
                                        <th style="text-align: center;">SEMESTRAL</th>
                                        <th style="text-align: center;">EQUIVALENT</th>
                                        <th style="text-align: center;">REMARKS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?= form_open('grades-college-encoding-submit'); ?>
                                    <?php foreach($importedGradeData as $igd):?>
                                        <tr>
                                            
                                                <td><?= $igd['studentno']; ?></td>
                                                <td>
                                                    <?= $igd['lname']; ?>, <?= $igd['fname']; ?>
                                                    <input type="hidden" name="schedid" value="<?= $igd['scheduleid']; ?>">
                                                    <input type="hidden" name="id[]" value="<?= $igd['impgradeid']; ?>">
                                                </td>
                                                <td ><input type="text" name="prelim[]" class="form-control" 
                                                    style="width: 100px; height: 30px; text-align: center; color: white;" value="<?= $igd['prelim']; ?>"></td>
                                                <td><input type="text" name="midterm[]" class="form-control" 
                                                    style="width: 100px; height: 30px; text-align: center; color: white;" value="<?= $igd['midterm']; ?>"></td>
                                                <td><input type="text" name="final[]" class="form-control" 
                                                    style="width: 100px; height: 30px; text-align: center; color: white;" value="<?= $igd['final']; ?>"></td>
                                                <td style="text-align: center;"><strong><?= $igd['semestral']; ?></strong></td>
                                                <td style="text-align: center;"><strong>
                                                    <?php 
                                                        if($igd['prelim'] == 'INC' || $igd['prelim'] == 'UW' || $igd['prelim'] == 'FA' || $igd['prelim'] == '' || $igd['prelim'] == 'inc' || $igd['prelim'] == 'uw' || $igd['prelim'] == 'fa'){
                                                            $PRELIM = '0';
                                                        }else{
                                                            $PRELIM = $igd['prelim'] * .3;
                                                        }
                                        
                                                        if($igd['midterm'] == 'INC' || $igd['midterm'] == 'UW' || $igd['midterm'] == 'FA' || $igd['midterm'] == '' || $igd['midterm'] == 'inc' || $igd['midterm'] == 'uw' || $igd['midterm'] == 'fa'){
                                                            $MIDTERM = '0';
                                                        }else{
                                                            $MIDTERM = $igd['midterm'] * .3;
                                                        }
                                                        
                                                        if($igd['final'] == 'INC' || $igd['final'] == 'UW' || $igd['final'] == 'FA' || $igd['final'] == '' || $igd['final'] == 'inc' || $igd['final'] == 'uw' || $igd['final'] == 'fa'){
                                                            $FINALS = '0';
                                                        }else{
                                                            $FINALS = $igd['final'] * .4;
                                                        }

                                                        $SEMESTRAL = $PRELIM + $MIDTERM + $FINALS;
                                                        $FORMATED = round($SEMESTRAL, 0);

                                                        if($FORMATED >= '97' && $FORMATED <= '100'){
                                                            echo '1.00';
                                                        }else if($FORMATED >= '94' && $FORMATED <= '96'){
                                                            echo '1.25';
                                                        }else if($FORMATED >= '91' && $FORMATED <= '93'){
                                                            echo '1.50';
                                                        }else if($FORMATED >= '88' && $FORMATED <= '90'){
                                                            echo '1.75';
                                                        }else if($FORMATED >= '85' && $FORMATED <= '87'){
                                                            echo '2.00';
                                                        }else if($FORMATED >= '82' && $FORMATED <= '84'){
                                                            echo '2.25';
                                                        }else if($FORMATED >= '79' && $FORMATED <= '81'){
                                                            echo '2.50';
                                                        }else if($FORMATED >= '76' && $FORMATED <= '78'){
                                                            echo '2.75';
                                                        }else if($FORMATED == '75' ){
                                                            echo '3.00';
                                                        }else if($FORMATED == '74'){
                                                            echo '5.00';
                                                        }else if($igd['prelim'] == 'INC' || $igd['prelim'] == 'inc' || $igd['midterm'] == 'INC' || $igd['midterm'] == 'inc' || $igd['final'] == 'INC' || $igd['final'] == 'inc'){
                                                            echo 'INC';
                                                        }else{
                                                            echo 'FA';
                                                        }
                                                    ?></strong>
                                                </td>
                                                <td style="text-align: center;"><strong>
                                                    <?php 
                                                        if($igd['prelim'] == 'INC' || $igd['prelim'] == 'UW' || $igd['prelim'] == 'FA' || $igd['prelim'] == '' || $igd['prelim'] == 'inc' || $igd['prelim'] == 'uw' || $igd['prelim'] == 'fa'){
                                                            $PRELIM = '0';
                                                        }else{
                                                            $PRELIM = $igd['prelim'] * .3;
                                                        }
                                        
                                                        if($igd['midterm'] == 'INC' || $igd['midterm'] == 'UW' || $igd['midterm'] == 'FA' || $igd['midterm'] == '' || $igd['midterm'] == 'inc' || $igd['midterm'] == 'uw' || $igd['midterm'] == 'fa'){
                                                            $MIDTERM = '0';
                                                        }else{
                                                            $MIDTERM = $igd['midterm'] * .3;
                                                        }
                                                        
                                                        if($igd['final'] == 'INC' || $igd['final'] == 'UW' || $igd['final'] == 'FA' || $igd['final'] == '' || $igd['final'] == 'inc' || $igd['final'] == 'uw' || $igd['final'] == 'fa'){
                                                            $FINALS = '0';
                                                        }else{
                                                            $FINALS = $igd['final'] * .4;
                                                        }
                                                        
                                                        $SEMESTRAL = $PRELIM + $MIDTERM + $FINALS;
                                                        $FORMATED = round($SEMESTRAL, 0);

                                                        if($FORMATED >= '75' || $FORMATED == '100'){
                                                            echo 'PASSED';
                                                        }else if($igd['prelim'] == 'INC' || $igd['prelim'] == 'inc' || $igd['midterm'] == 'INC' || $igd['midterm'] == 'inc' || $igd['final'] == 'INC' || $igd['final'] == 'inc'){
                                                            echo 'INC';
                                                        }else if($igd['prelim'] == 'UW' || $igd['midterm'] == 'UW' || $igd['final'] == 'UW'){
                                                            echo 'UW';
                                                        }else{
                                                            echo 'FAILED';
                                                        }
                                                    ?></strong>
                                                </td>
                                            
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <button class="btn btn-m btn-icon btn-success" style="width: 100%; height: 100px;">SAVE</button>
                            <?= form_close(); ?>
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