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
                            <h4 class="card-title">SELECT STUDENT TO PROCESS ADMISSION</h4>
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
                                        <th style="text-align: center;">COURSE</th>
                                        <th style="text-align: center;">SY</th>
                                        <th style="text-align: center;">LEVEL</th>
                                        <th style="text-align: center;">SEM</th>
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
                                                    if($enrollmenthistoryshsd['course'] == '0') {
                                                        echo "-";
                                                    } else {
                                                        echo $enrollmenthistoryshsd['course'];
                                                    }
                                                ?>
                                            </td>
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
                                                    if($enrollmenthistoryshsd['level'] == '') {
                                                        echo "-";
                                                    } else {
                                                        echo $enrollmenthistoryshsd['level'];
                                                    }
                                                ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php 
                                                    if($enrollmenthistoryshsd['sem'] == '') {
                                                        echo "-";
                                                    } else {
                                                        echo $enrollmenthistoryshsd['sem'];
                                                    }
                                                ?>
                                            </td>
                                            <td style="text-align: center;"><?php echo $formattedDate = date('F j, Y', strtotime($enrollmenthistoryshsd['date'])); ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <a class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="PROCESS"
                                                    onclick="window.location.href='<?= base_url(); ?>col-admission/process/<?= $enrollmenthistoryshsd['studid']; ?>';">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M12.0001 8.32739V15.6537" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M15.6668 11.9904H8.3335" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.6857 2H7.31429C4.04762 2 2 4.31208 2 7.58516V16.4148C2 19.6879 4.0381 22 7.31429 22H16.6857C19.9619 22 22 19.6879 22 16.4148V7.58516C22 4.31208 19.9619 2 16.6857 2Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg> PROCESS
                                                    </span>
                                                </a>
                                                <a class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="CANCEL"
                                                    onclick="window.location.href='<?= base_url(); ?>col-admission/process-cancel/<?= $enrollmenthistoryshsd['ehid']; ?>'">
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