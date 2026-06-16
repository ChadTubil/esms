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
                                    <h4 class="card-title">IBED</h4>
                                    <p class="mb-0">Integrated Basic Education</p>          
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-striped" style="font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th>LEVEL</th>
                                            <th>TOTAL</th>
                                            <th>LEVEL</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>KINDER 1</td>
                                            <td><?= $kinder1; ?></td>
                                            <td>GRADE 5</td>
                                            <td><?= $grade5; ?></td>
                                        </tr>
                                        <tr>
                                            <td>KINDER 2</td>
                                            <td><?= $kinder2; ?></td>
                                            <td>GRADE 6</td>
                                            <td><?= $grade6; ?></td>
                                        </tr>
                                        <tr>
                                            <td>GRADE 1</td>
                                            <td><?= $grade1; ?></td>
                                            <td>GRADE 7</td>
                                            <td><?= $grade7; ?></td>
                                        </tr>
                                        <tr>
                                            <td>GRADE 2</td>
                                            <td><?= $grade2; ?></td>
                                            <td>GRADE 8</td>
                                            <td><?= $grade8; ?></td>
                                        </tr>
                                        <tr>
                                            <td>GRADE 3</td>
                                            <td><?= $grade3; ?></td>
                                            <td>GRADE 9</td>
                                            <td><?= $grade9; ?></td>
                                        </tr>
                                        <tr>
                                            <td>GRADE 4</td>
                                            <td><?= $grade4; ?></td>
                                            <td>GRADE 10</td>
                                            <td><?= $grade10; ?></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td style="font-weight: bold; color: #18f12394;"></td>
                                            <td style="font-weight: bold; color: #18f12394;"></td>
                                            <td style="font-weight: bold; color: #18f12394;"><?= $TOTALIBED; ?></td>
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
                                    <h4 class="card-title">SHS</h4>
                                    <p class="mb-0">Senior High School</p>          
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-striped" style="font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th>PROGRAM</th>
                                            <th>GRADE 11</th>
                                            <th>GRADE 12</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>ASSH</td>
                                            <td><?= $assh11; ?></td>
                                            <td>0</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>STEM</td>
                                            <td><?= $stem11; ?></td>
                                            <td><?= $stem12; ?></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>HT</td>
                                            <td><?= $ht11; ?></td>
                                            <td>0</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>BE</td>
                                            <td><?= $be11; ?></td>
                                            <td>0</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>ICT</td>
                                            <td><?= $ict11; ?></td>
                                            <td><?= $ict12; ?></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>ABM</td>
                                            <td>0</td>
                                            <td><?= $abm12; ?></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>HUMSS</td>
                                            <td>0</td>
                                            <td><?= $humss12; ?></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>HE</td>
                                            <td>0</td>
                                            <td><?= $he12; ?></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td style="font-weight: bold; color: #18f12394;"><?= $TOTALGR11; ?></td>
                                            <td style="font-weight: bold; color: #18f12394;"><?= $TOTALGR12; ?></td>
                                            <td style="font-weight: bold; color: #18f12394;"></td>
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
                                            <td><?= $actdev1st; ?></td>
                                            <td><?= $actdev2nd; ?></td>
                                            <td><?= $actdev3rd; ?></td>
                                            <td><?= $actdev4th; ?></td>
                                            <td><?= $ACTDEVTOTAL; ?></td>
                                        </tr>
                                        <tr>
                                            <td>ACT - NETWORKING</td>
                                            <td><?= $actnet1st; ?></td>
                                            <td><?= $actnet2nd; ?></td>
                                            <td><?= $actnet3rd; ?></td>
                                            <td><?= $actnet4th; ?></td>
                                            <td><?= $ACTNETTOTAL; ?></td>
                                        </tr>
                                        <tr>
                                            <td>BSCE</td>
                                            <td><?= $bsce1st; ?></td>
                                            <td><?= $bsce2nd; ?></td>
                                            <td><?= $bsce3rd; ?></td>
                                            <td><?= $bsce4th; ?></td>
                                            <td><?= $BSCETOTAL; ?></td>
                                        </tr>
                                        <tr>
                                            <td>BSCPE</td>
                                            <td><?= $bscpe1st; ?></td>
                                            <td><?= $bscpe2nd; ?></td>
                                            <td><?= $bscpe3rd; ?></td>
                                            <td><?= $bscpe4th; ?></td>
                                            <td><?= $BSCPETOTAL; ?></td>
                                        </tr>
                                        <tr>
                                            <td>BSCS</td>
                                            <td><?= $bscs1st; ?></td>
                                            <td><?= $bscs2nd; ?></td>
                                            <td><?= $bscs3rd; ?></td>
                                            <td><?= $bscs4th; ?></td>
                                            <td><?= $BSCSTOTAL; ?></td>
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
                                            <td style ="font-weight: bold; color: #18f12394;"><?= $total1stsc; ?></td>
                                            <td style ="font-weight: bold; color: #18f12394;"><?= $total2ndsc; ?></td>
                                            <td style ="font-weight: bold; color: #18f12394;"><?= $total3rdsc; ?></td>
                                            <td style ="font-weight: bold; color: #18f12394;"><?= $total4thsc; ?></td>
                                            <td style ="font-weight: bold; color: #18f12394;"><?= $TOTALSCITE; ?></td>
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
                                            <td><?= $beed1st; ?></td>
                                            <td><?= $beed2nd; ?></td>
                                            <td><?= $beed3rd; ?></td>
                                            <td><?= $beed4th; ?></td>
                                            <td><?= $BEEDTOTAL; ?></td>
                                        </tr>
                                        <tr>
                                            <td>BSED - ENG</td>
                                            <td><?= $bseng1st; ?></td>
                                            <td><?= $bseng2nd; ?></td>
                                            <td><?= $bseng3rd; ?></td>
                                            <td><?= $bseng4th; ?></td>
                                            <td><?= $BSEDENGTOTAL; ?></td>
                                        </tr>
                                        <tr>
                                            <td>BSED - FIL</td>
                                            <td><?= $bsfil1st; ?></td>
                                            <td><?= $bsfil2nd; ?></td>
                                            <td><?= $bsfil3rd; ?></td>
                                            <td><?= $bsfil4th; ?></td>
                                            <td><?= $BSEDFILTOTAL; ?></td>
                                        </tr>
                                        <tr>
                                            <td>BSED - MATH</td>
                                            <td><?= $bsmath1st; ?></td>
                                            <td><?= $bsmath2nd; ?></td>
                                            <td><?= $bsmath3rd; ?></td>
                                            <td><?= $bsmath4th; ?></td>
                                            <td><?= $BSEDMATHTOTAL; ?></td>
                                        </tr>
                                        <tr>
                                            <td>BSED - SCI</td>
                                            <td><?= $bssci1st; ?></td>
                                            <td><?= $bssci2nd; ?></td>
                                            <td><?= $bssci3rd; ?></td>
                                            <td><?= $bssci4th; ?></td>
                                            <td><?= $BSEDSCITOTAL; ?></td>
                                        </tr>
                                        <tr>
                                            <td>BSPSYCH</td>
                                            <td><?= $bspsy1st; ?></td>
                                            <td><?= $bspsy2nd; ?></td>
                                            <td><?= $bspsy3rd; ?></td>
                                            <td><?= $bspsy4th; ?></td>
                                            <td><?= $BSEDPsychtOTAL; ?></td>
                                        </tr>
                                        <tr>
                                            <td>METHODS</td>
                                            <td><?= $bsmet1st; ?></td>
                                            <td><?= $bsmet2nd; ?></td>
                                            <td><?= $bsmet3rd; ?></td>
                                            <td><?= $bsmet4th; ?></td>
                                            <td><?= $BSEDMETHODSTOTAL; ?></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td style ="font-weight: bold; color: #18f12394;"><?= $total1stsased; ?></td>
                                            <td style ="font-weight: bold; color: #18f12394;"><?= $total2ndsased; ?></td>
                                            <td style ="font-weight: bold; color: #18f12394;"><?= $total3rdsased; ?></td>
                                            <td style ="font-weight: bold; color: #18f12394;"><?= $total4thsased; ?></td>
                                            <td style ="font-weight: bold; color: #18f12394;"><?= $TOTALSASED; ?></td>
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
                                            <td><?= $bsa1st; ?></td>
                                            <td><?= $bsa2nd; ?></td>
                                            <td><?= $bsa3rd; ?></td>
                                            <td><?= $bsa4th; ?></td>
                                            <td><?= $BSATOTAL; ?></td>
                                        </tr>
                                        <tr>
                                            <td>BSAIS</td>
                                            <td><?= $bsais1st; ?></td>
                                            <td><?= $bsais2nd; ?></td>
                                            <td><?= $bsais3rd; ?></td>
                                            <td><?= $bsais4th; ?></td>
                                            <td><?= $BSAISTOTAL; ?></td>
                                        </tr>
                                        <tr>
                                            <td>BSBA - MM</td>
                                            <td><?= $bsbamm1st; ?></td>
                                            <td><?= $bsbamm2nd; ?></td>
                                            <td><?= $bsbamm3rd; ?></td>
                                            <td><?= $bsbamm4th; ?></td>
                                            <td><?= $BSBAMMTOTAL; ?></td>
                                        </tr>
                                        <tr>
                                            <td>BSBA - FM</td>
                                            <td><?= $bsbafm1st; ?></td>
                                            <td><?= $bsbafm2nd; ?></td>
                                            <td><?= $bsbafm3rd; ?></td>
                                            <td><?= $bsbafm4th; ?></td>
                                            <td><?= $BSBAFMTOTAL; ?></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td style="font-weight: bold; color: #18f12394;"><?= $total1stsba; ?></td>
                                            <td style="font-weight: bold; color: #18f12394;"><?= $total2ndsba; ?></td>
                                            <td style="font-weight: bold; color: #18f12394;"><?= $total3rdsba; ?></td>
                                            <td style="font-weight: bold; color: #18f12394;"><?= $total4thsba; ?></td>
                                            <td style="font-weight: bold; color: #18f12394;"><?= $TOTALSBA; ?></td>
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
                                            <td><?= $bscrim1st; ?></td>
                                            <td><?= $bscrim2nd; ?></td>
                                            <td><?= $bscrim3rd; ?></td>
                                            <td><?= $bscrim4th; ?></td>
                                            <td><?= $BSCRIMTOTAL; ?></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td style="font-weight: bold; color: #18f12394;"><?= $total1stcrim; ?></td>
                                            <td style="font-weight: bold; color: #18f12394;"><?= $total2ndcrim; ?></td>
                                            <td style="font-weight: bold; color: #18f12394;"><?= $total3rdcrim; ?></td>
                                            <td style="font-weight: bold; color: #18f12394;"><?= $total4thcrim; ?></td>
                                            <td style="font-weight: bold; color: #18f12394;"><?= $TOTALSCJ; ?></td>
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
                                            <td><?= $bshm1st; ?></td>
                                            <td><?= $bshm2nd; ?></td>
                                            <td><?= $bshm3rd; ?></td>
                                            <td><?= $bshm4th; ?></td>
                                            <td><?= $BSHMTOTAL; ?></td>
                                        </tr>
                                        <tr>
                                            <td>BSTM</td>
                                            <td><?= $bstm1st; ?></td>
                                            <td><?= $bstm2nd; ?></td>
                                            <td><?= $bstm3rd; ?></td>
                                            <td><?= $bstm4th; ?></td>
                                            <td><?= $BSTMTOTAL; ?></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td style="font-weight: bold; color: #18f12394;"><?= $total1ststhm; ?></td>
                                            <td style="font-weight: bold; color: #18f12394;"><?= $total2ndsthm; ?></td>
                                            <td style="font-weight: bold; color: #18f12394;"><?= $total3rdsthm; ?></td>
                                            <td style="font-weight: bold; color: #18f12394;"><?= $total4thsthm; ?></td>
                                            <td style="font-weight: bold; color: #18f12394;"><?= $TOTALSTHM; ?></td>
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
        <!--  -->
    <!-- ----------- FOOTER ------------------ -->
    <?= $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?= $this->endSection(); ?>