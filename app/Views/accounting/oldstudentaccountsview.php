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
                            <?php if(session()->getTempdata('deletesuccess')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('deletesuccess');?>
                                </div>
                            <?php endif; ?>
                            <?php if(session()->getTempdata('activatesuccess')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('activatesuccess');?>
                                </div>
                            <?php endif; ?>
                            <?php if(session()->getTempdata('updatesuccess')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('updatesuccess');?>
                                </div>
                            <?php endif; ?>
                        <?php echo form_open('student-accounts'); ?> 
                            <div class="row">
                                <div class="col-lg-9 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SEARCH STUDENT</label>
                                    <input type="text" name="searchstud" class="form-control"
                                    placeholder="Search Student Number | Student Name">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <button class="btn btn-success" type="submit" name="add" style="width: 100%; height: 100%;">SEACH STUDENT</button>
                                </div>
                            </div>
                        <?php echo form_close(); ?>    
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <?php foreach($studentdata as $studentd): ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <h2 style="text-transform: uppercase;"><?= $studentd['studfullname']; ?></h2>
                                    <h4><strong>Student No: <?= $studentd['studentno']; ?></strong></h4>
                                </div>
                                <div class="col-md-6 text-end">
                                    <!-- <a href="<?= base_url(); ?>books-assessment/<?= $studentd['studentno']; ?>" class="btn btn-warning me-2">
                                        <i class="bi bi-journal-text"></i> Buy Book
                                    </a>
                                    <a href="<?= base_url(); ?>uniforms-assessment/<?= $studentd['studentno']; ?>" class="btn btn-primary me-2">
                                        <i class="bi bi-journal-text"></i> Buy Uniform
                                    </a> -->
                                    <a href="<?= base_url(); ?>student-accounts/view/<?= $studentd['studentno']; ?>" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i> Back to Accounts
                                    </a>
                                </div>
                                <?php if(session()->getTempdata('paymentmessage')) :?>
                                    <div class="alert alert-info">
                                        <?= session()->getTempdata('paymentmessage');?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">ADD ACCOUNT</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <?= form_open('old-student-accounts/view/'.$studentd['studentno']); ?>
                            <div class="row">
                                <div class="col-lg-2 col-sm-12">
                                    <label class="form-label">SCHOOL YEAR</label>
                                    <select name="sy" class="form-select">
                                        <option value="">-</option>
                                        <?php foreach($sydata as $syd): ?>
                                            <option value="<?= $syd['syname']; ?>"><?= $syd['syname']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label class="form-label">SEMESTER</label>
                                    <select name="sem" class="form-select">
                                        <option value="">-</option>
                                        <?php foreach($semdata as $semd): ?>
                                            <option value="<?= $semd['semester']; ?>"><?= $semd['semester']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label class="form-label">COURSE</label>
                                    <select name="course" class="form-select">
                                        <option value="">-</option>
                                        <?php foreach($coursedata as $coursed): ?>
                                            <option value="<?= $coursed['code']; ?>"><?= $coursed['code']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label class="form-label">CLUSTER</label>
                                    <select name="cluster" class="form-select">
                                        <option value="">-</option>
                                        <?php foreach($clusterdata as $clusterd): ?>
                                            <option value="<?= $clusterd['code']; ?>"><?= $clusterd['code']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label class="form-label">LEVEL</label>
                                    <select name="level" class="form-select">
                                        <option value="">-</option>
                                        <option value="KINDER 1">KINDER 1</option>
                                        <option value="KINDER 2">KINDER 2</option>
                                        <option value="GRADE 1">GRADE 1</option>
                                        <option value="GRADE 2">GRADE 2</option>
                                        <option value="GRADE 3">GRADE 3</option>
                                        <option value="GRADE 4">GRADE 4</option>
                                        <option value="GRADE 5">GRADE 5</option>
                                        <option value="GRADE 6">GRADE 6</option>
                                        <option value="GRADE 7">GRADE 7</option>
                                        <option value="GRADE 8">GRADE 8</option>
                                        <option value="GRADE 9">GRADE 9</option>
                                        <option value="GRADE 10">GRADE 10</option>
                                        <option value="Grade 11">GRADE 11</option>
                                        <option value="Grade 12">GRADE 12</option>
                                        <option value="1st Year">1st Year</option>
                                        <option value="2nd Year">2nd Year</option>
                                        <option value="3rd Year">3rd Year</option>
                                        <option value="4th Year">4th Year</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label class="form-label">ACTION</label>
                                    <button class="btn btn-success" type="submit" name="add" style="width: 100%;">ADD</button>
                                </div>
                            </div>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>                        
        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">ACCOUNTS</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td style="text-align: center;">NO</td>
                                        <td style="text-align: center;">SY</td>
                                    </tr>
                                    <?php foreach($studentaccountsdata as $studentaccountsd): ?>
                                        <tr>
                                            <td style="text-align: center;"> <a class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Account Details"
                                                    onclick="window.location.href='<?= base_url(); ?>student-accounts/view/details/<?= $studentaccountsd['studentno']; ?>/<?= $studentaccountsd['said']; ?>'">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M21.25 16.334V7.665C21.25 4.645 19.111 2.75 16.084 2.75H7.916C4.889 2.75 2.75 4.635 2.75 7.665L2.75 16.334C2.75 19.364 4.889 21.25 7.916 21.25H16.084C19.111 21.25 21.25 19.364 21.25 16.334Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M16.0861 12H7.91406" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M12.3223 8.25205L16.0863 12L12.3223 15.748" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                    </span><?= $studentaccountsd['said']; ?>
                                                </a></td>
                                            <td style="text-align: left;"><?= $studentaccountsd['sy']; ?> - <?= $studentaccountsd['sem']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">ACCOUNTS DETAILS</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4>Please select an account to view its details.</h4>
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