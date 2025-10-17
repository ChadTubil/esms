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
                        <?php if(!empty($assessment)) : ?>
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
                        <?php else: ?>
                            <?php foreach($etddata as $etdd): ?>
                                <?php foreach($students as $stud): ?>
                                    <?php if(!empty($studcurriculums)): ?>
                                        <?= form_open('assessment/process2/'.$etdd['studno']) ?>
                                            <div class="row">
                                                <div class="col-lg-12 col-sm-12">
                                                    <h1><?= $etdd['fullname']; ?></h1>
                                                </div>
                                                
                                                <div class="col-lg-2">
                                                    <br>
                                                    <label class="form-label" for="validationDefault01">STUDENT NUMBER</label>
                                                    <input type="hidden" name="studentnumber" class="form-control" value="<?= $etdd['studno']; ?>" disabled>
                                                    <input type="text" class="form-control" value="<?= $stud['studentno']; ?>" disabled>
                                                </div>
                                                <div class="col-lg-4">
                                                    <br>
                                                    <label class="form-label" for="validationDefault01">COURSE</label>
                                                    <input type="hidden" name="course" class="form-control" value="<?= $etdd['course']; ?>">
                                                    <input type="text" class="form-control" value="<?php
                                                            foreach($course as $c) {
                                                                if($c['courid'] == $etdd['course']) {
                                                                    echo $c['courcode']." - ".$c['course'];
                                                                }
                                                            }
                                                        ?>" disabled>
                                                </div>
                                                <div class="col-lg-2">
                                                    <br>
                                                    <label class="form-label" for="validationDefault01">SCHOOL YEAR</label>
                                                    <input type="hidden" name="sy" class="form-control" value="<?= $etdd['sy']; ?>">
                                                    <input type="text" class="form-control" value="<?= $etdd['sy']; ?>" disabled>
                                                </div>
                                                <div class="col-lg-2">
                                                    <br>
                                                    <label class="form-label" for="validationDefault01">SEMESTER</label>
                                                    <input type="hidden" name="sem" class="form-control" value="<?= $etdd['sem']; ?>">
                                                    <input type="text" class="form-control" value="<?= $etdd['sem']; ?>" disabled>
                                                </div>
                                                <div class="col-lg-2">
                                                    <br>
                                                    <label class="form-label" for="validationDefault01">YEAR LEVEL</label>
                                                    <input type="hidden" name="yl" class="form-control" value="<?= $etdd['level']; ?>">
                                                    <input type="text" class="form-control" value="<?= $etdd['level']; ?>" disabled>
                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="hidden" name="curriculum" class="form-control" value="<?php 
                                                            foreach($studcurriculums as $sctudcurr) {
                                                                echo $sctudcurr['currid'];
                                                            } 
                                                        ?>">
                                                    <label class="form-label" for="validationDefault01">SECTION</label>
                                                    <select name="section" class="form-select" style="width: 100%;" required>
                                                        <option value="" selected disabled>SELECT SECTION</option>
                                                        <?php if(empty($sectiondata)) : ?>
                                                            <option value="" disabled>No Section Found</option>
                                                        <?php else: ?>
                                                            <?php foreach($sectiondata as $sectiond) : ?>
                                                                <option value="<?= $sectiond['secid']; ?>"><?= $sectiond['section']; ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="form-label" for="validationDefault01">ACTION</label>
                                                    <button class="btn btn-success" type="submit" name="add" style="width: 100%;">PROCESS</button>
                                                </div>
                                            </div>
                                        <?= form_close(); ?>
                                        <?php else: ?>
                                            <div class="row">
                                                <div class="col-lg-12 col-sm-12">
                                                    <h1><?= $etdd['fullname']; ?></h1>
                                                </div>
                                                <div class="col-lg-2">
                                                <br>
                                                    <label class="form-label" for="validationDefault01">STUDENT NUMBER</label>
                                                    <input type="text" class="form-control" value="<?= $stud['studentno']; ?>" disabled>
                                                </div>
                                                <div class="col-lg-4">
                                                    <br>
                                                    <label class="form-label" for="validationDefault01">COURSE</label>
                                                    <input type="text" class="form-control" value="<?php
                                                            foreach($course as $c) {
                                                                if($c['courid'] == $etdd['course']) {
                                                                    echo $c['courcode']." - ".$c['course'];
                                                                }
                                                            }
                                                        ?>" disabled>
                                                </div>
                                                <div class="col-lg-2">
                                                    <br>
                                                    <label class="form-label" for="validationDefault01">SCHOOL YEAR</label>
                                                    <input type="text" class="form-control" value="<?= $etdd['sy']; ?>" disabled>
                                                </div>
                                                <div class="col-lg-2">
                                                    <br>
                                                    <label class="form-label" for="validationDefault01">SEMESTER</label>
                                                    <input type="text" class="form-control" value="<?= $etdd['sem']; ?>" disabled>
                                                </div>
                                                <div class="col-lg-2">
                                                    <br>
                                                    <label class="form-label" for="validationDefault01">YEAR LEVEL</label>
                                                    <input type="text" class="form-control" value="<?= $etdd['level']; ?>" disabled>
                                                </div>
                                            </div>
                                            <?= form_open('assessment/curricullum-set/'.$etdd['studno']) ?>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <label class="form-label" for="validationDefault01">SELECT CURRICULUM</label>
                                                    <select name="curriculum" class="form-select" style="width: 100%;" required>
                                                        <option value="" selected disabled>SELECT CURRICULUM</option>
                                                        <?php if(empty($curriculums)) : ?>
                                                            <option value="" disabled>No Curriculum Found</option>
                                                        <?php else: ?>
                                                            <?php foreach($curriculums as $cur) : ?>
                                                                <option value="<?= $cur['currid']; ?>"><?= $cur['course']; ?> - <?= $cur['sy']; ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="form-label" for="validationDefault01">ACTION</label>
                                                    <button class="btn btn-success" type="submit" name="add" style="width: 100%;">PROCESS</button>
                                                </div>
                                            </div>
                                            <?= form_close(); ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>  
                            <?php endforeach; ?> 
                        <?php endif; ?>   
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="row" style="margin: 10px;">
                        <div class="col-lg-4 col-sm-12">
                            <button class="btn btn-primary" style="width: 100%;">VIEW CURRICULUM</button>
                        </div>
                    </div>
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">ASSESSMENT HISTORY</h4>
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
                            <table id="datatable" class="table table-striped" data-toggle="data-table" style="font-size: 12px">
                                <thead>
                                    <tr>
                                        <th>SCHOOL YEAR</th>
                                        <th>SEMESTER</th>
                                        <th>LEVEL</th>
                                        <th>STATUS</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($assessment as $ass) : ?>
                                        <tr>
                                            <td><?= $ass['sy']; ?></td>
                                            <td><?= $ass['sem']; ?></td>
                                            <td><?= $ass['level']; ?></td>
                                            <td><?= $ass['status']; ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="VIEW ASSESSMENT"
                                                    onclick="window.location.href='<?= base_url(); ?>assessment/viewsubjects/<?= $ass['assid']; ?>'">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7366 2.76175H8.08455C6.00455 2.75375 4.29955 4.41075 4.25055 6.49075V17.3397C4.21555 19.3897 5.84855 21.0807 7.89955 21.1167C7.96055 21.1167 8.02255 21.1167 8.08455 21.1147H16.0726C18.1416 21.0937 19.8056 19.4087 19.8026 17.3397V8.03975L14.7366 2.76175Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M14.4741 2.75V5.659C14.4741 7.079 15.6231 8.23 17.0431 8.234H19.7971" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M14.2936 12.9141H9.39355" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M11.8442 15.3639V10.4639" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                          
                                                        </svg>                       
                                                    </span>VIEW
                                                </button>
                                                <a class="btn btn-sm btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="FINALIZE ASSESSMENT"
                                                    onclick="window.location.href='<?= base_url(); ?>assessment/finalize/<?= $ass['studentno']; ?>'">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                            <path d="M10.33 16.5928H4.0293" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M13.1406 6.90042H19.4413" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.72629 6.84625C8.72629 5.5506 7.66813 4.5 6.36314 4.5C5.05816 4.5 4 5.5506 4 6.84625C4 8.14191 5.05816 9.19251 6.36314 9.19251C7.66813 9.19251 8.72629 8.14191 8.72629 6.84625Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M20.0002 16.5538C20.0002 15.2581 18.9429 14.2075 17.6379 14.2075C16.3321 14.2075 15.2739 15.2581 15.2739 16.5538C15.2739 17.8494 16.3321 18.9 17.6379 18.9C18.9429 18.9 20.0002 17.8494 20.0002 16.5538Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                           
                                                        </svg>                       
                                                    </span>FINALIZE
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
        </div>
    </div>

    <!-- End of Page Content -->

    <!-- ----------- FOOTER ------------------ -->
    <?php echo $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?php echo $this->endSection(); ?>