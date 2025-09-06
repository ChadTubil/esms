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
                            <br>
                            <br>
                                <div class="row">
                                    <div class="col-lg-5 col-sm-12" style="text-align: center;">
                                        <h5><strong>TUITION FEES</strong></h5>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-3 align-self-center mb-0">MAJOR:</label>
                                            <div class="col-sm-9">
                                                <input type="number" step="0.01" class="form-control" 
                                                    name="major" 
                                                    <?php if($ratesda['major'] == '0.00'): ?>
                                                        placeholder="Enter Rate per hour"
                                                    <?php else: ?>
                                                        value="<?= $ratesda['major']; ?>"
                                                    <?php endif; ?> 
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-3 align-self-center mb-0">MINOR:</label>
                                            <div class="col-sm-9">
                                                <input type="number" step="0.01" class="form-control"
                                                    name="minor"
                                                    <?php if($ratesda['minor'] == '0.00'): ?>
                                                        placeholder="Enter Rate per hour"
                                                    <?php else: ?>
                                                        value="<?= $ratesda['minor']; ?>"
                                                    <?php endif; ?>
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-3 align-self-center mb-0">NSTP01:</label>
                                            <div class="col-sm-9">
                                                <input type="number" step="0.01" class="form-control"
                                                    name="nstp01"
                                                    <?php if($ratesda['nstp01'] == '0.00'): ?>
                                                        placeholder="Enter Rate per hour"
                                                    <?php else: ?>
                                                        value="<?= $ratesda['nstp01']; ?>"
                                                    <?php endif; ?>
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-3 align-self-center mb-0">NSTP02:</label>
                                            <div class="col-sm-9">
                                                <input type="number" step="0.01" class="form-control" 
                                                    name="nstp02"
                                                    <?php if($ratesda['nstp02'] == '0.00'): ?>
                                                        placeholder="Enter Rate per hour"
                                                    <?php else: ?>
                                                        value="<?= $ratesda['nstp02']; ?>"
                                                    <?php endif; ?>
                                                >
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        <br>
                                        <h5><strong>DUE DATES</strong></h5>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-3 align-self-center mb-0">DUE DATE 1:</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" 
                                                    name="due1" value="<?= $ratesda['due1']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-3 align-self-center mb-0">DUE DATE 2:</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" 
                                                    name="due2" value="<?= $ratesda['due2']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-3 align-self-center mb-0">DUE DATE 3:</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" 
                                                    name="due3" value="<?= $ratesda['due3']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-3 align-self-center mb-0">DUE DATE 4:</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" 
                                                    name="due4" value="<?= $ratesda['due4']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-sm-12" style="text-align: center;">

                                    </div>
                                    <div class="col-lg-5 col-sm-12" style="text-align: center;">
                                        <h5><strong>OTHER FEES</strong><br>PARTICULARS</h5>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-4 align-self-center mb-0">REGISTRATION FEE:</label>
                                            <div class="col-sm-8">
                                                <input type="registrationfee" step="0.01" class="form-control" 
                                                    name="registrationfee"
                                                    <?php if($ratesda['registrationfee'] == '0.00'): ?>
                                                        placeholder="Enter Fee"
                                                    <?php else: ?>
                                                        value="<?= $ratesda['registrationfee']; ?>"
                                                    <?php endif; ?>
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-4 align-self-center mb-0">LIBRARY:</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01" class="form-control" 
                                                    name="library"
                                                    <?php if($ratesda['library'] == '0.00'): ?>
                                                        placeholder="Enter Fee"
                                                    <?php else: ?>
                                                        value="<?= $ratesda['library']; ?>"
                                                    <?php endif; ?>
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-4 align-self-center mb-0">LABORATORY:</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01" class="form-control" 
                                                    name="laboratory"
                                                    <?php if($ratesda['laboratory'] == '0.00'): ?>
                                                        placeholder="Enter Fee"
                                                    <?php else: ?>
                                                        value="<?= $ratesda['laboratory']; ?>"
                                                    <?php endif; ?>
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-4 align-self-center mb-0">ATHLETICS:</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01" class="form-control"
                                                    name="athletics"
                                                    <?php if($ratesda['athletics'] == '0.00'): ?>
                                                        placeholder="Enter Fee"
                                                    <?php else: ?>
                                                        value="<?= $ratesda['athletics']; ?>"
                                                    <?php endif; ?>
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-4 align-self-center mb-0">MEDICAL & DENTAL:</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01" class="form-control"
                                                    name="medical"
                                                    <?php if($ratesda['medical'] == '0.00'): ?>
                                                        placeholder="Enter Fee"
                                                    <?php else: ?>
                                                        value="<?= $ratesda['medical']; ?>"
                                                    <?php endif; ?>
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-4 align-self-center mb-0">GUIDANCE:</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01" class="form-control"
                                                    name="guidance"
                                                    <?php if($ratesda['guidance'] == '0.00'): ?>
                                                        placeholder="Enter Fee"
                                                    <?php else: ?>
                                                        value="<?= $ratesda['guidance']; ?>"
                                                    <?php endif; ?>
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-4 align-self-center mb-0">SCHOOL ORGAN:</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01" class="form-control"
                                                    name="schoolorgan"
                                                    <?php if($ratesda['schoolorgan'] == '0.00'): ?>
                                                        placeholder="Enter Fee"
                                                    <?php else: ?>
                                                        value="<?= $ratesda['schoolorgan']; ?>"
                                                    <?php endif; ?>
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-4 align-self-center mb-0">ID:</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01" class="form-control"
                                                    name="id"
                                                    <?php if($ratesda['id'] == '0.00'): ?>
                                                        placeholder="Enter Fee"
                                                    <?php else: ?>
                                                        value="<?= $ratesda['id']; ?>"
                                                    <?php endif; ?>
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-4 align-self-center mb-0">AUDIO VISUAL:</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01" class="form-control"
                                                    name="av"
                                                    <?php if($ratesda['av'] == '0.00'): ?>
                                                        placeholder="Enter Fee"
                                                    <?php else: ?>
                                                        value="<?= $ratesda['av']; ?>"
                                                    <?php endif; ?>
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-4 align-self-center mb-0">PRISAA SPORTS DEV'T:</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01" class="form-control"
                                                    name="prisaa"
                                                    <?php if($ratesda['prisaa'] == '0.00'): ?>
                                                        placeholder="Enter Fee"
                                                    <?php else: ?>
                                                        value="<?= $ratesda['prisaa']; ?>"
                                                    <?php endif; ?>
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-4 align-self-center mb-0">INTERNET FEE:</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01" class="form-control"
                                                    name="internetfee"
                                                    <?php if($ratesda['internetfee'] == '0.00'): ?>
                                                        placeholder="Enter Fee"
                                                    <?php else: ?>
                                                        value="<?= $ratesda['internetfee']; ?>"
                                                    <?php endif; ?>
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-4 align-self-center mb-0">STUDENT HANDBOOK:</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01" class="form-control"
                                                    name="studenthb"
                                                    <?php if($ratesda['studenthb'] == '0.00'): ?>
                                                        placeholder="Enter Fee"
                                                    <?php else: ?>
                                                        value="<?= $ratesda['studenthb']; ?>"
                                                    <?php endif; ?>
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-4 align-self-center mb-0">INSURANCE:</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01" class="form-control"
                                                    name="insurance"
                                                    <?php if($ratesda['insurance'] == '0.00'): ?>
                                                        placeholder="Enter Fee"
                                                    <?php else: ?>
                                                        value="<?= $ratesda['insurance']; ?>"
                                                    <?php endif; ?>
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-4 align-self-center mb-0">RSO:</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01" class="form-control"
                                                    name="rso"
                                                    <?php if($ratesda['rso'] == '0.00'): ?>
                                                        placeholder="Enter Fee"
                                                    <?php else: ?>
                                                        value="<?= $ratesda['rso']; ?>"
                                                    <?php endif; ?>
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-4 align-self-center mb-0">CULTURAL FEE:</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01" class="form-control"
                                                    name="cultural"
                                                    <?php if($ratesda['cultural'] == '0.00'): ?>
                                                        placeholder="Enter Fee"
                                                    <?php else: ?>
                                                        value="<?= $ratesda['cultural']; ?>"
                                                    <?php endif; ?>
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-4 align-self-center mb-0">STUDENT COUNCIL FEE:</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01" class="form-control"
                                                    name="studentcouncil"
                                                    <?php if($ratesda['studentcouncil'] == '0.00'): ?>
                                                        placeholder="Enter Fee"
                                                    <?php else: ?>
                                                        value="<?= $ratesda['studentcouncil']; ?>"
                                                    <?php endif; ?>
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row" style="text-align: right;">
                                            <label class="control-label col-sm-4 align-self-center mb-0">FLEXIBLE/BLENDED LEARNING SYSTEM:</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="0.01" class="form-control"
                                                    name="learningsystem"
                                                    <?php if($ratesda['learningsystem'] == '0.00'): ?>
                                                        placeholder="Enter Fee"
                                                    <?php else: ?>
                                                        value="<?= $ratesda['learningsystem']; ?>"
                                                    <?php endif; ?>
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?= form_close(); ?>
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