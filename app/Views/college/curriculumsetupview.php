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
                        <?php foreach($curriculumdata as $curriculumd): ?>
                            <h1><?= $curriculumd['code']; ?> - <?= $curriculumd['sy']; ?></h1>
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
                        <?= form_open('col-curriculum/setup/'.$curriculumd['currid']); ?>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SUBJECT</label>
                                    <select name="subject" class="form-select" style="width: 100%;">
                                        <option selected="" disabled=""></option>
                                        <?php foreach ($subjectsdata as $subjectsd): ?>
                                            <option value="<?php echo $subjectsd['subid']; ?>"><?php echo $subjectsd['subcode']; ?> - <?php echo $subjectsd['subject']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">LEVEL</label>
                                    <select name="level" class="form-select" style="width: 100%;">
                                        <option value="1st Year">1st Year</option>
                                        <option value="2nd Year">2nd Year</option>
                                        <option value="3rd Year">3rd Year</option>
                                        <option value="4th Year">4th Year</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SEMESTER</label>
                                    <select name="sem" class="form-select" style="width: 100%;">
                                        <option value="1st Semester">1st Semester</option>
                                        <option value="2nd Semester">2nd Semester</option>
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
                                    <?php foreach($curriculumdata as $curriculumd): ?>
                                        <?= $curriculumd['code']; ?> - <?= $curriculumd['sy']; ?>
                                    <?php endforeach; ?>
                                </strong></h5>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
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
                                                    <?php foreach($subjectsdata as $subjectsd):?>
                                                        <?php if($cdd['subid'] == $subjectsd['subid'] && $cdd['level'] == '1st Year' && $cdd['sem'] == '1st Semester'): ?>
                                                            <tr>
                                                                <td style="text-align: center"><?= $subjectsd['subcode']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['subject']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['lechours']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['labhours']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['lecunits']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['labunits']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['units']; ?></td>
                                                                <td style="text-align: center"><?php 
                                                                    if($subjectsd['prerequisite'] == '') {
                                                                        echo 'None';
                                                                    } else {
                                                                        echo $subjectsd['prerequisite'];
                                                                    }
                                                                ?></td>
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
                                                        <?php foreach($curriculumdata as $curriculumd): ?>
                                                            <?php
                                                                $db = db_connect();
                                                                $query = $db->query("SELECT currdata.subid, SUM(subjects.lechours) AS LECHOURS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '1st Year' AND currdata.sem = '1st Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                                // Note: Ensure curriculumid is correctly referenced in your query");
                                                                $result = $query->getRow(0);
                                                                echo $LECHOURS = $result->LECHOURS;
                                                            ?> 
                                                        <?php endforeach; ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.labhours) AS LABHOURS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '1st Year' AND currdata.sem = '1st Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LABHOURS = $result->LABHOURS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.lecunits) AS LECUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '1st Year' AND currdata.sem = '1st Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LECUNITS = $result->LECUNITS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '1st Year' AND currdata.sem = '1st Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LABUNITS = $result->LABUNITS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.lecunits) AS LECUNITS, SUM(subjects.labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '1st Year' AND currdata.sem = '1st Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
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
                                <div class="col-lg-6 col-sm-12">
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
                                                    <?php foreach($subjectsdata as $subjectsd):?>
                                                        <?php if($cdd['subid'] == $subjectsd['subid'] && $cdd['level'] == '1st Year' && $cdd['sem'] == '2nd Semester'): ?>
                                                            <tr>
                                                                <td style="text-align: center"><?= $subjectsd['subcode']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['subject']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['lechours']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['labhours']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['lecunits']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['labunits']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['units']; ?></td>
                                                                <td style="text-align: center"><?php 
                                                                    if($subjectsd['prerequisite'] == '') {
                                                                        echo 'None';
                                                                    } else {
                                                                        echo $subjectsd['prerequisite'];
                                                                    }
                                                                ?></td>
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
                                                        <?php foreach($curriculumdata as $curriculumd): ?>
                                                            <?php
                                                                $db = db_connect();
                                                                $query = $db->query("SELECT currdata.subid, SUM(subjects.lechours) AS LECHOURS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '1st Year' AND currdata.sem = '2nd Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                                // Note: Ensure curriculumid is correctly referenced in your query");
                                                                $result = $query->getRow(0);
                                                                echo $LECHOURS = $result->LECHOURS;
                                                            ?> 
                                                        <?php endforeach; ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.labhours) AS LABHOURS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '1st Year' AND currdata.sem = '2nd Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LABHOURS = $result->LABHOURS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.lecunits) AS LECUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '1st Year' AND currdata.sem = '2nd Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LECUNITS = $result->LECUNITS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '1st Year' AND currdata.sem = '2nd Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LABUNITS = $result->LABUNITS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.lecunits) AS LECUNITS, SUM(subjects.labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '1st Year' AND currdata.sem = '2nd Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
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
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
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
                                                    <?php foreach($subjectsdata as $subjectsd):?>
                                                        <?php if($cdd['subid'] == $subjectsd['subid'] && $cdd['level'] == '2nd Year' && $cdd['sem'] == '1st Semester'): ?>
                                                            <tr>
                                                                <td style="text-align: center"><?= $subjectsd['subcode']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['subject']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['lechours']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['labhours']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['lecunits']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['labunits']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['units']; ?></td>
                                                                <td style="text-align: center"><?php 
                                                                    if($subjectsd['prerequisite'] == '') {
                                                                        echo 'None';
                                                                    } else {
                                                                        echo $subjectsd['prerequisite'];
                                                                    }
                                                                ?></td>
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
                                                        <?php foreach($curriculumdata as $curriculumd): ?>
                                                            <?php
                                                                $db = db_connect();
                                                                $query = $db->query("SELECT currdata.subid, SUM(subjects.lechours) AS LECHOURS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '2nd Year' AND currdata.sem = '1st Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                                // Note: Ensure curriculumid is correctly referenced in your query");
                                                                $result = $query->getRow(0);
                                                                echo $LECHOURS = $result->LECHOURS;
                                                            ?> 
                                                        <?php endforeach; ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.labhours) AS LABHOURS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '2nd Year' AND currdata.sem = '1st Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LABHOURS = $result->LABHOURS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.lecunits) AS LECUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '2nd Year' AND currdata.sem = '1st Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LECUNITS = $result->LECUNITS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '2nd Year' AND currdata.sem = '1st Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LABUNITS = $result->LABUNITS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.lecunits) AS LECUNITS, SUM(subjects.labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '2nd Year' AND currdata.sem = '1st Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
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
                                <div class="col-lg-6 col-sm-12">
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
                                                    <?php foreach($subjectsdata as $subjectsd):?>
                                                        <?php if($cdd['subid'] == $subjectsd['subid'] && $cdd['level'] == '2nd Year' && $cdd['sem'] == '2nd Semester'): ?>
                                                            <tr>
                                                                <td style="text-align: center"><?= $subjectsd['subcode']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['subject']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['lechours']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['labhours']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['lecunits']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['labunits']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['units']; ?></td>
                                                                <td style="text-align: center"><?php 
                                                                    if($subjectsd['prerequisite'] == '') {
                                                                        echo 'None';
                                                                    } else {
                                                                        echo $subjectsd['prerequisite'];
                                                                    }
                                                                ?></td>
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
                                                        <?php foreach($curriculumdata as $curriculumd): ?>
                                                            <?php
                                                                $db = db_connect();
                                                                $query = $db->query("SELECT currdata.subid, SUM(subjects.lechours) AS LECHOURS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '2nd Year' AND currdata.sem = '2nd Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                                // Note: Ensure curriculumid is correctly referenced in your query");
                                                                $result = $query->getRow(0);
                                                                echo $LECHOURS = $result->LECHOURS;
                                                            ?> 
                                                        <?php endforeach; ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.labhours) AS LABHOURS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '2nd Year' AND currdata.sem = '2nd Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LABHOURS = $result->LABHOURS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.lecunits) AS LECUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '2nd Year' AND currdata.sem = '2nd Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LECUNITS = $result->LECUNITS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '2nd Year' AND currdata.sem = '2nd Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LABUNITS = $result->LABUNITS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.lecunits) AS LECUNITS, SUM(subjects.labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '2nd Year' AND currdata.sem = '2nd Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
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
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
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
                                                    <?php foreach($subjectsdata as $subjectsd):?>
                                                        <?php if($cdd['subid'] == $subjectsd['subid'] && $cdd['level'] == '3rd Year' && $cdd['sem'] == '1st Semester'): ?>
                                                            <tr>
                                                                <td style="text-align: center"><?= $subjectsd['subcode']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['subject']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['lechours']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['labhours']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['lecunits']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['labunits']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['units']; ?></td>
                                                                <td style="text-align: center"><?php 
                                                                    if($subjectsd['prerequisite'] == '') {
                                                                        echo 'None';
                                                                    } else {
                                                                        echo $subjectsd['prerequisite'];
                                                                    }
                                                                ?></td>
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
                                                        <?php foreach($curriculumdata as $curriculumd): ?>
                                                            <?php
                                                                $db = db_connect();
                                                                $query = $db->query("SELECT currdata.subid, SUM(subjects.lechours) AS LECHOURS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '3rd Year' AND currdata.sem = '1st Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                                // Note: Ensure curriculumid is correctly referenced in your query");
                                                                $result = $query->getRow(0);
                                                                echo $LECHOURS = $result->LECHOURS;
                                                            ?> 
                                                        <?php endforeach; ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.labhours) AS LABHOURS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '3rd Year' AND currdata.sem = '1st Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LABHOURS = $result->LABHOURS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.lecunits) AS LECUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '3rd Year' AND currdata.sem = '1st Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LECUNITS = $result->LECUNITS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '3rd Year' AND currdata.sem = '1st Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LABUNITS = $result->LABUNITS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.lecunits) AS LECUNITS, SUM(subjects.labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '3rd Year' AND currdata.sem = '1st Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
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
                                <div class="col-lg-6 col-sm-12">
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
                                                    <?php foreach($subjectsdata as $subjectsd):?>
                                                        <?php if($cdd['subid'] == $subjectsd['subid'] && $cdd['level'] == '3rd Year' && $cdd['sem'] == '2nd Semester'): ?>
                                                            <tr>
                                                                <td style="text-align: center"><?= $subjectsd['subcode']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['subject']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['lechours']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['labhours']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['lecunits']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['labunits']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['units']; ?></td>
                                                                <td style="text-align: center"><?php 
                                                                    if($subjectsd['prerequisite'] == '') {
                                                                        echo 'None';
                                                                    } else {
                                                                        echo $subjectsd['prerequisite'];
                                                                    }
                                                                ?></td>
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
                                                        <?php foreach($curriculumdata as $curriculumd): ?>
                                                            <?php
                                                                $db = db_connect();
                                                                $query = $db->query("SELECT currdata.subid, SUM(subjects.lechours) AS LECHOURS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '3rd Year' AND currdata.sem = '2nd Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                                // Note: Ensure curriculumid is correctly referenced in your query");
                                                                $result = $query->getRow(0);
                                                                echo $LECHOURS = $result->LECHOURS;
                                                            ?> 
                                                        <?php endforeach; ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.labhours) AS LABHOURS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '3rd Year' AND currdata.sem = '2nd Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LABHOURS = $result->LABHOURS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.lecunits) AS LECUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '3rd Year' AND currdata.sem = '2nd Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LECUNITS = $result->LECUNITS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '3rd Year' AND currdata.sem = '2nd Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LABUNITS = $result->LABUNITS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.lecunits) AS LECUNITS, SUM(subjects.labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '3rd Year' AND currdata.sem = '2nd Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
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
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
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
                                                    <?php foreach($subjectsdata as $subjectsd):?>
                                                        <?php if($cdd['subid'] == $subjectsd['subid'] && $cdd['level'] == '4th Year' && $cdd['sem'] == '1st Semester'): ?>
                                                            <tr>
                                                                <td style="text-align: center"><?= $subjectsd['subcode']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['subject']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['lechours']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['labhours']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['lecunits']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['labunits']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['units']; ?></td>
                                                                <td style="text-align: center"><?php 
                                                                    if($subjectsd['prerequisite'] == '') {
                                                                        echo 'None';
                                                                    } else {
                                                                        echo $subjectsd['prerequisite'];
                                                                    }
                                                                ?></td>
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
                                                        <?php foreach($curriculumdata as $curriculumd): ?>
                                                            <?php
                                                                $db = db_connect();
                                                                $query = $db->query("SELECT currdata.subid, SUM(subjects.lechours) AS LECHOURS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '4th Year' AND currdata.sem = '1st Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                                // Note: Ensure curriculumid is correctly referenced in your query");
                                                                $result = $query->getRow(0);
                                                                echo $LECHOURS = $result->LECHOURS;
                                                            ?> 
                                                        <?php endforeach; ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.labhours) AS LABHOURS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '4th Year' AND currdata.sem = '1st Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LABHOURS = $result->LABHOURS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.lecunits) AS LECUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '4th Year' AND currdata.sem = '1st Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LECUNITS = $result->LECUNITS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '4th Year' AND currdata.sem = '1st Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LABUNITS = $result->LABUNITS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.lecunits) AS LECUNITS, SUM(subjects.labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '4th Year' AND currdata.sem = '1st Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
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
                                <div class="col-lg-6 col-sm-12">
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
                                                    <?php foreach($subjectsdata as $subjectsd):?>
                                                        <?php if($cdd['subid'] == $subjectsd['subid'] && $cdd['level'] == '4th Year' && $cdd['sem'] == '2nd Semester'): ?>
                                                            <tr>
                                                                <td style="text-align: center"><?= $subjectsd['subcode']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['subject']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['lechours']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['labhours']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['lecunits']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['labunits']; ?></td>
                                                                <td style="text-align: center"><?= $subjectsd['units']; ?></td>
                                                                <td style="text-align: center"><?php 
                                                                    if($subjectsd['prerequisite'] == '') {
                                                                        echo 'None';
                                                                    } else {
                                                                        echo $subjectsd['prerequisite'];
                                                                    }
                                                                ?></td>
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
                                                        <?php foreach($curriculumdata as $curriculumd): ?>
                                                            <?php
                                                                $db = db_connect();
                                                                $query = $db->query("SELECT currdata.subid, SUM(subjects.lechours) AS LECHOURS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '4th Year' AND currdata.sem = '2nd Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                                // Note: Ensure curriculumid is correctly referenced in your query");
                                                                $result = $query->getRow(0);
                                                                echo $LECHOURS = $result->LECHOURS;
                                                            ?> 
                                                        <?php endforeach; ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.labhours) AS LABHOURS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '4th Year' AND currdata.sem = '2nd Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LABHOURS = $result->LABHOURS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.lecunits) AS LECUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '4th Year' AND currdata.sem = '2nd Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LECUNITS = $result->LECUNITS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '4th Year' AND currdata.sem = '2nd Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
                                                            $result = $query->getRow(0);
                                                            echo $LABUNITS = $result->LABUNITS;
                                                        ?>
                                                    </strong></td>
                                                    <td style="color: green; text-align: center;"><strong>
                                                        <?php
                                                            $db = db_connect();
                                                            $query = $db->query("SELECT currdata.subid, SUM(subjects.lecunits) AS LECUNITS, SUM(subjects.labunits) AS LABUNITS FROM currdata LEFT JOIN subjects ON subjects.subid = currdata.subid WHERE currdata.level = '4th Year' AND currdata.sem = '2nd Semester' AND currdata.curriculumid = ".$curriculumd['currid']);
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
        </div>
    </div>
    <!-- End of Page Content -->

    <!-- ----------- FOOTER ------------------ -->
    <?= $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?= $this->endSection(); ?>