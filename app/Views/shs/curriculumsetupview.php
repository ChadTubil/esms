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
                    <div class="card-body">
                        <?php foreach($shscurriculumdata as $shscurriculumd): ?>
                            <h1><?= $shscurriculumd['code']; ?> - <?= $shscurriculumd['sy']; ?> - <?= $shscurriculumd['level']; ?></h1>
                        <?php endforeach; ?>
                        <h5>CURRICULUM</h5>
                        <br>
                        <br>
                        <h5>ADD SUBJECT</h5>
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
                        <?= form_open('shs-curriculum/setup/'.$shscurriculumd['currid']); ?>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SUBJECT</label>
                                    <select name="subject" class="form-select" style="width: 100%;">
                                        <option selected="" disabled=""></option>
                                        <?php foreach ($shssubjectsdata as $shssubjectsd): ?>
                                            <option value="<?php echo $shssubjectsd['subid']; ?>"><?php echo $shssubjectsd['code']; ?> - <?php echo $shssubjectsd['subject']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">LEVEL</label>
                                    <input type="text" name="level" class="form-control" value="<?= $shscurriculumd['level']; ?>" disabled>
                                    <input type="text" name="level" class="form-control" value="<?= $shscurriculumd['level']; ?>" hidden>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SEMESTER</label>
                                    <select name="sem" class="form-select" style="width: 100%;">
                                        <option value="1st Semester">1st Semester</option>
                                        <option value="2nd Semester">2nd Semester</option>
                                        <option value="Summer">Summer</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <button class="btn btn-success" type="submit" name="add" style="width: 100%;">ADD</button>
                        <?= form_close(); ?>
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card">
                        <div class="card-header">
                            <div style="text-align: center;">
                                <h5><strong>
                                    <?php foreach($shscurriculumdata as $shscurriculumd): ?>
                                        <?= $shscurriculumd['code']; ?> - <?= $shscurriculumd['sy']; ?> - <?= $shscurriculumd['level']; ?>
                                    <?php endforeach; ?>
                                </strong></h5>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive mt-4">
                                <div style="text-align: center;"><h6>FIRST SEMESTER</h6></div>
                                <table id="basic-table" class="table table-striped mb-0" role="grid" style="font-size: 11px">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">SUB CODE</th>
                                        <th style="text-align: center">DESCRIPTION</th>
                                        <th style="text-align: center">HOURS</th>
                                        <th style="text-align: center">PRE-REQUISITE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($cddata as $cdd):?>
                                            <?php foreach($shssubjectsdata as $shssubjectsd):?>
                                                <?php if($cdd['subid'] == $shssubjectsd['subid'] && $cdd['level'] == $shscurriculumd['level'] && $cdd['sem'] == '1st Semester'): ?>
                                                    <tr>
                                                        <td style="text-align: center"><?= $shssubjectsd['code']; ?></td>
                                                        <td style="text-align: center"><?= $shssubjectsd['subject']; ?></td>
                                                        <td style="text-align: center"><?= $shssubjectsd['hours']; ?></td>
                                                        <td style="text-align: center"><?php 
                                                            if($shssubjectsd['prerequisite'] == '') {
                                                                echo 'None';
                                                            } else {
                                                                echo $shssubjectsd['prerequisite'];
                                                            }
                                                        ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th style="text-align: right; font-size: 14px;">TOTAL HOURS</th>
                                            <th style="text-align: center; font-size: 14px;">
                                                <strong>
                                                    <?php
                                                        $totalHours = 0;
                                                        foreach($cddata as $cdd){
                                                            foreach($shssubjectsdata as $shssubjectsd){
                                                                if($cdd['subid'] == $shssubjectsd['subid'] && $cdd['level'] == $shscurriculumd['level'] && $cdd['sem'] == '1st Semester') {
                                                                    $totalHours += $shssubjectsd['hours'];
                                                                }
                                                            }
                                                        }
                                                        echo $totalHours;
                                                    ?>
                                                </strong>
                                            </th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <br>
                            <div class="table-responsive mt-4">
                                <div style="text-align: center;"><h6>SECOND SEMESTER</h6></div>
                                <table id="basic-table" class="table table-striped mb-0" role="grid" style="font-size: 11px">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">SUB CODE</th>
                                        <th style="text-align: center">DESCRIPTION</th>
                                        <th style="text-align: center">HOURS</th>
                                        <th style="text-align: center">PRE-REQUISITE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($cddata as $cdd):?>
                                            <?php foreach($shssubjectsdata as $shssubjectsd):?>
                                                <?php if($cdd['subid'] == $shssubjectsd['subid'] && $cdd['level'] == $shscurriculumd['level'] && $cdd['sem'] == '2nd Semester'): ?>
                                                    <tr>
                                                        <td style="text-align: center"><?= $shssubjectsd['code']; ?></td>
                                                        <td style="text-align: center"><?= $shssubjectsd['subject']; ?></td>
                                                        <td style="text-align: center"><?= $shssubjectsd['hours']; ?></td>
                                                        <td style="text-align: center"><?php 
                                                            if($shssubjectsd['prerequisite'] == '') {
                                                                echo 'None';
                                                            } else {
                                                                echo $shssubjectsd['prerequisite'];
                                                            }
                                                        ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th style="text-align: right; font-size: 14px;">TOTAL HOURS</th>
                                            <th style="text-align: center; font-size: 14px;">
                                                <strong>
                                                    <?php
                                                        $totalHours = 0;
                                                        foreach($cddata as $cdd){
                                                            foreach($shssubjectsdata as $shssubjectsd){
                                                                if($cdd['subid'] == $shssubjectsd['subid'] && $cdd['level'] == $shscurriculumd['level'] && $cdd['sem'] == '2nd Semester') {
                                                                    $totalHours += $shssubjectsd['hours'];
                                                                }
                                                            }
                                                        }
                                                        echo $totalHours;
                                                    ?>
                                                </strong>
                                            </th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
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