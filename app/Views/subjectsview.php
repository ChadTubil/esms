<?php $this->extend("layouts/base"); ?>

<?php $this->section("title"); ?>
    <?php echo $page_title; ?>
<?php $this->endSection(); ?>
<?php $this->section("page_heading"); ?>
    <?php echo $page_heading; ?>
<?php $this->endSection(); ?>
<?php $this->section("page_p"); ?>
    <?php echo $page_p; ?>
<?php $this->endSection(); ?>

<?php echo $this->section('content'); ?>
    <!-- ----------- SIDEBAR ------------------ -->
    <?php echo $this->include("partials/sidebar"); ?>  
    <!-- ----------- END OF SIDEBAR ------------------ --> 

    <!-- Begin Page Content -->

    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
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
                        <?= form_open('subjects'); ?>
                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SUBJECT</label>
                                    <input type="text" name="subject" class="form-control">
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">CODE</label>
                                    <input type="text" name="subcode" class="form-control">
                                </div>
                                <div class="col-lg-2 col-sm-12" style="text-align: center;">
                                    <label class="form-label" for="validationDefault01">MAJOR</label>
                                    <input class="form-check-input" type="checkbox" name="major" value="1">
                                </div>
                                <div class="col-lg-3 col-sm-12" style="text-align: center;">
                                    <label class="form-label" for="validationDefault01">LEC HOURS</label>
                                    <input type="text" name="lechours" class="form-control">
                                </div>
                                <div class="col-lg-3 col-sm-12" style="text-align: center;">
                                    <label class="form-label" for="validationDefault01">LAB HOURS</label>
                                    <input type="text" name="labhours" class="form-control">
                                </div>
                                <div class="col-lg-3 col-sm-12" style="text-align: center;">
                                    <label class="form-label" for="validationDefault01">LEC UNITS</label>
                                    <input type="text" name="lecunits" class="form-control">
                                </div>
                                <div class="col-lg-3 col-sm-12" style="text-align: center;">
                                    <label class="form-label" for="validationDefault01">LAB UNITS</label>
                                    <input type="text" name="labunits" class="form-control">
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label" for="validationDefault01">PRE-REQUISITE</label>
                                    <input type="text" name="prerequisite" class="form-control">
                                </div>
                            </div>
                            <br>
                            <button class="btn btn-success" type="submit" name="add" style="width: 100%;">SAVE</button>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
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
                                        <th>CODE</th>
                                        <th>SUBJECT</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($subjectsdata as $subjectsd):?>
                                        <tr>
                                            <td><?= $subjectsd['subcode']; ?></td>
                                            <td><?= $subjectsd['subject']; ?></td>
                                            <td>
                                                <div class="flex align-items-center list-user-action">
                                                    <a class="btn btn-sm btn-icon btn-primary" title="Edit"
                                                        href="#" data-bs-toggle="modal" data-bs-target="#editModal<?= $subjectsd['subid']; ?>">
                                                        <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                        </span>
                                                    </a>
                                                    <div class="modal fade" id="editModal<?= $subjectsd['subid']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content dark">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="staticBackdropLabel">UPDATE SUBJECT</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <?= form_open('subjects/update/'.$subjectsd['subid']); ?>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="email" class="form-label">SUBJECT</label>
                                                                        <input type="text" name="subject" class="form-control" value="<?php echo $subjectsd['subject']; ?>">
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-5 col-sm-12">
                                                                            <label class="form-label" for="validationDefault01">CODE</label>
                                                                            <input type="text" name="subcode" class="form-control" value="<?php echo $subjectsd['subcode']; ?>">
                                                                        </div>
                                                                        <div class="col-lg-2 col-sm-12" style="text-align: center;">
                                                                            <label class="form-label" for="validationDefault01">MAJOR</label><br>
                                                                            <input class="form-check-input" type="checkbox" name="major" value="1"
                                                                            <?php if($subjectsd['major'] == 1){ echo 'checked'; }else{ } ?>>
                                                                        </div>
                                                                        <div class="col-lg-5 col-sm-12">
                                                                            <label class="form-label" for="validationDefault01">PRE-REQUISITE</label>
                                                                            <input type="text" name="prerequisite" class="form-control" value="<?php echo $subjectsd['prerequisite']; ?>">
                                                                        </div>
                                                                        <div class="col-lg-4 col-sm-12">
                                                                            <label class="form-label" for="validationDefault01">LEC HOURS</label>
                                                                            <input type="text" name="lechours" class="form-control" value="<?php echo $subjectsd['lechours']; ?>">
                                                                        </div>
                                                                        <div class="col-lg-4 col-sm-12">
                                                                            <label class="form-label" for="validationDefault01">LAB HOURS</label>
                                                                            <input type="text" name="labhours" class="form-control" value="<?php echo $subjectsd['labhours']; ?>">
                                                                        </div>
                                                                        <div class="col-lg-4 col-sm-12">
                                                                            <label class="form-label" for="validationDefault01">TOTAL HOURS</label>
                                                                            <h2><?php echo $subjectsd['hours']; ?></h2>
                                                                        </div>
                                                                        <div class="col-lg-4 col-sm-12">
                                                                            <label class="form-label" for="validationDefault01">LEC UNITS</label>
                                                                            <input type="text" name="lecunits" class="form-control" value="<?php echo $subjectsd['lecunits']; ?>">
                                                                        </div>
                                                                        <div class="col-lg-4 col-sm-12">
                                                                            <label class="form-label" for="validationDefault01">LAB UNITS</label>
                                                                            <input type="text" name="labunits" class="form-control" value="<?php echo $subjectsd['labunits']; ?>">
                                                                        </div>
                                                                        <div class="col-lg-4 col-sm-12">
                                                                            <label class="form-label" for="validationDefault01">TOTAL UNITS</label>
                                                                            <h2><?php echo $subjectsd['units']; ?></h2>
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
                                                    <a class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                                        onclick="window.location.href='<?= base_url(); ?>subjects/delete/<?= $subjectsd['subid']; ?>';">
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
    <?php echo $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?php echo $this->endSection(); ?>