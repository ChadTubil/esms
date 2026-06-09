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
                        <?php echo form_open('col-classlist'); ?> 
                            <div class="row">
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SELECT PROGRAM</label>
                                    <select name="course" class="form-select">
                                        <option>-</option>
                                        <?php foreach($coursesdata as $coursesd): ?>
                                            <option value="<?= $coursesd['courid']; ?>"><?= $coursesd['code']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SCHOOL YEAR</label>
                                    <select name="sy" class="form-select">
                                        <option>-</option>
                                        <?php foreach($sydata as $syd): ?>
                                            <option value="<?= $syd['syname']; ?>"><?= $syd['syname']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SEMESTER</label>
                                    <select name="sem" class="form-select">
                                        <option>-</option>
                                        <option value="1st Semester">1st Semester</option>
                                        <option value="2nd Semester">2nd Semester</option>
                                        <option value="Summer">Summer</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <button class="btn btn-success" type="submit" name="add" style="width: 100%; height: 100%;">SEACH STUDENT</button>
                                </div>
                            </div>
                        <?php echo form_close(); ?>    
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">SELECT A SUBJECT TO VIEW</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>SUBJECTS</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($curriculumdata as $curriculumd):?>
                                        <tr>
                                            <td><?= $curriculumd['subcode']; ?>-<?= $curriculumd['subject']; ?></td>
                                            <td>
                                                <a class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View"
                                                    onclick="window.location.href='<?= base_url(); ?>col-classlist-students/<?= $curriculumd['curriculumid']; ?>/<?= $curriculumd['level']; ?>'">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                                            <path d="M22.4541 11.3918C22.7819 11.7385 22.7819 12.2615 22.4541 12.6082C21.0124 14.1335 16.8768 18 12 18C7.12317 18 2.98759 14.1335 1.54586 12.6082C1.21811 12.2615 1.21811 11.7385 1.54586 11.3918C2.98759 9.86647 7.12317 6 12 6C16.8768 6 21.0124 9.86647 22.4541 11.3918Z" stroke="#ffffff"></path>                                    
                                                            <circle cx="12" cy="12" r="5" stroke="#ffffff"></circle>                                    
                                                            <circle cx="12" cy="12" r="3" fill="#ffffff"></circle>                                    
                                                            <mask mask-type="alpha" maskUnits="userSpaceOnUse" x="9" y="9" width="6" height="6">                                    
                                                                <circle cx="12" cy="12" r="3" fill="#ffffff"></circle>                                    
                                                            </mask>                                    
                                                            <circle opacity="0.89" cx="13.5" cy="10.5" r="1.5" fill="white"></circle>                                    
                                                        </svg>                            
                                                    </span>
                                                </a>
                                                <a class="btn btn-sm btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="View"
                                                    href='<?= base_url(); ?>col-classlist-print/<?= $curriculumd['curriculumid']; ?>/<?= $curriculumd['level']; ?>/<?= $curriculumd['cdid']; ?>' target="_blank">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                                            <path d="M12.1221 15.436L12.1221 3.39502" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                                            <path d="M15.0381 12.5083L12.1221 15.4363L9.20609 12.5083" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                                            <path d="M16.7551 8.12793H17.6881C19.7231 8.12793 21.3721 9.77693 21.3721 11.8129V16.6969C21.3721 18.7269 19.7271 20.3719 17.6971 20.3719L6.55707 20.3719C4.52207 20.3719 2.87207 18.7219 2.87207 16.6869V11.8019C2.87207 9.77293 4.51807 8.12793 6.54707 8.12793L7.48907 8.12793" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
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
    <?php echo $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?php echo $this->endSection(); ?>