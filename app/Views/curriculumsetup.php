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
                        <?php foreach($curriculumdata as $curriculum): ?>
                            <h1><?= $curriculum['course']; ?> - <?= $curriculum['sy']; ?></h1>
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
                        <?= form_open('curriculum-setup/'.$curriculum['currid']); ?>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SUBJECT</label>
                                    <select name="subject" class="js-example-basic-single" id="subject" style="width: 100%;">
                                        <option selected="" disabled=""></option>
                                        <?php foreach ($subjectdata as $subjectd): ?>
                                            <option value="<?php echo $subjectd['subid']; ?>"><?php echo $subjectd['subcode']; ?> - <?php echo $subjectd['subject']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">LEVEL</label>
                                    <select name="level" class="js-example-basic-single" id="level" style="width: 100%;">
                                        <option selected="" disabled=""></option>
                                        <?php foreach ($leveldata as $leveld): ?>
                                            <option value="<?php echo $leveld['level']; ?>"><?php echo $leveld['level']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SEMESTER</label>
                                    <select name="sem" class="js-example-basic-single" id="semester" style="width: 100%;">
                                        <option selected="" disabled=""></option>
                                        <?php foreach ($semdata as $semd): ?>
                                            <option value="<?php echo $semd['semester']; ?>"><?php echo $semd['semester']; ?></option>
                                        <?php endforeach; ?>
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
                                    <?php foreach($curriculumdata as $curriculum): ?>
                                        <?= $curriculum['course']; ?> - <?= $curriculum['sy']; ?>
                                    <?php endforeach; ?>
                                </strong></h5>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive mt-4">
                                <div style="text-align: center;"><h6>FIRST YEAR - FIRST SEMESTER</h6></div>
                                <table id="basic-table" class="table table-striped mb-0" role="grid" style="font-size: 11px">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">SUB CODE</th>
                                        <th style="text-align: center">DESCRIPTION</th>
                                        <th style="text-align: center">NO. LEC HOURS</th>
                                        <th style="text-align: center">NO. LAB HOURS</th>
                                        <th style="text-align: center">LEC UNITS</th>
                                        <th style="text-align: center">LAB UNITS</th>
                                        <th style="text-align: center">TOTAL UNITS</th>
                                        <th style="text-align: center">PRE-REQUISITE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($cddata as $cdd):?>
                                            <?php foreach($subjectdata as $subjectd):?>
                                                <?php if($cdd['subjectsid'] == $subjectd['subid'] && $cdd['level'] == '1st Year' && $cdd['sem'] == '1st Semester'): ?>
                                                    <tr>
                                                        <td><?= $subjectd['subcode']; ?></td>
                                                        <td><?= $subjectd['subject']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['lechours']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['labhours']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['lecunits']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['labunits']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['units']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['prerequisite']; ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php foreach($curriculumdata as $curriculum): ?>
                                                    <?php
                                                        $db = db_connect();
                                                        $query = $db->query("SELECT subjectsid, SUM(lechours) AS LECHOURS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '1st Year' AND sem = '1st Semester' AND curriculumid = ".$curriculum['currid']);
                                                        // Note: Ensure curriculumid is correctly referenced in your query");
                                                        $result = $query->getRow(0);
                                                        echo $LECHOURS = $result->LECHOURS;
                                                    ?> 
                                                <?php endforeach; ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(labhours) AS LABHOURS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '1st Year' AND sem = '1st Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LABHOURS = $result->LABHOURS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lecunits) AS LECUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '1st Year' AND sem = '1st Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LECUNITS = $result->LECUNITS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '1st Year' AND sem = '1st Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LABUNITS = $result->LABUNITS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lecunits) AS LECUNITS, SUM(labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '1st Year' AND sem = '1st Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    $LECUNITS = $result->LECUNITS;
                                                    $LABUNITS = $result->LABUNITS;
                                                    $TOTALUNITS = $LECUNITS + $LABUNITS;
                                                    echo $TOTALUNITS;
                                                ?>
                                            </strong></td>
                                            <td><strong></strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="table-responsive mt-4">
                                <div style="text-align: center;"><h6>FIRST YEAR - SECOND SEMESTER</h6></div>
                                <table id="basic-table" class="table table-striped mb-0" role="grid" style="font-size: 11px">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">SUB CODE</th>
                                        <th style="text-align: center">DESCRIPTION</th>
                                        <th style="text-align: center">NO. LEC HOURS</th>
                                        <th style="text-align: center">NO. LAB HOURS</th>
                                        <th style="text-align: center">LEC UNITS</th>
                                        <th style="text-align: center">LAB UNITS</th>
                                        <th style="text-align: center">TOTAL UNITS</th>
                                        <th style="text-align: center">PRE-REQUISITE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($cddata as $cdd):?>
                                            <?php foreach($subjectdata as $subjectd):?>
                                                <?php if($cdd['subjectsid'] == $subjectd['subid'] && $cdd['level'] == '1st Year' && $cdd['sem'] == '2nd Semester'): ?>
                                                    <tr>
                                                        <td><?= $subjectd['subcode']; ?></td>
                                                        <td><?= $subjectd['subject']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['lechours']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['labhours']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['lecunits']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['labunits']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['units']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['prerequisite']; ?></td>
                                                    </tr>
                                                    
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lechours) AS LECHOURS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '1st Year' AND sem = '2nd Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LECHOURS = $result->LECHOURS;
                                                ?> 
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(labhours) AS LABHOURS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '1st Year' AND sem = '2nd Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LABHOURS = $result->LABHOURS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lecunits) AS LECUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '1st Year' AND sem = '2nd Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LECUNITS = $result->LECUNITS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '1st Year' AND sem = '2nd Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LABUNITS = $result->LABUNITS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lecunits) AS LECUNITS, SUM(labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '1st Year' AND sem = '2nd Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    $LECUNITS = $result->LECUNITS;
                                                    $LABUNITS = $result->LABUNITS;
                                                    $TOTALUNITS = $LECUNITS + $LABUNITS;
                                                    echo $TOTALUNITS;
                                                ?>
                                            </strong></td>
                                            <td><strong></strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="table-responsive mt-4">
                                <div style="text-align: center;"><h6>SECOND YEAR - FIRST SEMESTER</h6></div>
                                <table id="basic-table" class="table table-striped mb-0" role="grid" style="font-size: 11px">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">SUB CODE</th>
                                        <th style="text-align: center">DESCRIPTION</th>
                                        <th style="text-align: center">NO. LEC HOURS</th>
                                        <th style="text-align: center">NO. LAB HOURS</th>
                                        <th style="text-align: center">LEC UNITS</th>
                                        <th style="text-align: center">LAB UNITS</th>
                                        <th style="text-align: center">TOTAL UNITS</th>
                                        <th style="text-align: center">PRE-REQUISITE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($cddata as $cdd):?>
                                            <?php foreach($subjectdata as $subjectd):?>
                                                <?php if($cdd['subjectsid'] == $subjectd['subid'] && $cdd['level'] == '2nd Year' && $cdd['sem'] == '1st Semester'): ?>
                                                    <tr>
                                                        <td><?= $subjectd['subcode']; ?></td>
                                                        <td><?= $subjectd['subject']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['lechours']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['labhours']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['lecunits']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['labunits']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['units']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['prerequisite']; ?></td>
                                                    </tr>
                                                    
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lechours) AS LECHOURS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '2nd Year' AND sem = '1st Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LECHOURS = $result->LECHOURS;
                                                ?> 
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(labhours) AS LABHOURS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '2nd Year' AND sem = '1st Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LABHOURS = $result->LABHOURS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lecunits) AS LECUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '2nd Year' AND sem = '1st Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LECUNITS = $result->LECUNITS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '2nd Year' AND sem = '1st Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LABUNITS = $result->LABUNITS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lecunits) AS LECUNITS, SUM(labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '2nd Year' AND sem = '1st Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    $LECUNITS = $result->LECUNITS;
                                                    $LABUNITS = $result->LABUNITS;
                                                    $TOTALUNITS = $LECUNITS + $LABUNITS;
                                                    echo $TOTALUNITS;
                                                ?>
                                            </strong></td>
                                            <td><strong></strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="table-responsive mt-4">
                                <div style="text-align: center;"><h6>SECOND YEAR - SECOND SEMESTER</h6></div>
                                <table id="basic-table" class="table table-striped mb-0" role="grid" style="font-size: 11px">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">SUB CODE</th>
                                        <th style="text-align: center">DESCRIPTION</th>
                                        <th style="text-align: center">NO. LEC HOURS</th>
                                        <th style="text-align: center">NO. LAB HOURS</th>
                                        <th style="text-align: center">LEC UNITS</th>
                                        <th style="text-align: center">LAB UNITS</th>
                                        <th style="text-align: center">TOTAL UNITS</th>
                                        <th style="text-align: center">PRE-REQUISITE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($cddata as $cdd):?>
                                            <?php foreach($subjectdata as $subjectd):?>
                                                <?php if($cdd['subjectsid'] == $subjectd['subid'] && $cdd['level'] == '2nd Year' && $cdd['sem'] == '2nd Semester'): ?>
                                                    <tr>
                                                        <td><?= $subjectd['subcode']; ?></td>
                                                        <td><?= $subjectd['subject']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['lechours']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['labhours']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['lecunits']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['labunits']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['units']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['prerequisite']; ?></td>
                                                    </tr>
                                                    
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lechours) AS LECHOURS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '2nd Year' AND sem = '2nd Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LECHOURS = $result->LECHOURS;
                                                ?> 
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(labhours) AS LABHOURS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '2nd Year' AND sem = '2nd Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LABHOURS = $result->LABHOURS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lecunits) AS LECUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '2nd Year' AND sem = '2nd Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LECUNITS = $result->LECUNITS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '2nd Year' AND sem = '2nd Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LABUNITS = $result->LABUNITS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lecunits) AS LECUNITS, SUM(labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '2nd Year' AND sem = '2nd Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    $LECUNITS = $result->LECUNITS;
                                                    $LABUNITS = $result->LABUNITS;
                                                    $TOTALUNITS = $LECUNITS + $LABUNITS;
                                                    echo $TOTALUNITS;
                                                ?>
                                            </strong></td>
                                            <td><strong></strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="table-responsive mt-4">
                                <div style="text-align: center;"><h6>THIRD YEAR - FIRST SEMESTER</h6></div>
                                <table id="basic-table" class="table table-striped mb-0" role="grid" style="font-size: 11px">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">SUB CODE</th>
                                        <th style="text-align: center">DESCRIPTION</th>
                                        <th style="text-align: center">NO. LEC HOURS</th>
                                        <th style="text-align: center">NO. LAB HOURS</th>
                                        <th style="text-align: center">LEC UNITS</th>
                                        <th style="text-align: center">LAB UNITS</th>
                                        <th style="text-align: center">TOTAL UNITS</th>
                                        <th style="text-align: center">PRE-REQUISITE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($cddata as $cdd):?>
                                            <?php foreach($subjectdata as $subjectd):?>
                                                <?php if($cdd['subjectsid'] == $subjectd['subid'] && $cdd['level'] == '3rd Year' && $cdd['sem'] == '1st Semester'): ?>
                                                    <tr>
                                                        <td><?= $subjectd['subcode']; ?></td>
                                                        <td><?= $subjectd['subject']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['lechours']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['labhours']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['lecunits']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['labunits']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['units']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['prerequisite']; ?></td>
                                                    </tr>
                                                    
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lechours) AS LECHOURS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '3rd Year' AND sem = '1st Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LECHOURS = $result->LECHOURS;
                                                ?> 
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(labhours) AS LABHOURS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '3rd Year' AND sem = '1st Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LABHOURS = $result->LABHOURS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lecunits) AS LECUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '3rd Year' AND sem = '1st Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LECUNITS = $result->LECUNITS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '3rd Year' AND sem = '1st Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LABUNITS = $result->LABUNITS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lecunits) AS LECUNITS, SUM(labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '3rd Year' AND sem = '1st Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    $LECUNITS = $result->LECUNITS;
                                                    $LABUNITS = $result->LABUNITS;
                                                    $TOTALUNITS = $LECUNITS + $LABUNITS;
                                                    echo $TOTALUNITS;
                                                ?>
                                            </strong></td>
                                            <td><strong></strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="table-responsive mt-4">
                                <div style="text-align: center;"><h6>THIRD YEAR - SECOND SEMESTER</h6></div>
                                <table id="basic-table" class="table table-striped mb-0" role="grid" style="font-size: 11px">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">SUB CODE</th>
                                        <th style="text-align: center">DESCRIPTION</th>
                                        <th style="text-align: center">NO. LEC HOURS</th>
                                        <th style="text-align: center">NO. LAB HOURS</th>
                                        <th style="text-align: center">LEC UNITS</th>
                                        <th style="text-align: center">LAB UNITS</th>
                                        <th style="text-align: center">TOTAL UNITS</th>
                                        <th style="text-align: center">PRE-REQUISITE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($cddata as $cdd):?>
                                            <?php foreach($subjectdata as $subjectd):?>
                                                <?php if($cdd['subjectsid'] == $subjectd['subid'] && $cdd['level'] == '3rd Year' && $cdd['sem'] == '2nd Semester'): ?>
                                                    <tr>
                                                        <td><?= $subjectd['subcode']; ?></td>
                                                        <td><?= $subjectd['subject']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['lechours']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['labhours']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['lecunits']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['labunits']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['units']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['prerequisite']; ?></td>
                                                    </tr>
                                                    
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lechours) AS LECHOURS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '3rd Year' AND sem = '2nd Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LECHOURS = $result->LECHOURS;
                                                ?> 
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(labhours) AS LABHOURS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '3rd Year' AND sem = '2nd Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LABHOURS = $result->LABHOURS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lecunits) AS LECUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '3rd Year' AND sem = '2nd Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LECUNITS = $result->LECUNITS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '3rd Year' AND sem = '2nd Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LABUNITS = $result->LABUNITS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lecunits) AS LECUNITS, SUM(labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '3rd Year' AND sem = '2nd Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    $LECUNITS = $result->LECUNITS;
                                                    $LABUNITS = $result->LABUNITS;
                                                    $TOTALUNITS = $LECUNITS + $LABUNITS;
                                                    echo $TOTALUNITS;
                                                ?>
                                            </strong></td>
                                            <td><strong></strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="table-responsive mt-4">
                                <div style="text-align: center;"><h6>THIRD YEAR - SUMMER</h6></div>
                                <table id="basic-table" class="table table-striped mb-0" role="grid" style="font-size: 11px">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">SUB CODE</th>
                                        <th style="text-align: center">DESCRIPTION</th>
                                        <th style="text-align: center">NO. LEC HOURS</th>
                                        <th style="text-align: center">NO. LAB HOURS</th>
                                        <th style="text-align: center">LEC UNITS</th>
                                        <th style="text-align: center">LAB UNITS</th>
                                        <th style="text-align: center">TOTAL UNITS</th>
                                        <th style="text-align: center">PRE-REQUISITE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($cddata as $cdd):?>
                                            <?php foreach($subjectdata as $subjectd):?>
                                                <?php if($cdd['subjectsid'] == $subjectd['subid'] && $cdd['level'] == '3rd Year' && $cdd['sem'] == 'Summer'): ?>
                                                    <tr>
                                                        <td><?= $subjectd['subcode']; ?></td>
                                                        <td><?= $subjectd['subject']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['lechours']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['labhours']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['lecunits']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['labunits']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['units']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['prerequisite']; ?></td>
                                                    </tr>
                                                    
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lechours) AS LECHOURS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '3rd Year' AND sem = 'Summer' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LECHOURS = $result->LECHOURS;
                                                ?> 
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(labhours) AS LABHOURS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '3rd Year' AND sem = 'Summer' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LABHOURS = $result->LABHOURS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lecunits) AS LECUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '3rd Year' AND sem = 'Summer' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LECUNITS = $result->LECUNITS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '3rd Year' AND sem = 'Summer' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LABUNITS = $result->LABUNITS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lecunits) AS LECUNITS, SUM(labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '3rd Year' AND sem = 'Summer' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    $LECUNITS = $result->LECUNITS;
                                                    $LABUNITS = $result->LABUNITS;
                                                    $TOTALUNITS = $LECUNITS + $LABUNITS;
                                                    echo $TOTALUNITS;
                                                ?>
                                            </strong></td>
                                            <td><strong></strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="table-responsive mt-4">
                                <div style="text-align: center;"><h6>FOURTH YEAR - FIRST SEMESTER</h6></div>
                                <table id="basic-table" class="table table-striped mb-0" role="grid" style="font-size: 11px">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">SUB CODE</th>
                                        <th style="text-align: center">DESCRIPTION</th>
                                        <th style="text-align: center">NO. LEC HOURS</th>
                                        <th style="text-align: center">NO. LAB HOURS</th>
                                        <th style="text-align: center">LEC UNITS</th>
                                        <th style="text-align: center">LAB UNITS</th>
                                        <th style="text-align: center">TOTAL UNITS</th>
                                        <th style="text-align: center">PRE-REQUISITE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($cddata as $cdd):?>
                                            <?php foreach($subjectdata as $subjectd):?>
                                                <?php if($cdd['subjectsid'] == $subjectd['subid'] && $cdd['level'] == '4th Year' && $cdd['sem'] == '1st Semester'): ?>
                                                    <tr>
                                                        <td><?= $subjectd['subcode']; ?></td>
                                                        <td><?= $subjectd['subject']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['lechours']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['labhours']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['lecunits']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['labunits']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['units']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['prerequisite']; ?></td>
                                                    </tr>
                                                    
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lechours) AS LECHOURS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '4th Year' AND sem = '1st Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LECHOURS = $result->LECHOURS;
                                                ?> 
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(labhours) AS LABHOURS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '4th Year' AND sem = '1st Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LABHOURS = $result->LABHOURS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lecunits) AS LECUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '4th Year' AND sem = '1st Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LECUNITS = $result->LECUNITS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '4th Year' AND sem = '1st Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LABUNITS = $result->LABUNITS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lecunits) AS LECUNITS, SUM(labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '4th Year' AND sem = '1st Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    $LECUNITS = $result->LECUNITS;
                                                    $LABUNITS = $result->LABUNITS;
                                                    $TOTALUNITS = $LECUNITS + $LABUNITS;
                                                    echo $TOTALUNITS;
                                                ?>
                                            </strong></td>
                                            <td><strong></strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="table-responsive mt-4">
                                <div style="text-align: center;"><h6>FOURTH YEAR - SECOND SEMESTER</h6></div>
                                <table id="basic-table" class="table table-striped mb-0" role="grid" style="font-size: 11px">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">SUB CODE</th>
                                        <th style="text-align: center">DESCRIPTION</th>
                                        <th style="text-align: center">NO. LEC HOURS</th>
                                        <th style="text-align: center">NO. LAB HOURS</th>
                                        <th style="text-align: center">LEC UNITS</th>
                                        <th style="text-align: center">LAB UNITS</th>
                                        <th style="text-align: center">TOTAL UNITS</th>
                                        <th style="text-align: center">PRE-REQUISITE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($cddata as $cdd):?>
                                            <?php foreach($subjectdata as $subjectd):?>
                                                <?php if($cdd['subjectsid'] == $subjectd['subid'] && $cdd['level'] == '4th Year' && $cdd['sem'] == '2nd Semester'): ?>
                                                    <tr>
                                                        <td><?= $subjectd['subcode']; ?></td>
                                                        <td><?= $subjectd['subject']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['lechours']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['labhours']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['lecunits']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['labunits']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['units']; ?></td>
                                                        <td style="text-align: center"><?= $subjectd['prerequisite']; ?></td>
                                                    </tr>
                                                    
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lechours) AS LECHOURS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '4th Year' AND sem = '2nd Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LECHOURS = $result->LECHOURS;
                                                ?> 
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(labhours) AS LABHOURS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '4th Year' AND sem = '2nd Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LABHOURS = $result->LABHOURS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lecunits) AS LECUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '4th Year' AND sem = '2nd Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LECUNITS = $result->LECUNITS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '4th Year' AND sem = '2nd Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    echo $LABUNITS = $result->LABUNITS;
                                                ?>
                                            </strong></td>
                                            <td style="color: green; text-align: center;"><strong>
                                                <?php
                                                    $db = db_connect();
                                                    $query = $db->query("SELECT subjectsid, SUM(lecunits) AS LECUNITS, SUM(labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '4th Year' AND sem = '2nd Semester' AND curriculumid = ".$curriculum['currid']);
                                                    $result = $query->getRow(0);
                                                    $LECUNITS = $result->LECUNITS;
                                                    $LABUNITS = $result->LABUNITS;
                                                    $TOTALUNITS = $LECUNITS + $LABUNITS;
                                                    echo $TOTALUNITS;
                                                ?>
                                            </strong></td>
                                            <td><strong></strong></td>
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