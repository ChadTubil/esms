<?= $this->extend("layouts/base"); ?>

<?= $this->section("title"); ?>
    <?=$page_title; ?>
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
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h3>EVALUATION FOR:</h3>
                        <br>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12" >
                                <button class="btn btn-success" style="width: 100%; height: 60px;" type="disable">
                                    <strong>
                                        <?php foreach($sydata as $sy): ?>
                                            <?= $sy['syname']; ?>
                                        <?php endforeach; ?>
                                    </strong>
                                </button>
                            </div>
                            <div class="col-lg-6 col-sm-12" >
                                <button class="btn btn-success" style="width: 100%; height: 60px;" type="disable">
                                    <strong>
                                        <?php foreach($semdata as $sem): ?>
                                            <?= $sem['semester']; ?>
                                        <?php endforeach; ?>
                                    </strong>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h3>TEACHERS TO EVALUATE</h3>
                        <br>
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
                                        <th>TEACHER</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($studeval as $stude): ?>
                                        <tr>
                                            <td><?= $stude['subjectcode']; ?></td>
                                            <td><?= $stude['subjectdescription']; ?></td>
                                            <td><?= $stude['teachername']; ?></td>
                                            <td>
                                                <button class="btn btn-primary" style="width: 100%;"
                                                onclick="window.location.href='<?= base_url(); ?>studentfar/evaluation/<?= $stude['impgradeid']; ?>'"
                                                <?php foreach($fardata as $fard){
                                                    if($stude['sy'] == $fard['farsy'] && $stude['sem'] == $fard['farsem'] && $stude['studentno'] == $fard['faraccountid']
                                                    && $stude['teachername'] == $fard['farname'] && $stude['subjectdescription'] == $fard['farsubject']){
                                                        echo 'disabled';
                                                    }else{
                                                        
                                                    }
                                                } ?>
                                                >
                                                    EVALUATE
                                                </button>
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