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
            <div class="col-md-12 col-lg-12">
                <div class="row row-cols-1">
                    <div class="overflow-hidden d-slider1 ">
                    <?php foreach($usersaccess as $usera): ?>
                        <?php if($usera['uregistrar'] == 1 || $usera['uprogramchair'] == 1): ?>
                            
                        <?php else: ?>
                            <ul  class="p-0 m-0 mb-2 swiper-wrapper list-inline">
                                <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                                    <div class="card-body">
                                        <div class="progress-widget">
                                            <div class="progress-detail" style="width: 100%">
                                                <p  class="mb-2">IMPORTED GRADES</p>
                                                <button class="btn btn-primary" style="width: 100%"
                                                    onclick = "window.location.href='<?= base_url(); ?>gradesimportedlock'">
                                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M16.4232 9.4478V7.3008C16.4232 4.7878 14.3852 2.7498 11.8722 2.7498C9.35925 2.7388 7.31325 4.7668 7.30225 7.2808V7.3008V9.4478" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.683 21.2497H8.042C5.948 21.2497 4.25 19.5527 4.25 17.4577V13.1687C4.25 11.0737 5.948 9.37671 8.042 9.37671H15.683C17.777 9.37671 19.475 11.0737 19.475 13.1687V17.4577C19.475 19.5527 17.777 21.2497 15.683 21.2497Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M11.8628 14.2026V16.4236" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                                                    </svg>                            
                                                    LOCK
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                                    <div class="card-body">
                                        <div class="progress-widget">
                                            <div class="progress-detail" style="width: 100%">
                                                <p  class="mb-2">COMPUTE SEMESTRAL</p>
                                                <button class="btn btn-primary" style="width: 100%"
                                                    onclick = "window.location.href='<?= base_url(); ?>computesemestral'">
                                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M12.0001 8.32739V15.6537" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M15.6668 11.9904H8.3335" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.6857 2H7.31429C4.04762 2 2 4.31208 2 7.58516V16.4148C2 19.6879 4.0381 22 7.31429 22H16.6857C19.9619 22 22 19.6879 22 16.4148V7.58516C22 4.31208 19.9619 2 16.6857 2Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>                            
                                                    COMPUTE
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        <?php endif;?>
                    <?php endforeach; ?> 
                        <div class="swiper-button swiper-button-next"></div>
                        <div class="swiper-button swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </div>
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
                        <?php echo form_open('grades'); ?> 
                            <div class="row">
                                <div class="col-lg-9 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SEARCH STUDENT</label>
                                    <input type="text" name="searchstud" class="form-control"
                                    placeholder="Search Student Number/Lastname/Firstname" required>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <button class="btn btn-success" type="submit" name="add" style="width: 100%; height: 100%;">SEACH STUDENT</button>
                                </div>
                            </div>
                        <?php echo form_close(); ?>    
                    </div>
                </div>
            </div>
        </div>
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
                            <table id="datatable" class="table table-striped" data-toggle="data-table" style="font-size: 12px">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NAME</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($resultStudent as $resstud):?>
                                        <?php if($resstud['studisdel'] == 0): ?>
                                            <tr>
                                                <td><?= $resstud['studentno']; ?></td>
                                                <td style="text-transform: uppercase"><?= $resstud['studln']; ?>, <?= $resstud['studfn']; ?></td>
                                                <td>
                                                    <div class="flex align-items-center list-user-action">
                                                        <a class="btn btn-sm btn-icon btn-warning" title="View Grade" href="gradesview/<?= $resstud['studentno']; ?>">
                                                            <span class="btn-inner">
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                                <path d="M22.4541 11.3918C22.7819 11.7385 22.7819 12.2615 22.4541 12.6082C21.0124 14.1335 16.8768 18 12 18C7.12317 18 2.98759 14.1335 1.54586 12.6082C1.21811 12.2615 1.21811 11.7385 1.54586 11.3918C2.98759 9.86647 7.12317 6 12 6C16.8768 6 21.0124 9.86647 22.4541 11.3918Z" stroke="#130F26"></path>                                    
                                                                <circle cx="12" cy="12" r="5" stroke="#130F26"></circle>
                                                                <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                    
                                                                <mask mask-type="alpha" maskUnits="userSpaceOnUse" x="9" y="9" width="6" height="6">                                    
                                                                    <circle cx="12" cy="12" r="3" fill="#130F26"></circle>                                    
                                                                </mask>                                    
                                                                <circle opacity="0.89" cx="13.5" cy="10.5" r="1.5" fill="white"></circle>
                                                            </svg>
                                                            </span>
                                                        </a>
                                                        <a class="btn btn-sm btn-icon btn-info" title="Download Grade"
                                                            href="#" data-bs-toggle="modal" data-bs-target="#gradedlModal<?= $resstud['studid']; ?>">
                                                            <span class="btn-inner">
                                                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                                    <path d="M12.1221 15.436L12.1221 3.39502" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    <path d="M15.0381 12.5083L12.1221 15.4363L9.20609 12.5083" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    <path d="M16.7551 8.12793H17.6881C19.7231 8.12793 21.3721 9.77693 21.3721 11.8129V16.6969C21.3721 18.7269 19.7271 20.3719 17.6971 20.3719L6.55707 20.3719C4.52207 20.3719 2.87207 18.7219 2.87207 16.6869V11.8019C2.87207 9.77293 4.51807 8.12793 6.54707 8.12793L7.48907 8.12793" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                       
                                                                </svg> 
                                                            </span>
                                                        </a>
                                                        <div class="modal fade" id="gradedlModal<?= $resstud['studid']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content dark">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="staticBackdropLabel">SELECT SCHOOL YEAR</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <?= form_open('gradesdownload'); ?>
                                                                        <div class="modal-body">
                                                                            <h3><?= $resstud['studln']; ?>, <?= $resstud['studfn']; ?></h3>
                                                                            <input type="hidden" name="studno" value="<?= $resstud['studentno']; ?>">
                                                                            <br>
                                                                            <div class="row">
                                                                                <div class="col-lg-6 col-sm-12">
                                                                                    <label class="form-label" for="validationDefault01">SCHOOL YEAR</label>
                                                                                    <select name="schoolyear" class="form-select" id="exampleFormControlSelect1"
                                                                                    required>
                                                                                        <option selected="" disabled=""></option>
                                                                                        <?php foreach ($schoolyeardata as $syd): ?>
                                                                                            <option value="<?php echo $syd['syid']; ?>"><?php echo $syd['syname']; ?></option>
                                                                                        <?php endforeach; ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-lg-6 col-sm-12">
                                                                                    <label class="form-label" for="validationDefault01">SEMESTER</label>
                                                                                    <select name="semester" class="form-select" id="exampleFormControlSelect1"
                                                                                    required>
                                                                                        <option selected="" disabled=""></option>
                                                                                        <?php foreach ($semesterdata as $semd): ?>
                                                                                            <option value="<?php echo $semd['semid']; ?>"><?php echo $semd['semester']; ?></option>
                                                                                        <?php endforeach; ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <br>
                                                                            <div class="text-start" >
                                                                                <button type="submit" name="update" class="btn btn-success">
                                                                                    <span class="btn-inner">
                                                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                                                            <path d="M12.1221 15.436L12.1221 3.39502" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                                            <path d="M15.0381 12.5083L12.1221 15.4363L9.20609 12.5083" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                                            <path d="M16.7551 8.12793H17.6881C19.7231 8.12793 21.3721 9.77693 21.3721 11.8129V16.6969C21.3721 18.7269 19.7271 20.3719 17.6971 20.3719L6.55707 20.3719C4.52207 20.3719 2.87207 18.7219 2.87207 16.6869V11.8019C2.87207 9.77293 4.51807 8.12793 6.54707 8.12793L7.48907 8.12793" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                       
                                                                                        </svg> 
                                                                                    </span>
                                                                                    Download
                                                                                </button>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    <?= form_close(); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
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

    <!-- End of Page Content -->

    <!-- ----------- FOOTER ------------------ -->
    <?= $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?= $this->endSection(); ?>