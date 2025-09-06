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
                            <h5 class="card-title">SELECT CUTOFF DATE TO GENERATE ATTENDANCE</h5>
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
                        <?= form_open('hrd-attendance'); ?>
                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">STARTING DATE</label>
                                    <input type="date" name="startdate" class="form-control" value="<?= $DATESTART ?>">
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label class="form-label" for="validationDefault01">ENDING DATE</label>
                                    <input type="date" name="enddate" class="form-control" value="<?= $DATEEND ?>">
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <button class="btn btn-success" type="submit" style="width: 100%; height: 100%;">GENERATE</button>
                                    <br>
                                    
                                </div>
                            </div>
                            <br>
                        <?= form_close(); ?>
                    </div>
                </div>
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
                            <div>
                                <h6>SAVE AS</h6>
                                <button class="btn btn-success" style="width: 10%;" data-bs-toggle="tooltip" data-bs-placement="top" title="Save as xlsx"
                                    onclick="window.location.href='<?= base_url(); ?>hrd-attendanc-download-excel/<?= $DATESTART; ?>/<?= $DATEEND; ?>'">EXCEL</button>
                            </div>
                            <br>
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NAME</th>
                                        <th>DATE</th>
                                        <th>IN</th>
                                        <th>OUT</th>
                                        <th>RH</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($attendancedata as $attendanced):?>
                                        <?php foreach($empdata as $empd):?>
                                            <?php if($attendanced['employeeno'] == $empd['empnum']): ?>
                                                <tr>
                                                    <td><?= $attendanced['employeeno']; ?></td>
                                                    <td><?= $empd['empfullname']; ?></td>
                                                    <td><?= $formattedDate = date('F j, Y', strtotime($attendanced['date'])); ?></td>
                                                    <td><?= $formattedTime = date('h:i A', strtotime($attendanced['timein'])); ?></td>
                                                    <td>
                                                        <?php  
                                                            if(empty($attendanced['timeout']) || $attendanced['timeout'] == '00:00:00') {
                                                                echo "--:-- --";
                                                            } else {
                                                                echo $formattedTime = date('h:i A', strtotime($attendanced['timeout']));
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php  
                                                            $start = new DateTime($attendanced['timein']);
                                                            $end = new DateTime($attendanced['timeout']);
                                                            if(empty($attendanced['timeout']) || $attendanced['timeout'] == '00:00:00')  {
                                                                echo $formattedDiffHours = '-';
                                                            } else {
                                                                $interval = $start->diff($end);
                                                                $hours = $interval->h + ($interval->i / 60) + ($interval->s / 3600);
                                                                echo $formattedDiffHours = number_format($hours, 3);
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
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