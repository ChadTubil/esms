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
                        <div class="header-title" >
                            <h4 class="card-title">ADMISSION PROCESS</h4>
                        </div>
                    </div>
                    <?php foreach($studentsshsdata as $stud): ?>
                        <div class="card-body">
                            <?= form_open('shs-admission/process/'.$stud['studid']); ?>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <h5>NAME: <strong><?= $stud['studfullname']; ?></strong></h5>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">STUDENT NO.</label>
                                                    <?php if($stud['studentno'] == ''): ?>
                                                        <a class="btn btn-info" style="width: 100%"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Generate Student Number"
                                                            onclick="window.location.href='<?= base_url(); ?>shs-admission/process-generate/<?= $stud['studid']; ?>'">
                                                            GENERATE
                                                        </a>
                                                    <?php else: ?>
                                                        <input type="text" name="studnum" class="form-control" value="<?= $stud['studentno']; ?>" readonly>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">SCHOOL YEAR</label>
                                                    <select name="schoolyear" class="form-select" required>
                                                        <option></option>
                                                        <?php foreach ($schoolyear as $sy): ?>
                                                            <option value="<?php echo $sy['syname']; ?>"><?php echo $sy['syname']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">LEVEL</label>
                                                    <select name="level" class="form-select" required>
                                                        <option></option>
                                                        <option value="Grade 11">Grade 11</option>
                                                        <option value="Grade 12">Grade 12</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">CLUSTER</label>
                                                    <select name="cluster" class="form-select" required>
                                                        <option></option>
                                                        <?php foreach ($clusterdata as $clusterd): ?>
                                                            <option value="<?php echo $clusterd['cluid']; ?>"><?php echo $clusterd['code']; ?> - <?php echo $clusterd['name']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">STATUS</label>
                                                    <select name="status" class="form-select" required>
                                                        <option></option>
                                                        <option value="NEW">NEW</option>
                                                        <option value="OLD">OLD</option>
                                                        <option value="KICKED">KICKED-OUT</option>
                                                        <option value="TRANSFERRED">TRANSFERRED</option>
                                                        <option value="TRANSFEREE">TRANSFEREE</option>
                                                        <option value="INACTIVE">INACTIVE</option>
                                                        <option value="RETURNEE">RETURNEE</option>
                                                        <option value="WITH-CASES">WITH-CASES</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <h3 style="text-align: center;"><strong>OTHER INFORMATION</strong></h3>
                                <br>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <h5><strong>EDUCATIONAL BACKGROUND</strong></h5>
                                        <br>
                                        <div class="row">
                                            <!-- ELEMENTARY  -->
                                            <div class="col-lg-8 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">GRADE SCHOOL</label>
                                                    <input type="text" name="eschool" class="form-control form-control-x" style="text-transform: uppercase;" value="<?= $stud['eschool']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">YEAR GRADUATED</label>
                                                    <input type="text" name="eyeargraduate" class="form-control form-control-x" style="text-transform: uppercase;" value="<?= $stud['eyeargraduate']; ?>">
                                                </div>
                                            </div>
                                            <!-- JUNIOR HIGH SCHOOL  -->
                                            <div class="col-lg-8 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">JUNIOR HIGH SCHOOL</label>
                                                    <input type="text" name="jhschool" class="form-control form-control-x" style="text-transform: uppercase;" value="<?= $stud['jhschool']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">YEAR GRADUATED</label>
                                                    <input type="text" name="jhyeargraduate" class="form-control form-control-x" style="text-transform: uppercase;" value="<?= $stud['jhyeargraduate']; ?>">
                                                </div>
                                            </div>
                                            <!-- ADDITIONAL EDUCATION BACKGROUND -->
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">PLANS AFTER COLLEGE</label>
                                                    <input type="text" name="plans" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">AWARDS AND HONORS RECEIVED</label>
                                                    <input type="text" name="awards" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">NAME OF ORGANIZATION/CLUB</label>
                                                    <input type="text" name="orgname" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">POSITION/TITLE</label>
                                                    <input type="text" name="orgpos" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">OTHER AFFILIATIONS</label>
                                                    <input type="text" name="orgnameo" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">POSITION/TITLE</label>
                                                    <input type="text" name="orgposo" class="form-control" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <h5><strong>FAMILY BACKGROUND</strong></h5>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">FATHER'S NAME</label>
                                                    <input type="text" name="fname" class="form-control form-control-x" style="text-transform: uppercase;" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">FATHER'S DATE OF BIRTH</label>
                                                    <input type="date" name="fdateofbirth" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">FATHER'S PLACE OF BIRTH</label>
                                                    <input type="text" name="fplaceofbirth" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">FATHER'S ADDRESS</label>
                                                    <input type="text" name="faddress" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">FATHER'S CONTACT NUMBER</label>
                                                    <input type="text" name="fcontact" class="form-control form-control-x" style="text-transform: uppercase;" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">FATHER'S EDUCATIONAL ATTAINMENT</label>
                                                    <input type="text" name="feduc" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">FATHER'S EMAIL ADDRESS</label>
                                                    <input type="text" name="femail" class="form-control form-control-x" style="text-transform: uppercase;">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">FATHER'S WORK</label>
                                                    <input type="text" name="fwork" class="form-control form-control-x" style="text-transform: uppercase;">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">FATHER'S OFFICE CONTACT NUMBER</label>
                                                    <input type="text" name="foffice" class="form-control form-control-x" style="text-transform: uppercase;">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">FATHER'S LANGUAGE SPOKEN</label>
                                                    <input type="text" name="flanguage" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">MOTHERS'S NAME</label>
                                                    <input type="text" name="mname" class="form-control form-control-x" style="text-transform: uppercase;" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">MOTHER'S DATE OF BIRTH</label>
                                                    <input type="date" name="mdateofbirth" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">MOTHER'S PLACE OF BIRTH</label>
                                                    <input type="text" name="mplaceofbirth" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">MOTHER'S ADDRESS</label>
                                                    <input type="text" name="maddress" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">MOTHERS'S CONTACT NUMBER</label>
                                                    <input type="text" name="mcontact" class="form-control form-control-x" style="text-transform: uppercase;" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">MOTHER'S EDUCATIONAL ATTAINMENT</label>
                                                    <input type="text" name="meducation" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">MOTHERS'S EMAIL ADDRESS</label>
                                                    <input type="text" name="memail" class="form-control form-control-x" style="text-transform: uppercase;">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">MOTHERS'S WORK</label>
                                                    <input type="text" name="mwork" class="form-control form-control-x" style="text-transform: uppercase;">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">MOTHERS'S OFFICE CONTACT NUMBER</label>
                                                    <input type="text" name="moffice" class="form-control form-control-x" style="text-transform: uppercase;">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">MOTHER'S LANGUAGE SPOKEN</label>
                                                    <input type="text" name="mlanguage" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">STATUS</label>
                                                    <select name="pstatus" class="form-select" required>
                                                        <option value="">Select Status</option>
                                                        <option value="Living Together">Living Together</option>
                                                        <option value="Father w/ another partner">Father w/ another partner</option>
                                                        <option value="Mother w/ another partner">Mother w/ another partner</option>
                                                        <option value="Permanently Separated">Permanently Separated</option>
                                                        <option value="Temporarily Separated">Temporarily Separated</option>
                                                        <option value="Mother is OFW">Mother is OFW</option>
                                                        <option value="Father is OFW">Father is OFW</option>
                                                        <option value="Legally Separated">Legally Separated</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">NAME OF GUARDIAN</label>
                                                    <input type="text" name="nameg" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">GUARDIAN'S CONTACT NUMBER</label>
                                                    <input type="number" name="contactg" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">GUARDIAN'S ADDRESS</label>
                                                    <input type="text" name="gaddress" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">PERSON TO CONTACT</label>
                                                    <input type="text" name="contactperson" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">CONTACT NUMBER</label>
                                                    <input type="number" name="personcontactno" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">NAME OF SIBLINGS</label>
                                                    <input type="text" name="siblingname" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">SCHOOL/PLACE OF WORK</label>
                                                    <input type="text" name="siblingwork" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">AGE</label>
                                                    <input type="number" name="siblingage" class="form-control" >
                                                </div>
                                            </div>
                                            <h5><strong>UNIQUE FEATURES</strong></h5>
                                            <br>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">INTEREST</label>
                                                    <input type="text" name="interest" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">TALENTS</label>
                                                    <input type="text" name="talents" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">HOBBIES</label>
                                                    <input type="text" name="hobbies" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">GOALS IN LIFE</label>
                                                    <input type="text" name="goals" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">CHARACTERISTICS THAT DESCRIBE YOU BEST</label>
                                                    <input type="text" name="characteristics" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">PRESENT FEARS</label>
                                                    <input type="text" name="fears" class="form-control" >
                                                </div>
                                            </div>
                                            <h5><strong>HEALTH</strong></h5>
                                            <br>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">DISABLITIES/IMPAIRMENTS</label>
                                                    <input type="text" name="disabilities" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">CHRONIC ILLNESSES</label>
                                                    <input type="text" name="chronic_illnesses" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">MEDICINE TAKEN REGULARLY</label>
                                                    <input type="text" name="medicine" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">VITAMINS TAKEN REGULARLY</label>
                                                    <input type="text" name="vitamins" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">ANY RECENT ACCIDENTS OR INJURIES? WHAT KIND?</label>
                                                    <input type="text" name="recent_accidents" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">WHAT WAS THE EFFECTS/EXPERIENCE TO YOU?</label>
                                                    <input type="text" name="experience_accidents" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">ANY RECENT SURGICAL OPERATIONS OR PROCEDURES? WHAT KIND?</label>
                                                    <input type="text" name="recent_surgical" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">WHAT WAS THE EFFECTS/EXPERIENCE TO YOU?</label>
                                                    <input type="text" name="experience_surgical" class="form-control" >
                                                </div>
                                            </div>
                                            <h6><strong>PLEASE SELECT VACCINATIONS YOU HAVE HAD</strong></h6>
                                            <br><br>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <select name="vaccines" class="form-select" >
                                                        <option value="">Select Vaccine</option>
                                                        <option value="Chicken Pox">Chicken Pox</option>
                                                        <option value="Mumps">Mumps</option>
                                                        <option value="Boosters">Boosters</option>
                                                        <option value="Influenza">Influenza</option>
                                                        <option value="Small Pox">Small Pox</option>
                                                        <option value="Hepatitis B">Hepatitis B</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <h6><strong>PREVIOUS PSYCHOLOGICAL CONSULTATIONS</strong></h6>
                                            <br><br>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">HAVE YOU CONSULTED A PSYCHIATRIST BEFORE?</label>
                                                    <input type="text" name="con_psy" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">IF YES WHEN?</label>
                                                    <input type="text" name="con_psy_date" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">HOW MANY SESSIONS?</label>
                                                    <input type="text" name="con_psy_sessions" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">DIAGNOSIS</label>
                                                    <input type="text" name="con_psy_diagnosis" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">HAVE YOU CONSULTED A REGISTERED PSYCHOLOGIST BEFORE?</label>
                                                    <input type="text" name="con_regpsy" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">IF YES WHEN?</label>
                                                    <input type="text" name="con_regpsy_date" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">HOW MANY SESSIONS?</label>
                                                    <input type="text" name="con_regpsy_sessions" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">DIAGNOSIS</label>
                                                    <input type="text" name="con_regpsy_diagnosis" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">HAVE YOU CONSULTED A REGISTERED GUIDANCE COUNSELLOR BEFORE?</label>
                                                    <input type="text" name="con_regguid" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">IF YES WHEN?</label>
                                                    <input type="text" name="con_regguid_date" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">HOW MANY SESSIONS?</label>
                                                    <input type="text" name="con_regguid_sessions" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">DIAGNOSIS</label>
                                                    <input type="text" name="con_regguid_diagnosis" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <br>
                                                <button type="submit" name="update" class="btn btn-primary" style="width: 100%">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?= form_close(); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Page Content -->

    <!-- ----------- FOOTER ------------------ -->
    <?= $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->
    <script>
        document.querySelectorAll('.form-control-x').forEach(input => {
            input.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        });
    </script>

<?= $this->endSection(); ?>