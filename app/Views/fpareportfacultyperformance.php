<?php $this->extend("layouts/base"); ?>

<?php $this->section("title"); ?>
    <?php echo $page_title; ?>
<?php $this->endSection(); ?>
<?php $this->section("page_heading"); ?>
    <?php echo $page_heading; ?>
<?php $this->endSection(); ?>
<?php $this->section("page_p"); ?>
    <?php echo $page_p; ?>
<?php $this->endSection(); ?>

<?php echo $this->section('content'); ?>
    <!-- ----------- SIDEBAR ------------------ -->
    <?php echo $this->include("partials/sidebar"); ?>  
    <!-- ----------- END OF SIDEBAR ------------------ --> 

    <!-- Begin Page Content -->
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <?php foreach($facultyinfo as $faculty): ?>
                            <?= form_open('hrd-fpareportsfaculty-view/'.$faculty['empid']) ?>
                                <div class="row">
                                
                                    <div class="col-lg-12 col-sm-12">
                                        <h1>
                                            <?php foreach($facultyinfo as $faculty): ?>
                                                <?= $faculty['empfullname']; ?>
                                            <?php endforeach; ?>
                                        </h1>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="validationDefault01">SCHOOL YEAR</label>
                                        <select name="schoolyear" class="form-select" id="exampleFormControlSelect1" required>
                                            <?php foreach ($selectedsy as $ssy): ?>
                                                <option value="<?php echo $ssy['syname']; ?>" selected><?php echo $ssy['syname']; ?></option>
                                            <?php endforeach; ?>
                                            <?php foreach ($schoolyeardata as $syd): ?>
                                                <option value="<?php echo $syd['syname']; ?>"><?php echo $syd['syname']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="form-label" for="validationDefault01">SEMESTER</label>
                                        <select name="semester" class="form-select" id="exampleFormControlSelect1" required>
                                            <?php foreach ($selectedsem as $ssem): ?>
                                                <option value="<?php echo $ssem['semester']; ?>" selected><?php echo $ssem['semester']; ?></option>
                                            <?php endforeach; ?>
                                            <?php foreach ($semesterdata as $semd): ?>
                                                <option value="<?php echo $semd['semester']; ?>"><?php echo $semd['semester']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <button class="btn btn-success" type="submit" name="add" style="width: 100%; height: 100%;">VIEW PERFORMANCE</button>
                                    </div>
                                </div>
                            <?= form_close(); ?>
                        <?php endforeach; ?>    
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="card-body" style="text-align: center">
                        <h5><strong>STUDENTS</strong></h5>
                        <br>
                        <?php foreach($farstudents as $fs): ?>
                            <?php 
                                $FARNAME = $fs['farname']; 
                                $FARSY = $fs['farsy']; 
                                $FARSEM = $fs['farsem']; 
                            ?>
                        <?php endforeach; ?>
                        <h1 style="font-size: 70px">
                            <strong>
                                <?php
                                    $db = \Config\Database::connect();

                                    $farStudScore = $db->query("SELECT SUM(farqtotal) as FARQTOTAL FROM far 
                                    WHERE farevaluator = '1' AND farname = '$FARNAME' AND farsy = '$FARSY' AND farsem = '$FARSEM'");
                                    $farStudScoreresult = $farStudScore->getRow();
                                    $STUDSCORE = $farStudScoreresult->FARQTOTAL;

                                    $farStudCount = $db->query("SELECT COUNT(farid) as COUN FROM far 
                                    WHERE farevaluator = '1' AND farname = '$FARNAME' AND farsy = '$FARSY' AND farsem = '$FARSEM'");
                                    $farStudCountresult = $farStudCount->getRow();
                                    $STUDCount = $farStudCountresult->COUN;
                                    $STUDCOMPUTED = 210 * $STUDCount;

                                    $FARSTUDSCORE = $STUDSCORE / $STUDCOMPUTED;
                                    echo $STUDENT = $FARSTUDSCORE * 100;
                                ?>
                            </strong>
                        </h1>
                        <p>SCORE</p>
                        <p>TOTAL STUDENT SCORES / TOTAL NUMBER OF EVALUATORS</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="card-body" style="text-align: center">
                        <h5><strong>HEADS</strong></h5>
                        <br>
                        <h1 style="font-size: 70px"><strong>1000</strong></h1>
                        <p>SCORE</p>
                        <p>TOTAL HEAD SCORES / TOTAL NUMBER OF EVALUATORS</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="card-body" style="text-align: center">
                        <h5><strong>SELF</strong></h5>
                        <br>
                        <h1 style="font-size: 70px"><strong>1000</strong></h1>
                        <p>SCORE</p>
                        <p>SELF EVALUATION</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <div class="card-body" style="text-align: center">
                        <h5><strong>COMPUTATION</strong></h5>
                        <br>
                        <div class="row">
                            <div class="col-lg-4 col-sm-12">
                                <div class="card">
                                    <h5>STUDENT</h5>
                                    <h3>1000 x 30%</h3>
                                    <p>TOTAL STUDENT SCORE x 30%</p>
                                </div>
                            </div> 
                            <div class="col-lg-4 col-sm-12">
                                <div class="card">
                                    <h5>HEADS</h5>
                                    <h3>1000 x 60%</h3>
                                    <p>TOTAL HEADS SCORE x 60%</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <div class="card">
                                    <h5>SELF</h5>
                                    <h3>1000 x 10%</h3>
                                    <p>TOTAL SELF SCORE x 10%</p>
                                </div>
                            </div>                       
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="card-body" style="text-align: center">
                        <h5><strong>TOTAL</strong></h5>
                        <br>
                        <h1 style="font-size: 70px">
                            <strong>
                                <?php
                                    $db = \Config\Database::connect();
                                    // STUDENT
                                    $farStudScore = $db->query("SELECT SUM(farqtotal) as FARQTOTAL FROM far 
                                    WHERE farevaluator = '1' AND farname = '$FARNAME' AND farsy = '$FARSY' AND farsem = '$FARSEM'");
                                    $farStudScoreresult = $farStudScore->getRow();
                                    $STUDSCORE = $farStudScoreresult->FARQTOTAL;

                                    $farStudCount = $db->query("SELECT COUNT(farid) as COUN FROM far 
                                    WHERE farevaluator = '1' AND farname = '$FARNAME' AND farsy = '$FARSY' AND farsem = '$FARSEM'");

                                    $farStudCountresult = $farStudCount->getRow();
                                    $STUDCount = $farStudCountresult->COUN;
                                    $STUDCOMPUTED = 210 * $STUDCount;

                                    $FARSTUDSCORE = $STUDSCORE / $STUDCOMPUTED;
                                    $STUDENT = $FARSTUDSCORE * 100;

                                    echo $STUDENTFINAL = $STUDENT * 0.3;
                                ?>%
                            </strong>
                        </h1>
                        <p>OVER ALL SCORE</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Page Content -->

    <!-- ----------- FOOTER ------------------ -->
    <?php echo $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?php echo $this->endSection(); ?>