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
                        <div class="header-title">
                            <h4 class="card-title">OLD STUDENTS</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <?php if(session()->getTempdata('deletesuccess')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('deletesuccess');?>
                                </div>
                            <?php endif; ?>
                            <?php if(session()->getTempdata('endedsuccess')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('endedsuccess');?>
                                </div>
                            <?php endif; ?>
                            <?php if(session()->getTempdata('updatesuccess')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('updatesuccess');?>
                                </div>
                            <?php endif; ?>
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>STUDENT NO</th>
                                        <th>NAME</th>
                                        <th>SY</th>
                                        <th>SEMESTER</th>
                                        <th>LEVEL</th>
                                        <th>DATE</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($etddata as $etdd):?>
                                        <tr>
                                            <td>
                                                <?php 
                                                    foreach($studentinfo as $studenti) {
                                                        if($studenti['studid'] == $etdd['studno']) {
                                                        echo $studenti['studentno'];
                                                        }
                                                    }
                                                ?>
                                            </td>
                                            <td><?= $etdd['fullname']; ?></td>
                                            <td><?= $etdd['sy']; ?></td>
                                            <td><?= $etdd['sem']; ?></td>
                                            <td><?= $etdd['level']; ?></td>
                                            <td><?= $etdd['date']; ?></td>
                                            <td>
                                                <a class="btn btn-sm btn-icon btn-primary" title="PROCESS"
                                                    href="#" data-bs-toggle="modal" data-bs-target="#processModal<?= $etdd['studno']; ?>">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M12.0001 8.32739V15.6537" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M15.6668 11.9904H8.3335" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.6857 2H7.31429C4.04762 2 2 4.31208 2 7.58516V16.4148C2 19.6879 4.0381 22 7.31429 22H16.6857C19.9619 22 22 19.6879 22 16.4148V7.58516C22 4.31208 19.9619 2 16.6857 2Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg> PROCESS
                                                    </span>
                                                </a>
                                                <div class="modal fade" id="processModal<?= $etdd['studno']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content dark">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">ADMISSION PROCESS</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <?= form_open('register-oldstudent-process/'.$etdd['etdid']); ?>
                                                            <div class="modal-body">
                                                                <h5>NAME: <strong style="text-transform: uppercase"><?= $etdd['fullname']; ?></strong></h5>
                                                                <h5>STUDENT NO: <strong style="text-transform: uppercase"><strong>
                                                                    <?php
                                                                        foreach($studentinfo as $studenti) {
                                                                            if($studenti['studid'] == $etdd['studno']) {
                                                                            echo $studenti['studentno'];
                                                                            }
                                                                        }
                                                                    ?>
                                                                </strong></h5>
                                                                <br>
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="email" class="form-label">SCHOOL YEAR</label>
                                                                            <select name="schoolyear" class="form-select">
                                                                                <option value="<?php foreach($schoolrecord as $sr) {
                                                                                        if($sr['srstudid'] == $etdd['studno']) {
                                                                                            echo $sr['srsy'];
                                                                                        }
                                                                                    } ?>" selected><?php foreach($schoolrecord as $sr) {
                                                                                        if($sr['srstudid'] == $etdd['studno']) {
                                                                                            echo $sr['srsy'];
                                                                                        }
                                                                                    } ?></option>
                                                                                <?php foreach ($schoolyear as $sy): ?>
                                                                                    <option value="<?php echo $sy['syname']; ?>"><?php echo $sy['syname']; ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="email" class="form-label">SEMESTER</label>
                                                                            <select name="semester" class="form-select">
                                                                                <option value="<?php foreach($schoolrecord as $sr) {
                                                                                        if($sr['srstudid'] == $etdd['studno']) {
                                                                                            echo $sr['srsem'];
                                                                                        }
                                                                                    } ?>" selected><?php foreach($schoolrecord as $sr) {
                                                                                        if($sr['srstudid'] == $etdd['studno']) {
                                                                                            echo $sr['srsem'];
                                                                                        }
                                                                                    } ?></option>
                                                                                <?php foreach ($semester as $sem): ?>
                                                                                    <option value="<?php echo $sem['semester']; ?>"><?php echo $sem['semester']; ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="email" class="form-label">LEVEL</label>
                                                                            <select name="level" class="form-select">
                                                                                <option value="<?php foreach($schoolrecord as $sr) {
                                                                                        if($sr['srstudid'] == $etdd['studno']) {
                                                                                            echo $sr['srlevel'];
                                                                                        }
                                                                                    } ?>" selected><?php foreach($schoolrecord as $sr) {
                                                                                        if($sr['srstudid'] == $etdd['studno']) {
                                                                                            echo $sr['srlevel'];
                                                                                        }
                                                                                    } ?></option>
                                                                                <?php foreach ($level as $lev): ?>
                                                                                    <option value="<?php echo $lev['level']; ?>"><?php echo $lev['level']; ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label class="form-label">STATUS</label>
                                                                            <select name="status" class="form-select">
                                                                                <option value="<?php foreach($schoolrecord as $sr) {
                                                                                        if($sr['srstudid'] == $etdd['studno']) {
                                                                                            echo $sr['srstatus'];
                                                                                        }
                                                                                    } ?>"><?php foreach($schoolrecord as $sr) {
                                                                                        if($sr['srstudid'] == $etdd['studno']) {
                                                                                            echo $sr['srstatus'];
                                                                                        }
                                                                                    } ?></option>
                                                                                <option value="NEW">NEW</option>
                                                                                <option value="OLD">OLD</option>
                                                                                <option value="KICKED">KICKED-OUT</option>
                                                                                <option value="TRANSFERRED">TRANSFERRED</option>
                                                                                <option value="TRANSFEREE">TRANSFEREE</option>
                                                                                <option value="INACTIVE">INACTIVE</option>
                                                                                <option value="RETURNEE">RETURNEE</option>
                                                                                <option value="WITH-CASES">WITH-CASES</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="email" class="form-label">COURSE</label>
                                                                            <select name="course" class="form-select" style="text-transform: uppercase">
                                                                                <option value="<?php foreach($course as $courd) {
                                                                                        if($courd['courid'] == $etdd['course']) {
                                                                                            echo $courd['courid'];
                                                                                        }
                                                                                    } ?>" selected>
                                                                                    <?php foreach($course as $courd) {
                                                                                        if($courd['courid'] == $etdd['course']) {
                                                                                            echo $courd['course'];
                                                                                        }
                                                                                    } ?>
                                                                                </option>
                                                                                <?php foreach ($course as $cour): ?>
                                                                                    <option value="<?php echo $cour['courid']; ?>"><?php echo $cour['course']; ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="email" class="form-label">MAJOR</label>
                                                                            <?php foreach ($schoolrecord as $sr): ?>
                                                                                <?php if ($sr['srstudid'] == $etdd['studno']): ?>
                                                                                    <?php if ($sr['srmajor'] == ''): ?>
                                                                                        <input type="text" name="major" class="form-control" placeholder="Enter Major">
                                                                                    <?php else: ?>
                                                                                        <input type="text" name="major" class="form-control" value="<?= $sr['srmajor']; ?>">
                                                                                    <?php endif; ?>
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 col-sm-12">
                                                                        <div class="form-group">
                                                                            <?php foreach ($schoolrecord as $sr): ?>
                                                                                <?php if ($sr['srstudid'] == $etdd['studno']): ?>
                                                                                    <?php if ($sr['srirregular'] == '1'): ?>
                                                                                        <input class="form-check-input" type="checkbox" name="irreg" value="1" checked>
                                                                                    <?php else: ?>
                                                                                        <input class="form-check-input" type="checkbox" name="irreg">
                                                                                    <?php endif; ?>
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                            <span>IRREGULAR</span><span style="color: red;"> (Check if the student is not regular.)</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <div class="text-start">
                                                                    <button type="submit" name="update" class="btn btn-primary">Process</button>
                                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                                </div>
                                                            </div>
                                                            <?= form_close(); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="CANCEL"
                                                    onclick="window.location.href='<?= base_url(); ?>admission/delete/<?= $etdd['etdid']; ?>'">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M14.3955 9.59497L9.60352 14.387" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M14.3971 14.3898L9.60107 9.59277" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.3345 2.75024H7.66549C4.64449 2.75024 2.75049 4.88924 2.75049 7.91624V16.0842C2.75049 19.1112 4.63549 21.2502 7.66549 21.2502H16.3335C19.3645 21.2502 21.2505 19.1112 21.2505 16.0842V7.91624C21.2505 4.88924 19.3645 2.75024 16.3345 2.75024Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg> CANCEL                        
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
    <!-- End of Page Content -->

    <!-- ----------- FOOTER ------------------ -->
    <?= $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?= $this->endSection(); ?>