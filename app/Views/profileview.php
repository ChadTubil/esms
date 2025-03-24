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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            <div class="d-flex flex-wrap align-items-center">
                                <div class="profile-img position-relative me-3 mb-3 mb-lg-0 profile-logo profile-logo1">
                                    <img src="<?= base_url(); ?>public/assets/images/avatars/01.png" alt="User-Profile" class="theme-color-default-img img-fluid rounded-pill avatar-100">
                                    <img src="<?= base_url(); ?>public/assets/images/avatars/avtar_1.png" alt="User-Profile" class="theme-color-purple-img img-fluid rounded-pill avatar-100">
                                    <img src="<?= base_url(); ?>public/assets/images/avatars/avtar_2.png" alt="User-Profile" class="theme-color-blue-img img-fluid rounded-pill avatar-100">
                                    <img src="<?= base_url(); ?>public/assets/images/avatars/avtar_4.png" alt="User-Profile" class="theme-color-green-img img-fluid rounded-pill avatar-100">
                                    <img src="<?= base_url(); ?>public/assets/images/avatars/avtar_5.png" alt="User-Profile" class="theme-color-yellow-img img-fluid rounded-pill avatar-100">
                                    <img src="<?= base_url(); ?>public/assets/images/avatars/avtar_3.png" alt="User-Profile" class="theme-color-pink-img img-fluid rounded-pill avatar-100">
                                </div>
                                <?php foreach($usersaccess as $usera): ?>
                                    <?php if($usera['ustudent'] == 1): ?>
                                        <?php foreach($profiledata as $profiled): ?>
                                            <div class="d-flex flex-wrap align-items-center mb-3 mb-sm-0">
                                                <h4 class="me-2 h4"><?= $profiled['studfullname']; ?></h4>
                                                <span> - <?= $profiled['studentno']; ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php elseif($usera['uadmin'] == 1): ?>
                                        <?php foreach($profiledata as $profiled): ?>
                                            <div class="d-flex flex-wrap align-items-center mb-3 mb-sm-0">
                                                <h4 class="me-2 h4"><?= $profiled['empfullname']; ?></h4>
                                                <span> - <?= $profiled['empnum']; ?></span>
                                            </div>
                                        <?php endforeach; ?>    
                                    <?php endif; ?>
                                <?php endforeach; ?>     
                            </div>
                            <ul class="d-flex nav nav-pills mb-0 text-center profile-tab" data-toggle="slider-tab" id="profile-pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active show" data-bs-toggle="tab" href="#profile-profile" role="tab" aria-selected="false">Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " data-bs-toggle="tab" href="#profile-friends" role="tab" aria-selected="false">Account</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-lg-3">
                <div class="card">
                <div class="card-header">
                    <div class="header-title">
                        <h4 class="card-title">News</h4>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-inline m-0 p-0">
                        <li class="d-flex mb-2">
                            <div class="news-icon me-3">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                            </svg>
                            </div>
                            <p class="news-detail mb-0">there is a meetup in your city on fryday at 19:00. <a href="#">see details</a></p>
                        </li>
                        <li class="d-flex">
                            <div class="news-icon me-3">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4C22,2.89 21.1,2 20,2Z" />
                            </svg>
                            </div>
                            <p class="news-detail mb-0">20% off coupon on selected items at pharmaprix </p>
                        </li>
                    </ul>
                </div>
                </div>
                <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Gallery</h4>
                    </div>
                    <span>132 pics</span>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-card grid-cols-3">
                        <a data-fslightbox="gallery" href="<?= base_url(); ?>public/assets/images/icons/04.png">
                            <img src="<?= base_url(); ?>public/assets/images/icons/04.png" class="img-fluid bg-soft-info rounded" alt="profile-image">
                        </a>
                        <a data-fslightbox="gallery" href="<?= base_url(); ?>public/assets/images/shapes/02.png">
                            <img src="<?= base_url(); ?>public/assets/images/shapes/02.png" class="img-fluid bg-soft-primary rounded" alt="profile-image">
                        </a>
                        <a data-fslightbox="gallery" href="<?= base_url(); ?>public/assets/images/icons/08.png">
                            <img src="<?= base_url(); ?>public/assets/images/icons/08.png" class="img-fluid bg-soft-info rounded" alt="profile-image">
                        </a>
                        <a data-fslightbox="gallery" href="<?= base_url(); ?>public/assets/images/shapes/04.png">
                            <img src="<?= base_url(); ?>public/assets/images/shapes/04.png" class="img-fluid bg-soft-primary rounded" alt="profile-image">
                        </a>
                        <a data-fslightbox="gallery" href="<?= base_url(); ?>public/assets/images/icons/02.png">
                            <img src="<?= base_url(); ?>public/assets/images/icons/02.png" class="img-fluid bg-soft-warning rounded" alt="profile-image">
                        </a>
                        <a data-fslightbox="gallery" href="<?= base_url(); ?>public/assets/images/shapes/06.png">
                            <img src="<?= base_url(); ?>public/assets/images/shapes/06.png" class="img-fluid bg-soft-primary rounded" alt="profile-image">
                        </a>
                        <a data-fslightbox="gallery" href="<?= base_url(); ?>public/assets/images/icons/05.png">
                            <img src="<?= base_url(); ?>public/assets/images/icons/05.png" class="img-fluid bg-soft-danger rounded" alt="profile-image">
                        </a>
                        <a data-fslightbox="gallery" href="<?= base_url(); ?>public/assets/images/shapes/04.png">
                            <img src="<?= base_url(); ?>public/assets/images/shapes/04.png" class="img-fluid bg-soft-primary rounded" alt="profile-image">
                        </a>
                        <a data-fslightbox="gallery" href="<?= base_url(); ?>public/assets/images/icons/01.png">
                            <img src="<?= base_url(); ?>public/assets/images/icons/01.png" class="img-fluid bg-soft-success rounded" alt="profile-image">
                        </a>
                    </div>
                </div>
                </div>
                <div class="card">
                <div class="card-header">
                    <div class="header-title">
                        <h4 class="card-title">Twitter Feeds</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="twit-feed">
                        <div class="d-flex align-items-center mb-2">
                            <img class="rounded-pill img-fluid avatar-50 me-3 p-1 bg-soft-danger ps-2" src="<?= base_url(); ?>public/assets/images/icons/03.png" alt="">
                            <div class="media-support-info">
                            <h6 class="mb-0">Figma Community</h6>
                            <p class="mb-0">@figma20 
                                <span class="text-primary">
                                    <svg class="icon-15" width="15" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M10,17L5,12L6.41,10.58L10,14.17L17.59,6.58L19,8M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                                    </svg>
                                </span>
                            </p>
                            </div>
                        </div>
                        <div class="media-support-body">
                            <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                            <div class="d-flex flex-wrap">
                            <a href="#" class="twit-meta-tag pe-2">#Html</a>
                            <a href="#" class="twit-meta-tag pe-2">#Bootstrap</a>
                            </div>
                            <div class="twit-date">07 Jan 2021</div>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="twit-feed">
                        <div class="d-flex align-items-center mb-2">
                            <img class="rounded-pill img-fluid avatar-50 me-3 p-1 bg-soft-primary" src="<?= base_url(); ?>public/assets/images/icons/04.png" alt="">
                            <div class="media-support-info">
                            <h6 class="mb-0">Flutter</h6>
                            <p class="mb-0">@jane59
                                <span class="text-primary">
                                    <svg class="icon-15" width="15" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M10,17L5,12L6.41,10.58L10,14.17L17.59,6.58L19,8M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                                    </svg>
                                </span>
                            </p>
                            </div>
                        </div>
                        <div class="media-support-body">
                            <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                            <div class="d-flex flex-wrap">
                            <a href="#" class="twit-meta-tag pe-2">#Js</a>
                            <a href="#" class="twit-meta-tag pe-2">#Bootstrap</a>
                            </div>
                            <div class="twit-date">18 Feb 2021</div>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="twit-feed">
                        <div class="d-flex align-items-center mb-2">
                            <img class="rounded-pill img-fluid avatar-50 me-3 p-1 bg-soft-warning pt-2" src="<?= base_url(); ?>public/assets/images/icons/02.png" alt="">
                            <div class="mt-2">
                            <h6 class="mb-0">Blender</h6>
                            <p class="mb-0">@blender59
                                <span class="text-primary">
                                    <svg class="icon-15" width="15" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M10,17L5,12L6.41,10.58L10,14.17L17.59,6.58L19,8M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                                    </svg>
                                </span>
                            </p>
                            </div>
                        </div>
                        <div class="media-support-body">
                            <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                            <div class="d-flex flex-wrap">
                            <a href="#" class="twit-meta-tag pe-2">#Html</a>
                            <a href="#" class="twit-meta-tag pe-2">#CSS</a>
                            </div>
                            <div class="twit-date">15 Mar 2021</div>
                        </div>
                    </div>
                </div>
                </div>
            </div> -->
            <div class="col-lg-7">
                <div class="profile-content tab-content">
                    <!-- ACCOUNT -->
                    <div id="profile-friends" class="tab-pane fade">
                        <div class="card">
                            <div class="card-header">
                                <div class="header-title">
                                    <h4 class="card-title">Account Details</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php if(session()->getTempdata('updateaccountsuccess')) :?>
                                    <div class="alert alert-success">
                                        <?= session()->getTempdata('updateaccountsuccess');?>
                                    </div>
                                <?php endif; ?>
                                <?php foreach($studdata as $studd): ?>
                                    <?= form_open('profile/updateaccount/'.$studd['studid']); ?>
                                        <label class="form-label" for="validationDefault01">FIRST NAME</label>
                                        <input type="text" name="firstname" class="form-control" 
                                        value="<?= $studd['studfn']; ?>">
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <label class="form-label" for="validationDefault01">MIDDLE NAME</label>
                                                <input type="text" name="middlename" class="form-control"
                                                value="<?= $studd['studmn']; ?>">
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label" for="validationDefault01">LAST NAME</label>
                                                <input type="text" name="lastname" class="form-control" 
                                                value="<?= $studd['studln']; ?>">
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label" for="validationDefault01">EXTENSION</label>
                                                <input type="text" name="ext" class="form-control" 
                                                value="<?= $studd['studextension']; ?>">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <label class="form-label" for="validationDefault01">BARANGAY</label>
                                                <input type="text" name="brgy" class="form-control" 
                                                value="<?= $studd['studstbarangay']; ?>">
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label" for="validationDefault01">MUNICIPALITY</label>
                                                <input type="text" name="city" class="form-control" 
                                                value="<?= $studd['studcity']; ?>">
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label" for="validationDefault01">PROVINCE</label>
                                                <input type="text" name="prov" class="form-control" 
                                                value="<?= $studd['studprovince']; ?>">
                                            </div>
                                        </div>
                                        <br>
                                        <label class="form-label" for="validationDefault01">CONTACT #</label>
                                        <input type="text" name="contact" class="form-control" 
                                        value="<?= $studd['studcontact']; ?>">
                                        <br>
                                        <label class="form-label" for="validationDefault01">EMAIL</label>
                                        <input type="text" name="email" class="form-control" 
                                        value="<?= $studd['studemail']; ?>">
                                        <br>
                                        <button class="btn btn-success" type="submit" name="update" style="width: 100%;">UPDATE</button>
                                    <?= form_close(); ?> 
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div> 
                    <!-- PROFILE -->
                    <div id="profile-profile" class="tab-pane fade active show">
                        <div class="card">
                            <div class="card-header">
                                <div class="header-title">
                                <h4 class="card-title">Profile</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="user-profile">
                                        <img src="<?= base_url(); ?>public/assets/images/avatars/01.png" alt="profile-img" class="rounded-pill avatar-130 img-fluid">
                                    </div>
                                    <?php foreach($usersaccess as $usera): ?>
                                        <?php if($usera['ustudent'] == 1): ?>
                                            <?php foreach($profiledata as $profiled): ?>
                                                <div class="mt-3">
                                                    <h3 class="d-inline-block"><?= $profiled['studfullname']; ?></h3>
                                                    <p class="d-inline-block pl-3"> - <?= $profiled['studentno']; ?></p>
                                                    <!-- <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p> -->
                                                </div>
                                            <?php endforeach; ?>
                                        <?php elseif($usera['uadmin'] == 1): ?>
                                            <?php foreach($profiledata as $profiled): ?>
                                                <div class="mt-3">
                                                    <h3 class="d-inline-block"><?= $profiled['empfullname']; ?></h3>
                                                    <p class="d-inline-block pl-3"> - <?= $profiled['empnum']; ?></p>
                                                    <!-- <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p> -->
                                                </div>
                                            <?php endforeach; ?>    
                                        <?php endif; ?>
                                    <?php endforeach; ?> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header">
                        <div class="header-title">
                            <h4 class="card-title">Change Password</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if(session()->getTempdata('updatesuccess')) :?>
                            <div class="alert alert-success">
                                <?= session()->getTempdata('updatesuccess');?>
                            </div>
                        <?php endif; ?>
                        <?php foreach($usersaccess as $usera): ?>
                            <?= form_open('profile/changepassword/'.$usera['uid']); ?>
                                <label class="form-label" for="validationDefault01">OLD PASSWORD</label>
                                
                                <input type="text" name="rcode" class="form-control" value="<?= $usera['upassword']; ?>" 
                                    style="text-alignment: left;" disabled>
                                
                                <label class="form-label" for="validationDefault01">NEW PASSWORD</label>
                                <input type="text" name="newpass" class="form-control" minlength="6" maxlength="16" required>
                                <br>
                                <button class="btn btn-success" type="submit" name="update" style="width: 100%;">UPDATE</button>
                            <?= form_close(); ?> 
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