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
            <div class="col-lg-6 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if(session()->getTempdata('success')) :?>
                            <div class="alert alert-success">
                                <?= session()->getTempdata('success');?>
                            </div>
                        <?php endif; ?>
                        <?php if(isset($validation)): ?>
                            <div class="alert alert-danger">
                                <?php echo $validation->listErrors(); ?>
                            </div>
                        <?php endif; ?>
                        <?= form_open('discount'); ?>
                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">NAME</label>
                                    <input type="text" name="discountname" class="form-control">
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">DISCOUNT TYPE</label>
                                    <select name="discounttype" class="form-select">
                                        <option value="">-</option>
                                        <option value="SCHOLARSHIP">SCHOLARSHIP</option>
                                        <option value="DISCOUNT">DISCOUNT</option>
                                        <option value="GRANT">GRANT</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">FEE TYPE</label>
                                    <select name="feetype" class="form-select">
                                        <option value="">-</option>
                                        <option value="SCHOLARSHIP">ALL</option>
                                        <option value="DISCOUNT">TUITION FEE</option>
                                        <option value="GRANT">MISC FEE</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">PERCENTAGE</label>
                                    <input type="number" name="percentage" class="form-control">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">AMOUNT</label>
                                    <input type="number" step="0.01" name="amount" class="form-control">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">START DATE</label>
                                    <input type="date" name="startdate" class="form-control">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">END DATE</label>
                                    <input type="date" name="enddate" class="form-control">
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <label class="form-label" for="validationDefault01">TERMS</label>
                                    <input type="text" name="terms" class="form-control">
                                </div>
                            </div>
                            <br>
                            <button class="btn btn-success" type="submit" style="width: 100%;">SAVE</button>
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
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>NAME</th>
                                        <th>DISCOUNT</th>
                                        <th>TYPE</th>
                                        <th>STATUS</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($discountdata as $discountd): ?>
                                        <tr>
                                            <td><?= $discountd['discountname']; ?></td>
                                            <td><?php 
                                                if($discountd['discountamount'] == 0){
                                                    echo $discountd['discountpercentage'].'%';
                                                }else{
                                                    echo '₱'.$discountd['discountamount'];
                                                }
                                            ?></td>
                                            <td><?= $discountd['discounttype']; ?></td>
                                            <td><?= $discountd['status']; ?></td>
                                            <td>
                                                <a class="btn btn-sm btn-icon btn-primary" title="Edit"
                                                    href="#" data-bs-toggle="modal" data-bs-target="#editModal<?= $discountd['discountid']; ?>">
                                                    <span class="btn-inner">
                                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
                                                    </span>
                                                </a>
                                                <div class="modal fade" id="editModal<?= $discountd['discountid']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content dark">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">UPDATE SCHOOL YEAR</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <?= form_open('discount/update/'.$discountd['discountid']); ?>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-lg-4 col-sm-12">
                                                                        <label class="form-label" for="validationDefault01">NAME</label>
                                                                        <input type="text" name="discountname" class="form-control"
                                                                        value="<?= $discountd['discountname']; ?>">
                                                                    </div>
                                                                    <div class="col-lg-4 col-sm-12">
                                                                        <label class="form-label" for="validationDefault01">DISCOUNT TYPE</label>
                                                                        <select name="discounttype" class="form-select">
                                                                            <option value="<?= $discountd['discounttype']; ?>"><?= $discountd['discounttype']; ?></option>
                                                                            <option value="SCHOLARSHIP">SCHOLARSHIP</option>
                                                                            <option value="DISCOUNT">DISCOUNT</option>
                                                                            <option value="GRANT">GRANT</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-4 col-sm-12">
                                                                        <label class="form-label" for="validationDefault01">FEE TYPE</label>
                                                                        <select name="feetype" class="form-select">
                                                                            <option value="<?= $discountd['feetype']; ?>"><?= $discountd['feetype']; ?></option>
                                                                            <option value="SCHOLARSHIP">ALL</option>
                                                                            <option value="DISCOUNT">TUITION FEE</option>
                                                                            <option value="GRANT">MISC FEE</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-3 col-sm-12">
                                                                        <label class="form-label" for="validationDefault01">PERCENTAGE</label>
                                                                        <input type="number" name="percentage" class="form-control"
                                                                        value="<?= $discountd['discountpercentage']; ?>">
                                                                    </div>
                                                                    <div class="col-lg-3 col-sm-12">
                                                                        <label class="form-label" for="validationDefault01">AMOUNT</label>
                                                                        <input type="number" step="0.01" name="amount" class="form-control"
                                                                        value="<?= $discountd['discountamount']; ?>">
                                                                    </div>
                                                                    <div class="col-lg-3 col-sm-12">
                                                                        <label class="form-label" for="validationDefault01">START DATE</label>
                                                                        <input type="date" name="startdate" class="form-control"
                                                                        value="<?= $discountd['startdate']; ?>">
                                                                    </div>
                                                                    <div class="col-lg-3 col-sm-12">
                                                                        <label class="form-label" for="validationDefault01">END DATE</label>
                                                                        <input type="date" name="enddate" class="form-control"
                                                                        value="<?= $discountd['enddate']; ?>">
                                                                    </div>
                                                                    <div class="col-lg-12 col-sm-12">
                                                                        <label class="form-label" for="validationDefault01">TERMS</label>
                                                                        <input type="text" name="terms" class="form-control"
                                                                        value="<?= $discountd['terms']; ?>">
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
                                                <?php if($discountd['status'] == 'Active'): ?>
                                                    <a class="btn btn-sm btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Expired"
                                                        onclick="window.location.href='<?= base_url(); ?>discount/expired/<?= $discountd['discountid']; ?>'">
                                                        <span class="btn-inner">
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M14.3955 9.59497L9.60352 14.387" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M14.3971 14.3898L9.60107 9.59277" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.3345 2.75024H7.66549C4.64449 2.75024 2.75049 4.88924 2.75049 7.91624V16.0842C2.75049 19.1112 4.63549 21.2502 7.66549 21.2502H16.3335C19.3645 21.2502 21.2505 19.1112 21.2505 16.0842V7.91624C21.2505 4.88924 19.3645 2.75024 16.3345 2.75024Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                <?php else: ?>
                                                    <a class="btn btn-sm btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Active"
                                                        onclick="window.location.href='<?= base_url(); ?>discount/active/<?= $discountd['discountid'];; ?>'">
                                                        <span class="btn-inner">
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.3345 2.75024H7.66549C4.64449 2.75024 2.75049 4.88924 2.75049 7.91624V16.0842C2.75049 19.1112 4.63549 21.2502 7.66549 21.2502H16.3335C19.3645 21.2502 21.2505 19.1112 21.2505 16.0842V7.91624C21.2505 4.88924 19.3645 2.75024 16.3345 2.75024Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                                                <path d="M8.43994 12.0002L10.8139 14.3732L15.5599 9.6272" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                                                            </svg>                            
                                                        </span>
                                                    </a>
                                                <?php endif; ?>
                                                <a class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                                    onclick="window.location.href='<?= base_url(); ?>discount/delete/<?= $discountd['discountid']; ?>'">
                                                    <span class="btn-inner">
                                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                        <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
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