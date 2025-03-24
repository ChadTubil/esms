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
            <div class="col-lg-4 col-sm-12">
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
                        <?= form_open('users'); ?>
                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <label class="form-label" for="validationDefault01">ACCOUNT NO.</label>
                                    <input type="text" name="account" class="form-control">
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <label class="form-label" for="validationDefault01">USERNAME</label>
                                    <input type="text" name="username" class="form-control">
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <label class="form-label" for="validationDefault01">PASSWORD</label>
                                    <input type="text" name="password" class="form-control">
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <br>
                                    <label class="form-label" for="validationDefault01">ACCESS</label>
                                    <br>
                                    <input class="form-check-input" type="checkbox" name="cadmin" value="1"><span> Administrator</span>
                                    <br>
                                    <input class="form-check-input" type="checkbox" name="cregistrar" value="1"><span> Registrar</span>
                                    <br>
                                    <input class="form-check-input" type="checkbox" name="cpc" value="1"><span> Program Chair</span>
                                </div>
                            </div>
                            <br>
                            <button class="btn btn-success" type="submit" name="add" style="width: 100%;">SAVE</button>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-sm-12">
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
                                        <th>ID</th>
                                        <th>USERNAME</th>
                                        <th>STATUS</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($usersinfo as $user):?>
                                        <tr>
                                            <td><?= $user['uaccountid']; ?></td>
                                            <td><?= $user['username']; ?></td>
                                            <td>
                                                <?php if($user['ustatus'] == 1): ?>
                                                    <?= "Disabled"; ?>
                                                <?php else: ?>
                                                    <?= "Active"; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="flex align-items-center list-user-action">
                                                    <button class="btn btn-sm btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Disable"
                                                        onclick="window.location.href='<?= base_url(); ?>users/disable/<?= $user['uid']; ?>';"
                                                        <?php if($user['ustatus'] == 1){echo 'hidden';}else{} ?>>
                                                        <span class="btn-inner">
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M14.3955 9.59497L9.60352 14.387" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M14.3971 14.3898L9.60107 9.59277" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.3345 2.75024H7.66549C4.64449 2.75024 2.75049 4.88924 2.75049 7.91624V16.0842C2.75049 19.1112 4.63549 21.2502 7.66549 21.2502H16.3335C19.3645 21.2502 21.2505 19.1112 21.2505 16.0842V7.91624C21.2505 4.88924 19.3645 2.75024 16.3345 2.75024Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>                                                                                              
                                                        </span>
                                                    </button>
                                                    <button class="btn btn-sm btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Enable"
                                                        onclick="window.location.href='<?= base_url(); ?>users/enable/<?= $user['uid']; ?>';"
                                                        <?php if($user['ustatus'] == 0){echo 'hidden';}else{} ?>>
                                                        <span class="btn-inner">
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M10.33 16.5928H4.0293" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M13.1406 6.90042H19.4413" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.72629 6.84625C8.72629 5.5506 7.66813 4.5 6.36314 4.5C5.05816 4.5 4 5.5506 4 6.84625C4 8.14191 5.05816 9.19251 6.36314 9.19251C7.66813 9.19251 8.72629 8.14191 8.72629 6.84625Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M20.0002 16.5538C20.0002 15.2581 18.9429 14.2075 17.6379 14.2075C16.3321 14.2075 15.2739 15.2581 15.2739 16.5538C15.2739 17.8494 16.3321 18.9 17.6379 18.9C18.9429 18.9 20.0002 17.8494 20.0002 16.5538Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                         
                                                            </svg>                                                                                              
                                                        </span>
                                                    </button>
                                                    <a class="btn btn-sm btn-icon btn-primary" title="Edit"
                                                        href="#" data-bs-toggle="modal" data-bs-target="#editModal<?= $user['uid']; ?>">
                                                        <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                        </span>
                                                    </a>
                                                    <div class="modal fade" id="editModal<?= $user['uid']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content dark">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="staticBackdropLabel">UPDATE - <?= $user['username'] ?></h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <?= form_open('users/update/'.$user['uid']); ?>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="email" class="form-label">ACCOUNT NO.</label>
                                                                        <input type="text" name="account" class="form-control" value="<?php echo $user['uaccountid']; ?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="email" class="form-label">USERNAME</label>
                                                                        <input type="text" name="username" class="form-control" value="<?php echo $user['username']; ?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="email" class="form-label">PASSWORD</label>
                                                                        <input type="text" name="password" class="form-control" value="<?php echo $user['upassword']; ?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="validationDefault01">ACCESS</label>
                                                                        <br>
                                                                        <input class="form-check-input" type="checkbox" name="cadmin" value="1"
                                                                            <?php if($user['uadmin'] == 1){ echo 'checked'; }else{ } ?>><span> Administrator</span>
                                                                        <br>
                                                                        <input class="form-check-input" type="checkbox" name="cregistrar" value="1"
                                                                            <?php if($user['uregistrar'] == 1){ echo 'checked'; }else{ } ?>><span> Registrar</span>
                                                                        <br>
                                                                        <input class="form-check-input" type="checkbox" name="cpc" value="1"
                                                                            <?php if($user['uprogramchair'] == 1){ echo 'checked'; }else{ } ?>><span> Program Chair</span>
                                                                    </div>
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
                                                        onclick="window.location.href='<?= base_url(); ?>users/delete/<?= $user['uid']; ?>';">
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