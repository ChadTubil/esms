<?php
    $page_session = \CodeIgniter\Config\Services::session();
?>
<?php $this->section("title"); ?>
    <?php echo $page_title; ?>
<?php $this->endSection(); ?>
<!doctype html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php $this->renderSection("title"); ?></title>
        <!-- Favicon -->
        <link rel="shortcut icon" href="<?= base_url(); ?>/public/assets/images/hccicon.ico">
        <!-- Library / Plugin Css Build -->
        <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/core/libs.min.css">
        <!-- Hope Ui Design System Css -->
        <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/hope-ui.min.css?v=4.0.0">
        <!-- Custom Css -->
        <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/custom.min.css?v=4.0.0">
        <!-- Dark Css -->
        <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/dark.min.css">
        <!-- Customizer Css -->
        <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/customizer.min.css">
        <!-- RTL Css -->
        <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/rtl.min.css">
    </head>
    <body class="" data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0" tabindex="0">
        <div class="wrapper">
            <section class="login-content">
                <div class="row m-0 align-items-center vh-100" style="background-color: #263A56">            
                    <div class="col-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div style="background-color: #263A56; text-align: center;">
                                    <img src="<?= base_url(); ?>public/assets/images/logo4.png" alt="" style="width: 40%">
                                    <h3 style="color: white;"><strong>HOLY CROSS COLLEGE<br>STUDENT PORTAL</strong></h3>
                                    <br>
                                    <?php echo form_open(); ?>
                                        <div class="row" style="text-align: left;">
                                            <?php if(isset($validation)): ?>
                                                <div class="alert alert-danger d-flex align-items-left" role="alert">
                                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                                                        <use xlink:href="#exclamation-triangle-fill" />
                                                    </svg>
                                                    <div>
                                                        <?php echo $validation->listErrors(); ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <?php if(session()->getTempdata('error')): ?>
                                                <div class="alert alert-danger d-flex align-items-center" role="alert">
                                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                                                        <use xlink:href="#exclamation-triangle-fill" />
                                                    </svg>
                                                    <div>
                                                        <?php echo session()->getTempdata('error'); ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <div class="col-lg-2"></div>
                                                <div class="col-lg-8">
                                                    <div class="form-group">
                                                    <!-- <label for="email" class="form-label">Email</label> -->
                                                    <input type="text" name="studentno" class="form-control" placeholder="Student No." style="color: black;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">    
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <!-- <label for="password" class="form-label">Password</label> -->
                                                    <input type="password" name="pass" class="form-control" placeholder="Password" style="color: black;">
                                                </div>
                                                <input type="submit" value="SIGN IN" class="btn btn-primary" style="width: 100%">
                                            </div>
                                        </div>
                                    <?php echo form_close();?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
                        <img src="<?= base_url(); ?>/public/assets/images/hccnewlypainted2.jpg" class="img-fluid gradient-main animated-scaleX" alt="images">
                    </div>
                </div>
            </section>
        </div>
        <!-- Library Bundle Script -->
        <script src="<?= base_url(); ?>/public/assets/js/core/libs.min.js"></script>
        <!-- External Library Bundle Script -->
        <script src="<?= base_url(); ?>/public/assets/js/core/external.min.js"></script>
        <!-- Widgetchart Script -->
        <script src="<?= base_url(); ?>/public/assets/js/charts/widgetcharts.js"></script>
        <!-- mapchart Script -->
        <script src="<?= base_url(); ?>/public/assets/js/charts/vectore-chart.js"></script>
        <script src="<?= base_url(); ?>/public/assets/js/charts/dashboard.js" ></script>
        <!-- fslightbox Script -->
        <script src="<?= base_url(); ?>/public/assets/js/plugins/fslightbox.js"></script>
        <!-- Settings Script -->
        <script src="<?= base_url(); ?>/public/assets/js/plugins/setting.js"></script>
        <!-- Slider-tab Script -->
        <script src="<?= base_url(); ?>/public/assets/js/plugins/slider-tabs.js"></script>
        <!-- Form Wizard Script -->
        <script src="<?= base_url(); ?>/public/assets/js/plugins/form-wizard.js"></script>
        <!-- AOS Animation Plugin-->
        <!-- App Script -->
        <script src="<?= base_url(); ?>/public/assets/js/hope-ui.js" defer></script>
    </body>
</html>