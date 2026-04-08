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
                            <h4 class="card-title">SELECT STUDENT TO ASSESS</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <?php if(session()->getTempdata('success')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('success');?>
                                </div>
                            <?php endif; ?>
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">STUDENT NO</th>
                                        <th style="text-align: center;">NAME</th>
                                        <th style="text-align: center;">SY</th>
                                        <th style="text-align: center;">CLUSTER</th>
                                        <th style="text-align: center;">LEVEL</th>
                                        <th style="text-align: center;">DATE</th>
                                        <th style="text-align: center;">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($enrollmenthistoryshsdata as $enrollmenthistoryshsd):?>
                                        <tr>
                                            <td style="text-align: left;">
                                                <?php
                                                    if($enrollmenthistoryshsd['studentno'] == '') {
                                                        echo "NEW STUDENT";
                                                    } else {
                                                        echo $enrollmenthistoryshsd['studentno'];
                                                    } 
                                                ?>
                                            </td>
                                            <td style="text-transform: uppercase; text-align: left;"><?= $enrollmenthistoryshsd['studfullname']; ?></td>
                                            <td style="text-align: center;">
                                                <?php 
                                                    if($enrollmenthistoryshsd['sy'] == '') {
                                                        echo "-";
                                                    } else {
                                                        echo $enrollmenthistoryshsd['sy'];
                                                    }
                                                ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php 
                                                    if($enrollmenthistoryshsd['cluster'] == '') {
                                                        echo "-";
                                                    } else {
                                                        echo $enrollmenthistoryshsd['code'];
                                                    }
                                                ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php 
                                                    if($enrollmenthistoryshsd['level'] == '') {
                                                        echo "-";
                                                    } else {
                                                        echo $enrollmenthistoryshsd['level'];
                                                    }
                                                ?>
                                            </td>
                                            <td style="text-align: center;"><?php echo $formattedDate = date('F j, Y', strtotime($enrollmenthistoryshsd['date'])); ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <a class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Assessment"
                                                    onclick="window.location.href='<?= base_url(); ?>shs-assessment/view/<?= $enrollmenthistoryshsd['studid']; ?>';">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                                            <path d="M22.4541 11.3918C22.7819 11.7385 22.7819 12.2615 22.4541 12.6082C21.0124 14.1335 16.8768 18 12 18C7.12317 18 2.98759 14.1335 1.54586 12.6082C1.21811 12.2615 1.21811 11.7385 1.54586 11.3918C2.98759 9.86647 7.12317 6 12 6C16.8768 6 21.0124 9.86647 22.4541 11.3918Z" stroke="currentColor"></path>                                    
                                                            <circle cx="12" cy="12" r="5" stroke="currentColor"></circle>                                    
                                                            <circle cx="12" cy="12" r="3" fill="currentColor"></circle>                                    
                                                            <mask mask-type="alpha" maskUnits="userSpaceOnUse" x="9" y="9" width="6" height="6">                                    
                                                                <circle cx="12" cy="12" r="3" fill="currentColor"></circle>                                    
                                                            </mask>                                    
                                                            <circle opacity="0.89" cx="13.5" cy="10.5" r="1.5" fill="white"></circle>                                    
                                                        </svg> VIEW
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