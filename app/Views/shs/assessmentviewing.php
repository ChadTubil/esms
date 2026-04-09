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
                            <h4 class="card-title">ACTION</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php foreach($enrollmenthistoryshsdata as $ehshsd): ?>
                            <a class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="PRINT COR"
                            
                            href="<?= base_url('shs-assessment/print/'.$ehshsd['studid']) ?>" 
                            target="_blank">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7379 2.76175H8.08493C6.00493 2.75375 4.29993 4.41175 4.25093 6.49075V17.2037C4.20493 19.3167 5.87993 21.0677 7.99293 21.1147C8.02393 21.1147 8.05393 21.1157 8.08493 21.1147H16.0739C18.1679 21.0297 19.8179 19.2997 19.8029 17.2037V8.03775L14.7379 2.76175Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                    <path d="M14.4751 2.75V5.659C14.4751 7.079 15.6231 8.23 17.0431 8.234H19.7981" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                    <path d="M14.2882 15.3584H8.88818" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                    <path d="M12.2432 11.606H8.88721" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                                </svg> PRINT COR                           
                            </a>
                            <a class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="APPROVED"
                            href="<?= base_url('shs-assessment/aprroved/'.$ehshsd['ehid']) ?>">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.3345 2.75024H7.66549C4.64449 2.75024 2.75049 4.88924 2.75049 7.91624V16.0842C2.75049 19.1112 4.63549 21.2502 7.66549 21.2502H16.3335C19.3645 21.2502 21.2505 19.1112 21.2505 16.0842V7.91624C21.2505 4.88924 19.3645 2.75024 16.3345 2.75024Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                    <path d="M8.43994 12.0002L10.8139 14.3732L15.5599 9.6272" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                                </svg> APRROVED                           
                            </a>
                        <?php endforeach; ?>
                        <button class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="BACK" onclick="window.history.back();">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                            </svg> BACK                          
                        </button>
                    </div>
                </div>
            </div>
        </div>
            <?php foreach($shsassessmentdata as $shsassessd): ?>
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="card">
                            <div class="card-header justify-content-between" style="text-align: center;">
                                <div class="header-title">
                                    <h4 class="card-title"><strong>ASSESSMENT OF FEES</strong></h4>
                                </div>
                            </div>
                            <br>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <h5>Student Name: <strong><?= $shsassessd['studfullname']; ?></strong></h5>
                                        <h5>Address: <strong><?= $shsassessd['studstbarangay']; ?> <?= $shsassessd['studcity']; ?>, <?= $shsassessd['studprovince']; ?></strong></h5>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <h5>Level/Class: <strong><?= $shsassessd['level']; ?> - <?= $shsassessd['cluster']; ?> / <?= $shsassessd['section']; ?></strong></h5>
                                        <h5>School Year: <strong><?= $shsassessd['sy']; ?></strong></h5>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <h5><strong>FIRST SEMESTER</strong></h5>
                                        <div class="table-responsive">
                                            <table class="table" style="font-size: 11px;">
                                                <thead>
                                                    <tr>
                                                        <th>GROUPING</th>
                                                        <th>SUBJECT</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($firstsemester as $firstsem): ?>
                                                        <tr>
                                                            <td><?= $firstsem['type']; ?> SUBJECTS</td>
                                                            <td><?= $firstsem['code']; ?> - <?= $firstsem['subject']; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <h5><strong>SECOND SEMESTER</strong></h5>
                                        <div class="table-responsive">
                                            <table class="table" style="font-size: 11px;">
                                                <thead>
                                                    <tr>
                                                        <th>GROUPING</th>
                                                        <th>SUBJECT</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($secondsemester as $secondseme): ?>
                                                        <tr>
                                                            <td><?= $secondseme['type']; ?> SUBJECTS</td>
                                                            <td><?= $secondseme['code']; ?> - <?= $secondseme['subject']; ?></td>
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
            <?php endforeach; ?>
            <?php foreach($shsratedata as $shsrated): ?>
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-12">
                                        <h5><strong>TUITION FEE</strong></h5>
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table" style="width: 100%;">
                                                <tbody>
                                                    <tr>
                                                        <td>Tuition</td>
                                                        <td style="text-align: right;">₱<?= $shsrated['tf']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>QVR (Public)</td>
                                                        <td style="text-align: right;">-₱<?= $shsrated['tf']; ?></td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td style="text-align: right;">Sub Total</td>
                                                        <td>₱0.00</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <h5><strong>MISCELLANEOUS FEES</strong></h5>
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table" style="width: 100%;">
                                                <tbody>
                                                    <?php foreach($shsrofdata as $shsrofd): ?>
                                                        <?php if($shsrofd['rateid'] == $shsrated['rateid']): ?>
                                                            <tr>
                                                                <td><?= $shsrofd['name']; ?></td>
                                                                <td style="text-align: right;">₱<?= $shsrofd['otherfees']; ?></td>
                                                            </tr>
                                                        <?php else: ?>
                                                            <p>No miscellaneous fees found.</p>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td style="text-align: right;">Sub Total</td>
                                                        <td style="text-align: right;">
                                                            <?php 
                                                                $totalotherfees = 0;
                                                                foreach($shsrofdata as $shsrofd) {
                                                                    if($shsrofd['rateid'] == $shsrated['rateid']) {
                                                                        $totalotherfees += $shsrofd['otherfees'];
                                                                    }
                                                                }
                                                                echo "₱" . number_format($totalotherfees, 2);
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <div class="table-responsive">
                                            <br>
                                            <br>
                                            <table class="table" style="width: 100%;">
                                                <tbody>
                                                    <tr>
                                                        <td>Tuition</td>
                                                        <td style="text-align: right;">₱0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Miscellaneous</td>
                                                        <td style="text-align: right;"><?php 
                                                                $totalotherfees = 0;
                                                                foreach($shsrofdata as $shsrofd) {
                                                                    if($shsrofd['rateid'] == $shsrated['rateid']) {
                                                                        $totalotherfees += $shsrofd['otherfees'];
                                                                    }
                                                                }
                                                                echo "₱" . number_format($totalotherfees, 2);
                                                            ?></td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td style="text-align: right;">Grand Total</td>
                                                        <td style="text-align: right;">
                                                            <?php 
                                                                $grandtotal = 0 + $totalotherfees;
                                                                echo "₱" . number_format($grandtotal, 2);
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <div class="table-responsive">
                                            <h5><strong>INSTALLMENT SCHEDULE</strong></h5>
                                            <br>
                                            <table class="table" style="width: 100%;">
                                                <tbody>
                                                    <?php foreach($shsrddata as $shsrdd): ?>
                                                        <?php if($shsrdd['rateid'] == $shsrated['rateid']): ?>
                                                            <tr>
                                                                <td><?= $shsrdd['name']; ?></td>
                                                                <td><?php 
                                                                    $formatted = (new DateTime($shsrdd['due']))->format('F j, Y');
                                                                    echo $formatted;
                                                                ?></td>
                                                            </tr>
                                                        <?php else: ?>
                                                            <p>No installment data found.</p>
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
                </div>
            <?php endforeach; ?>
    </div>
    <!-- End of Page Content -->

    <!-- ----------- FOOTER ------------------ -->
    <?= $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?= $this->endSection(); ?>