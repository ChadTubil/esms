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
            <div class="card-body">
                <?php if(session()->getTempdata('addsuccess')) :?>
                    <div class="alert alert-success">
                        <?= session()->getTempdata('addsuccess');?>
                    </div>
                <?php endif; ?>
                <?php if(isset($validation)): ?>
                    <div class="alert alert-danger">
                        <?php echo $validation->listErrors(); ?>
                    </div>
                <?php endif; ?>
            </div>
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
                            <?php if(session()->getTempdata('endedsuccess')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('endedsuccess');?>
                                </div>
                            <?php endif; ?>
                            <?php if(session()->getTempdata('updatesuccess')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('updatesuccess');?>
                                </div>
                            <?php endif; ?>
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>STUDENT NUMBER</th>
                                        <th>STUDENT FULLNAME</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($admissionrecordsshs as $adrecshs):?>
                                        <tr>
                                            <td>
                                                <?= $adrecshs['studentno'] ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    if($adrecshs['studfullname'] == '') {
                                                        echo $adrecshs['studln'] . ', ' . $adrecshs['studfn'] . ' ' . $adrecshs['studmn'];
                                                    } else {
                                                        echo $adrecshs['studfullname'];
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <!-- Print Button -->
                                                <a href="<?= base_url('guidance-records/print/' . $adrecshs['studid']); ?>" target="_blank" 
                                                    class="btn btn-sm btn-icon btn-success" title="Print">
                                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7369 2.76175H8.08489C6.00489 2.75375 4.30089 4.41075 4.25089 6.49075V17.2277C4.20589 19.3297 5.87389 21.0697 7.97489 21.1147C8.01189 21.1147 8.04889 21.1157 8.08489 21.1147H16.0729C18.1629 21.0407 19.8149 19.3187 19.8029 17.2277V8.03775L14.7369 2.76175Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                                        <path d="M14.4751 2.75V5.659C14.4751 7.079 15.6241 8.23 17.0441 8.234H19.7981" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                                        <path d="M11.6421 15.9497V9.90869" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                                        <path d="M9.29639 13.5942L11.6414 15.9492L13.9864 13.5942" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                                                    </svg>
                                                </a>
                                                <!-- Edit Button -->
                                                <a class="btn btn-sm btn-icon btn-primary" title="Edit"
                                                href="#" data-bs-toggle="modal" data-bs-target="#editModal<?= $adrecshs['studid']; ?>">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                                            <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                                            <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                                                        </svg>                                                      
                                                    </span>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
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