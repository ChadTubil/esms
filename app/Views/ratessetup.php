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
                            <h5 class="card-title">
                                <?php foreach($ratesdata as $ratesd) :?>
                                    <h3>RATE SET UP FOR: <strong><?= $ratesd['sy']; ?> - <?= $ratesd['sem']; ?> - <?= $ratesd['course']; ?> <?= $ratesd['year']; ?></strong></h3>
                                <?php endforeach; ?>
                            </h5>
                        </div>
                    </div>
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
                        <?php foreach($ratesdata as $ratesda) :?>
                            <?= form_open('rates/setup/'.$ratesda['rateid']); ?>
                            <h6 style="margin-left: 10px;">ACTIONS:</h6>
                            <button class="btn btn-success" type="submit" style="margin-left: 10px;">SAVE</button>
                            <a class="btn btn-primary" onclick="location.href='<?= base_url() ?>rates'" style="margin-left: 10px;">BACK</a>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-lg-5 col-sm-12" style="text-align: center;">
                                    <h5><strong>TUITION FEES</strong></h5>
                                    <div class="form-group row" style="text-align: right;">
                                        <label class="control-label col-sm-3 align-self-center mb-0">MAJOR: ₱</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" name="major" 
                                                <?php if($ratesda['major'] == '0.00'): ?>
                                                    step="0.01" type="number" placeholder="Enter Rate per hour"
                                                <?php else: ?>
                                                    type="text" value="<?= $ratesda['major']; ?>"
                                                <?php endif; ?> 
                                            >
                                        </div>
                                    </div>
                                    <div class="form-group row" style="text-align: right;">
                                        <label class="control-label col-sm-3 align-self-center mb-0">MINOR: ₱</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" name="minor"
                                                <?php if($ratesda['minor'] == '0.00'): ?>
                                                    step="0.01" type="number" placeholder="Enter Rate per hour"
                                                <?php else: ?>
                                                    type="text" value="<?= $ratesda['minor']; ?>"
                                                <?php endif; ?>
                                            >
                                        </div>
                                    </div>
                                    <div class="form-group row" style="text-align: right;">
                                        <label class="control-label col-sm-3 align-self-center mb-0">NSTP01: ₱</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" name="nstp01"
                                                <?php if($ratesda['nstp01'] == '0.00'): ?>
                                                    step="0.01" type="number" placeholder="Enter Rate per hour"
                                                <?php else: ?>
                                                    type="text" value="<?= $ratesda['nstp01']; ?>"
                                                <?php endif; ?>
                                            >
                                        </div>
                                    </div>
                                    <div class="form-group row" style="text-align: right;">
                                        <label class="control-label col-sm-3 align-self-center mb-0">NSTP02: ₱</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" name="nstp02"
                                                <?php if($ratesda['nstp02'] == '0.00'): ?>
                                                    step="0.01" type="number" placeholder="Enter Rate per hour"
                                                <?php else: ?>
                                                    type="text" value="<?= $ratesda['nstp02']; ?>"
                                                <?php endif; ?>
                                            >
                                        </div>
                                    </div>
                                    <div class="form-group row" style="text-align: right;">
                                        <label class="control-label col-sm-3 align-self-center mb-0">OTHER FEES: ₱</label>
                                        <div class="col-sm-9">
                                            <input type="text" step="0.01" class="form-control" value="<?php
                                                $totalotherfees = 0;
                                                foreach($rofdata as $rofd) {
                                                    $totalotherfees += $rofd['otherfees'];
                                                }
                                                echo number_format((float)$totalotherfees, 2, '.', '');
                                            ?>" disabled>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <?= form_close(); ?>
                                    <h5><strong>DUE DATES</strong></h5>
                                    <br>
                                    <?= form_open('rates/dues/'.$ratesda['rateid']); ?>
                                        <div class="form-group row" style="text-align: right;">
                                            <div class="col-sm-1"></div>
                                            <div class="col-sm-8" style="text-align: left;">
                                                <input type="date" class="form-control col-sm-4" name="due" required>
                                            </div>
                                            <div class="col-sm-3" style="text-align: left;">
                                                <button class="btn btn-primary" style="width: 100%">ADD</button>
                                            </div>
                                        </div>
                                    <?= form_close(); ?>
                                    <div class="form-group row" style="text-align: right;">
                                        <div class="col-sm-1"></div>
                                        <div class="col-sm-11" style="text-align: left;">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <?php if(empty($rddata)): ?>
                                                        <tr>
                                                            <td>-</td>
                                                            <td>No due dates set.</td>
                                                        </tr>
                                                    <?php else : ?>
                                                        <?php foreach($rddata as $rdd) :?>
                                                            <tr>
                                                                <td><?= $rdd['name']; ?></td>
                                                                <td><?php 
                                                                    $formatted = (new DateTime($rdd['due']))->format('F j, Y');
                                                                    echo $formatted;
                                                                ?></td>
                                                                <td style="text-align: center;">
                                                                    <a class="btn btn-sm btn-icon btn-info" title="Edit"
                                                                        href="#" data-bs-toggle="modal" data-bs-target="#editDues<?= $rdd['rdid']; ?>">
                                                                        <span class="btn-inner">
                                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                            <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        </svg>
                                                                        </span>
                                                                    </a>
                                                                    <div class="modal fade" id="editDues<?= $rdd['rdid']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content dark">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="staticBackdropLabel">UPDATE</h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <?= form_open('rates/dues/update/'.$rdd['rdid']); ?>
                                                                                <div class="modal-body" style="text-align: left;">
                                                                                    <div class="form-group">
                                                                                        <label for="email" class="form-label"><?= $rdd['name']; ?></label>
                                                                                        <input type="date" name="due" class="form-control" value="<?php echo $rdd['due']; ?>">
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
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-sm-12" style="text-align: center;"></div>
                                <div class="col-lg-5 col-sm-12" style="text-align: center;">
                                    <?= form_open('rates/rof/'.$ratesda['rateid']); ?>
                                        <h5><strong>OTHER FEES</strong><br>PARTICULARS</h5>
                                        <br>
                                        <div class="form-group row" style="text-align: right;">
                                            <div class="col-sm-1"></div>
                                            <div class="col-sm-5" style="text-align: left;">
                                                <label class="form-label">NAME</label>
                                                <input type="text" class="form-control col-sm-4" name="ratename" required>
                                            </div>
                                            <div class="col-sm-3" style="text-align: left;">
                                                <label class="form-label">FEE</label>
                                                <input type="number" step="0.01" class="form-control" name="otherfees" required>
                                            </div>
                                            <div class="col-sm-3" style="text-align: left;">
                                                <label class="form-label">ACTION</label>
                                                <button class="btn btn-primary" style="width: 100%">ADD</button>
                                            </div>
                                        </div>
                                    <?= form_close(); ?>
                                    <div class="form-group row" style="text-align: right;">
                                        <div class="col-sm-1"></div>
                                        <div class="col-sm-11" style="text-align: left;">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <?php if(empty($rofdata)): ?>
                                                        <tr>
                                                            <td>-</td>
                                                            <td>No other fees set.</td>
                                                        </tr>
                                                    <?php else : ?>
                                                        <?php foreach($rofdata as $rofd) :?>
                                                            <tr>
                                                                <td><?= $rofd['name']; ?></td>
                                                                <td>₱<?= $rofd['otherfees']; ?></td>
                                                                <td style="text-align: center;">
                                                                    <a class="btn btn-sm btn-icon btn-info" title="Edit"
                                                                        href="#" data-bs-toggle="modal" data-bs-target="#editROF<?= $rofd['rofid']; ?>">
                                                                        <span class="btn-inner">
                                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                            <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        </svg>
                                                                        </span>
                                                                    </a>
                                                                    <div class="modal fade" id="editROF<?= $rofd['rofid']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content dark">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="staticBackdropLabel">UPDATE</h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <?= form_open('rates/rof/update/'.$rofd['rofid']); ?>
                                                                                <div class="modal-body" style="text-align: left;">
                                                                                    <div class="form-group">
                                                                                        <label for="email" class="form-label">Name</label>
                                                                                        <input type="text" name="name" class="form-control" value="<?php echo $rofd['name']; ?>">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="email" class="form-label">Fee</label>
                                                                                        <input type="number" name="otherfee" class="form-control" value="<?php echo $rofd['otherfees']; ?>">
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
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        <?php endforeach; ?>
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