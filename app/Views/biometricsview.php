<!doctype html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="refresh" content="10;url=<?= base_url(); ?>biometrics-blank">
        <title>Holy Cross College | Biometrics</title>
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
                    <div class="col-md-4" style="text-align: center;">
                        <?php if(session()->getTempdata('message')) :?>
                            <div class="alert alert-danger">
                                <?= session()->getTempdata('message');?>
                            </div>
                        <?php endif; ?>
                        <h1 style="color: white"><strong>EMPLOYEE TIME LOGS</strong></h1>
                        <div class="card">
                            <!-- <div class="card-body"> -->
                                <div class="table-responsive">
                                    <table class="table table">
                                        <thead>
                                            <tr>
                                                <th style="color: black; text-align: center;">NAME</th>
                                                <th style="color: black; text-align: center;">TIME IN</th>
                                                <th style="color: black; text-align: center;">TIME OUT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($attdata as $attd):?>
                                                <?php foreach($empdata as $empd):?>
                                                    <?php if($attd['employeeno'] == $empd['empnum']): ?>
                                                        <tr>
                                                            <td style="text-align: left; color: black;"><?= $empd['empfullname']; ?></td>
                                                            <td style="text-align: center; color: black;">
                                                                <?php 
                                                                    $TIMEIN = $attd['timein']; 
                                                                    echo $formattedTime = date('h:i A', strtotime($TIMEIN));
                                                                ?>
                                                            </td>
                                                            <td style="text-align: center; color: black;">
                                                                <?php 
                                                                    $TIMEOUT = $attd['timeout'];
                                                                    if($TIMEOUT == '00:00:00' || empty($TIMEOUT)){
                                                                        echo '--:-- --';
                                                                    } else {
                                                                        echo $formattedTime = date('h:i A', strtotime($TIMEOUT));
                                                                    }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <!-- </div> -->
                        </div>
                    </div>          
                    <div class="col-md-8" style="border-left-style: solid;">
                        <div class="row justify-content-center">
                            <div style="background-color: #263A56; text-align: center;">
                                <div class="row">
                                    <div class="col-3" style="text-align: right;">
                                        <img src="<?= base_url(); ?>public/assets/images/logohcc.png" style="width: 50%">
                                    </div>
                                    <div class="col-6">
                                        <h1 style="color: white;"><strong>HOLY CROSS COLLEGE<br>BIOMETRICS</strong></h1>
                                    </div>
                                    <div class="col-3" style="text-align: left;">
                                        <img src="<?= base_url(); ?>public/assets/images/mislogo.png" style="width: 50%">
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="row" style="justify-content: center; text-align: center;">
                                    <div class="col-12">
                                        <!-- Hidden video preview -->
                                        <video id="video" autoplay playsinline style="display:none;"></video>
                                        <!-- <video id="video" autoplay playsinline style="width: 500px"></video> -->
                                        <canvas id="canvas" style="display:none;"></canvas>
                                    </div>
                                </div>
                                <img src="
                                    <?php
                                        if(empty($employeedata['image'])){
                                            echo base_url().'/public/assets/images/bioimage.png"';
                                        } else {
                                            echo $employeedata['image'];
                                        }
                                    ?>" 
                                    alt="" style="width: 30%">
                                <br>
                                <br>
                                <h2 style="color: white;"><strong>
                                    <?php 
                                        if(empty($employeedata['empfullname'])){
                                            echo "EMPLOYEE NAME";
                                        } else {
                                            echo $employeedata['empfullname'];
                                        }
                                    ?>
                                </strong></h2>
                                <h4 style="color: #fecc09;"><strong>
                                    <?php
                                        if(empty($attendancedata['employeeno'])){
                                            echo "EMPLOYEE NUMBER";
                                        } else {
                                            echo $attendancedata['employeeno'];
                                        }
                                    ?>
                                </strong></h4>
                                <br>
                                <div class="row">
                                    <div class="col-4" style="text-align: right;">
                                        <h5 style="color: #fecc09;"><strong>TIME IN</strong></h5>
                                        <h4 style="color: white;"><strong>
                                            <?php 
                                                if(empty($attendancedata['timein']) || $attendancedata['timein'] == '00:00:00'){
                                                    echo "--:-- --";
                                                }else{
                                                    $TIMEIN = $attendancedata['timein'];
                                                    echo $formattedTime = date('h:i A', strtotime($TIMEIN));
                                                }
                                                
                                            ?>
                                        </strong></h4>
                                    </div>
                                    <div class="col-4" style="text-align: center;">
                                        <h1 style="color: white; text-transform: uppercase;"><strong>
                                            <?php 
                                                if(empty($attendancedata['date'])){
                                                    echo "DATE";
                                                }else{
                                                    $DATE = $attendancedata['date']; 
                                                    echo $formattedDate = date('F j, Y', strtotime($DATE));
                                                }
                                                
                                            ?>
                                        </strong></h1>
                                    </div>
                                    <div class="col-4" style="text-align: left;">
                                        <h5 style="color: #fecc09;"><strong>TIME OUT</strong></h5>
                                        <h4 style="color: white;"><strong>
                                            <?php 
                                                if(empty($attendancedata['timeout']) ||$attendancedata['timeout'] == '00:00:00'){
                                                    echo "--:-- --";
                                                }else{
                                                    $TIMEOUT = $attendancedata['timeout'];
                                                    echo $formattedTime = date('h:i A', strtotime($TIMEOUT));
                                                }
                                                
                                            ?>
                                        </strong></h4>
                                    </div>
                                </div>
                                <?= form_open_multipart('biometrics', ['id' => 'captureForm']); ?>
                                    <input type="hidden" name="image" id="image">
                                    <input type="text" name="rfidno" id="hiddenInput" class="visually-hidden" autocomplete="off" autofocus>
                                <?= form_close(); ?>
                            </div>
                        </div>
                    </div>
                    <!-- <div div class="col-md-2"></div> -->
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
        
        <style>
            .visually-hidden {
                position: absolute;
                width: 1px;
                height: 1px;
                margin: -1px;
                padding: 0;
                overflow: hidden;
                clip: rect(0 0 0 0);
                white-space: nowrap;
                border: 0;
            }
        </style>
        <script>
            // Access the webcam
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    const video = document.getElementById('video');
                    video.srcObject = stream;

                    // Wait for stream to be ready, then capture automatically
                    setTimeout(() => {
                        captureImage();
                    }, 2000); // 2 seconds delay
                })
                .catch(err => {
                    console.error("Camera access denied:", err);
                });

            function captureImage() {
                const video = document.getElementById('video');
                const canvas = document.getElementById('canvas');
                const context = canvas.getContext('2d');

                // Set canvas size same as video
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;

                // Draw the current frame
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                // Convert to Base64
                const dataUrl = canvas.toDataURL('image/png');

                // Put in hidden input
                document.getElementById('image').value = dataUrl;
            }
        </script>
    </body>
</html>