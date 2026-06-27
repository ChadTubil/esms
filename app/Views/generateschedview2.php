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

    <?= $this->include("partials/sidebar"); ?>

    <style>
        .custom-select2 + .select2-container .select2-selection {
            height: 40px;
            border: 1px solid #e1e5e9;
            border-radius: 4px;
            padding-left: 10px;
            padding-top: 10px;
        }

        .custom-select2 + .select2-container .select2-selection__arrow {
            height: 48px;
        }

        .custom-select2 + .select2-container .select2-selection--single .select2-selection__rendered {
            line-height: 26px;
            padding-left: 0;
        }

        .custom-select2 + .select2-container.select2-container--open .select2-selection {
            border-color: #4a90e2;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        .custom-select2 + .select2-container .select2-dropdown {
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .custom-select2 + .select2-container .select2-results__option {
            font-size: 10px;
        }

        .select2-results__option:hover {
            background-color: #4a90e2;
            color: #1a202c;
        }

        .custom-select2 + .select2-container .select2-results__option--highlighted {
            background-color: #f8f9fa;
            color: #2d3748;
            
        }

        .custom-select2 + .select2-container .select2-search__field {
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
    </style>

    <style>
    .time-slot-container {
        transition: all 0.3s ease;
        margin-top: 20px;
        padding: 20px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        background-color: #222738;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .slot-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e9ecef;
    }

    .slot-title {
        color: #495057;
        font-weight: 600;
        margin: 0;
    }

    .hidden-slot {
        display: none;
    }

    .fade-in {
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .btn-slot {
        margin-right: 10px;
        transition: all 0.3s ease;
    }

    .btn-slot:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .slot-badge {
        background-color: #007bff;
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    </style>

    <!-- Add necessary CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript">

        $(document).ready(function() {
            // Initialize all custom select2 elements
            $('.custom-select2').select2({
                theme: "custom-theme",
                width: '100%'
            });
            // Course change handlers for main form
            $('#Course').change(function() {
                var courid = $(this).val();
                $('#Section').html('<option value="">Select Section</option>');
                $('#Section').prop('disabled', true);
                
                if(courid !== '') {
                    fetchSections(courid, '#Section');
                }
            });

            // Course change handlers for edit modal
            $('#UCourse').change(function() {
                var courid = $(this).val();
                $('#USection').html('<option value="">Select Section</option>');
                $('#USection').prop('disabled', true);
                
                if(courid !== '') {
                    fetchSections(courid, '#USection');
                }
            });              
        });

            function fetchSections(courid, targetSelector) {
                $.ajax({
                    url: "<?php echo base_url('schedules/fetchsections'); ?>",
                    method: 'POST',
                    data: {courid: courid},
                    dataType: 'json',
                    success: function(response) {
                        if(response && response.length > 0) {
                            $(targetSelector).prop('disabled', false);
                            $.each(response, function(index, data) {
                                $(targetSelector).append('<option value="'+data.secid+'">'+data.section+'</option>');
                            });
                        } else {
                            console.log('No sections found for this course');
                            $(targetSelector).html('<option value="">No sections available</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        $(targetSelector).html('<option value="">Error loading sections</option>');
                    }
                });
            }
        </script>
        <script>
        // Function to show time slot
        function showTimeSlot(slotNumber) {
            const slotElement = document.getElementById(`timeSlot${slotNumber}`);
            const button = document.getElementById(`addSlot${slotNumber}Btn`);
            
            if (slotElement) {
                // Show the slot
                slotElement.classList.remove('hidden-slot');
                
                // Disable and change the button
                if (button) {
                    button.disabled = true;
                    button.innerHTML = `<i class="fas fa-check-circle"></i> Time Slot ${slotNumber} Added`;
                    button.classList.remove('btn-info');
                    button.classList.add('btn-success');
                }
                
                // If slot 3 is shown, hide slot 2's button? (Optional)
                // if (slotNumber === 3) {
                //     document.getElementById('addSlot2Btn').style.display = 'none';
                // }
            }
        }

        // Function to hide time slot
        function hideTimeSlot(slotNumber) {
            const slotElement = document.getElementById(`timeSlot${slotNumber}`);
            const button = document.getElementById(`addSlot${slotNumber}Btn`);
            
            if (slotElement) {
                // Hide the slot
                slotElement.classList.add('hidden-slot');
                
                // Reset the button
                if (button) {
                    button.disabled = false;
                    button.innerHTML = `<i class="fas fa-plus-circle"></i> Add Time Slot ${slotNumber}`;
                    button.classList.remove('btn-success');
                    button.classList.add('btn-info');
                }
                
                // Clear form fields in the hidden slot
                const inputs = slotElement.querySelectorAll('input, select');
                inputs.forEach(input => {
                    if (input.type !== 'button') {
                        input.value = '';
                    }
                });
            }
        }

        // Optional: Add validation to ensure at least one time slot is filled
        document.getElementById('scheduleForm').addEventListener('submit', function(e) {
            const slot2 = document.getElementById('timeSlot2');
            const slot3 = document.getElementById('timeSlot3');
            
            // Check if slot 2 is visible but empty
            if (!slot2.classList.contains('hidden-slot')) {
                const day2 = document.querySelector('select[name="day2"]').value;
                const timein2 = document.querySelector('input[name="timein2"]').value;
                const timeout2 = document.querySelector('input[name="timeout2"]').value;
                
                if (!day2 || !timein2 || !timeout2) {
                    e.preventDefault();
                    alert('Please fill in all fields for Time Slot 2 or remove it.');
                    return false;
                }
            }
            
            // Check if slot 3 is visible but empty
            if (!slot3.classList.contains('hidden-slot')) {
                const day3 = document.querySelector('select[name="day3"]').value;
                const timein3 = document.querySelector('input[name="timein3"]').value;
                const timeout3 = document.querySelector('input[name="timeout3"]').value;
                
                if (!day3 || !timein3 || !timeout3) {
                    e.preventDefault();
                    alert('Please fill in all fields for Time Slot 3 or remove it.');
                    return false;
                }
            }
        });
    </script>

    <div class="container-fluid content-inner mt-n5 py-0">
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
                            <?php if(session()->getTempdata('teacherConflict')): ?>
                                <div class="alert alert-danger">
                                    <?= session()->getTempdata('teacherConflict');?>
                                </div>
                            <?php endif; ?>
                            <?php if(session()->getTempdata('roomConflict')): ?>
                                <div class="alert alert-danger">
                                    <?= session()->getTempdata('roomConflict');?>
                                </div>
                            <?php endif; ?>
                            <?php if(session()->getTempdata('sectionConflict')): ?>
                                <div class="alert alert-danger">
                                    <?= session()->getTempdata('sectionConflict');?>
                                </div>
                            <?php endif; ?>

                        <?= form_open('generate-schedule'); ?>
                            <div class="row">
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">COURSE</label>
                                    <select name="course" class="custom-select2" id="Course">
                                        <option selected="" disabled="">Select Course</option>
                                        <?php foreach ($coursedata as $courd): ?>
                                            <option value="<?php echo $courd['courid']; ?>">
                                                <?php echo $courd['code']; ?> - <?php echo $courd['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SECTION</label>
                                    <select name="section" class="custom-select2" id="Section" disabled>
                                        <option selected="" disabled="">Select Course First</option>
                                        <?php foreach ($sectiondata as $sectd): ?>
                                            <option value="<?php echo $sectd['level']; ?>">
                                                <?php echo $sectd['section']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label" for="validationDefault01">CURRICULUM</label>
                                    <select name="curriculum" class="custom-select2">
                                        <option selected="">Select Curriculum</option>
                                        <?php foreach ($curriculumdata as $cmd): ?>
                                            <option value="<?php echo $cmd['sy']; ?>">
                                                <?php echo $cmd['sy']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <button class="btn btn-success" type="submit" name="add" style="width: 100%; height: 100%;">
                                        GENERATE
                                    </button>
                                </div>
                            </div>
                        <?= form_close(); ?>
                            <div class="card-body p-0">
                                <div class="table-responsive mt-4">
                                    <h5><strong>
                                        <?php foreach($selectedCourse as $selc):?>
                                            <?php foreach($selectedSection as $sects):?>

                                                <?= $sects['section']?> - <?= $sects['level']?>
                                            
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                    </strong></h5> 
                                </div>
                            </div>
                                <br>
                                <table id="basic-table" class="table table-striped mb-0" role="grid" style="font-size: 11px">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">SUB CODE</th>
                                        <th style="text-align: center">DESCRIPTION</th>
                                        <th style="text-align: center">ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                            <?php foreach($selectedSubjects as $selsubd):?>
                                                <tr>
                                                        <td style="text-align: center"><?= $selsubd['subcode']; ?></td>
                                                        <td style="text-align: center"><?= $selsubd['subject']; ?></td>
                                                        <td style="text-align: center">
                                                        <!-- ADD SCHEDULE -->
                                                        <div class="flex align-items-center list-user-action">
                                                            <a class="btn btn-sm btn-icon btn-success" title="Add"
                                                                href="#" data-bs-toggle="modal" data-bs-target="#addModal<?= $selsubd['subid']; ?>" style ="padding-left: 10px; padding-right: 10px;">
                                                                <span class="btn-inner">
                                                                    <svg class="icon-20" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                                                        <path d="M12.0001 8.32739V15.6537" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                                                        <path d="M15.6668 11.9904H8.3335" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.6857 2H7.31429C4.04762 2 2 4.31208 2 7.58516V16.4148C2 19.6879 4.0381 22 7.31429 22H16.6857C19.9619 22 22 19.6879 22 16.4148V7.58516C22 4.31208 19.9619 2 16.6857 2Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                                                                    </svg>
                                                                    Add Schedule                            
                                                                </span>
                                                            </a>
                                                            <div class="modal fade" id="addModal<?= $selsubd['subid']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg"> <!-- Added modal-lg for larger width -->
                                                                    <div class="modal-content dark">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="staticBackdropLabel">ADD SCHEDULE</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <?= form_open('schedules/add/' . $selsubd['subid']) ?>
                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <!-- Third Row: SECTION and TEACHER -->
                                                                                <div class="row mb-3">
                                                                                    <div class="col-lg-5 col-sm-12">
                                                                                        <label class="form-label" hidden>COURSE</label>
                                                                                        <select name="course" class="form-select" id="UCourse" hidden>
                                                                                        <?php foreach ($selectedSubjects as $selsubjectd): ?>
                                                                                            <option value="<?= $selsubjectd['course']; ?>" selected>
                                                                                                <?= $selsubjectd['course']; ?>
                                                                                            </option>
                                                                                        <?php endforeach; ?>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-lg-5 col-sm-12">
                                                                                        <label class="form-label" hidden>SUBJECT</label>
                                                                                        <select name="subject" class="form-select" id="USubject" hidden>
                                                                                            <option value="<?= $selsubd['subid']; ?>" selected>
                                                                                                <?= $selsubd['subject']; ?>
                                                                                            </option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-lg-5 col-sm-12">
                                                                                        <label class="form-label">SECTION</label>
                                                                                        <select name="section" class="form-select" id="USection">
                                                                                            <?php foreach ($selectedSection as $selsubjectd): ?>
                                                                                                <option value="<?= $selsubjectd['secid']; ?>" selected>
                                                                                                <?= $selsubjectd['section']; ?>
                                                                                                </option>
                                                                                            <?php endforeach; ?>
                                                                                            </option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-lg-7 col-sm-12">
                                                                                        <label class="form-label">TEACHER</label>
                                                                                        <select name="teacher" class="form-select" required>
                                                                                            <option selected="" disabled="">Select Teacher</option>
                                                                                            <option value ="TBA">TBA</option>
                                                                                                <?php foreach($employeesdata as $empd): ?>
                                                                                                    <option value ="<?= $empd['empfullname']; ?>">
                                                                                                    <?= $empd['empnum']; ?> - <?= $empd['empfullname']; ?>
                                                                                                <?php endforeach; ?>
                                                                                            </option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Fourth Row: ROOM and MAX STUD -->
                                                                                <div class="row mb-3">
                                                                                    <div class="col-lg-7 col-sm-12">
                                                                                        <label class="form-label">ROOM</label>
                                                                                        <select name="room" class="form-select" required>
                                                                                            <option selected="" disabled="">Select Room</option>
                                                                                                <?php foreach ($roomsdata as $roomsd): ?> 
                                                                                                        <?php echo $roomsd['roomcode']; ?>
                                                                                                <?php endforeach; ?>
                                                                                            </option>
                                                                                            <?php foreach ($roomsdata as $roomsd): ?>
                                                                                                <option value="<?php echo $roomsd['roomcode']; ?>"><?php echo $roomsd['roomcode']; ?></option>
                                                                                            <?php endforeach; ?>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-lg-5 col-sm-12">
                                                                                        <label class="form-label">MAX STUD</label>
                                                                                        <input type="number" name="maxstudent" class="form-control" value="" placeholder="1-60" required>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Time Slot 1 Section -->
                                                                                <div class="time-slot-container">
                                                                                    <div class="slot-header">
                                                                                        <h5 class="slot-title"><span class="slot-badge">1</span>Time Slot 1</h5>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-lg-4 col-sm-12">
                                                                                            <label class="form-label">DAY</label>
                                                                                            <select name="day" class="form-select" required>
                                                                                                <option value="" selected>Select Day</option>
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
                                                                                            <label class="form-label">TIME IN</label>
                                                                                            <input type="time" name="timein" class="form-control" value="" required>
                                                                                        </div>
                                                                                        <div class="col-lg-4 col-sm-12">
                                                                                            <label class="form-label">TIME OUT</label>
                                                                                            <input type="time" name="timeout" class="form-control" value="" required>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- TIME SLOT 2 (Hidden by default) -->
                                                                                <div id="timeSlot2" class="time-slot-container hidden-slot fade-in">
                                                                                    <div class="slot-header">
                                                                                        <h5 class="slot-title"><span class="slot-badge">2</span>Time Slot 2</h5>
                                                                                        <button type="button" class="btn btn-sm btn-danger" onclick="hideTimeSlot(2)">
                                                                                            Remove
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label>DAY</label>
                                                                                                <select name="day2" class="form-control">
                                                                                                    <option value="" selected>Select Day</option>
                                                                                                    <option value="Sunday">Sunday</option>
                                                                                                    <option value="Monday">Monday</option>
                                                                                                    <option value="Tuesday">Tuesday</option>
                                                                                                    <option value="Wednesday">Wednesday</option>
                                                                                                    <option value="Thursday">Thursday</option>
                                                                                                    <option value="Friday">Friday</option>
                                                                                                    <option value="Saturday">Saturday</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <div class="form-group">
                                                                                                <label>TIME IN</label>
                                                                                                <input type="time" name="timein2" class="form-control">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <div class="form-group">
                                                                                                <label>TIME OUT</label>
                                                                                                <input type="time" name="timeout2" class="form-control">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-2">
                                                                                            <div class="col-lg-7 col-sm-12">
                                                                                                <label class="form-label">ROOM</label>
                                                                                                <select name="room" class="form-select" required>
                                                                                                    <option selected="" disabled="">Select Room</option>
                                                                                                        <?php foreach ($roomsdata as $roomsd): ?> 
                                                                                                                <?php echo $roomsd['roomcode']; ?>
                                                                                                        <?php endforeach; ?>
                                                                                                    </option>
                                                                                                    <?php foreach ($roomsdata as $roomsd): ?>
                                                                                                        <option value="<?php echo $roomsd['roomcode']; ?>"><?php echo $roomsd['roomcode']; ?></option>
                                                                                                    <?php endforeach; ?>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <br>
                                                                                <!-- TIME SLOT 3 (Hidden by default) -->
                                                                                <div id="timeSlot3" class="time-slot-container hidden-slot fade-in">
                                                                                    <div class="slot-header">
                                                                                        <h5 class="slot-title"><span class="slot-badge">3</span> Time Slot 3</h5>
                                                                                        <button type="button" class="btn btn-sm btn-danger" onclick="hideTimeSlot(3)">
                                                                                            <i class="fas fa-times"></i> Remove
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label>DAY</label>
                                                                                                <select name="day3" class="form-control">
                                                                                                    <option value="" selected>Select Day</option>
                                                                                                    <option value="Sunday">Sunday</option>
                                                                                                    <option value="Monday">Monday</option>
                                                                                                    <option value="Tuesday">Tuesday</option>
                                                                                                    <option value="Wednesday">Wednesday</option>
                                                                                                    <option value="Thursday">Thursday</option>
                                                                                                    <option value="Friday">Friday</option>
                                                                                                    <option value="Saturday">Saturday</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <div class="form-group">
                                                                                                <label>TIME IN</label>
                                                                                                <input type="time" name="timein3" class="form-control">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <div class="form-group">
                                                                                                <label>TIME OUT</label>
                                                                                                <input type="time" name="timeout3" class="form-control">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-2">
                                                                                            <div class="col-lg-7 col-sm-12">
                                                                                                <label class="form-label">ROOM</label>
                                                                                                <select name="room" class="form-select" required>
                                                                                                    <option selected="" disabled="">Select Room</option>
                                                                                                        <?php foreach ($roomsdata as $roomsd): ?> 
                                                                                                                <?php echo $roomsd['roomcode']; ?>
                                                                                                        <?php endforeach; ?>
                                                                                                    </option>
                                                                                                    <?php foreach ($roomsdata as $roomsd): ?>
                                                                                                        <option value="<?php echo $roomsd['roomcode']; ?>"><?php echo $roomsd['roomcode']; ?></option>
                                                                                                    <?php endforeach; ?>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <br>                    
                                                                                <button style ="width: 50%" type="button" id="addSlot2Btn" class="btn btn-primary" 
                                                                                onclick="showTimeSlot(2)">Add Time Slot 2</button>
                                                                                <div id="additionalInfo" style="display: none; margin-top: 10px;">
                                                                                    <div class="form-group">
                                                                                        <label>Additional Information</label>
                                                                                        <input type="text" name="additional_info" class="form-control" placeholder="Enter additional info">
                                                                                    </div>
                                                                                </div>
                                                                                <button style ="width: 50%" type="button" id="addSlot3Btn" class="btn btn-primary"
                                                                                onclick="showTimeSlot(3)">Add Time Slot 3</button>
                                                                                <div id="additionalInfo2" style="display: none; margin-top: 10px;">
                                                                                    <div class="form-group">
                                                                                        <label>Additional Information3</label>
                                                                                        <input type="text" name="additional_info2" class="form-control" placeholder="Enter additional info">
                                                                                    </div>
                                                                                </div>
                                                                                <br>
                                                                                <br>
                                                                                <div class="text-end">
                                                                                    <button type="submit" name="update" class="btn btn-success">Add Schedule</button>
                                                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                                                </div>
                                                                            </div>
                                                                            <?= form_close(); ?>
                                                                </div>
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

    <?= $this->include("partials/footer"); ?>

<?= $this->endSection(); ?>