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
            <div class="col-lg-5 col-sm-12">
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
            <div class="col-lg-7 col-sm-12">
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
                        <?php endforeach; ?>
                        <br>
                        <div class="row">
                            <label for="">ADD SUBJECTS TO ASSESSMENT</label>
                            <div class="form-group" style="display: flex; gap: 10px; justify-content: center;">
                                <select name="addsubjectassessment" class="form-select" required>
                                    <option value="" disabled selected hidden>Select Subject to Add</option>
                                    <optgroup label="🔫 1st Year">
                                        <?php if(empty($colcurrdataasssubjects)): ?>
                                        <?php else: ?>
                                            <?php foreach($colcurrdataasssubjects as $ccas): ?>
                                                <?php if($ccas['level'] == "1st Year"): ?>
                                                    <option value="<?= $ccas['cdid']; ?>"><?= $ccas['subcode']; ?> - <?= $ccas['subject']; ?> (<?= $ccas['sem']; ?>)</option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </optgroup>
                                    <optgroup label="🔫 2nd Year">
                                        <?php if(empty($colcurrdataasssubjects)): ?>
                                        <?php else: ?>
                                            <?php foreach($colcurrdataasssubjects as $ccas): ?>
                                                <?php if($ccas['level'] == "2nd Year"): ?>
                                                    <option value="<?= $ccas['cdid']; ?>"><?= $ccas['subcode']; ?> - <?= $ccas['subject']; ?> (<?= $ccas['sem']; ?>)</option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </optgroup>
                                    <optgroup label="🔫 3rd Year">
                                        <?php if(empty($colcurrdataasssubjects)): ?>
                                        <?php else: ?>
                                            <?php foreach($colcurrdataasssubjects as $ccas): ?>
                                                <?php if($ccas['level'] == "3rd Year"): ?>
                                                    <option value="<?= $ccas['cdid']; ?>"><?= $ccas['subcode']; ?> - <?= $ccas['subject']; ?> (<?= $ccas['sem']; ?>)</option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </optgroup>
                                    <optgroup label="🔫 4th Year">
                                        <?php if(empty($colcurrdataasssubjects)): ?>
                                        <?php else: ?>
                                            <?php foreach($colcurrdataasssubjects as $ccas): ?>
                                                <?php if($ccas['level'] == "4th Year"): ?>
                                                    <option value="<?= $ccas['cdid']; ?>"><?= $ccas['subcode']; ?> - <?= $ccas['subject']; ?> (<?= $ccas['sem']; ?>)</option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </optgroup>
                                </select>
                                <button type="submit" class="btn btn-m btn-icon btn-primary" style="width: 10%;">ADD</button>
                            </div>
                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped" data-toggle="">
                                    <thead>
                                        <tr>
                                            <th style="text-align: left;">SUBJECTS</th>
                                            <th style="text-align: center;">UNIT|HOUR</th>
                                            <th style="text-align: center;">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($studentsubjectsdata as $ssd): ?>
                                            <tr>
                                                <td style="text-align: left;"><?= $ssd['subcode']; ?> - <?= $ssd['subject']; ?></td>
                                                <td style="text-align: center;"><?= $ssd['units']; ?> - <?= $ssd['hours']; ?></td>
                                                <td style="text-align: center;">
                                                    <a class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="DROP"
                                                        onclick="window.location.href='<?= base_url(); ?>col-advising/drop/<?= $ssd['ssid']; ?>'">
                                                        <span class="btn-inner">
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M14.3955 9.59497L9.60352 14.387" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M14.3971 14.3898L9.60107 9.59277" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.3345 2.75024H7.66549C4.64449 2.75024 2.75049 4.88924 2.75049 7.91624V16.0842C2.75049 19.1112 4.63549 21.2502 7.66549 21.2502H16.3335C19.3645 21.2502 21.2505 19.1112 21.2505 16.0842V7.91624C21.2505 4.88924 19.3645 2.75024 16.3345 2.75024Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>DROP  
                                                        </span>
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
    </div>
    <!-- End of Page Content -->

    <!-- ----------- FOOTER ------------------ -->
    <?= $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?= $this->endSection(); ?>