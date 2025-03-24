<?= $this->extend("layouts/base"); ?>

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
                    <?php foreach($accountinfo as $account): ?>
                        <?= form_open('gradesview/result/'.$account['studentno']) ?>
                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <h1>
                                            <?= $account['studln']; ?>, <?= $account['studfn']; ?> <?= $account['studmn']; ?>
                                        <?php endforeach; ?>
                                    </h1>
                                </div>
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
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <table id="datatable" class="table table-striped" data-toggle="data-table" style="font-size: 12px">
                                    <thead>
                                        <tr>
                                            <th>CODE</th>
                                            <th>SUBJECT</th>
                                            <th>TEACHER</th>
                                            <th>PRELIM</th>
                                            <th>MIDTERM</th>
                                            <th>FINALS</th>
                                            <th>SEMESTRAL</th>
                                            <th>EQUIVALENT</th>
                                            <th>REMARKS</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($importedGradeData as $igd):?>
                                            <tr>
                                                <?= form_open('gradesview/update/'.$igd['impgradeid']); ?>
                                                    <td>
                                                        <input type="hidden" name="studnotext" value="<?= $igd['studentno']; ?>">
                                                        <?= $igd['subjectcode']; ?>
                                                    </td>
                                                    <td><?= $igd['subjectdescription']; ?></td>
                                                    <td><?= $igd['teachername']; ?></td>
                                                    <td style="text-align: center;"><input type="text" name="prelimtext" class="form-control" 
                                                        style="width: 70px; height: 25px; text-align: center; color: white;" 
                                                        value="<?= $igd['prelim']; ?>">
                                                    </td>
                                                    <td style="text-align: center;"><input type="text" name="midtermtext" class="form-control" 
                                                        style="width: 70px; height: 25px; text-align: center; color: white;" 
                                                        value="<?= $igd['midterm']; ?>">
                                                    </td>
                                                    <td style="text-align: center;"><input type="text" name="finaltext" class="form-control" 
                                                        style="width: 70px; height: 25px; text-align: center; color: white;" 
                                                        value="<?= $igd['final']; ?>">
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php
                                                            if($igd['prelim'] == 'INC' || $igd['prelim'] == 'UW' || $igd['prelim'] == 'FA' || $igd['prelim'] == ''){
                                                                $PRELIM = '0';
                                                            }else{
                                                                $PRELIM = $igd['prelim'] * .3;
                                                            }
                                            
                                                            if($igd['midterm'] == 'INC' || $igd['midterm'] == 'UW' || $igd['midterm'] == 'FA' || $igd['midterm'] == ''){
                                                                $MIDTERM = '0';
                                                            }else{
                                                                $MIDTERM = $igd['midterm'] * .3;
                                                            }
                                                            
                                                            if($igd['final'] == 'INC' || $igd['final'] == 'UW' || $igd['final'] == 'FA' || $igd['final'] == ''){
                                                                $FINALS = '0';
                                                            }else{
                                                                $FINALS = $igd['final'] * .4;
                                                            }
                                                            
                                                            $SEMESTRAL = $PRELIM + $MIDTERM + $FINALS;
                                                            echo $FORMATED = round($SEMESTRAL, 0);
                                                        ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php 
                                                            if($igd['prelim'] == 'INC' || $igd['prelim'] == 'UW' || $igd['prelim'] == 'FA' || $igd['prelim'] == ''){
                                                                $PRELIM = '0';
                                                            }else{
                                                                $PRELIM = $igd['prelim'] * .3;
                                                            }
                                            
                                                            if($igd['midterm'] == 'INC' || $igd['midterm'] == 'UW' || $igd['midterm'] == 'FA' || $igd['midterm'] == ''){
                                                                $MIDTERM = '0';
                                                            }else{
                                                                $MIDTERM = $igd['midterm'] * .3;
                                                            }
                                                            
                                                            if($igd['final'] == 'INC' || $igd['final'] == 'UW' || $igd['final'] == 'FA' || $igd['final'] == ''){
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
                                                        ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php 
                                                            if($igd['prelim'] == 'INC' || $igd['prelim'] == 'UW' || $igd['prelim'] == 'FA' || $igd['prelim'] == ''){
                                                                $PRELIM = '0';
                                                            }else{
                                                                $PRELIM = $igd['prelim'] * .3;
                                                            }
                                            
                                                            if($igd['midterm'] == 'INC' || $igd['midterm'] == 'UW' || $igd['midterm'] == 'FA' || $igd['midterm'] == ''){
                                                                $MIDTERM = '0';
                                                            }else{
                                                                $MIDTERM = $igd['midterm'] * .3;
                                                            }
                                                            
                                                            if($igd['final'] == 'INC' || $igd['final'] == 'UW' || $igd['final'] == 'FA' || $igd['final'] == ''){
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
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-success btn-sm">
                                                            SAVE
                                                        </button>
                                                    </td>
                                                <?= form_close(); ?>
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
    </div>

    <!-- End of Page Content -->

    <!-- ----------- FOOTER ------------------ -->
    <?= $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?= $this->endSection(); ?>