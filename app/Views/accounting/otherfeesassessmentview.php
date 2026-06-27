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
                                    <a href="<?= base_url(); ?>otherfee-assessment/process/<?= $studentd['studentno']; ?>" class="btn btn-success me-2">
                                        <i class="bi bi-journal-text"></i> PROCESS
                                    </a>
                                    <a href="<?= base_url(); ?>student-accounts/view/<?= $studentd['studentno']; ?>" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i> Back to Accounts
                                    </a>
                                </div>
                                <?php if(session()->getTempdata('paymentmessage')) :?>
                                    <div class="alert alert-info">
                                        <?= session()->getTempdata('paymentmessage');?>
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
                                        <th style="text-align: center;">PRICE</th>
                                        <th style="text-align: center;">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($otherfeesdata as $otherfeesd): ?>
                                        <tr>
                                            <td style="text-align: left; word-wrap: break-word; white-space: normal; max-width: 250px;">
                                                <?= $otherfeesd['name']; ?>
                                            </td>
                                            <td style="text-align: right;">₱<?= number_format($otherfeesd['price'], 2); ?></td>
                                            <td style="text-align: center;">
                                                <a href="<?= base_url(); ?>otherfee-assessment/add/<?= $studentd['studentno']; ?>/<?= $otherfeesd['ofid']; ?>" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-cart-plus"></i> Add
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
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
                        <?php if(empty($otherfeesassessmentdata)): ?>
                            <p>No books assessed for this student.</p>
                        <?php else: ?>
                            <div class="table-responsive"></div>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th style="text-align: center;">TITLE</th>
                                            <th style="text-align: center;">PRICE</th>
                                            <th style="text-align: center;">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $counter = 1;
                                            $totalBooksAssessment = 0;
                                            foreach($otherfeesassessmentdata as $assessment): 
                                            $totalBooksAssessment += $assessment['price'];
                                        ?>
                                        <tr>
                                            <td><?= $counter++; ?></td>
                                            <td style="text-align: left; word-wrap: break-word; white-space: normal; max-width: 250px;">
                                                <?= $assessment['name']; ?>
                                            </td>
                                            <td style="text-align: right;">₱<?= number_format($assessment['price'], 2); ?></td>
                                            <td style="text-align: center;">
                                                <a class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                                onclick="window.location.href='<?= base_url(); ?>books-assessment/delete/<?= $assessment['ofaid']; ?>'">
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
                                            <th colspan="1" style="text-align: right;">Total Items: <?= count($ofassessmentdata); ?></th>
                                            <th style="text-align: right;">Total:</th>
                                            <th style="text-align: right;">₱<?= number_format($totalBooksAssessment, 2); ?></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
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