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
    <style>
        /* --- Original Select2 Styles --- */
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
            background-color: #222738;
            color: #2d3748;
        }

        .custom-select2 + .select2-container .select2-search__field {
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        /* --- NEW: Modal Specific Dark Theme Select2 Styles (FORCED) --- */
        /* Forces the main selection box to be dark */
        .modal .select2-container .select2-selection--single {
            background-color: #222738 !important; 
            border: 1px solid #4a5168 !important; 
            height: 40px !important;
            display: flex !important;
            align-items: center !important;
        }

        /* Forces the selected text to match dark theme text */
        .modal .select2-container .select2-selection--single .select2-selection__rendered {
            color: #a0aec0 !important; 
            line-height: normal !important;
            padding-left: 12px !important;
        }

        /* Forces the dropdown list background to be dark */
        .modal .select2-container .select2-dropdown {
            background-color: #222738 !important;
            border: 1px solid #4a5168 !important;
        }

        /* Forces the individual options to be dark */
        .modal .select2-container .select2-results__option {
            background-color: #222738 !important;
            color: #a0aec0 !important;
            font-size: 13px !important;
        }

        /* Hovered/Selected option styling */
        .modal .select2-container .select2-results__option[aria-selected="true"] {
            background-color: #1a202c !important;
        }

        .modal .select2-container .select2-results__option--highlighted[aria-selected] {
            background-color: #4a90e2 !important; 
            color: #ffffff !important;
        }

        /* Search box inside the dropdown */
        .modal .select2-search--dropdown .select2-search__field {
            background-color: #1a202c !important; 
            color: #fff !important;
            border: 1px solid #4a5168 !important;
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
            display: none !important;
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

        .btn-success:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        .modal-content.dark {
            background-color: #fff;
        }


    </style>

    <style>
        /* Print Styles */
        @media print {
            body * {
                visibility: hidden;
            }
            .schedule-print-area, .schedule-print-area * {
                visibility: visible;
            }
            .schedule-print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 20px;
            }
            .no-print {
                display: none !important;
            }
            .modal-header, .modal-footer {
                display: none !important;
            }
            .modal-content {
                border: none !important;
                box-shadow: none !important;
            }
            .schedule-table {
                width: 100% !important;
                border-collapse: collapse !important;
            }
            .schedule-table th, .schedule-table td {
                border: 1px solid #ddd !important;
                padding: 8px !important;
            }
        }
        
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    

    <script>
        // Function to show time slot
        function showTimeSlot(slotNumber, scheduleId = null) {
            let slotElement, button;
            
            if (scheduleId) {
                // For edit modal with specific schedule
                slotElement = document.getElementById(`timeSlot${slotNumber}_${scheduleId}`);
                button = document.getElementById(`addSlot${slotNumber}Btn_${scheduleId}`);
            } else {
                // For main form
                slotElement = document.getElementById(`timeSlot${slotNumber}`);
                button = document.getElementById(`addSlot${slotNumber}Btn`);
            }
            
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
            }
        }

        // Function to hide time slot
        function hideTimeSlot(slotNumber, scheduleId = null) {
            let slotElement, button;
            
            if (scheduleId) {
                // For edit modal with specific schedule
                slotElement = document.getElementById(`timeSlot${slotNumber}_${scheduleId}`);
                button = document.getElementById(`addSlot${slotNumber}Btn_${scheduleId}`);
            } else {
                // For main form
                slotElement = document.getElementById(`timeSlot${slotNumber}`);
                button = document.getElementById(`addSlot${slotNumber}Btn`);
            }
            
            if (slotElement) {
                // Hide the slot
                slotElement.classList.add('hidden-slot');
                
                // Clear form fields in the hidden slot
                const inputs = slotElement.querySelectorAll('input, select');
                inputs.forEach(input => {
                    if (input.type !== 'button') {
                        input.value = '';
                    }
                });
                
                // Reset the button
                if (button) {
                    button.disabled = false;
                    button.innerHTML = `<i class="fas fa-plus-circle"></i> Add Time Slot ${slotNumber}`;
                    button.classList.remove('btn-success');
                    button.classList.add('btn-info');
                }
            }
        }

        // Confirm delete function
        function confirmDelete(url) {
            if (confirm('Are you sure you want to delete this schedule?')) {
                window.location.href = url;
            }
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            // Initialize all custom select2 elements
            $('.custom-select2').select2({
                theme: "custom-theme",
                width: '100%'
            });

            // Initialize Select2 for modal selects
            $('.modal .custom-select2').select2({
                theme: "custom-theme",
                width: '100%',
                dropdownParent: $('.modal')
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

            // Function to fetch sections
            function fetchSections(courid, targetSelector) {
                
                // Clear existing options
                $(targetSelector).empty();
                
                if (!courid || courid === '') {
                    $(targetSelector).html('<option value="">Select course first</option>');
                    return;
                }

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
            // Add time slot from modal
            window.addTimeSlotFromModal = function(slotNumber) {
                var day = $('#modalDay' + slotNumber).val();
                var timein = $('#modalTimein' + slotNumber).val();
                var timeout = $('#modalTimeout' + slotNumber).val();
                var room = $('#modalRoom' + slotNumber).val();
                
                if(!day || !timein || !timeout || !room) {
                    alert('Please fill all fields');
                    return;
                }
                
                // Set values in the hidden container
                $('#additionalTimeSlotFields' + slotNumber + ' select[name="day' + slotNumber + '"]').val(day);
                $('#additionalTimeSlotFields' + slotNumber + ' input[name="timein' + slotNumber + '"]').val(timein);
                $('#additionalTimeSlotFields' + slotNumber + ' input[name="timeout' + slotNumber + '"]').val(timeout);
                $('#additionalTimeSlotFields' + slotNumber + ' select[name="room' + slotNumber + '"]').val(room);
                
                // Show the additional fields
                $('#additionalTimeSlotFields' + slotNumber).show();
                
                // Close the modal
                $('#AddTSModal' + slotNumber).modal('hide');
                
                // Clear modal fields
                $('#modalDay' + slotNumber).val('');
                $('#modalTimein' + slotNumber).val('');
                $('#modalTimeout' + slotNumber).val('');
                $('#modalRoom' + slotNumber).val('');
            }

            // Remove additional time slot
            window.removeAdditionalTimeSlot = function(slotNumber) {
                // Clear the fields
                $('#additionalTimeSlotFields' + slotNumber + ' select[name="day' + slotNumber + '"]').val('');
                $('#additionalTimeSlotFields' + slotNumber + ' input[name="timein' + slotNumber + '"]').val('');
                $('#additionalTimeSlotFields' + slotNumber + ' input[name="timeout' + slotNumber + '"]').val('');
                $('#additionalTimeSlotFields' + slotNumber + ' select[name="room' + slotNumber + '"]').val('');
                
                // Hide the container
                $('#additionalTimeSlotFields' + slotNumber).hide();
            }

            // Remove additional time slot on edit slot 2
            window.removeAdditionalTimeSlotE2 = function(slotNumber, scheduleId) {
                var modal = $('#editModal' + scheduleId);
                modal.find('select[name="day2"]').val('');
                modal.find('input[name="timein2"]').val('');
                modal.find('input[name="timeout2"]').val('');
                modal.find('select[name="room2"]').val('');
                
                // Hide the container and reset button
                modal.find('#timeSlot2_' + scheduleId).addClass('hidden-slot');
                modal.find('#addSlot2Btn_' + scheduleId).prop('disabled', false);
                modal.find('#addSlot2Btn_' + scheduleId).html('<i class="fas fa-plus-circle"></i> Add Time Slot 2');
                modal.find('#addSlot2Btn_' + scheduleId).removeClass('btn-success').addClass('btn-info');

                alert('Time slot 2 has been cleared');
            }

            // Remove additional time slot for edit mode (for slot 3)
            window.removeAdditionalTimeSlotE3 = function(slotNumber, scheduleId) {
                var modal = $('#editModal' + scheduleId);
                modal.find('select[name="day3"]').val('');
                modal.find('input[name="timein3"]').val('');
                modal.find('input[name="timeout3"]').val('');
                modal.find('select[name="room3"]').val('');
                
                // Hide the container and reset button
                modal.find('#timeSlot3_' + scheduleId).addClass('hidden-slot');
                modal.find('#addSlot3Btn_' + scheduleId).prop('disabled', false);
                modal.find('#addSlot3Btn_' + scheduleId).html('<i class="fas fa-plus-circle"></i> Add Time Slot 3');
                modal.find('#addSlot3Btn_' + scheduleId).removeClass('btn-success').addClass('btn-info');
                
                alert('Time slot 3 has been cleared');
            }

            // Reset modals when closed
            $('.time-slot-modal').on('hidden.bs.modal', function () {
                var modalId = $(this).attr('id');
                var slotNumber = modalId.replace('AddTSModal', '');
                
                $('#modalDay' + slotNumber).val('');
                $('#modalTimein' + slotNumber).val('');
                $('#modalTimeout' + slotNumber).val('');
                $('#modalRoom' + slotNumber).val('');
            });

            // Validation for schedule forms
            $('form[id="scheduleForm"], form[action*="schedules/update"]').on('submit', function(e) {
                const form = $(this);
                const isEditForm = form.attr('action') ? form.attr('action').includes('update') : false;
                
                if (isEditForm) {
                    const actionUrl = form.attr('action');
                    const scheduleId = actionUrl.split('/').pop();
                    
                    const slot2 = document.getElementById(`timeSlot2_${scheduleId}`);
                    const slot3 = document.getElementById(`timeSlot3_${scheduleId}`);
                    
                    // Check if slot 2 is visible but has empty required fields
                    if (slot2 && !slot2.classList.contains('hidden-slot')) {
                        const day2 = slot2.querySelector('select[name="day2"]')?.value;
                        const timein2 = slot2.querySelector('input[name="timein2"]')?.value;
                        const timeout2 = slot2.querySelector('input[name="timeout2"]')?.value;
                        const room2 = slot2.querySelector('select[name="room2"]')?.value;
                        
                        if (!day2 || !timein2 || !timeout2 || !room2) {
                            e.preventDefault();
                            alert('Please fill in all fields for Time Slot 2 or remove it.');
                            return false;
                        }
                    }
                    
                    // Check if slot 3 is visible but has empty required fields
                    if (slot3 && !slot3.classList.contains('hidden-slot')) {
                        const day3 = slot3.querySelector('select[name="day3"]')?.value;
                        const timein3 = slot3.querySelector('input[name="timein3"]')?.value;
                        const timeout3 = slot3.querySelector('input[name="timeout3"]')?.value;
                        const room3 = slot3.querySelector('select[name="room3"]')?.value;
                        
                        if (!day3 || !timein3 || !timeout3 || !room3) {
                            e.preventDefault();
                            alert('Please fill in all fields for Time Slot 3 or remove it.');
                            return false;
                        }
                    }
                } else {
                    // Main form validation
                    const slot2 = document.getElementById('timeSlot2');
                    const slot3 = document.getElementById('timeSlot3');
                    
                    // Check if slot 2 is visible but empty
                    if (slot2 && !slot2.classList.contains('hidden-slot')) {
                        const day2 = document.querySelector('select[name="day2"]')?.value;
                        const timein2 = document.querySelector('input[name="timein2"]')?.value;
                        const timeout2 = document.querySelector('input[name="timeout2"]')?.value;
                        
                        if (!day2 || !timein2 || !timeout2) {
                            e.preventDefault();
                            alert('Please fill in all fields for Time Slot 2 or remove it.');
                            return false;
                        }
                    }
                    
                    // Check if slot 3 is visible but empty
                    if (slot3 && !slot3.classList.contains('hidden-slot')) {
                        const day3 = document.querySelector('select[name="day3"]')?.value;
                        const timein3 = document.querySelector('input[name="timein3"]')?.value;
                        const timeout3 = document.querySelector('input[name="timeout3"]')?.value;
                        
                        if (!day3 || !timein3 || !timeout3) {
                            e.preventDefault();
                            alert('Please fill in all fields for Time Slot 3 or remove it.');
                            return false;
                        }
                    }
                }
            });
        });
        
    </script>

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
                        <?php if(session()->getTempdata('internalConflict')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getTempdata('internalConflict');?>
                            </div>
                        <?php endif; ?>
                        <?php if(session()->getTempdata('deletesuccess')) :?>
                            <div class="alert alert-success">
                                <?= session()->getTempdata('deletesuccess');?>
                            </div>
                        <?php endif; ?>
                        <?php if(session()->getTempdata('updatesuccess')) :?>
                            <div class="alert alert-success">
                                <?= session()->getTempdata('updatesuccess');?>
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
                        <?php if(session()->getTempdata('subjectConflict')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getTempdata('subjectConflict');?>
                            </div>
                        <?php endif; ?>
                        
                        <?= form_open('generate-schedule', ['id' => 'scheduleForm']); ?>
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
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Created Schedules Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="header-title">
                    <h4 class="card-title">Created Schedules</h4>
                </div>
                <div class="no-print">
                        <a href="<?= base_url('schedules/exportAllSchedules'); ?>" 
                        class="btn btn-success" 
                        target="_blank">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                <path d="M12.1221 15.436L12.1221 3.39502" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                <path d="M15.0381 12.5083L12.1221 15.4363L9.20609 12.5083" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                <path d="M16.7551 8.12793H17.6881C19.7231 8.12793 21.3721 9.77693 21.3721 11.8129V16.6969C21.3721 18.7269 19.7271 20.3719 17.6971 20.3719L6.55707 20.3719C4.52207 20.3719 2.87207 18.7219 2.87207 16.6869V11.8019C2.87207 9.77293 4.51807 8.12793 6.54707 8.12793L7.48907 8.12793" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                            </svg> Export All Created Schedules
                        </a>
                    </div>
                </div>
            <div class="card-body">
                <div class="table-responsive mt-4">
                    <table id="datatable" class="table table-striped" data-toggle="data-table" style="font-size: 11px">
                        <thead>
                            <tr>
                                <th>COURSE & SECTION</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($scheduledata as $sched): ?>
                                            <tr>
                                                <td>
                                                    <?php 
                                                        $courseSection = '';
                                                        foreach($coursedata as $courd) {
                                                            if($courd['courid'] == $sched['schedcourid']) {
                                                                $courseSection = $courd['code']; 
                                                                break;
                                                            }
                                                        }
                                                        foreach($sectiondata as $sectd) {
                                                            if($sectd['secid'] == $sched['schedsecid']) {
                                                                $courseSection .= ' ' . '-' . ' '. $sectd['section'];
                                                                break;
                                                            }
                                                        }
                                                        echo $courseSection;
                                                        ?>
                                                </td>
                                                <td>
                                                    <!-- View Button -->
                                                    <a class="btn btn-sm btn-icon btn-success" title="View"
                                                    href="#" data-bs-toggle="modal" data-bs-target="#viewSchedulesModal<?= $sched['schedid']; ?>">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                                            <path d="M22.4541 11.3918C22.7819 11.7385 22.7819 12.2615 22.4541 12.6082C21.0124 14.1335 16.8768 18 12 18C7.12317 18 2.98759 14.1335 1.54586 12.6082C1.21811 12.2615 1.21811 11.7385 1.54586 11.3918C2.98759 9.86647 7.12317 6 12 6C16.8768 6 21.0124 9.86647 22.4541 11.3918Z" stroke="currentColor"></path>                                    
                                                            <circle cx="12" cy="12" r="5" stroke="currentColor"></circle>                                    
                                                            <circle cx="12" cy="12" r="3" fill="currentColor"></circle>                                    
                                                            <mask mask-type="alpha" maskUnits="userSpaceOnUse" x="9" y="9" width="6" height="6">                                    
                                                                <circle cx="12" cy="12" r="3" fill="currentColor"></circle>                                    
                                                            </mask>                                    
                                                            <circle opacity="0.89" cx="13.5" cy="10.5" r="1.5" fill="white"></circle>                                    
                                                        </svg>                            
                                                    </a>
                                                    <!-- Edit Button -->
                                                    <a class="btn btn-sm btn-icon btn-primary" title="Edit"
                                                        href="#" data-bs-toggle="modal" data-bs-target="#editModal<?= $sched['schedid']; ?>">
                                                        <span class="btn-inner">
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                                                <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                                                <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                                                            </svg>                                                      
                                                        </span>
                                                    </a>
                                                    <!-- View Modal -->
                                                    <div class="modal fade" id="viewSchedulesModal<?= $sched['schedid']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content dark">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="staticBackdropLabel">
                                                                        Course Schedules
                                                                    </h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div id="scheduleContent" class="schedule-print-area">
                                                                        <!-- Content will be loaded here -->
                                                                        <div class="table-responsive mt-4">
                                                                            <table id="" class="table table-striped" data-toggle="" style="font-size: 11px">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>COURSE & SECTION</th>
                                                                                        <th>SUBJECT</th>
                                                                                        <th>UNITS</th>
                                                                                        <th>HOURS</th>
                                                                                        <th>ROOM</th>
                                                                                        <th>TEACHER</th>
                                                                                        <th>DAY & TIME</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php foreach ($scheduledata2 as $sched2): ?>
                                                                                        <?php if($sched['schedsecid'] == $sched2['schedsecid']): ?>
                                                                                            <?php foreach ($subjectsdata as $subjectsd): ?>
                                                                                                <?php if($subjectsd['subid'] == $sched2['schedsubid']): ?>
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            <?php 
                                                                                                                $courseSection = '';
                                                                                                                foreach($sectiondata as $sectd) {
                                                                                                                    if($sectd['secid'] == $sched2['schedsecid']) {
                                                                                                                        $courseSection .= ' ' . ' ' . ' '. $sectd['section'];
                                                                                                                        break;
                                                                                                                    }
                                                                                                                }
                                                                                                                echo $courseSection;
                                                                                                                ?>
                                                                                                        </td>
                                                                                                        <td><?= $subjectsd['subcode']; ?> - <?= $subjectsd['subject']; ?></td>
                                                                                                        <td><?= $subjectsd['units']; ?></td>
                                                                                                        <td><?= $subjectsd['hours']; ?></td>
                                                                                                        <td>
                                                                                                            <?php if($sched2['schedroom2'] && $sched2['schedroom3'] != " "):?>
                                                                                                                <?= $sched2['schedroom']; ?> <?= $sched2['schedroom2']; ?>  <?= $sched2['schedroom3']; ?>
                                                                                                            <?php else: ?>
                                                                                                                <?= $sched2['schedroom']; ?>
                                                                                                            <?php endif; ?>
                                                                                                        </td>
                                                                                                        <td><?= $sched2['schedteacher']; ?></td>
                                                                                                        <td>
                                                                                                            <?= date("h:i A", strtotime($sched2['schedtimeF'])); ?> - <?= date("h:i A", strtotime($sched2['schedtimeT'])); ?> - <?= $sched2['schedday']; ?>
                                                                                                            <?php if(!empty($sched2['schedday2']) && !empty($sched2['schedtimeF2']) && $sched2['schedtimeF2'] != '00:00:00'): ?>
                                                                                                                <br><?= date("h:i A", strtotime($sched2['schedtimeF2'])); ?> - <?= date("h:i A", strtotime($sched2['schedtimeT2'])); ?> - <?= $sched2['schedday2']; ?>
                                                                                                            <?php endif; ?>
                                                                                                            <?php if(!empty($sched2['schedday3']) && !empty($sched2['schedtimeF3']) && $sched2['schedtimeF3'] != '00:00:00'): ?>
                                                                                                                <br><?= date("h:i A", strtotime($sched2['schedtimeF3'])); ?> - <?= date("h:i A", strtotime($sched2['schedtimeT3'])); ?> - <?= $sched2['schedday3']; ?>
                                                                                                            <?php endif; ?>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                <?php endif;?>
                                                                                            <?php endforeach; ?> 
                                                                                        <?php endif; ?>
                                                                                    <?php endforeach; ?> 
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a href="<?= base_url('schedules/downloadExcel/' . $sched['schedsecid']); ?>" 
                                                                        class="btn btn-success" 
                                                                        target="_blank">
                                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                                                            <path d="M12.1221 15.436L12.1221 3.39502" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                                                            <path d="M15.0381 12.5083L12.1221 15.4363L9.20609 12.5083" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                                                            <path d="M16.7551 8.12793H17.6881C19.7231 8.12793 21.3721 9.77693 21.3721 11.8129V16.6969C21.3721 18.7269 19.7271 20.3719 17.6971 20.3719L6.55707 20.3719C4.52207 20.3719 2.87207 18.7219 2.87207 16.6869V11.8019C2.87207 9.77293 4.51807 8.12793 6.54707 8.12793L7.48907 8.12793" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                                                                        </svg> Export to Excel
                                                                    </a>
                                                                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Edit Modal -->
                                                    <div class="modal fade" id="editModal<?= $sched['schedid']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content dark">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">EDIT SCHEDULES - <?= $courseSection; ?></h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Tabs for each schedule -->
                                                                    <ul class="nav nav-tabs" style="font-size: 14px;" id="scheduleTabs<?= $sched['schedcourid']; ?>" role="tablist">
                                                                        <?php 
                                                                        $scheduleCounter = 0;
                                                                        foreach ($scheduledata2 as $sched2):
                                                                            if($sched['schedsecid'] == $sched2['schedsecid']):
                                                                                    $scheduleCounter++;
                                                                            ?>
                                                                            <li class="nav-item" role="presentation">
                                                                                <button class="nav-link <?= ($scheduleCounter == 1) ? 'active' : ''; ?>" 
                                                                                        id="schedule-tab-<?= $sched2['schedid']; ?>" 
                                                                                        data-bs-toggle="tab" 
                                                                                        data-bs-target="#schedule-<?= $sched2['schedid']; ?>" 
                                                                                        type="button" role="tab">
                                                                                    <?php 
                                                                                        // Get subject name
                                                                                        $subjectName = '';
                                                                                        foreach($subjectsdata as $subj) {
                                                                                            if($subj['subid'] == $sched2['schedsubid']) {
                                                                                                $subjectName = $subj['subcode'];
                                                                                                break;
                                                                                            }
                                                                                        }
                                                                                        echo $subjectName ?: 'Schedule ' . $scheduleCounter;
                                                                                    ?>
                                                                                </button>
                                                                            </li>
                                                                        <?php 
                                                                            endif;
                                                                        endforeach; 
                                                                        ?>
                                                                    </ul>
                                                                    
                                                                    <div class="tab-content mt-3" id="scheduleTabsContent<?= $sched['schedcourid']; ?>">
                                                                        <?php 
                                                                        $scheduleCounter = 0;
                                                                        foreach ($scheduledata2 as $sched2):
                                                                            if($sched['schedsecid'] == $sched2['schedsecid']):
                                                                                $scheduleCounter++;
                                                                        ?>
                                                                            <div class="tab-pane fade <?= ($scheduleCounter == 1) ? 'show active' : ''; ?>" 
                                                                                id="schedule-<?= $sched2['schedid']; ?>" 
                                                                                role="tabpanel">
                                                                                
                                                                                <?= form_open('schedules/update/' . $sched2['schedid']); ?>
                                                                                    <div class="form-group">
                                                                                        <!-- Display Schedule Info Header -->
                                                                                        <div class="alert alert-info mb-3">
                                                                                            <strong>Subject:</strong> 
                                                                                            <?php 
                                                                                                foreach($subjectsdata as $subj) {
                                                                                                    if($subj['subid'] == $sched2['schedsubid']) {
                                                                                                        echo $subj['subcode'] . ' - ' . $subj['subject'];
                                                                                                        break;
                                                                                                    }
                                                                                                }
                                                                                            ?>
                                                                                            <br>
                                                                                            <strong>Schedule ID:</strong> <?= $sched2['schedid']; ?>
                                                                                        </div>
                                                                                        
                                                                                        <!-- Hidden Fields -->
                                                                                        <input type="hidden" name="schedule_id" value="<?= $sched2['schedid']; ?>">
                                                                                        <!-- COURSE and SUBJECT Row -->
                                                                                        <div class="row mb-3" hidden>
                                                                                            <div class="col-lg-7 col-sm-12">
                                                                                                <label class="form-label">COURSE</label>
                                                                                                <select name="course" class="form-select">
                                                                                                    <option value="<?= $sched2['schedcourid']; ?>" selected>
                                                                                                        <?= $sched2['schedcourid']; ?>
                                                                                                    </option>
                                                                                                    <?php foreach($coursedata as $cour): ?>
                                                                                                        <option value="<?= $cour['courid']; ?>">
                                                                                                            <?= $cour['code']; ?> - <?= $cour['name']; ?>
                                                                                                        </option>
                                                                                                    <?php endforeach; ?>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-lg-7 col-sm-12">
                                                                                                <label class="form-label">SUBJECT</label>
                                                                                                <select name="subject" class="form-select">
                                                                                                    <option value="<?= $sched2['schedsubid']; ?>" selected>
                                                                                                        <?= $sched2['schedsubid']; ?>
                                                                                                    </option>
                                                                                                    <?php foreach($subjectsdata as $subj): ?>
                                                                                                        <option value="<?= $subj['subid']; ?>">
                                                                                                            <?= $subj['subcode']; ?> - <?= $subj['subject']; ?>
                                                                                                        </option>
                                                                                                    <?php endforeach; ?>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <!-- SECTION and TEACHER Row -->
                                                                                        <div class="row mb-3">
                                                                                            <div class="col-lg-5 col-sm-12">
                                                                                                <label class="form-label">SECTION</label>
                                                                                                <select name="section" class="form-select" required>
                                                                                                    <option value="<?= $sched2['schedsecid']; ?>" selected>
                                                                                                        <?php 
                                                                                                            $sectionName = '';
                                                                                                            foreach($sectiondata as $sec) {
                                                                                                                if($sec['secid'] == $sched2['schedsecid']) {
                                                                                                                    $sectionName = $sec['section'];
                                                                                                                    break;
                                                                                                                }
                                                                                                            }
                                                                                                            echo $sectionName;
                                                                                                        ?>
                                                                                                    </option>
                                                                                                    <?php foreach($sectiondata as $sec): ?>
                                                                                                        <option value="<?= $sec['secid']; ?>"><?= $sec['section']; ?></option>
                                                                                                    <?php endforeach; ?>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-lg-7 col-sm-12">
                                                                                                <label class="form-label">TEACHER</label>
                                                                                                <br>
                                                                                                <select name="teacher" class="form-select" required>
                                                                                                    <option value="<?= $sched2['schedteacher']; ?>" selected>
                                                                                                        <?= $sched2['schedteacher']; ?>
                                                                                                    </option>
                                                                                                    <?php foreach($employeesdata as $empd): ?>
                                                                                                        <option value="<?= $empd['empfullname']; ?>">
                                                                                                            <?= $empd['empnum']; ?> - <?= $empd['empfullname']; ?>
                                                                                                        </option>
                                                                                                    <?php endforeach; ?>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        
                                                                                        <!-- ROOM and MAX STUD Row -->
                                                                                        <div class="row mb-3">
                                                                                            <div class="col-lg-7 col-sm-12">
                                                                                                <label class="form-label">ROOM</label>
                                                                                                <br>
                                                                                                <select name="room" class="form-select" required>
                                                                                                    <option value="<?= $sched2['schedroom']; ?>" selected>
                                                                                                        <?= $sched2['schedroom']; ?>
                                                                                                    </option>
                                                                                                    <?php foreach ($roomsdata as $roomsd): ?>
                                                                                                        <option value="<?php echo $roomsd['roomcode']; ?>"><?php echo $roomsd['roomcode']; ?></option>
                                                                                                    <?php endforeach; ?>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-lg-5 col-sm-12">
                                                                                                <label class="form-label">MAX STUD</label>
                                                                                                <input type="number" name="maxstudent" class="form-control" value="<?= $sched2['schedmaxstudent']; ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                        
                                                                                        <!-- Time Slot 1 -->
                                                                                        <div class="time-slot-container">
                                                                                            <div class="slot-header">
                                                                                                <h5 class="slot-title"><span class="slot-badge">1</span> Time Slot 1</h5>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col-md-4">
                                                                                                    <label class="form-label">DAY</label>
                                                                                                    <select name="day" class="form-select" required>
                                                                                                        <option value="<?= $sched2['schedday']; ?>" selected><?= $sched2['schedday']; ?></option>
                                                                                                        <option value="Sunday">Sunday</option>
                                                                                                        <option value="Monday">Monday</option>
                                                                                                        <option value="Tuesday">Tuesday</option>
                                                                                                        <option value="Wednesday">Wednesday</option>
                                                                                                        <option value="Thursday">Thursday</option>
                                                                                                        <option value="Friday">Friday</option>
                                                                                                        <option value="Saturday">Saturday</option>
                                                                                                    </select>
                                                                                                </div>
                                                                                                <div class="col-md-4">
                                                                                                    <label class="form-label">TIME IN</label>
                                                                                                    <input type="time" name="timein" class="form-control" value="<?= $sched2['schedtimeF']; ?>" required >
                                                                                                </div>
                                                                                                <div class="col-md-4">
                                                                                                    <label class="form-label">TIME OUT</label>
                                                                                                    <input type="time" name="timeout" class="form-control" value="<?= $sched2['schedtimeT']; ?>" required>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        
                                                                                        <!-- Time Slot 2 -->
                                                                                        <div id="timeSlot2_<?= $sched2['schedid']; ?>" class="time-slot-container fade-in <?= (!empty($sched2['schedday2']) && $sched2['schedtimeF2'] != '00:00:00') ? '' : 'hidden-slot'; ?>">
                                                                                            <div class="slot-header">
                                                                                                <h5 class="slot-title"><span class="slot-badge">2</span> Time Slot 2</h5>
                                                                                                <button type="button" class="btn btn-sm btn-danger" onclick="hideTimeSlot(2, '<?= $sched2['schedid']; ?>')">Remove</button>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col-md-4">
                                                                                                    <select name="day2" class="form-control">
                                                                                                        <option value="">Select Day</option>
                                                                                                        <option value="Sunday" <?= ($sched2['schedday2'] == 'Sunday') ? 'selected' : ''; ?>>Sunday</option>
                                                                                                        <option value="Monday" <?= ($sched2['schedday2'] == 'Monday') ? 'selected' : ''; ?>>Monday</option>
                                                                                                        <option value="Tuesday" <?= ($sched2['schedday2'] == 'Tuesday') ? 'selected' : ''; ?>>Tuesday</option>
                                                                                                        <option value="Wednesday" <?= ($sched2['schedday2'] == 'Wednesday') ? 'selected' : ''; ?>>Wednesday</option>
                                                                                                        <option value="Thursday" <?= ($sched2['schedday2'] == 'Thursday') ? 'selected' : ''; ?>>Thursday</option>
                                                                                                        <option value="Friday" <?= ($sched2['schedday2'] == 'Friday') ? 'selected' : ''; ?>>Friday</option>
                                                                                                        <option value="Saturday" <?= ($sched2['schedday2'] == 'Saturday') ? 'selected' : ''; ?>>Saturday</option>
                                                                                                    </select>
                                                                                                </div>
                                                                                                <div class="col-md-3">
                                                                                                    <input type="time" name="timein2" class="form-control" value="<?= ($sched2['schedtimeF2'] != '00:00:00') ? $sched2['schedtimeF2'] : ''; ?>">
                                                                                                </div>
                                                                                                <div class="col-md-3">
                                                                                                    <input type="time" name="timeout2" class="form-control" value="<?= ($sched2['schedtimeT2'] != '00:00:00') ? $sched2['schedtimeT2'] : ''; ?>">
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <select name="room2" class="form-control">
                                                                                                        <option value="">Select Room</option>
                                                                                                        <?php foreach ($roomsdata as $room): ?>
                                                                                                            <option value="<?= $room['roomcode'] ?>" <?= ($sched2['schedroom2'] == $room['roomcode']) ? 'selected' : ''; ?>><?= $room['roomcode'] ?></option>
                                                                                                        <?php endforeach; ?>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        
                                                                                        <!-- Time Slot 3 -->
                                                                                        <div id="timeSlot3_<?= $sched2['schedid']; ?>" class="time-slot-container fade-in <?= (!empty($sched2['schedday3']) && $sched2['schedtimeF3'] != '00:00:00') ? '' : 'hidden-slot'; ?>">
                                                                                            <div class="slot-header">
                                                                                                <h5 class="slot-title"><span class="slot-badge">3</span> Time Slot 3</h5>
                                                                                                <button type="button" class="btn btn-sm btn-danger" onclick="hideTimeSlot(3, '<?= $sched2['schedid']; ?>')">Remove</button>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col-md-4">
                                                                                                    <select name="day3" class="form-control">
                                                                                                        <option value="">Select Day</option>
                                                                                                        <option value="Sunday" <?= ($sched2['schedday3'] == 'Sunday') ? 'selected' : ''; ?>>Sunday</option>
                                                                                                        <option value="Monday" <?= ($sched2['schedday3'] == 'Monday') ? 'selected' : ''; ?>>Monday</option>
                                                                                                        <option value="Tuesday" <?= ($sched2['schedday3'] == 'Tuesday') ? 'selected' : ''; ?>>Tuesday</option>
                                                                                                        <option value="Wednesday" <?= ($sched2['schedday3'] == 'Wednesday') ? 'selected' : ''; ?>>Wednesday</option>
                                                                                                        <option value="Thursday" <?= ($sched2['schedday3'] == 'Thursday') ? 'selected' : ''; ?>>Thursday</option>
                                                                                                        <option value="Friday" <?= ($sched2['schedday3'] == 'Friday') ? 'selected' : ''; ?>>Friday</option>
                                                                                                        <option value="Saturday" <?= ($sched2['schedday3'] == 'Saturday') ? 'selected' : ''; ?>>Saturday</option>
                                                                                                    </select>
                                                                                                </div>
                                                                                                <div class="col-md-3">
                                                                                                    <input type="time" name="timein3" class="form-control" value="<?= ($sched2['schedtimeF3'] != '00:00:00') ? $sched2['schedtimeF3'] : ''; ?>">
                                                                                                </div>
                                                                                                <div class="col-md-3">
                                                                                                    <input type="time" name="timeout3" class="form-control" value="<?= ($sched2['schedtimeT3'] != '00:00:00') ? $sched2['schedtimeT3'] : ''; ?>">
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <select name="room3" class="form-control">
                                                                                                        <option value="">Select Room</option>
                                                                                                        <?php foreach ($roomsdata as $room): ?>
                                                                                                            <option value="<?= $room['roomcode'] ?>" <?= ($sched2['schedroom3'] == $room['roomcode']) ? 'selected' : ''; ?>><?= $room['roomcode'] ?></option>
                                                                                                        <?php endforeach; ?>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        
                                                                                        <!-- Action Buttons for this schedule -->
                                                                                        <div class="mt-3">
                                                                                            <button type="button" id="addSlot2Btn_<?= $sched2['schedid']; ?>" 
                                                                                                    class="btn btn-<?= (!empty($sched2['schedday2']) && $sched2['schedtimeF2'] != '00:00:00') ? 'primary' : 'info'; ?> btn-sm" 
                                                                                                    onclick="showTimeSlot(2, '<?= $sched2['schedid']; ?>')"
                                                                                                    <?= (!empty($sched2['schedday2']) && $sched2['schedtimeF2'] != '00:00:00') ? 'disabled' : ''; ?>>
                                                                                                <i class="fas fa-<?= (!empty($sched2['schedday2']) && $sched2['schedtimeF2'] != '00:00:00') ? 'check-circle' : 'plus-circle'; ?>"></i> 
                                                                                                <?= (!empty($sched2['schedday2']) && $sched2['schedtimeF2'] != '00:00:00') ? 'Time Slot 2 Added' : 'Add Time Slot 2'; ?>
                                                                                            </button>
                                                                                            
                                                                                            <button type="button" id="addSlot3Btn_<?= $sched2['schedid']; ?>" 
                                                                                                    class="btn btn-<?= (!empty($sched2['schedday3']) && $sched2['schedtimeF3'] != '00:00:00') ? 'primary' : 'info'; ?> btn-sm" 
                                                                                                    onclick="showTimeSlot(3, '<?= $sched2['schedid']; ?>')"
                                                                                                    <?= (!empty($sched2['schedday3']) && $sched2['schedtimeF3'] != '00:00:00') ? 'disabled' : ''; ?>>
                                                                                                <i class="fas fa-<?= (!empty($sched2['schedday3']) && $sched2['schedtimeF3'] != '00:00:00') ? 'check-circle' : 'plus-circle'; ?>"></i> 
                                                                                                <?= (!empty($sched2['schedday3']) && $sched2['schedtimeF3'] != '00:00:00') ? 'Time Slot 3 Added' : 'Add Time Slot 3'; ?>
                                                                                            </button>
                                                                                        </div>
                                                                                        
                                                                                        <hr class="my-3">
                                                                                        
                                                                                        <div class="text-end">
                                                                                            <button type="submit" name="update" class="btn btn-success">Update This Schedule</button>
                                                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                                                        </div>
                                                                                    </div>
                                                                                <?= form_close(); ?>
                                                                            </div>
                                                                        <?php 
                                                                            endif;
                                                                        endforeach; 
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Delete Button -->
                                                    <a class="btn btn-sm btn-icon btn-danger" title="Delete"
                                                        onclick="confirmDelete('<?= base_url(); ?>schedules/delete/<?= $sched['schedid']; ?>')">
                                                        <span class="btn-inner">
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                                                <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                                                <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                   
                                                                <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                                                            </svg>                                                                             
                                                        </span>
                                                    </a>
                                                </td>
                                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ----------- FOOTER ------------------ -->
    <?= $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?= $this->endSection(); ?>