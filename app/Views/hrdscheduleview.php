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
                        <div class="header-title">
                            <h4 class="card-title">EMPLOYEES SCHEDULE</h4>
                        </div>
                        <!-- Search Input -->
                        <div class="search-container">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search by ID or Name..." style="width: 300px;">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <?php if(session()->getTempdata('updatesuccess')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('updatesuccess');?>
                                </div>
                            <?php endif; ?>
                            <table id="datatable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NAME</th>
                                        <th>TIME IN</th>
                                        <th>TIME OUT</th>
                                    </tr>
                                </thead>
                                <tbody id="scheduleTableBody">
                                    <?php foreach($employeesdata as $employeesd):?>
                                        <?= form_open('hrd-schedule-save'); ?>
                                        <tr class="schedule-row" data-id="<?= $employeesd['empnum']; ?>" data-name="<?= strtolower($employeesd['empfullname']); ?>">
                                            <td><?= $employeesd['empnum'];?><input type="hidden" name="id[]" value="<?= $employeesd['empid']; ?>"></td>
                                            <td><?= $employeesd['empfullname'];?></td>
                                            <td><input type="time" name="timein[]" class="form-control schedule-timein" value="<?php 
                                                if($employeesd['timein'] == '00:00:00' || empty($employeesd['timein'])){
                                                    echo '';
                                                } else {
                                                    echo $employeesd['timein'];
                                                }?>"></td>
                                            <td><input type="time" name="timeout[]" class="form-control schedule-timeout" value="<?php 
                                                if($employeesd['timeout'] == '00:00:00' || empty($employeesd['timeout'])){
                                                    echo '';
                                                } else {
                                                    echo $employeesd['timeout'];
                                                }?>"></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-m btn-icon btn-success" style="width: 100%; height: 100px;">SAVE</button>
                        <?= form_close(); ?>
                        </div>
                        <br>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Page Content -->

    <!-- Search JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('.schedule-row');
        
        // Add event listener for search input
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            
            tableRows.forEach(row => {
                const id = row.getAttribute('data-id').toLowerCase();
                const name = row.getAttribute('data-name');
                
                // Check if search term matches ID or Name
                const matchesSearch = id.includes(searchTerm) || name.includes(searchTerm);
                
                // Show/hide row based on search match
                if (matchesSearch || searchTerm === '') {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            
          
            updateClearButton();
        });
        
      
        function updateClearButton() {
            if (searchInput.value !== '') {
                if (!searchInput.parentNode.querySelector('.clear-search')) {
                    const clearBtn = document.createElement('button');
                    clearBtn.type = 'button';
                    clearBtn.className = 'clear-search btn btn-sm btn-link';
                    clearBtn.innerHTML = '&times;';
                    clearBtn.style.position = 'absolute';
                    clearBtn.style.right = '10px';
                    clearBtn.style.top = '50%';
                    clearBtn.style.transform = 'translateY(-50%)';
                    clearBtn.style.border = 'none';
                    clearBtn.style.background = 'transparent';
                    clearBtn.style.fontSize = '1.5em';
                    clearBtn.style.cursor = 'pointer';
                    
                    // Add click event to clear button
                    clearBtn.addEventListener('click', function() {
                        searchInput.value = '';
                        searchInput.dispatchEvent(new Event('input'));
                        searchInput.focus();
                    });
                    
                    searchInput.parentNode.style.position = 'relative';
                    searchInput.parentNode.appendChild(clearBtn);
                }
            } else {
                const clearBtn = searchInput.parentNode.querySelector('.clear-search');
                if (clearBtn) {
                    clearBtn.remove();
                }
            }
        }
        
        // Also add search by pressing slash key (optional feature)
        document.addEventListener('keydown', function(e) {
            // Focus search input when '/' is pressed (except when in input field)
            if (e.key === '/' && !['INPUT', 'TEXTAREA'].includes(e.target.tagName)) {
                e.preventDefault();
                searchInput.focus();
            }
            
            // Clear search with Escape key when search input is focused
            if (e.key === 'Escape' && document.activeElement === searchInput) {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
            }
        });
        
        // Add placeholder text that shows keyboard shortcut
        searchInput.placeholder = "Search by ID or Name... (Press '/' to focus)";
        
        // Initialize clear button
        updateClearButton();
    });
    </script>
    
    <style>
    /* Optional: Add some styling for better search experience */
    .search-container {
        position: relative;
        display: inline-block;
    }
    
    #searchInput {
        padding-right: 30px; /* Space for clear button */
    }
    
    .clear-search {
        color: #999;
        transition: color 0.2s;
    }
    
    .clear-search:hover {
        color: #333;
    }
    
    /* Style for no results message */
    .no-results {
        text-align: center;
        padding: 20px;
        font-style: italic;
        color: #666;
        display: none;
    }
    </style>

    <!-- ----------- FOOTER ------------------ -->
    <?= $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?= $this->endSection(); ?>