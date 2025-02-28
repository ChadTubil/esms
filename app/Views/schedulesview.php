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
            <div class="col-lg-12 col-sm-12">
                <div class="card">
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
                        <?= form_open('schedules', ['class' => 'user']); ?>
                            <div class="row">
                                <div class="col-lg-2 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SCHEDULE ID</label>
                                    <h4><strong><?php
                                            $db = db_connect();
                                            $query = $db->query("SELECT COUNT(*) AS COUNTID FROM schedule");
                                            $result = $query->getRow(0);
                                            $callid =$result->COUNTID;
                                            $sumid = $callid + '1';
                                            echo $sumid;
                                            
                                        ?></strong></h4>
                                </div>
                                <div class="col-lg-5 col-sm-12">
                                    <label class="form-label" for="validationDefault01">COURSE</label>
                                    <select name="course" class="js-example-basic-single" id="Course"
                                    style="width: 100%;">
                                        <option selected="" disabled=""></option>
                                        <?php foreach ($coursedata as $courd): ?>
                                            <option value="<?php echo $courd['courid']; ?>"><?php echo $courd['courcode']; ?> - <?php echo $courd['course']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-5 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SECTION</label>
                                    <select name="section" class="js-example-basic-single" id="Section"
                                    style="width: 100%;">
                                        <option selected="" disabled=""></option>
                                        <?php foreach ($sectiondata as $sectd): ?>
                                            <option value="<?php echo $sectd['secid']; ?>"><?php echo $sectd['section']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SUBJECT</label>
                                    <select name="subject" class="js-example-basic-single" id="Subject"
                                    style="width: 100%;">
                                        <option selected="" disabled=""></option>
                                        <?php foreach ($subjectsdata as $subjd): ?>
                                            <option value="<?php echo $subjd['subid']; ?>"><?php echo $subjd['subcode']; ?> - <?php echo $subjd['subject']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">ROOM</label>
                                    <select name="room" class="js-example-basic-single" id="Room"
                                    style="width: 100%;">
                                        <option selected="" disabled=""></option>
                                        <?php foreach ($roomsdata as $roomsd): ?>
                                            <option value="<?php echo $roomsd['roomid']; ?>"><?php echo $roomsd['roomcode']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-7 col-sm-12">
                                    <label class="form-label" for="validationDefault01">TEACHER</label>
                                    <select name="teacher" class="js-example-basic-single" id="Teacher"
                                    style="width: 100%;">
                                        <option selected="" disabled=""></option>
                                        <?php foreach ($employeesdata as $empd): ?>
                                            <option value="<?php echo $empd['empid']; ?>"><?php echo $empd['empnum']; ?> - <?php echo $empd['empfullname']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label class="form-label" for="validationDefault01">MAX STUDENT</label>
                                    <input type="number" name="maxstudent" class="form-control">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label class="form-label" for="validationDefault01">DAY</label>
                                    <select name="day" class="form-select" id="Day">
                                        <option selected="" disabled=""></option>
                                        <option value="Sunday">Sunday</option>
                                        <option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                        <option value="Saturday">Saturday</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label class="form-label" for="validationDefault01">TIME IN</label>
                                    <input type="time" name="timein" class="form-control">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label class="form-label" for="validationDefault01">TIME OUT</label>
                                    <input type="time" name="timeout" class="form-control">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label class="form-label" for="validationDefault01">DAY 2</label>
                                    <select name="day2" class="form-select" id="Day2">
                                        <option selected="" disabled=""></option>
                                        <option value="Sunday">Sunday</option>
                                        <option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                        <option value="Saturday">Saturday</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label class="form-label" for="validationDefault01">TIME IN 2</label>
                                    <input type="time" name="timein2" class="form-control">
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label class="form-label" for="validationDefault01">TIME OUT 2</label>
                                    <input type="time" name="timeout2" class="form-control">
                                </div>
                            </div>
                            <br>
                            <button class="btn btn-success" type="submit" name="add" style="width: 100%;">SAVE</button>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
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
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>COURSES</th>
                                        <th>SUBJECTS</th>
                                        <th>SECTIONS</th>
                                        <th>DAY & TIME</th>
                                        <th>TEACHERS</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($scheduledata as $schedd):?>
                                        <tr>
                                            <td><?= $schedd['schedid']; ?></td>
                                            <td>
                                                <?php foreach($coursedata as $courd): ?>
                                                    <?php if($courd['courid'] == $schedd['schedcourid']): ?>
                                                        <?= $courd['courcode']; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </td>
                                            <td>
                                                <?php foreach($subjectsdata as $subjd): ?>
                                                    <?php if($subjd['subid'] == $schedd['schedsubid']): ?>
                                                        <?= $subjd['subcode']; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </td>
                                            <td>
                                                <?php foreach($sectiondata as $secd): ?>
                                                    <?php if($secd['secid'] == $schedd['schedsecid']): ?>
                                                        <?= $secd['section']; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </td>
                                            <td>
                                                <?= $schedd['schedday']; ?>(<?= date('h:iA', strtotime($schedd['schedtimeF'])); ?>-<?= date('h:iA', strtotime($schedd['schedtimeT'])); ?>)
                                                <?php if($schedd['schedday2'] == ''):?>
                                                <?php else:?>
                                                    <br>
                                                    <?= $schedd['schedday2']; ?>(<?= date('h:iA', strtotime($schedd['schedtimeF2'])); ?>-<?= date('h:iA', strtotime($schedd['schedtimeT2'])); ?>)
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php foreach($employeesdata as $empd): ?>
                                                    <?php if($empd['empid'] == $schedd['schedteacher']): ?>
                                                        <?= $empd['empfullname']; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </td>
                                            <td>
                                                <div class="flex align-items-center list-user-action">
                                                    <a class="btn btn-sm btn-icon btn-primary" title="Edit"
                                                        href="#" data-bs-toggle="modal" data-bs-target="#editModal<?= $schedd['schedid']; ?>">
                                                        <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                        </span>
                                                    </a>
                                                    <div class="modal fade" id="editModal<?= $schedd['schedid']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content dark">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="staticBackdropLabel">UPDATE SCHEDULE</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <?= form_open('schedules/update/'.$schedd['schedid']); ?>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <div class="row">
                                                                            <div class="col-lg-3 col-sm-12">
                                                                                <label for="email" class="form-label">SCHED ID</label>
                                                                                <input type="text" name="semester" class="form-control" value="<?php echo $schedd['schedid']; ?>" disabled>
                                                                            </div>
                                                                            <div class="col-lg-9 col-sm-12">
                                                                                <label class="form-label" for="validationDefault01">COURSE</label>
                                                                                <select name="course" class="form-select" id="exampleFormControlSelect1">
                                                                                    <option value="<?php echo $schedd['schedcourid']; ?>" selected>
                                                                                        <?php foreach ($coursedata as $courd): ?> 
                                                                                            <?php if($courd['courid'] == $schedd['schedcourid']): ?>
                                                                                                <?php echo $courd['course']; ?>
                                                                                            <?php endif; ?>
                                                                                        <?php endforeach; ?>
                                                                                    </option>
                                                                                    <?php foreach ($coursedata as $courd): ?>
                                                                                        <option value="<?php echo $courd['courid']; ?>"><?php echo $courd['courcode']; ?> - <?php echo $courd['course']; ?></option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-lg-12 col-sm-12">
                                                                                <label class="form-label" for="validationDefault01">SUBJECT</label>
                                                                                <select name="subject" class="form-select" id="exampleFormControlSelect1">
                                                                                    <option value="<?php echo $schedd['schedsubid']; ?>" selected>
                                                                                        <?php foreach ($subjectsdata as $subjd): ?> 
                                                                                            <?php if($subjd['subid'] == $schedd['schedsubid']): ?>
                                                                                                <?php echo $subjd['subcode']; ?> - <?php echo $subjd['subject']; ?>
                                                                                            <?php endif; ?>
                                                                                        <?php endforeach; ?>
                                                                                    </option>
                                                                                    <?php foreach ($subjectsdata as $subjd): ?>
                                                                                        <option value="<?php echo $subjd['subid']; ?>"><?php echo $subjd['subcode']; ?> - <?php echo $subjd['subject']; ?></option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-lg-5 col-sm-12">
                                                                                <label class="form-label" for="validationDefault01">SECTION</label>
                                                                                <select name="section" class="form-select" id="exampleFormControlSelect1">
                                                                                    <option value="<?php echo $schedd['schedsecid']; ?>" selected>
                                                                                        <?php foreach ($sectiondata as $sectd): ?> 
                                                                                            <?php if($sectd['secid'] == $schedd['schedsecid']): ?>
                                                                                                <?php echo $sectd['section']; ?>
                                                                                            <?php endif; ?>
                                                                                        <?php endforeach; ?>
                                                                                    </option>
                                                                                    <?php foreach ($sectiondata as $sectd): ?>
                                                                                        <option value="<?php echo $sectd['secid']; ?>"><?php echo $sectd['section']; ?></option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-lg-7 col-sm-12">
                                                                                <label class="form-label" for="validationDefault01">TEACHER</label>
                                                                                <select name="teacher" class="form-select" id="exampleFormControlSelect1">
                                                                                    <option value="<?php echo $schedd['schedteacher']; ?>" selected>
                                                                                        <?php foreach ($employeesdata as $empd): ?> 
                                                                                            <?php if($empd['empid'] == $schedd['schedteacher']): ?>
                                                                                                <?php echo $empd['empfullname']; ?>
                                                                                            <?php endif; ?>
                                                                                        <?php endforeach; ?>
                                                                                    </option>
                                                                                    <?php foreach ($employeesdata as $empd): ?>
                                                                                        <option value="<?php echo $empd['empid']; ?>"><?php echo $empd['empnum']; ?> - <?php echo $empd['empfullname']; ?></option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-lg-7 col-sm-12">
                                                                                <label class="form-label" for="validationDefault01">ROOM</label>
                                                                                <select name="room" class="form-select" id="exampleFormControlSelect1">
                                                                                    <option value="<?php echo $schedd['schedroom']; ?>" selected>
                                                                                        <?php foreach ($roomsdata as $roomsd): ?> 
                                                                                            <?php if($roomsd['roomid'] == $schedd['schedroom']): ?>
                                                                                                <?php echo $roomsd['roomcode']; ?>
                                                                                            <?php endif; ?>
                                                                                        <?php endforeach; ?>
                                                                                    </option>
                                                                                    <?php foreach ($roomsdata as $roomsd): ?>
                                                                                        <option value="<?php echo $roomsd['roomid']; ?>"><?php echo $roomsd['roomcode']; ?></option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-lg-5 col-sm-12">
                                                                                <label for="email" class="form-label">MAX STUD</label>
                                                                                <input type="number" name="maxstudent" class="form-control" value="<?php echo $schedd['schedmaxstudent']; ?>">
                                                                            </div>
                                                                            <div class="col-lg-4 col-sm-12">
                                                                                <label for="email" class="form-label">DAY</label>
                                                                                <select name="day" class="form-select" id="Day2">
                                                                                    <option value="<?php echo $schedd['schedday']; ?>" selected><?php echo $schedd['schedday']; ?></option>
                                                                                    <option value="Sunday">Sunday</option>
                                                                                    <option value="Monday">Monday</option>
                                                                                    <option value="Tuesday">Tuesday</option>
                                                                                    <option value="Wednesday">Wednesday</option>
                                                                                    <option value="Thursday">Thursday</option>
                                                                                    <option value="Friday">Friday</option>
                                                                                    <option value="Saturday">Saturday</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-lg-4 col-sm-12">
                                                                                <label for="email" class="form-label">TIME IN</label>
                                                                                <input type="time" name="timein" class="form-control" value="<?php echo $schedd['schedtimeF']; ?>">
                                                                            </div>
                                                                            <div class="col-lg-4 col-sm-12">
                                                                                <label for="email" class="form-label">TIME OUT</label>
                                                                                <input type="time" name="timeout" class="form-control" value="<?php echo $schedd['schedtimeT']; ?>">
                                                                            </div>
                                                                            <div class="col-lg-4 col-sm-12">
                                                                                <label for="email" class="form-label">DAY2</label>
                                                                                <select name="day2" class="form-select" id="Day2">
                                                                                    <option value="<?php echo $schedd['schedday2']; ?>" selected><?php echo $schedd['schedday2']; ?></option>
                                                                                    <option value="Sunday">Sunday</option>
                                                                                    <option value="Monday">Monday</option>
                                                                                    <option value="Tuesday">Tuesday</option>
                                                                                    <option value="Wednesday">Wednesday</option>
                                                                                    <option value="Thursday">Thursday</option>
                                                                                    <option value="Friday">Friday</option>
                                                                                    <option value="Saturday">Saturday</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-lg-4 col-sm-12">
                                                                                <label for="email" class="form-label">TIME IN 2</label>
                                                                                <input type="time" name="timein2" class="form-control" value="<?php echo $schedd['schedtimeF2']; ?>">
                                                                            </div>
                                                                            <div class="col-lg-4 col-sm-12">
                                                                                <label for="email" class="form-label">TIME OUT 2</label>
                                                                                <input type="time" name="timeout2" class="form-control" value="<?php echo $schedd['schedtimeT2']; ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="text-start">
                                                                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </div>
                                                                <?= form_close(); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                                        onclick="window.location.href='<?= base_url(); ?>schedules/delete/<?= $schedd['schedid']; ?>';">
                                                        <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                                            <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                        </span>
                                                    </a>
                                                </div>
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