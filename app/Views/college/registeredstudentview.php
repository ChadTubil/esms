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
                            <h4 class="card-title">REGISTERED STUDENTS</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <?php if(session()->getTempdata('error')) :?>
                                <div class="alert alert-danger">
                                    <?= session()->getTempdata('error');?>
                                </div>
                            <?php endif; ?>
                            <?php if(session()->getTempdata('success')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('success');?>
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
                                    <?php foreach($registeredstudents as $rsd):?>
                                        <?php foreach($paymenttransactionsData as $ptd):?>
                                            <?php if($ptd['studfullname'] == $rsd['studfullname']):?>
                                                <?php $CHECK= $ptd['paymentstatus']; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td><?= $rsd['studfullname']; ?></td>
                                            <td>
                                                <?php if($CHECK == 'Pending'): ?>
                                                    <span class="badge bg-danger">NO PAYMENT</span>
                                                <?php else: ?>

                                                    <a class="btn btn-sm btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="PROCESS"
                                                        onclick="window.location.href='<?= base_url(); ?>col-registeredstudent/process/<?= $rsd['studid']; ?>'">
                                                        <span class="btn-inner">
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.3345 2.75024H7.66549C4.64449 2.75024 2.75049 4.88924 2.75049 7.91624V16.0842C2.75049 19.1112 4.63549 21.2502 7.66549 21.2502H16.3335C19.3645 21.2502 21.2505 19.1112 21.2505 16.0842V7.91624C21.2505 4.88924 19.3645 2.75024 16.3345 2.75024Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M8.43994 12.0002L10.8139 14.3732L15.5599 9.6272" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg> PROCESS                        
                                                        </span>
                                                    </a>
                                                <?php endif; ?>
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