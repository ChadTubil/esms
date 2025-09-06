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
            <div class="col-lg-12 col-sm-12">
                <div class="card">
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
                        <?= form_open('employees'); ?>
                            <div class="row">
                                <div class="col-lg-8 col-sm-12">
                                    <label class="form-label" for="validationDefault01">EMPLOYEE NO.</label>
                                    <input type="text" name="employeenum" class="form-control">
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">EXTENSION</label>
                                    <input type="text" name="extension" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">LAST NAME</label>
                                    <input type="text" name="lastname" class="form-control">
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">FIRST NAME</label>
                                    <input type="text" name="firstname" class="form-control">
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">MIDDLE NAME</label>
                                    <input type="text" name="middlename" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-5 col-sm-12">
                                    <label class="form-label" for="validationDefault01">HIRING DATE</label>
                                    <input type="date" name="hiringdate" class="form-control">
                                </div>
                                <div class="col-lg-7 col-sm-12">
                                    <label class="form-label" for="validationDefault01">POSITION</label>
                                    <input type="text" name="position" class="form-control">
                                </div>
                            </div>
                            <label class="form-label" for="exampleFormControlSelect1">STATUS</label>
                            <select name="employeestatus" class="form-select" id="exampleFormControlSelect1">
                                <option selected="" disabled=""></option>
                                <option value="Full Time">Full Time</option>
                                <option value="Part Time">Part Time</option>
                                <option value="On The Job Training">On The Job Training</option>
                                <option value="Part Time">Part Time</option>
                                <option value="Contractual">Contractual</option>
                                <option value="Probationary">Probationary</option>
                                <option value="Regular">Regular</option>
                            </select>
                            <br>
                            <button class="btn btn-success" type="submit" name="add" style="width: 100%;">SAVE</button>
                        <?= form_close(); ?>
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
                                        <th>EMP NO.</th>
                                        <th>NAME</th>
                                        <th>POSITION</th>
                                        <th>STATUS</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($employeesdata as $empd):?>
                                        <tr>
                                            <td><?= $empd['empnum']; ?></td>
                                            <td><?= $empd['empfullname']; ?></td>
                                            <td><?= $empd['empposition']; ?></td>
                                            <td><?= $empd['empstatus']; ?></td>
                                            <td>
                                                <div class="flex align-items-center list-user-action">
                                                    <a class="btn btn-sm btn-icon btn-warning" title="Image"
                                                        href="#" data-bs-toggle="modal" data-bs-target="#imageModal<?= $empd['empid']; ?>">
                                                        <span class="btn-inner">
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9849 15.3462C8.11731 15.3462 4.81445 15.931 4.81445 18.2729C4.81445 20.6148 8.09636 21.2205 11.9849 21.2205C15.8525 21.2205 19.1545 20.6348 19.1545 18.2938C19.1545 15.9529 15.8735 15.3462 11.9849 15.3462Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9849 12.0059C14.523 12.0059 16.5801 9.94779 16.5801 7.40969C16.5801 4.8716 14.523 2.81445 11.9849 2.81445C9.44679 2.81445 7.3887 4.8716 7.3887 7.40969C7.38013 9.93922 9.42394 11.9973 11.9525 12.0059H11.9849Z" stroke="currentColor" stroke-width="1.42857" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>                                                        
                                                        </span>
                                                    </a>
                                                    <div class="modal fade" id="imageModal<?= $empd['empid']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content dark">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="staticBackdropLabel">UPDATE IMAGE</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <?= form_open_multipart('employees/image/'.$empd['empid']); ?>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-12 col-sm-12">
                                                                            <div class="form-group" style="text-align: center">
                                                                                <img src="<?php
                                                                                        if(empty($empd['image'])){
                                                                                            echo base_url().'/public/assets/images/bioimage.png"';
                                                                                        } else {
                                                                                            echo $empd['image'];
                                                                                        }
                                                                                ?>" alt="" style="width: 50%">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="email" class="form-label">UPLOAD IMAGE FOR BIOMETRICS</label>
                                                                                <p>Use 1920 x 1920 pixels and layout format.</p>
                                                                                <input type="file" name="bioimage" class="form-control" value="<?php echo $empd['image']; ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="text-start">
                                                                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </div>
                                                                <?= form_close(); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a class="btn btn-sm btn-icon btn-info" title="RFID"
                                                        href="#" data-bs-toggle="modal" data-bs-target="#rfidModal<?= $empd['empid']; ?>">
                                                        <span class="btn-inner">
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9846 21.606C11.9846 21.606 19.6566 19.283 19.6566 12.879C19.6566 6.474 19.9346 5.974 19.3196 5.358C18.7036 4.742 12.9906 2.75 11.9846 2.75C10.9786 2.75 5.26557 4.742 4.65057 5.358C4.03457 5.974 4.31257 6.474 4.31257 12.879C4.31257 19.283 11.9846 21.606 11.9846 21.606Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M9.38574 11.8746L11.2777 13.7696L15.1757 9.86963" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>                            
                                                        </span>
                                                    </a>
                                                    <div class="modal fade" id="rfidModal<?= $empd['empid']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content dark">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="staticBackdropLabel">UPDATE RFID</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <?= form_open('employees/rfid/'.$empd['empid']); ?>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-12 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label for="email" class="form-label">RFID</label>
                                                                                <input type="text" name="rfid" class="form-control" value="<?php echo $empd['rfidno']; ?>" autocomplete="off" autofocus>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <!-- <div class="text-start">
                                                                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                                    </div> -->
                                                                </div>
                                                                <?= form_close(); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a class="btn btn-sm btn-icon btn-primary" title="Edit"
                                                        href="#" data-bs-toggle="modal" data-bs-target="#editModal<?= $empd['empid']; ?>">
                                                        <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                        </span>
                                                    </a>
                                                    <div class="modal fade" id="editModal<?= $empd['empid']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content dark">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="staticBackdropLabel">UPDATE EMPLOYEE</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <?= form_open('employees/update/'.$empd['empid']); ?>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-4 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label for="email" class="form-label">EMP NO.</label>
                                                                                <input type="text" name="employeenum" class="form-control" value="<?php echo $empd['empnum']; ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label for="email" class="form-label">IMP ID</label>
                                                                                <input type="text" name="impno" class="form-control" value="<?php echo $empd['impno']; ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-5 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label for="email" class="form-label">HIRING DATE</label>
                                                                                <input type="date" name="hiringdate" class="form-control" value="<?php echo $empd['emphiringdate']; ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-5 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label for="email" class="form-label">EXTENSION</label>
                                                                                <input type="text" name="extension" class="form-control" value="<?php echo $empd['empextension']; ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-7 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label for="email" class="form-label">LAST NAME</label>
                                                                                <input type="text" name="lastname" class="form-control" value="<?php echo $empd['empln']; ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-7 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label for="email" class="form-label">FIRST NAME</label>
                                                                                <input type="text" name="firstname" class="form-control" value="<?php echo $empd['empfn']; ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-5 col-sm-12">
                                                                            <div class="form-group">
                                                                                <label for="email" class="form-label">MIDDLE NAME</label>
                                                                                <input type="text" name="middlename" class="form-control" value="<?php echo $empd['empmn']; ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="email" class="form-label">POSITION</label>
                                                                        <input type="text" name="position" class="form-control" value="<?php echo $empd['empposition']; ?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="exampleFormControlSelect1">STATUS</label>
                                                                        <select name="employeestatus" class="form-select" id="exampleFormControlSelect1">
                                                                            <option value="<?php echo $empd['empstatus']; ?>" selected><?php echo $empd['empstatus']; ?></option>
                                                                            <option value="On The Job Training">On The Job Training</option>
                                                                            <option value="Part Time">Part Time</option>
                                                                            <option value="Contractual">Contractual</option>
                                                                            <option value="Probationary">Probationary</option>
                                                                            <option value="Regular">Regular</option>
                                                                        </select>
                                                                    </div>
                                                                    <br>
                                                                    <div class="text-start">
                                                                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </div>
                                                                <?= form_close(); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                                        onclick="window.location.href='<?= base_url(); ?>employees/delete/<?= $empd['empid']; ?>';">
                                                        <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                            <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                        </span>
                                                    </a>
                                                </div>
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