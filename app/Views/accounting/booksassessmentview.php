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

    <style>
        .wrap-title {
        word-wrap: break-word;      /* Allow words to break if needed */
        white-space: normal;        /* Allow wrapping */
        max-width: 250px;           /* Optional: set a max width */
        }
    </style>

    <!-- Begin Page Content -->
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                            <?php if(session()->getTempdata('deletesuccess')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('deletesuccess');?>
                                </div>
                            <?php endif; ?>
                            <?php if(session()->getTempdata('activatesuccess')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('activatesuccess');?>
                                </div>
                            <?php endif; ?>
                            <?php if(session()->getTempdata('updatesuccess')) :?>
                                <div class="alert alert-success">
                                    <?= session()->getTempdata('updatesuccess');?>
                                </div>
                            <?php endif; ?>
                        <?php echo form_open('student-accounts'); ?> 
                            <div class="row">
                                <div class="col-lg-9 col-sm-12">
                                    <label class="form-label" for="validationDefault01">SEARCH STUDENT</label>
                                    <input type="text" name="searchstud" class="form-control"
                                    placeholder="Search Student Number | Student Name">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <button class="btn btn-success" type="submit" name="add" style="width: 100%; height: 100%;">SEACH STUDENT</button>
                                </div>
                            </div>
                        <?php echo form_close(); ?>    
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <?php foreach($studentdata as $studentd): ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <h2 style="text-transform: uppercase;"><?= $studentd['studfullname']; ?></h2>
                                    <h4><strong>Student No: <?= $studentd['studentno']; ?></strong></h4>
                                </div>
                                <div class="col-md-6 text-end">
                                    <a href="<?= base_url(); ?>books-assessment/process/<?= $studentd['studentno']; ?>" class="btn btn-success me-2">
                                        <i class="bi bi-journal-text"></i> PROCESS
                                    </a>
                                    <a onclick="history.back()" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i> Back to Accounts
                                    </a>
                                </div>
                                <?php if(session()->getTempdata('message')) :?>
                                    <div class="alert alert-success">
                                        <?= session()->getTempdata('message');?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">LIST OF BOOKS</h4>
                        </div>
                        <br>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" data-toggle="data-table" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">TITLE</th>
                                        <th style="text-align: center;">LEVEL</th>
                                        <th style="text-align: center;">CLUSTER</th>
                                        <th style="text-align: center;">PRICE</th>
                                        <th style="text-align: center;">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($booksdata as $bookd): ?>
                                        <tr>
                                            <td style="text-align: left; word-wrap: break-word; white-space: normal; max-width: 250px;">
                                                <?= $bookd['name']; ?>
                                            </td>
                                            <td style="text-align: center;"><?= $bookd['level']; ?></td>
                                            <td style="text-align: center;"><?= $bookd['cluster']; ?></td>
                                            <td style="text-align: right;">₱<?= number_format($bookd['price'], 2); ?></td>
                                            <td style="text-align: center;">
                                                <a href="<?= base_url(); ?>books-assessment/add/<?= $studentd['studentno']; ?>/<?= $bookd['bookid']; ?>" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-cart-plus"></i> Add
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <div style="text-align: right;">
                                        <a href="<?= base_url(); ?>books-assessment/addall/<?= $studentd['studentno']; ?>/<?= $bookd['level']; ?>" class="btn btn-primary btn-sm">
                                            <i class="bi bi-cart-plus"></i> Add All Books
                                        </a>
                                    </div>
                                    <br>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title mb-0">BOOKS ASSESSMENT</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if(session()->getTempdata('addsuccess')) :?>
                            <div class="alert alert-success">
                                <?= session()->getTempdata('addsuccess');?>
                            </div>
                        <?php endif; ?>
                        <?php if(empty($booksassessmentdata)): ?>
                            <p>No books assessed for this student.</p>
                        <?php else: ?>
                            <div class="table-responsive"></div>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th style="text-align: center;">TITLE</th>
                                            <th style="text-align: center;">LEVEL</th>
                                            <th style="text-align: center;">CLUSTER</th>
                                            <th style="text-align: center;">PRICE</th>
                                            <th style="text-align: center;">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $counter = 1;
                                            $totalBooksAssessment = 0;
                                            foreach($booksassessmentdata as $assessment): 
                                            $totalBooksAssessment += $assessment['price'];
                                        ?>
                                        <tr>
                                            <td><?= $counter++; ?></td>
                                            <td style="text-align: left; word-wrap: break-word; white-space: normal; max-width: 250px;">
                                                <?= $assessment['name']; ?>
                                            </td>
                                            <td style="text-align: center;"><?= $assessment['level']; ?></td>
                                            <td style="text-align: center;"><?= $assessment['cluster']; ?></td>
                                            <td style="text-align: right;">₱<?= number_format($assessment['price'], 2); ?></td>
                                            <td style="text-align: center;">
                                                <a class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                                onclick="window.location.href='<?= base_url(); ?>books-assessment/delete/<?= $assessment['baid']; ?>'">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
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
                                    <tfoot>
                                        <tr>
                                            <th colspan="2" style="text-align: right;">Total Items: <?= count($booksassessmentdata); ?></th>
                                            <th style="text-align: right;">Total:</th>
                                            <th style="text-align: right;">₱<?= number_format($totalBooksAssessment, 2); ?></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <br>
                                <a class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="PRINT" style="width: 100%;"
                                href="<?= base_url('book-assessment/print/'.$studentd['studentno']) ?>" 
                                target="_blank">
                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7379 2.76175H8.08493C6.00493 2.75375 4.29993 4.41175 4.25093 6.49075V17.2037C4.20493 19.3167 5.87993 21.0677 7.99293 21.1147C8.02393 21.1147 8.05393 21.1157 8.08493 21.1147H16.0739C18.1679 21.0297 19.8179 19.2997 19.8029 17.2037V8.03775L14.7379 2.76175Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                        <path d="M14.4751 2.75V5.659C14.4751 7.079 15.6231 8.23 17.0431 8.234H19.7981" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                        <path d="M14.2882 15.3584H8.88818" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                        <path d="M12.2432 11.606H8.88721" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                                    </svg> PRINT                         
                                </a>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title mb-0">BOOKS ASSESSMENT HISTORY</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if(session()->getTempdata('updatesuccess')) :?>
                            <div class="alert alert-success">
                                <?= session()->getTempdata('updatesuccess');?>
                            </div>
                        <?php endif; ?>
                        <?php if(empty($bookassessmentdata)): ?>
                            <p>No books assessed for this student.</p>
                        <?php else: ?>
                            <div class="table-responsive"></div>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">STUDENT NUMBER</th>
                                            <th style="text-align: center;">TOTAL AMOUNT</th>
                                            <th style="text-align: center;">OR NUMBER</th>
                                            <th style="text-align: center;">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $counter = 1;
                                            foreach($bookassessmentdata as $assessment):
                                        ?>
                                            <?php if($assessment['transactionno'] == 0): ?>
                                                <p>No books assessed for this student.</p>
                                            <?php else: ?>
                                                <tr>
                                                    <td style="text-align: center;"><?= $assessment['studno']; ?></td>
                                                    <td style="text-align: center;">
                                                        ₱<?= number_format($assessment['total'], 2); ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php if(empty($assessment['ornumber'])): ?>
                                                            <?= form_open('book-assessment/submitOR/'.$assessment['studno'].'/'.$assessment['transactionno']); ?>
                                                                <input type="text" name="ornumber" value="" placeholder="Enter OR Number" class="form-control" required>
                                                            <?= form_close(); ?>
                                                        <?php else: ?>
                                                            <?= $assessment['ornumber']; ?>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php if($assessment['status'] == 'Released'): ?>
                                                            RELEASED
                                                            <?php elseif($assessment['ornumber']== null): ?>
                                                            <?php else: ?>
                                                            <a class="btn btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Release"
                                                            onclick="window.location.href='<?= base_url(); ?>book-assessment/release/<?= $assessment['transactionno']; ?>'">
                                                                <span class="btn-inner">
                                                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                    
                                                                        <path d="M16.4242 5.56204C15.8072 3.78004 14.1142 2.50004 12.1222 2.50004C9.60925 2.49004 7.56325 4.51804 7.55225 7.03104V7.05104V9.19804" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.933 21.0005H8.292C6.198 21.0005 4.5 19.3025 4.5 17.2075V12.9195C4.5 10.8245 6.198 9.12646 8.292 9.12646H15.933C18.027 9.12646 19.725 10.8245 19.725 12.9195V17.2075C19.725 19.3025 18.027 21.0005 15.933 21.0005Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    
                                                                        <path d="M12.1128 13.9526V16.1746" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                                                                    </svg>                            
                                                                </span>
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif;?>
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