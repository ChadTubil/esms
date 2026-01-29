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
                        <?= form_open('chartofaccounts'); ?>
                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <label class="form-label" for="validationDefault01">CODE</label>
                                    <input type="text" name="code" class="form-control">
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <label class="form-label" for="validationDefault01">NAME</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <label class="form-label" for="validationDefault01">TYPE</label>
                                    <select name="type" class="form-select">
                                        <option value="CURRENT ASSET">CURRENT ASSET</option>
                                        <option value="NON-CURRENT ASSET">NON-CURRENT ASSET</option>
                                        <option value="LIABILITY">LIABILITY</option>
                                        <option value="EQUITY">EQUITY</option>
                                        <option value="INCOME">INCOME</option>
                                        <option value="EXPENSE">EXPENSE</option>
                                    </select>
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <label class="form-label" for="validationDefault01">PARENT ACCOUNT</label>
                                    <select name="parentaccount" class="form-select">
                                        <option value="0">Parent Account</option>
                                        <?php foreach($coadata as $coad):?>
                                            <option value="<?= $coad['accountid']; ?>"><?= $coad['accountcode']; ?> - <?= $coad['accountname']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <label class="form-label" for="validationDefault01">DESCRIPTION</label>
                                    <textarea name="description" class="form-control"></textarea>
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
                                        <th>CODE</th>
                                        <th>ACCOUNT</th>
                                        <th>PARENT</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($coadata as $coad):?>
                                        <tr>
                                            <td><?= $coad['accountcode']; ?></td>
                                            <td><?= $coad['accountname']; ?></td>
                                            <td><?php
                                                if($coad['parentaccountid'] == 0) {
                                                    echo "Parent Account";
                                                } else {
                                                    $parentId = $coad['parentaccountid'];
                                                    $parent = isset($coadata) ? array_filter($coadata, function($item) use ($parentId) { return $item['accountid'] == $parentId; }) : [];
                                                    if(!empty($parent)) {
                                                        $parent = reset($parent);
                                                        echo $parent['accountcode'] . ' - ' . $parent['accountname'];
                                                    } else {
                                                        echo "N/A";
                                                    }
                                                }
                                            ?></td>
                                            <td>
                                                <a class="btn btn-sm btn-icon btn-primary" title="View Details"
                                                    href="#" data-bs-toggle="modal" data-bs-target="#editModal<?= $coad['accountid']; ?>">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                                            <path d="M22.4541 11.3918C22.7819 11.7385 22.7819 12.2615 22.4541 12.6082C21.0124 14.1335 16.8768 18 12 18C7.12317 18 2.98759 14.1335 1.54586 12.6082C1.21811 12.2615 1.21811 11.7385 1.54586 11.3918C2.98759 9.86647 7.12317 6 12 6C16.8768 6 21.0124 9.86647 22.4541 11.3918Z" stroke="currentColor"></path>                                    
                                                            <circle cx="12" cy="12" r="5" stroke="currentColor"></circle>                                    
                                                            <circle cx="12" cy="12" r="3" fill="currentColor"></circle>                                    
                                                            <mask mask-type="alpha" maskUnits="userSpaceOnUse" x="9" y="9" width="6" height="6">                                    
                                                                <circle cx="12" cy="12" r="3" fill="currentColor"></circle>                                    
                                                            </mask>                                    
                                                            <circle opacity="0.89" cx="13.5" cy="10.5" r="1.5" fill="white"></circle>                                    
                                                        </svg>                            
                                                    </span>
                                                </a>
                                                <div class="modal fade" id="editModal<?= $coad['accountid']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content dark">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">UPDATE CHART OF ACCOUNTS</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <?= form_open('chartofaccounts/update/'.$coad['accountid']); ?>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="email" class="form-label">CODE</label>
                                                                    <input type="text" name="code" class="form-control" value="<?php echo $coad['accountcode']; ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="email" class="form-label">NAME</label>
                                                                    <input type="text" name="name" class="form-control" value="<?php echo $coad['accountname']; ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="email" class="form-label">TYPE</label>
                                                                    <select name="type" class="form-select">
                                                                        <option value="<?php echo $coad['accounttype']; ?>" selected><?php echo $coad['accounttype']; ?></option>
                                                                        <option value="CURRENT ASSET">CURRENT ASSET</option>
                                                                        <option value="NON-CURRENT ASSET">NON-CURRENT ASSET</option>
                                                                        <option value="LIABILITY">LIABILITY</option>
                                                                        <option value="EQUITY">EQUITY</option>
                                                                        <option value="INCOME">INCOME</option>
                                                                        <option value="EXPENSE">EXPENSE</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="email" class="form-label">PARENT ACCOUNT</label>
                                                                    <select name="parentaccount" class="form-select">
                                                                        <option value="<?php echo $coad['parentaccountid']; ?>" selected>
                                                                            <?php
                                                                                if($coad['parentaccountid'] == 0) {
                                                                                    echo "Parent Account";
                                                                                } else {
                                                                                    $parentId = $coad['parentaccountid'];
                                                                                    $parent = isset($coadata) ? array_filter($coadata, function($item) use ($parentId) { return $item['accountid'] == $parentId; }) : [];
                                                                                    if(!empty($parent)) {
                                                                                        $parent = reset($parent);
                                                                                        echo $parent['accountcode'] . ' - ' . $parent['accountname'];
                                                                                    } else {
                                                                                        echo "N/A";
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </option>
                                                                        <option value="<?= $coad['accountid']; ?>"><?= $coad['accountcode']; ?> - <?= $coad['accountname']; ?></option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="email" class="form-label">DESCRIPTION</label>
                                                                    <textarea name="description" id="description" class="form-control"><?= $coad['description']; ?></textarea>
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
                                                    onclick="window.location.href='<?= base_url(); ?>chartofaccounts/delete/<?= $coad['accountid']; ?>'">
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