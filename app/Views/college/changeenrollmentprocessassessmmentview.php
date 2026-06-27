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
<?php foreach($enrollmmenthistorydata as $EHD) {
        $EHID = $EHD['ehid'];
    }
?>
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
                        <?php foreach($studentdata as $studentd): ?>
                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">STUDENT NO</label>
                                    <input type="text" class="form-control" value="<?= $studentd['studentno']; ?>" disabled>
                                </div>
                                <div class="col-lg-8 col-sm-12">
                                    <label class="form-label" for="validationDefault01">STUDENT NAME</label>
                                    <input type="text" class="form-control" value="<?= $studentd['studfullname']; ?>" disabled>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">ENROLLMENT HISTORY</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">SY</th>
                                        <th style="text-align: center;">LEVEL</th>
                                        <th style="text-align: center;">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($enrollmmenthistorydata as $enrollmmenthistoryd):?>
                                        <tr>
                                            <td><?= $enrollmmenthistoryd['sy']; ?> - <?= $enrollmmenthistoryd['sem']; ?></td>
                                            <td><?= $enrollmmenthistoryd['level']; ?></td>
                                            <td style="text-align: center;">
                                                <button class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View"
                                                    onclick="window.location.href='<?= base_url(); ?>col-change-enrollment/process-assessment/<?= $enrollmmenthistoryd['ehid']; ?>'">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M21.25 16.334V7.665C21.25 4.645 19.111 2.75 16.084 2.75H7.916C4.889 2.75 2.75 4.635 2.75 7.665L2.75 16.334C2.75 19.364 4.889 21.25 7.916 21.25H16.084C19.111 21.25 21.25 19.364 21.25 16.334Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M16.0861 12H7.91406" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M12.3223 8.25205L16.0863 12L12.3223 15.748" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                    </span>
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
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">ASSESSMENT DETAILS</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php foreach($assessmentdata as $assessmentd): ?>
                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SCHOOL YEAR</label>
                                    <input type="text" class="form-control" value="<?= $assessmentd['sy']; ?>" disabled>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SEMESTER</label>
                                    <input type="text" class="form-control" value="<?= $assessmentd['sem']; ?>" disabled>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">LEVEL</label>
                                    <input type="text" class="form-control" value="<?= $assessmentd['level']; ?>" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <label class="form-label" for="validationDefault01">COURSE</label>
                                    <input type="text" class="form-control" value="<?php 
                                        foreach($coursedata as $coursed){
                                            if($coursed['courid'] == $assessmentd['course']){
                                                echo $coursed['code'].' - '.$coursed['name'];
                                            }
                                        }
                                    ?>" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">CURRICULUM</label>
                                    <input type="text" class="form-control" value="<?php 
                                        foreach($curriculumdata as $curriculumd){
                                            if($curriculumd['currid'] == $assessmentd['curriculum']){
                                                echo $curriculumd['sy'];
                                            }
                                        } 
                                    ?>" disabled>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SECTION</label>
                                    <input type="text" class="form-control" value="<?php 
                                        foreach($sectiondata as $sectiond){
                                            if($sectiond['secid'] == $assessmentd['section']){
                                                echo $sectiond['section'];
                                            }
                                        } 
                                    ?>" disabled>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">STATUS</label>
                                    <input type="text" class="form-control" value="<?= $assessmentd['status']; ?>" disabled>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    <a class="btn btn-primary" style="width: 100%; padding-top: 20px; padding-bottom: 20px;">
                                        <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                            <path d="M16.8397 20.1642V6.54639" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                            <path d="M20.9173 16.0681L16.8395 20.1648L12.7617 16.0681" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                            <path d="M6.91102 3.83276V17.4505" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                            <path d="M2.8335 7.92894L6.91127 3.83228L10.9891 7.92894" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                                        </svg> SHIFT                           
                                    </a>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <a class="btn btn-info" style="width: 100%; padding-top: 20px; padding-bottom: 20px;"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Add & Drop"
                                        onclick="window.location.href='<?= base_url(); ?>col-change-enrollment/process-assessment-adddrop/<?= $assessmentd['assid']; ?>'">
                                        <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7366 2.76175H8.08455C6.00455 2.75375 4.29955 4.41075 4.25055 6.49075V17.3397C4.21555 19.3897 5.84855 21.0807 7.89955 21.1167C7.96055 21.1167 8.02255 21.1167 8.08455 21.1147H16.0726C18.1416 21.0937 19.8056 19.4087 19.8026 17.3397V8.03975L14.7366 2.76175Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                            <path d="M14.4741 2.75V5.659C14.4741 7.079 15.6231 8.23 17.0431 8.234H19.7971" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                            <path d="M14.2936 12.9141H9.39355" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                            <path d="M11.8442 15.3639V10.4639" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                                        </svg> ADD & DROP                           
                                    </a>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <a class="btn btn-warning" style="width: 100%; padding-top: 20px; padding-bottom: 20px;"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Change Schedule"
                                        onclick="window.location.href='<?= base_url(); ?>col-change-enrollment/process-assessment-changeschedule/<?= $assessmentd['assid']; ?>'">
                                        <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                            <path d="M3.09277 9.40421H20.9167" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                            <path d="M16.442 13.3097H16.4512" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                            <path d="M12.0045 13.3097H12.0137" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                            <path d="M7.55818 13.3097H7.56744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                            <path d="M16.442 17.1962H16.4512" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                            <path d="M12.0045 17.1962H12.0137" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                            <path d="M7.55818 17.1962H7.56744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                            <path d="M16.0433 2V5.29078" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                            <path d="M7.96515 2V5.29078" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.2383 3.5791H7.77096C4.83427 3.5791 3 5.21504 3 8.22213V17.2718C3 20.3261 4.83427 21.9999 7.77096 21.9999H16.229C19.175 21.9999 21 20.3545 21 17.3474V8.22213C21.0092 5.21504 19.1842 3.5791 16.2383 3.5791Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                                        </svg> CHANGE SCHEDULE                           
                                    </a>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <a class="btn btn-success" style="width: 100%; padding-top: 20px; padding-bottom: 20px;"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Re-Print COR"
                                        onclick="window.location.href='<?= base_url(); ?>col-assessment/print/<?= $EHID; ?>'" target="_blank">
                                        <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                            <path d="M12.1221 15.436L12.1221 3.39502" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                            <path d="M15.0381 12.5083L12.1221 15.4363L9.20609 12.5083" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                            <path d="M16.7551 8.12793H17.6881C19.7231 8.12793 21.3721 9.77693 21.3721 11.8129V16.6969C21.3721 18.7269 19.7271 20.3719 17.6971 20.3719L6.55707 20.3719C4.52207 20.3719 2.87207 18.7219 2.87207 16.6869V11.8019C2.87207 9.77293 4.51807 8.12793 6.54707 8.12793L7.48907 8.12793" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                                        </svg> RE-PRINT COR                           
                                    </a>
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