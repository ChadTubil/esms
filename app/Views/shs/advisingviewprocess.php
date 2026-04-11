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
                        <div class="header-title" >
                            <h4 class="card-title">ADVISING PROCESS</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if(session()->getTempdata('success')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('success');?>
                                </div>
                            <?php endif; ?>
                        <div class="row">
                            <?php foreach($enrollmenthistoryshsdata as $stud): ?>
                            <div class="col-lg-12 col-sm-12">
                                <h5>NAME: <strong><?= $stud['studfullname']; ?></strong></h5>
                                <br>
                                <?= form_open('shs-advising/process/'.$stud['studid']); ?>
                                    <div class="row">
                                        <div class="col-lg-3 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label">STUDENT NO.</label>
                                                <input type="text" name="studnum" class="form-control" value="<?= $stud['studentno']; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label">SCHOOL YEAR</label>
                                                <input type="text" name="sy" class="form-control" value="<?= $stud['sy']; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label">LEVEL</label>
                                                <input type="text" name="level" class="form-control" value="<?= $stud['level']; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label">CLUSTER</label>
                                                <input type="text" name="cluster" class="form-control" value="<?= $stud['code']; ?>" readonly>
                                            </div>
                                        </div>
                                        <?php if(!empty($shsassessmentdata)): ?>
                                            
                                        <?php else: ?>
                                            <div class="col-lg-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">CURRICULUM</label>
                                                    <select name="curriculum" class="form-select" required>
                                                        <?php foreach($shscurriculumdata as $shscurriculumd): ?>
                                                            <option value="<?= $shscurriculumd['currid']; ?>"><?= $shscurriculumd['code']; ?> - <?= $shscurriculumd['sy']; ?> <?= $shscurriculumd['level']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        
                                            <div class="col-lg-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">SECTION</label>
                                                    <select name="section" class="form-select" required>
                                                        <?php foreach($shssectiondata as $shssectiond): ?>
                                                            <option value="<?= $shssectiond['secid']; ?>"><?= $shssectiond['section']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if(empty($shsassessmentdata)): ?>
                                            <div class="col-lg-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">ACTION</label><br>
                                                    <button type="submit" class="btn btn-success" style="width: 100%;"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="PROCESS">
                                                        <span class="btn-inner">
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M12.0001 8.32739V15.6537" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M15.6668 11.9904H8.3335" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.6857 2H7.31429C4.04762 2 2 4.31208 2 7.58516V16.4148C2 19.6879 4.0381 22 7.31429 22H16.6857C19.9619 22 22 19.6879 22 16.4148V7.58516C22 4.31208 19.9619 2 16.6857 2Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg> PROCESS
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                            <?= form_close(); ?>
                                        <?php else: ?>
                                            <div class="col-lg-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">ACTION</label><br>
                                                    <a class="btn btn-success" style="width: 100%;"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="FINALIZE"
                                                        onclick="window.location.href='<?= base_url(); ?>shs-advising/submit-account/<?= $stud['studid']; ?>'">
                                                        <span class="btn-inner">
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.3345 2.75024H7.66549C4.64449 2.75024 2.75049 4.88924 2.75049 7.91624V16.0842C2.75049 19.1112 4.63549 21.2502 7.66549 21.2502H16.3335C19.3645 21.2502 21.2505 19.1112 21.2505 16.0842V7.91624C21.2505 4.88924 19.3645 2.75024 16.3345 2.75024Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                                                <path d="M8.43994 12.0002L10.8139 14.3732L15.5599 9.6272" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                                                            </svg> FINALIZE  
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    
                                    <?php if(!empty($shsassessmentdata)): ?>
                                    <?php else: ?>
                                        <div class="col-lg-3 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label">ACTION</label><br>
                                                <a class="btn btn-danger" style="width: 100%;" data-bs-toggle="tooltip" data-bs-placement="top" title="CANCEL"
                                                    onclick="window.location.href='<?= base_url(); ?>shs-admission/process-cancel/<?= $stud['ehid']; ?>'">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M14.3955 9.59497L9.60352 14.387" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M14.3971 14.3898L9.60107 9.59277" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.3345 2.75024H7.66549C4.64449 2.75024 2.75049 4.88924 2.75049 7.91624V16.0842C2.75049 19.1112 4.63549 21.2502 7.66549 21.2502H16.3335C19.3645 21.2502 21.2505 19.1112 21.2505 16.0842V7.91624C21.2505 4.88924 19.3645 2.75024 16.3345 2.75024Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg> CANCEL                        
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if(empty($shsassessmentdata)): ?>
            <div class="alert alert-warning">
                No assessment data found for this student.
            </div>
        <?php else: ?>
            <?php foreach($shsassessmentdata as $shsassessd): ?>
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="card">
                            <div class="card-header justify-content-between" style="text-align: center;">
                                <div class="header-title">
                                    <h4 class="card-title"><strong>ASSESSMENT OF FEES</strong></h4>
                                </div>
                            </div>
                            <br>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <h5>Student Name: <strong><?= $shsassessd['studfullname']; ?></strong></h5>
                                        <h5>Address: <strong><?= $shsassessd['studstbarangay']; ?> <?= $shsassessd['studcity']; ?>, <?= $shsassessd['studprovince']; ?></strong></h5>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <h5>Level/Class: <strong><?= $shsassessd['level']; ?> - <?= $shsassessd['code']; ?> / <?= $shsassessd['section']; ?></strong></h5>
                                        <h5>School Year: <strong><?= $shsassessd['sy']; ?></strong></h5>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <h5><strong>FIRST SEMESTER</strong></h5>
                                        <div class="table-responsive">
                                            <table class="table" style="font-size: 11px;">
                                                <thead>
                                                    <tr>
                                                        <th>GROUPING</th>
                                                        <th>SUBJECT</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($firstsemester as $firstsem): ?>
                                                        <tr>
                                                            <td><?= $firstsem['type']; ?> SUBJECTS</td>
                                                            <td><?= $firstsem['code']; ?> - <?= $firstsem['subject']; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <h5><strong>SECOND SEMESTER</strong></h5>
                                        <div class="table-responsive">
                                            <table class="table" style="font-size: 11px;">
                                                <thead>
                                                    <tr>
                                                        <th>GROUPING</th>
                                                        <th>SUBJECT</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($secondsemester as $secondseme): ?>
                                                        <tr>
                                                            <td><?= $secondseme['type']; ?> SUBJECTS</td>
                                                            <td><?= $secondseme['code']; ?> - <?= $secondseme['subject']; ?></td>
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
            <?php endforeach; ?>
            <?php foreach($shsratedata as $shsrated): ?>
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-12">
                                        <h5><strong>TUITION FEE</strong></h5>
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table" style="width: 100%;">
                                                <tbody>
                                                    <tr>
                                                        <td>Tuition</td>
                                                        <td style="text-align: right;">₱<?= $shsrated['tf']; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <h5><strong>MISCELLANEOUS FEES</strong></h5>
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table" style="width: 100%;">
                                                <tbody>
                                                    <?php foreach($shsrofdata as $shsrofd): ?>
                                                        <?php if($shsrofd['rateid'] == $shsrated['rateid']): ?>
                                                            <tr>
                                                                <td><?= $shsrofd['name']; ?></td>
                                                                <td style="text-align: right;">₱<?= $shsrofd['otherfees']; ?></td>
                                                            </tr>
                                                        <?php else: ?>
                                                            <p>No miscellaneous fees found.</p>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td style="text-align: right;">Sub Total</td>
                                                        <td style="text-align: right;">
                                                            <?php 
                                                                $totalotherfees = 0;
                                                                foreach($shsrofdata as $shsrofd) {
                                                                    if($shsrofd['rateid'] == $shsrated['rateid']) {
                                                                        $totalotherfees += $shsrofd['otherfees'];
                                                                    }
                                                                }
                                                                echo "₱" . number_format($totalotherfees, 2);
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <div class="table-responsive">
                                            <br>
                                            <br>
                                            <table class="table" style="width: 100%;">
                                                <tbody>
                                                    <tr>
                                                        <td>Tuition</td>
                                                        <td style="text-align: right;">₱<?= $shsrated['tf']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Miscellaneous</td>
                                                        <td style="text-align: right;"><?php 
                                                                $totalotherfees = 0;
                                                                foreach($shsrofdata as $shsrofd) {
                                                                    if($shsrofd['rateid'] == $shsrated['rateid']) {
                                                                        $totalotherfees += $shsrofd['otherfees'];
                                                                    }
                                                                }
                                                                echo "₱" . number_format($totalotherfees, 2);
                                                            ?></td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td style="text-align: right;">Grand Total</td>
                                                        <td style="text-align: right;">
                                                            <?php 
                                                                $grandtotal = $shsrated['tf'] + $totalotherfees;
                                                                echo "₱" . number_format($grandtotal, 2);
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <div class="table-responsive">
                                            <h5><strong>INSTALLMENT SCHEDULE</strong></h5>
                                            <br>
                                            <table class="table" style="width: 100%;">
                                                <tbody>
                                                    <?php foreach($shsrddata as $shsrdd): ?>
                                                        <?php if($shsrdd['rateid'] == $shsrated['rateid']): ?>
                                                            <tr>
                                                                <td><?= $shsrdd['name']; ?></td>
                                                                <td><?php 
                                                                    $formatted = (new DateTime($shsrdd['due']))->format('F j, Y');
                                                                    echo $formatted;
                                                                ?></td>
                                                            </tr>
                                                        <?php else: ?>
                                                            <p>No installment data found.</p>
                                                        <?php endif; ?>
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
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <!-- End of Page Content -->

    <!-- ----------- FOOTER ------------------ -->
    <?= $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?= $this->endSection(); ?>