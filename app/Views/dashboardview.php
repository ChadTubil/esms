<?php $this->extend("layouts/base"); ?>

<?= $this->section('title') ?>
    <?= $page_title; ?>
<?= $this->endSection() ?>
<?= $this->section('page_heading') ?>
    <?= $page_heading; ?>
<?= $this->endSection(); ?>
<?= $this->section("page_p"); ?>
    <?= $page_p; ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
    <!-- ----------- SIDEBAR ------------------ -->
    <?= $this->include("partials/sidebar"); ?>  
    <!-- ----------- END OF SIDEBAR ------------------ --> 
    <?php foreach($usersaccess as $access) : ?>
        <?php if($access['uadmin'] == '1' || $access['uregistrar'] == '1') : ?>
            <div class="conatiner-fluid content-inner mt-n5 py-0">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="row row-cols-1">
                            <div class="overflow-hidden d-slider1 ">
                                <ul  class="p-0 m-0 mb-2 swiper-wrapper list-inline">
                                    <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                                        <div class="card-body" style="width: 100%;">
                                            <div class="progress-widget">
                                                <div class="progress-detail">
                                                    <p class="mb-2">NEW STUDENTS</p>
                                                    <h4 class="counter"><?= $etdnewstudent; ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                                        <div class="card-body">
                                            <div class="progress-widget">
                                                <div class="progress-detail">
                                                    <p class="mb-2">OLD STUDENTS</p>
                                                    <h4 class="counter"><?= $etdoldstudent; ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                                        <div class="card-body">
                                            <div class="progress-widget">
                                                <div class="progress-detail">
                                                    <p  class="mb-2">REGISTERED</p>
                                                    <h4 class="counter"><?= $etdregisteredstudent; ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
                                        <div class="card-body">
                                            <div class="progress-widget">
                                                <div class="progress-detail">
                                                    <p  class="mb-2">ADMITTED</p>
                                                    <h4 class="counter"><?= $etdadmittedstudent; ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
                                        <div class="card-body">
                                            <div class="progress-widget">
                                                <div class="progress-detail">
                                                    <p  class="mb-2">ADVISED</p>
                                                    <h4 class="counter">0</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
                                        <div class="card-body">
                                            <div class="progress-widget">
                                                <div class="progress-detail">
                                                    <p  class="mb-2">ENROLLED</p>
                                                    <h4 class="counter">0</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <div class="swiper-button swiper-button-next"></div>
                                <div class="swiper-button swiper-button-prev"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">SCITE</h4>
                                    <p class="mb-0">School Of Computing, Information Technology, & Engineering</p>          
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-striped" style="font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th>PROGRAM</th>
                                            <th>1ST</th>
                                            <th>2ND</th>
                                            <th>3RD</th>
                                            <th>4TH</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>ACT - APP DEV</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>ACT - NETWORKING</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>BSCE</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>BSCPE</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>BSCS</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>BSIT</td>
                                            <td><?= $bsit1st; ?></td>
                                            <td><?= $bsit2nd; ?></td>
                                            <td><?= $bsit3rd; ?></td>
                                            <td><?= $bsit4th; ?></td>
                                            <td><?= $BSITTOTAL; ?></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><?= $total1st; ?></td>
                                            <td><?= $total2nd; ?></td>
                                            <td><?= $total3rd; ?></td>
                                            <td><?= $total4th; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">SASED</h4>
                                    <p class="mb-0">School Of Arts, Sciences, & Education</p>          
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-striped" style="font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th>PROGRAM</th>
                                            <th>1ST</th>
                                            <th>2ND</th>
                                            <th>3RD</th>
                                            <th>4TH</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>BEED</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>BSED - ENG</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>BSED - FIL</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>BSED - MATH</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>BSED - SCI</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>BSPSYCH</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>METHODS</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">SBA</h4>
                                    <p class="mb-0">School Of Business Administration</p>          
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-striped" style="font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th>PROGRAM</th>
                                            <th>1ST</th>
                                            <th>2ND</th>
                                            <th>3RD</th>
                                            <th>4TH</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>BSA</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>BSAIS</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>BSBA - MM</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>BSBA - FM</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">SCJ</h4>
                                    <p class="mb-0">School Of Criminal Justice</p>          
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-striped" style="font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th>PROGRAM</th>
                                            <th>1ST</th>
                                            <th>2ND</th>
                                            <th>3RD</th>
                                            <th>4TH</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>BSCRIM</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">STHM</h4>
                                    <p class="mb-0">School Of Tourism, And Hospitality Management</p>          
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-striped" style="font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th>PROGRAM</th>
                                            <th>1ST</th>
                                            <th>2ND</th>
                                            <th>3RD</th>
                                            <th>4TH</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>BSHM</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>BSTM</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="conatiner-fluid content-inner mt-n5 py-0">
                
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
        
    <!-- ----------- FOOTER ------------------ -->
    <?= $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?= $this->endSection(); ?>
        