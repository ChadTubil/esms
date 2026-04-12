<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration | Holy Cross College Pampanga</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url(); ?>/public/assets/images/hccicon.ico">
    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/core/libs.min.css" />
    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/hope-ui.min.css?v=2.0.0" />
    <!-- Custom Css -->
    <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/custom.min.css?v=2.0.0" />
    <!-- Dark Css -->
    <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/dark.min.css"/>
    <!-- Customizer Css -->
    <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/customizer.min.css" />
    <!-- RTL Css -->
    <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/rtl.min.css"/>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .navbar-center {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 100%;
            gap: 10px;
        }
        
        .logo-title {
            color: black;
            margin: 0;
            font-size: 3rem;
        }
        
        .logo-main {
            display: flex;
            align-items: center;
        }
        
        .form-section {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .form-label {
            font-weight: 600;
            color: #263A56;
        }
        
        .form-control:focus {
            border-color: #263A56;
            box-shadow: 0 0 0 0.2rem rgba(38, 58, 86, 0.25);
        }
        
        .required-field::after {
            content: " *";
            color: red;
        }
        
        .submit-btn {
            background-color: #263A56;
            color: white;
            padding: 12px 30px;
            font-weight: 600;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        
        .submit-btn:hover {
            background-color: #1a2840;
        }
        
        @media (max-width: 768px) {
            .navbar-center {
                flex-direction: column;
                gap: 10px;
            }
            .logo-title {
                font-size: 1.2rem;
                text-align: center;
            }
            .card-body {
                padding: 15px;
            }
        }
        
        @media (max-width: 576px) {
            .form-row {
                margin-bottom: 0;
            }
            .col-form-label {
                padding-bottom: 5px;
            }
        }

        /* Footer styling */
        .footer {
            background-color: #263A56;
            color: white;
            padding: 10px 0;
            margin-top: 40px;
        }
        
        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .footer-logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .footer-logo img {
            width: 60px;
            height: auto;
        }
        
        .footer-logo-text h4 {
            margin: 0;
            font-size: 1.2rem;
        }
        
        .footer-logo-text p {
            margin: 0;
            opacity: 0.8;
            font-size: 0.9rem;
        }
        
        .footer-contact h5 {
            margin-bottom: 10px;
            font-size: 1rem;
        }
        
        .footer-contact p {
            margin: 5px 0;
            opacity: 0.8;
            font-size: 0.9rem;
        }
        
        .footer-bottom {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgb(255, 255, 255);
            opacity: 0.7;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .program-button {
                min-width: 100%;
                max-width: 100%;
            }
            
            .footer-content {
                flex-direction: column;
                text-align: center;
            }
            
            .footer-logo {
                justify-content: center;
            }
        }
        /* Webcam Styles */
        .webcam-section {
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .webcam-container {
            text-align: center;
        }

        #video {
            width: 250px;
            max-width: 400px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            display: block;
            margin: 0 auto;
            
        }

        .webcam-buttons {
            margin-top: 15px;
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .captured-image {
            text-align: center;
            margin-top: 20px;
        }

        .photo-preview {
            display: inline-block;
            position: relative;
        }

        #capturedPhoto {
            max-width: 250px;
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-success {
            background: #27ae60;
            color: white;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .btn-warning {
            background: #f39c12;
            color: white;
        }

        .btn-secondary {
            background: #95a5a6;
            color: white;
        }

        #canvas {
            display: none;
        }

        .remove-photo {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #e74c3c;
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
            border: none;
            font-weight: bold;
        }

        .remove-photo:hover {
            background: #c0392b;
        }

        @media (max-width: 600px) {
            form {
                padding: 20px;
            }
            
            .webcam-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }

        .photo-required {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="conatiner-fluid content-inner" style="background-color: #263A56">
        <div class="row">
            <div class="col-lg-1 col-sm-12"></div>
            <div class="col-lg-10 col-sm-12">
                <div class="container">
                    <div class="rounded nav navbar" style="background-color: white;">
                        <div class="container-fluid">
                            <div class="mx-2 navbar-center">
                                <div class="logo-main">
                                    <a href="<?php echo base_url() ?>online-registration">
                                    <img src="<?= base_url(); ?>/public/assets/images/logohcc.png" alt="HCC Logo" style="width: 80px; height: auto;"></a>
                                </div>
                                <h1 class="logo-title"><strong>HOLY CROSS COLLEGE REGISTRATION</strong></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-1 col-sm-12"></div>

            <div class="col-lg-12 col-sm-12" style="margin-top: 30px;">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h2 class="card-title" style="color: black; margin-bottom: 5px;"><strong>IBED STUDENT INFORMATION</strong></h2>
                            <p class="text-muted">Please fill out all the required fields below</p>
                        </div>
                        <?php if(isset($validation)): ?>
                            <div class="alert alert-danger">
                                <?php echo $validation->listErrors(); ?>
                            </div>
                        <?php endif; ?>
                        <?php if(session()->getTempdata('error')) :?>
                            <div class="alert alert-danger">
                                <?= session()->getTempdata('error');?>
                            </div>
                        <?php endif; ?>
                        <!-- Student Information Form -->
                        <?= form_open('kiosk-registration-gs'); ?>
                            <div class="form-section">
                                <h4 style="color: #263A56; border-bottom: 2px solid #263A56; padding-bottom: 10px; margin-bottom: 25px;">Personal Information</h4>
                                <div class="row">
                                    <div class="col-md-9">
                                        <!-- Name Section -->
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="lastname" class="form-label required-field">Last Name</label>
                                                <input type="text" class="form-control form-control-x" id="lastname" name="lastname" placeholder="Enter your last name"
                                                style="text-transform: uppercase;" value="<?php echo set_value('lastname'); ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="firstname" class="form-label required-field">First Name</label>
                                                <input type="text" class="form-control form-control-x" id="firstname" name="firstname" placeholder="Enter your first name"
                                                style="text-transform: uppercase;" value="<?php echo set_value('firstname'); ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="middlename" class="form-label required-field">Middle Name</label>
                                                <input type="text" class="form-control form-control-x" id="middlename" name="middlename" placeholder="Enter your middle name"
                                                style="text-transform: uppercase;" value="<?php echo set_value('middlename'); ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="extension" class="form-label">Name Extension</label>
                                                <select class="form-control" id="extension" name="extension">
                                                    <option value="">Select Extension</option>
                                                    <option value="JR.">Jr.</option>
                                                    <option value="SR.">Sr.</option>
                                                    <option value="II">II</option>
                                                    <option value="III">III</option>
                                                    <option value="IV">IV</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <!-- Personal Details -->
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="birthday" class="form-label required-field">Birthday</label>
                                                <input type="date" class="form-control" id="birthday" name="birthday"
                                                value="<?php echo set_value('birthday'); ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="birthplace" class="form-label required-field">Birth Place</label>
                                                <input type="text" class="form-control form-control-x" id="birthplace" name="birthplace" placeholder="City/Municipality, Province"
                                                style="text-transform: uppercase;" value="<?php echo set_value('birthplace'); ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="gender" class="form-label required-field">Gender</label>
                                                <select class="form-control" id="gender" name="gender">
                                                    <option value="">Select Gender</option>
                                                    <option value="MALE">Male</option>
                                                    <option value="FEMALE">Female</option>
                                                    <option value="OTHER">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <!-- Contact Information -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="email" class="form-label required-field">Email Address</label>
                                                <input type="email" class="form-control form-control-x" id="email" name="email" placeholder="example@email.com"
                                                style="text-transform: uppercase;" value="<?php echo set_value('email'); ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="contact" class="form-label required-field">Contact Number</label>
                                                <input type="text" class="form-control" id="contact" name="contact" placeholder="09XXXXXXXXX"
                                                style="text-transform: uppercase;" value="<?php echo set_value('contact'); ?>">
                                            </div>
                                        </div>
                                        
                                        <!-- Citizenship & Religion -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="citizenship" class="form-label required-field">Citizenship</label>
                                                <input type="text" class="form-control form-control-x" id="citizenship" name="citizenship" placeholder="Citizenship"
                                                style="text-transform: uppercase;" value="<?php echo set_value('citizenship'); ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="religion" class="form-label required-field">Religion</label>
                                                <input type="text" class="form-control form-control-x" id="religion" name="religion" placeholder="Enter your religion"
                                                style="text-transform: uppercase;" value="<?php echo set_value('religion'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Webcam Capture Section -->
                                    <div class="col-md-3">
                                        <div class="col-md-12">
                                            <div class="webcam-section" style="background-color: #f8f9fa; border: 2px solid #e0e0e0;">
                                                <h5 style="color: #263A56; padding-bottom: 10px; margin-bottom: 25px;">
                                                    <i class="fas fa-camera"></i> Student ID Photo Capture 
                                                    <span style="color: red;">*</span>
                                                </h5>

                                            <div class="webcam-container">
                                                <video id="video" autoplay playsinline></video>
                                                <canvas id="canvas"></canvas>

                                                <div class="captured-image" id="photoPreview" style="display: none;">
                                                    <h5><i class="fas fa-check-circle" style="color: #27ae60;"></i> Captured Photo:</h5>
                                                    <div class="photo-preview">
                                                        <img id="capturedPhoto" alt="Captured photo">
                                                        <button type="button" class="remove-photo" id="removePhoto">×</button>
                                                    </div>
                                                </div>
                                                
                                                <input type="hidden" name="student_photo" id="studentPhotoData">
                                                <div class="photo-required" id="photoRequiredMsg" style="display: none;">
                                                    <i class="fas fa-exclamation-circle"></i> Please capture a photo before submitting
                                                </div>
                                                
                                                <div class="webcam-buttons">
                                                    <button type="button" class="btn btn-primary" id="startCamera" data-bs-placement="below" title="Start Camera">
                                                        <i class="fas fa-video"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-success" id="captureBtn" data-bs-placement="below" title="Capture Photo" disabled>
                                                        <i class="fas fa-camera"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-warning" id="retakeBtn" data-bs-placement="below" title="Retake Photo">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger" id="stopCamera" data-bs-placement="below" title="Stop Camera" disabled>
                                                        <i class="fas fa-stop"></i>
                                                    </button>
                                                </div>   
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Address Section -->
                            <div class="form-section">
                                <h4 style="color: #263A56; border-bottom: 2px solid #263A56; padding-bottom: 10px; margin-bottom: 25px;">Address Information</h4>
                                
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="barangay" class="form-label required-field">Barangay</label>
                                        <input type="text" class="form-control form-control-x" id="barangay" name="barangay" placeholder="Enter your barangay"
                                        style="text-transform: uppercase;" value="<?php echo set_value('barangay'); ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="municipality" class="form-label required-field">Municipality/City</label>
                                        <input type="text" class="form-control form-control-x" id="municipality" name="municipality" placeholder="Enter municipality/city"
                                        style="text-transform: uppercase;" value="<?php echo set_value('municipality'); ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="province" class="form-label required-field">Province</label>
                                        <input type="text" class="form-control form-control-x" id="province" name="province" placeholder="Enter your province"
                                        style="text-transform: uppercase;" value="<?php echo set_value('province'); ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Terms and Conditions -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">
                                    I hereby certify that the information provided above is true and correct to the best of my knowledge.
                                </label>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="text-center mt-4">
                                <button type="submit" class="submit-btn">Submit Registration</button>
                            </div>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="footer-content">
                    <div class="footer-logo">
                        <img src="<?= base_url(); ?>/public/assets/images/logohcc.png" alt="HCC Logo">
                        <div class="footer-logo-text">
                            <h4  style="color: white;"><strong>HOLY CROSS COLLEGE</strong></h4>
                            <p  style="color: white;">Pampanga, Philippines</p>
                        </div>
                    </div>
                    
                    <div class="footer-contact">
                        <h5  style="color: white;"><strong>CONTACT INFORMATION</strong></h5>
                        <p><i class="fas fa-phone-alt"></i> (045) 123-4567</p>
                        <p><i class="fas fa-envelope"></i> registrar.office@holycrosscollegepampanga.edu.ph</p>
                        <p><i class="fas fa-map-marker-alt"></i> Sta. Ana, Pampanga, Philippines</p>
                    </div>
                    
                    <div class="footer-social">
                        <h5  style="color: white;"><strong>FOLLOW US</strong></h5>
                        <div style="display: flex; gap: 15px; font-size: 1.5rem;">
                            <a href="#" style="color: white;"><i class="fab fa-facebook"></i></a>
                            <a href="#" style="color: white;"><i class="fab fa-twitter"></i></a>
                            <a href="#" style="color: white;"><i class="fab fa-instagram"></i></a>
                            <a href="#" style="color: white;"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="footer-bottom">
                    <p style="color: white;">&copy; 2026 Holy Cross College Pampanga. All Rights Reserved. | TRS Department</p>
                </div>
            </div>
        </footer>
    </div>
    <script>
        document.querySelectorAll('.form-control-x').forEach(input => {
            input.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        });
        // Webcam functionality
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const startBtn = document.getElementById('startCamera');
        const captureBtn = document.getElementById('captureBtn');
        const retakeBtn = document.getElementById('retakeBtn');
        const stopBtn = document.getElementById('stopCamera');
        const photoPreview = document.getElementById('photoPreview');
        const capturedPhoto = document.getElementById('capturedPhoto');
        const studentPhotoData = document.getElementById('studentPhotoData');
        const removePhotoBtn = document.getElementById('removePhoto');
        const photoRequiredMsg = document.getElementById('photoRequiredMsg');

        let stream = null;
        let photoCaptured = false;

        // Start camera
        startBtn.addEventListener('click', async () => {
            try {
                if (stream) {
                    stopStream();
                }
                
                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        width: { ideal: 500 },
                        height: { ideal: 500 }
                    } 
                });
                video.srcObject = stream;
                video.style.display = 'block';
                canvas.style.display = 'none';
                photoCaptured = false;
                captureBtn.disabled = false;
                stopBtn.disabled = false;
                startBtn.disabled = true;
                
                // Hide photo required message
                photoRequiredMsg.style.display = 'none';
            } catch (err) {
                console.error('Error accessing camera:', err);
                alert('Unable to access camera. Please ensure you have granted camera permissions.');
            }
        });

        // Capture photo
        let countdownInterval = null;

        captureBtn.addEventListener('click', () => {
            if (!stream) {
                alert('Please start the camera first.');
                return;
            }
            
            // Disable capture button during countdown
            captureBtn.disabled = true;
            
            let countdown = 3;
            
            // Create or get countdown display element
            let countdownDisplay = document.getElementById('countdownDisplay');
            if (!countdownDisplay) {
                countdownDisplay = document.createElement('div');
                countdownDisplay.id = 'countdownDisplay';
                countdownDisplay.style.cssText = `
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    font-size: 80px;
                    font-weight: bold;
                    color: white;
                    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
                    background: rgba(0, 0, 0, 0);
                    padding: 30px 40px;
                    border-radius: 20px;
                    text-align: center;
                    z-index: 1000;
                    font-family: Arial, sans-serif;
                    animation: countdownPulse 1s infinite;
                    pointer-events: none;
                `;
                
                // Add pulse animation if not already added
                if (!document.querySelector('#countdownStyle')) {
                    const style = document.createElement('style');
                    style.id = 'countdownStyle';
                    style.textContent = `
                        @keyframes countdownPulse {
                            0% { transform: translate(-50%, -50%) scale(1); }
                            50% { transform: translate(-50%, -50%) scale(1.2); }
                            100% { transform: translate(-50%, -50%) scale(1); }
                        }
                    `;
                    document.head.appendChild(style);
                }
                
                // Make sure video container has relative positioning
                const videoContainer = video.parentElement;
                if (getComputedStyle(videoContainer).position === 'static') {
                    videoContainer.style.position = 'relative';
                }
                videoContainer.appendChild(countdownDisplay);
            }
    
            // Show countdown display
            countdownDisplay.style.display = 'flex';
            countdownDisplay.textContent = countdown;
            
            // Clear any existing interval
            if (countdownInterval) {
                clearInterval(countdownInterval);
            }
            
            // Also disable retake and stop buttons during countdown
            const retakeBtn = document.getElementById('retakeBtn');
            const stopCameraBtn = document.getElementById('stopCamera');
            retakeBtn.disabled = true;
            stopCameraBtn.disabled = true;
            
            countdownInterval = setInterval(() => {
                countdown--;
                
                if (countdown > 0) {
                    countdownDisplay.textContent = countdown;
                    
                    // Optional: Add a subtle beep sound if you have audio files
                    // const beepSound = new Audio('beep.mp3');
                    // beepSound.play().catch(e => console.log('Audio play failed:', e));
                } else {
                    // Clear the interval
                    clearInterval(countdownInterval);
                    countdownInterval = null;
                    
                    // Hide countdown display
                    countdownDisplay.style.display = 'none';
                    
                    // Re-enable retake and stop buttons
                    retakeBtn.disabled = false;
                    stopCameraBtn.disabled = false;
                    
                    // Capture the photo
                    performCapture();
                }
            }, 1000);
        });

            // Retake photo
            retakeBtn.addEventListener('click', () => {
            // Clear countdown if active
            if (countdownInterval) {
                clearInterval(countdownInterval);
                countdownInterval = null;
                const countdownDisplay = document.getElementById('countdownDisplay');
                if (countdownDisplay) {
                    countdownDisplay.style.display = 'none';
                }
                captureBtn.disabled = false;
            }
            
            if (stream) {
                video.style.display = 'block';
                canvas.style.display = 'none';
                photoPreview.style.display = 'none';
                studentPhotoData.value = '';
                photoCaptured = false;
                captureBtn.disabled = false;
            } else {
                // If no stream, try to start camera
                startBtn.click();
            }
        });

        // Stop camera
        stopBtn.addEventListener('click', () => {
        // Clear countdown if active
        if (countdownInterval) {
            clearInterval(countdownInterval);
            countdownInterval = null;
            const countdownDisplay = document.getElementById('countdownDisplay');
            if (countdownDisplay) {
                countdownDisplay.style.display = 'none';
            }
        }
        
            stopStream();
            video.style.display = 'none';
            canvas.style.display = 'none';
            captureBtn.disabled = true;
            stopBtn.disabled = true;
            startBtn.disabled = false;
            
            // Re-enable retake button if needed
            const retakeBtn = document.getElementById('retakeBtn');
            retakeBtn.disabled = false;
        });


        // Remove captured photo
        removePhotoBtn.addEventListener('click', () => {
            photoPreview.style.display = 'none';
            studentPhotoData.value = '';
            photoCaptured = false;
            if (stream) {
                video.style.display = 'block';
                canvas.style.display = 'none';
                captureBtn.disabled = false;
            }
        });

        function stopStream() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
                video.srcObject = null;
            }
        }

        // Create a separate function for the actual capture
        function performCapture() {
            // Set canvas dimensions to match video
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Convert to base64 with proper format
            const imageData = canvas.toDataURL('image/jpeg', 0.8);
            capturedPhoto.src = imageData;
            studentPhotoData.value = imageData;
            
            video.style.display = 'none';
            canvas.style.display = 'none';
            photoPreview.style.display = 'block';
            photoCaptured = true;
            
            // Hide photo required message
            photoRequiredMsg.style.display = 'none';
        }

        // Form validation before submit
        const studentForm = document.getElementById('studentForm');
        if (studentForm) {
            studentForm.addEventListener('submit', function(e) {
                // Check if photo is captured
                if (!studentPhotoData.value) {
                    e.preventDefault();
                    photoRequiredMsg.style.display = 'block';
                    photoRequiredMsg.style.color = '#e74c3c';
                    photoRequiredMsg.style.marginTop = '10px';
                    alert('Please capture a student photo before submitting.');
                    
                    // Scroll to webcam section
                    document.querySelector('.webcam-section').scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center' 
                    });
                    return false;
                }
                
                // Validate contact number (Philippine format)
                const contact = document.getElementById('contact').value;
                const phoneRegex = /^09[0-9]{9}$/;
                if (contact && !phoneRegex.test(contact)) {
                    e.preventDefault();
                    alert('Please enter a valid Philippine mobile number (11 digits starting with 09)');
                    return false;
                }
                
                // Check terms checkbox
                const termsCheckbox = document.getElementById('terms');
                if (!termsCheckbox.checked) {
                    e.preventDefault();
                    alert('Please agree to the terms and conditions.');
                    return false;
                }
                
                // Show loading message
                const submitBtn = document.querySelector('.submit-btn');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
                submitBtn.disabled = true;
                
                return true;
            });
        }
    </script>
</body>
</html>