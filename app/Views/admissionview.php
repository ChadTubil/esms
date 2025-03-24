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
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"></h4>
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
                                        <th>NAME</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($admission as $ad):?>
                                        <tr>
                                            <td style="text-transform: uppercase"><?= $ad['studfullname']; ?></td>
                                            <td>
                                                <a class="btn btn-sm btn-icon btn-primary" title="PROCESS"
                                                    href="#" data-bs-toggle="modal" data-bs-target="#processModal<?= $ad['studid']; ?>">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M12.0001 8.32739V15.6537" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M15.6668 11.9904H8.3335" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.6857 2H7.31429C4.04762 2 2 4.31208 2 7.58516V16.4148C2 19.6879 4.0381 22 7.31429 22H16.6857C19.9619 22 22 19.6879 22 16.4148V7.58516C22 4.31208 19.9619 2 16.6857 2Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg> PROCESS
                                                    </span>
                                                </a>
                                                <div class="modal fade" id="processModal<?= $ad['studid']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content dark">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">ADMISSION PROCESS</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <?= form_open('admission/process/'.$ad['studid']); ?>
                                                            <div class="modal-body">
                                                                <h5>NAME: <strong style="text-transform: uppercase"><?= $ad['studfullname']; ?></strong></h5>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="email" class="form-label">STUDENT NO.</label>
                                                                            <input type="text" name="studnum" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="email" class="form-label">SCHOOL YEAR</label>
                                                                            <select name="schoolyear" class="form-select">
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
                                                                                <?php foreach ($course as $cour): ?>
                                                                                    <option value="<?php echo $cour['courid']; ?>"><?php echo $cour['course']; ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="email" class="form-label">MAJOR</label>
                                                                            <input type="text" name="major" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 col-sm-12">
                                                                        <div class="form-group">
                                                                            <input class="form-check-input" type="checkbox" name="irreg">
                                                                            <span>IRREGULAR</span><span style="color: red;"> (Check if the student is not regular.)</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <div class="text-start">
                                                                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                                </div>
                                                            </div>
                                                            <?= form_close(); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                                    onclick="window.location.href='<?= base_url(); ?>admission/delete/<?= $ad['studid']; ?>';">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                            <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
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