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
        </div>
    <!-- ----------- FOOTER ------------------ -->
    <?= $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?= $this->endSection(); ?>
        