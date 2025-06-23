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
                    <?php foreach($accountinfo as $account): ?>
                        <?php if($account['studstatus'] == 1 || $account['studstatus'] == 2 || $account['studstatus'] == 3) :?>
                            <div class="card-body">
                                <?= form_open('collegestudentsgradesview') ?>
                                    <div class="row">
                                    
                                        <div class="col-lg-12 col-sm-12">
                                            <h1>
                                                <?php foreach($accountinfo as $account): ?>
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
                                                    <th style="text-align: center;">PRELIM</th>
                                                    <th style="text-align: center;">MIDTERM</th>
                                                    <th style="text-align: center;">FINALS</th>
                                                    <th style="text-align: center;">SEMESTRAL</th>
                                                    <th style="text-align: center;">EQUIVALENT</th>
                                                    <th style="text-align: center;">REMARKS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($importedGradeData as $igd):?>
                                                    <tr>
                                                        <td><?= $igd['subjectcode']; ?></td>
                                                        <td><?= $igd['subjectdescription']; ?></td>
                                                        <td><?= $igd['teachername']; ?></td>
                                                        <?php foreach($accountinfo as $account): ?>
                                                            <?php if($account['studstatus'] == 1 || $account['studstatus'] == 2 || $account['studstatus'] == 3) :?>
                                                                <!-- PRELIM -->
                                                                <td style="text-align: center;"><?= $igd['prelim']; ?></td>
                                                            <?php else : ?>
                                                                <td style="text-align: center;">
                                                                    <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M9.76045 14.3667C9.18545 13.7927 8.83545 13.0127 8.83545 12.1377C8.83545 10.3847 10.2474 8.97168 11.9994 8.97168C12.8664 8.97168 13.6644 9.32268 14.2294 9.89668" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    <path d="M15.1049 12.6987C14.8729 13.9887 13.8569 15.0067 12.5679 15.2407" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M6.65451 17.4722C5.06751 16.2262 3.72351 14.4062 2.74951 12.1372C3.73351 9.85823 5.08651 8.02823 6.68351 6.77223C8.27051 5.51623 10.1015 4.83423 11.9995 4.83423C13.9085 4.83423 15.7385 5.52623 17.3355 6.79123" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    <path d="M19.4473 8.99072C20.1353 9.90472 20.7403 10.9597 21.2493 12.1367C19.2823 16.6937 15.8063 19.4387 11.9993 19.4387C11.1363 19.4387 10.2853 19.2987 9.46729 19.0257" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M19.8868 4.24951L4.11279 20.0235" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    </svg>
                                                                </td>
                                                            <?php endif; ?>
                                                            <?php if($account['studstatus'] == 2 || $account['studstatus'] == 3) :?>
                                                                <!-- MIDTERM -->
                                                                <td style="text-align: center;"><?= $igd['midterm']; ?></td>
                                                            <?php else : ?>
                                                                <td style="text-align: center;">
                                                                    <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M9.76045 14.3667C9.18545 13.7927 8.83545 13.0127 8.83545 12.1377C8.83545 10.3847 10.2474 8.97168 11.9994 8.97168C12.8664 8.97168 13.6644 9.32268 14.2294 9.89668" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    <path d="M15.1049 12.6987C14.8729 13.9887 13.8569 15.0067 12.5679 15.2407" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M6.65451 17.4722C5.06751 16.2262 3.72351 14.4062 2.74951 12.1372C3.73351 9.85823 5.08651 8.02823 6.68351 6.77223C8.27051 5.51623 10.1015 4.83423 11.9995 4.83423C13.9085 4.83423 15.7385 5.52623 17.3355 6.79123" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    <path d="M19.4473 8.99072C20.1353 9.90472 20.7403 10.9597 21.2493 12.1367C19.2823 16.6937 15.8063 19.4387 11.9993 19.4387C11.1363 19.4387 10.2853 19.2987 9.46729 19.0257" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M19.8868 4.24951L4.11279 20.0235" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    </svg>
                                                                </td>
                                                            <?php endif; ?>
                                                            <?php if($account['studstatus'] == 3) :?>
                                                                <!-- FINALS -->    
                                                                <td style="text-align: center;"><?= $igd['final']; ?></td>
                                                            <?php else : ?>
                                                                <td style="text-align: center;">
                                                                    <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M9.76045 14.3667C9.18545 13.7927 8.83545 13.0127 8.83545 12.1377C8.83545 10.3847 10.2474 8.97168 11.9994 8.97168C12.8664 8.97168 13.6644 9.32268 14.2294 9.89668" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    <path d="M15.1049 12.6987C14.8729 13.9887 13.8569 15.0067 12.5679 15.2407" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M6.65451 17.4722C5.06751 16.2262 3.72351 14.4062 2.74951 12.1372C3.73351 9.85823 5.08651 8.02823 6.68351 6.77223C8.27051 5.51623 10.1015 4.83423 11.9995 4.83423C13.9085 4.83423 15.7385 5.52623 17.3355 6.79123" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    <path d="M19.4473 8.99072C20.1353 9.90472 20.7403 10.9597 21.2493 12.1367C19.2823 16.6937 15.8063 19.4387 11.9993 19.4387C11.1363 19.4387 10.2853 19.2987 9.46729 19.0257" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M19.8868 4.24951L4.11279 20.0235" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    </svg>
                                                                </td>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?> 
                                                        <td style="text-align: center;">
                                                            <?php
                                                                if($igd['prelim'] == '' || $igd['prelim'] == 'INC' || $igd['prelim'] == 'UW'){
                                                                    $PRELIM = '0';
                                                                }else{
                                                                    $PRELIM = $igd['prelim'] * .3;
                                                                }

                                                                if($igd['midterm'] == '' || $igd['midterm'] == 'INC' || $igd['midterm'] == 'UW'){
                                                                    $MIDTERM = '0';
                                                                }else{
                                                                    $MIDTERM = $igd['midterm'] * .3;
                                                                }
                                                                
                                                                if($igd['final'] == '' || $igd['final'] == 'INC' || $igd['final'] == 'UW'){
                                                                    $FINALS = '0';
                                                                }else{
                                                                    $FINALS = $igd['final'] * .4;
                                                                }
                                                                
                                                                $SEMESTRAL = $PRELIM + $MIDTERM + $FINALS;
                                                                if($account['studstatus'] == 3) {
                                                                    echo $FORMATED = round($SEMESTRAL, 0);
                                                                } else {
                                                                    echo 
                                                                    '
                                                                        <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M9.76045 14.3667C9.18545 13.7927 8.83545 13.0127 8.83545 12.1377C8.83545 10.3847 10.2474 8.97168 11.9994 8.97168C12.8664 8.97168 13.6644 9.32268 14.2294 9.89668" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M15.1049 12.6987C14.8729 13.9887 13.8569 15.0067 12.5679 15.2407" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M6.65451 17.4722C5.06751 16.2262 3.72351 14.4062 2.74951 12.1372C3.73351 9.85823 5.08651 8.02823 6.68351 6.77223C8.27051 5.51623 10.1015 4.83423 11.9995 4.83423C13.9085 4.83423 15.7385 5.52623 17.3355 6.79123" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M19.4473 8.99072C20.1353 9.90472 20.7403 10.9597 21.2493 12.1367C19.2823 16.6937 15.8063 19.4387 11.9993 19.4387C11.1363 19.4387 10.2853 19.2987 9.46729 19.0257" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M19.8868 4.24951L4.11279 20.0235" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        </svg>
                                                                    ';
                                                                }
                                                                
                                                            ?>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <?php 
                                                                if($igd['prelim'] == '' || $igd['prelim'] == 'INC' || $igd['prelim'] == 'UW'){
                                                                    $PRELIM = '0';
                                                                }else{
                                                                    $PRELIM = $igd['prelim'] * .3;
                                                                }

                                                                if($igd['midterm'] == '' || $igd['midterm'] == 'INC' || $igd['midterm'] == 'UW'){
                                                                    $MIDTERM = '0';
                                                                }else{
                                                                    $MIDTERM = $igd['midterm'] * .3;
                                                                }
                                                                
                                                                if($igd['final'] == '' || $igd['final'] == 'INC' || $igd['final'] == 'UW'){
                                                                    $FINALS = '0';
                                                                }else{
                                                                    $FINALS = $igd['final'] * .4;
                                                                }

                                                                $SEMESTRAL = $PRELIM + $MIDTERM + $FINALS;
                                                                $FORMATED = round($SEMESTRAL, 0);
                                                                if($account['studstatus'] == 3) {
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
                                                                    }else if($FORMATED <= '74'){
                                                                        echo '5.00';
                                                                    }
                                                                } else {
                                                                    echo 
                                                                    '
                                                                        <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M9.76045 14.3667C9.18545 13.7927 8.83545 13.0127 8.83545 12.1377C8.83545 10.3847 10.2474 8.97168 11.9994 8.97168C12.8664 8.97168 13.6644 9.32268 14.2294 9.89668" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M15.1049 12.6987C14.8729 13.9887 13.8569 15.0067 12.5679 15.2407" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M6.65451 17.4722C5.06751 16.2262 3.72351 14.4062 2.74951 12.1372C3.73351 9.85823 5.08651 8.02823 6.68351 6.77223C8.27051 5.51623 10.1015 4.83423 11.9995 4.83423C13.9085 4.83423 15.7385 5.52623 17.3355 6.79123" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M19.4473 8.99072C20.1353 9.90472 20.7403 10.9597 21.2493 12.1367C19.2823 16.6937 15.8063 19.4387 11.9993 19.4387C11.1363 19.4387 10.2853 19.2987 9.46729 19.0257" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M19.8868 4.24951L4.11279 20.0235" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        </svg>
                                                                    ';
                                                                }
                                                            ?>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <?php 
                                                                if($igd['prelim'] == '' || $igd['prelim'] == 'INC' || $igd['prelim'] == 'UW'){
                                                                    $PRELIM = '0';
                                                                }else{
                                                                    $PRELIM = $igd['prelim'] * .3;
                                                                }

                                                                if($igd['midterm'] == '' || $igd['midterm'] == 'INC' || $igd['midterm'] == 'UW'){
                                                                    $MIDTERM = '0';
                                                                }else{
                                                                    $MIDTERM = $igd['midterm'] * .3;
                                                                }
                                                                
                                                                if($igd['final'] == '' || $igd['final'] == 'INC' || $igd['final'] == 'UW'){
                                                                    $FINALS = '0';
                                                                }else{
                                                                    $FINALS = $igd['final'] * .4;
                                                                }
                                                                
                                                                $SEMESTRAL = $PRELIM + $MIDTERM + $FINALS;
                                                                $FORMATED = round($SEMESTRAL, 0);
                                                                if($account['studstatus'] == 3) {
                                                                    if($FORMATED >= '75' && $FORMATED <= '100'){
                                                                        echo 'PASSED';
                                                                    }else if($FORMATED <= '74'){
                                                                        echo 'FAILED';
                                                                    }else if($PRELIM == 'INC' || $MIDTERM == 'INC' || $FINALS == 'INC'){
                                                                        echo 'INC';
                                                                    }else{
                                                                        echo 'UW';
                                                                    }
                                                                } else {
                                                                    echo 
                                                                    '
                                                                        <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M9.76045 14.3667C9.18545 13.7927 8.83545 13.0127 8.83545 12.1377C8.83545 10.3847 10.2474 8.97168 11.9994 8.97168C12.8664 8.97168 13.6644 9.32268 14.2294 9.89668" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M15.1049 12.6987C14.8729 13.9887 13.8569 15.0067 12.5679 15.2407" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M6.65451 17.4722C5.06751 16.2262 3.72351 14.4062 2.74951 12.1372C3.73351 9.85823 5.08651 8.02823 6.68351 6.77223C8.27051 5.51623 10.1015 4.83423 11.9995 4.83423C13.9085 4.83423 15.7385 5.52623 17.3355 6.79123" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M19.4473 8.99072C20.1353 9.90472 20.7403 10.9597 21.2493 12.1367C19.2823 16.6937 15.8063 19.4387 11.9993 19.4387C11.1363 19.4387 10.2853 19.2987 9.46729 19.0257" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M19.8868 4.24951L4.11279 20.0235" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        </svg>
                                                                    ';
                                                                }
                                                            ?>
                                                        </td>
                                                        
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php else :?>
                            <div class="card-body">
                                <h1>PLEASE GO TO MIS DEPARTMENT FOR THE ACTIVATION OF YOUR ACCOUNT. 
                                SO YOU CAN VIEW YOUR GRADES. PLEASE BRING YOUR UPDATED RECEIPT. THANK YOU!</h1>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?> 
                </div>
            </div>
        </div>
    </div>

    <!-- End of Page Content -->

    <!-- ----------- FOOTER ------------------ -->
    <?php echo $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?php echo $this->endSection(); ?>