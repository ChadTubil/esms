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
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <?php foreach($studeval as $stude): ?>
                            <?= form_open('studentfar/evaluationfirst'); ?>
                                <h3>EVALUATION FOR:</h3>
                                <br>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12" >
                                        <label class="form-label" for="validationDefault01"><strong>SCHOOL YEAR</strong></label>
                                        <input class="form-control" type="text" value="<?= $stude['sy']; ?>" disabled>
                                        <input class="form-control" type="hidden" name="txtsy" value="<?= $stude['sy']; ?>" >
                                        <input class="form-control" name="txtaccount" type="hidden" value="<?= $stude['studentno']; ?>">
                                    </div>
                                    <div class="col-lg-6 col-sm-12" >
                                        <label class="form-label" for="validationDefault01"><strong>SEMESTER</strong></label>
                                        <input class="form-control" type="text" value="<?= $stude['sem']; ?>" disabled>
                                        <input class="form-control" name="txtsem" type="hidden" value="<?= $stude['sem']; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12" >
                                        <label class="form-label" for="validationDefault01"><strong>DEPARTMENT</strong></label>
                                        <select name="txtdepartment" class="form-select">
                                            <option value="">Choose Department</option>
                                            <option value="SASED">SASED</option>
                                            <option value="SECLS">SECLS</option>
                                            <option value="SBA">SBA</option>
                                            <option value="SBA">SCJ</option>
                                            <option value="SBA">SHM</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-sm-12" >
                                        <label class="form-label" for="validationDefault01"><strong>COURSE</strong></label>
                                        <input class="form-control" type="text" value="<?= $stude['course']; ?>" disabled>
                                        <input class="form-control" name="txtcourse" type="hidden" value="<?= $stude['course']; ?>" >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-sm-12" >
                                        <label class="form-label" for="validationDefault01"><strong>CODE</strong></label>
                                        <input class="form-control" type="text" value="<?= $stude['subjectcode']; ?>" disabled>
                                        <input class="form-control" name="txtcode" type="hidden" value="<?= $stude['subjectcode']; ?>">
                                    </div>
                                    <div class="col-lg-8 col-sm-12" >
                                        <label class="form-label" for="validationDefault01"><strong>SUBJECT</strong></label>
                                        <input class="form-control" type="text" value="<?= $stude['subjectdescription']; ?>" disabled>
                                        <input class="form-control" name="txtsubject" type="hidden" value="<?= $stude['subjectdescription']; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12" >
                                        <label class="form-label" for="validationDefault01"><strong>TEACHER</strong></label>
                                        <input class="form-control" type="text" value="<?= $stude['teachername']; ?>" disabled>
                                        <input class="form-control" name="txtteacher" type="hidden" value="<?= $stude['teachername']; ?>">
                                    </div>
                                </div>
                                <br>
                                <button class="btn btn-success" style="width: 100%;" type="submit">NEXT</button>
                                <p>Please do not close this tab until the evaluation is done. Thank you!</p>
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