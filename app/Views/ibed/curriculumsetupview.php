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
                        <?php foreach($ibedcurriculumdata as $ibedcurriculumd): ?>
                            <h1><?= $ibedcurriculumd['name']; ?> - <?= $ibedcurriculumd['sy']; ?></h1>
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
                        <?= form_open('ibed-curriculum/setup/'.$ibedcurriculumd['currid']); ?>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SUBJECT</label>
                                    <select name="subject" class="form-select" style="width: 100%;">
                                        <option selected="" disabled=""></option>
                                        <?php foreach ($ibedsubdata as $ibedsubd): ?>
                                            <option value="<?php echo $ibedsubd['subid']; ?>"><?php echo $ibedsubd['subject']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label" for="validationDefault01">LEVEL</label>
                                    <input type="text" name="level" class="form-control" value="<?= $ibedcurriculumd['name']; ?>" disabled>
                                    <input type="text" name="level" class="form-control" value="<?= $ibedcurriculumd['level']; ?>" hidden>
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
                                    <?php foreach($ibedcurriculumdata as $ibedcurriculumd): ?>
                                        <h1><?= $ibedcurriculumd['name']; ?> - <?= $ibedcurriculumd['sy']; ?></h1>
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
                                        <th style="text-align: left">DESCRIPTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($cddata as $cdd):?>
                                            <?php foreach($ibedsubdata as $ibedsubd):?>
                                                <?php if($cdd['subid'] == $ibedsubd['subid'] && $cdd['level'] == $ibedcurriculumd['levelid']): ?>
                                                    <tr>
                                                        <td style="text-align: center"><?= $ibedsubd['code']; ?></td>
                                                        <td style="text-align: left"><?= $ibedsubd['subject']; ?></td>
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
    </div>
    <!-- End of Page Content -->

    <!-- ----------- FOOTER ------------------ -->
    <?= $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?= $this->endSection(); ?>