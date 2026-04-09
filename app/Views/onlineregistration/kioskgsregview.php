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
                        <?= form_open('online-registration-gs'); ?>
                            <div class="form-section">
                                <h4 style="color: #263A56; border-bottom: 2px solid #263A56; padding-bottom: 10px; margin-bottom: 25px;">Personal Information</h4>
                                
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
    </script>
</body>
</html>