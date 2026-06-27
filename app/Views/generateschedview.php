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
        
        .additional-time-slot {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .time-slot-header {
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        
        .remove-timeslot-btn {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .remove-timeslot-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }
        
        .add-timeslot-btn {
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .add-timeslot-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .time-slot-icon {
            margin-right: 8px;
        }
        
        .time-slot-card {
            background: #222738;
            border-radius: 8px;
            padding: 15px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
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

            // Course change handlers for edit modal
            $('#UCourse').change(function() {
                var courid = $(this).val();
                $('#USection').html('<option value="">Select Section</option>');
                $('#USection').prop('disabled', true);
                
                if(courid !== '') {
                    fetchSections(courid, '#USection');
                }
            });
            $('#Section').change(function() {
                var courid = $(this).val();
                $('#Level').html('<option value="">Select Level</option>');
                $('#Level').prop('disabled', true);
                
                if(seclevel !== '') {
                    fetchSections(seclevel, '#Level');
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

            function fetchLevels(level, targetSelector) {
                $.ajax({
                    url: "<?php echo base_url('schedules/fetchlevels'); ?>",
                    method: 'POST',
                    data: {level: level},
                    dataType: 'json',
                    success: function(response) {
                        if(response && response.length > 0) {
                            $(targetSelector).prop('disabled', false);
                            $.each(response, function(index, data) {
                                $(targetSelector).append('<option value="'+data.level+'">'+data.level+'</option>');
                            });
                        } else {
                            console.log('No levels found for this section');
                            $(targetSelector).html('<option value="">No levels available</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        $(targetSelector).html('<option value="">Error loading levels</option>');
                    }
                });
            }

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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->include("partials/footer"); ?>


<?= $this->endSection(); ?>