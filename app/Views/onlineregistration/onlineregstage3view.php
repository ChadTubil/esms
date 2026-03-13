<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Registration | Holy Cross College Pampanga</title>
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
    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

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

        /* Success Card Styling */
        .success-card {
            background: #263A56;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(38, 58, 86, 0.1);
            border: none;
            overflow: hidden;
            margin-top: 30px;
            margin-bottom: 30px;
            position: relative;
        }

        .success-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--hcc-primary), var(--hcc-secondary), var(--hcc-accent));
        }

        .card-header {
            background: linear-gradient(135deg, var(--hcc-primary), #263A56);
            color: white;
            text-align: center;
            padding: 30px 20px;
            border-radius: 0 !important;
        }

        .success-icon {
            font-size: 5rem;
            color: #28a745;
            margin-bottom: 20px;
            animation: bounceIn 1s;
        }

        .success-icon-container {
            display: inline-block;
            background: white;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
            margin: 0 auto 20px;
            border: 5px solid #e9f7ef;
        }

        .reference-number-container {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border: 3px dashed var(--hcc-accent);
            padding: 30px;
            border-radius: 15px;
            margin: 30px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .reference-number-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(0, 123, 255, 0.1), transparent);
            transform: rotate(45deg);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        .reference-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: #28a745;
            letter-spacing: 3px;
            margin: 20px 0;
            padding: 20px;
            background: white;
            border-radius: 10px;
            border: 2px solid #dee2e6;
            font-family: 'Courier New', monospace;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
            position: relative;
            z-index: 1;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .note {
            color: #ff0000;
            font-style: italic;
            background: white;
            padding: 10px 20px;
            border-radius: 20px;
            display: inline-block;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .payment-instructions {
            background: linear-gradient(135deg, #e9ecef, #dee2e6);
            padding: 25px;
            border-radius: 15px;
            margin: 30px 0;
            border-left: 5px solid var(--hcc-primary);
        }

        .instruction-step {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        }

        .step-number {
            background: var(--hcc-primary);
            color: #263A56;;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
            font-weight: bold;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .btn-custom {
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--hcc-primary), var(--hcc-accent));
            border: none;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #495057);
            border: none;
            color: white;
        }

        .btn-outline-success {
            border: 2px solid var(--hcc-success);
            color: var(--hcc-success);
            background: transparent;
        }

        .btn-outline-success:hover {
            background: var(--hcc-success);
            color: white;
        }

        .info-box {
            background: white;
            border-left: 5px solid #ff0000;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .info-box i {
            color: #2196f3;
            font-size: 1.5rem;
            margin-right: 10px;
        }

        .deadline-badge {
            background: linear-gradient(135deg, #ff9800, #f57c00);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            margin: 10px 0;
        }

        .countdown {
            font-size: 1.2rem;
            color: var(--hcc-primary);
            font-weight: bold;
            text-align: center;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            margin: 20px 0;
        }
        .print-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 100;
        }

        @media print {
            .print-btn, .action-buttons, .footer {
                display: none;
            }
            
            .success-card {
                box-shadow: none;
                border: 1px solid #ddd;
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
                                <h1 class="logo-title"><strong>HOLY CROSS COLLEGE ONLINE REGISTRATION</strong></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-1 col-sm-12"></div>

            <div class="col-lg-12 col-sm-12" style="margin-top: 30px;">
                <div class="card">
                    <div class="card-body">
                        <div class="success-card animate__animated animate__fadeInUp">
                            <div class="card-header">
                                <div class="success-icon-container">
                                    <i class="fas fa-check-circle success-icon"></i>
                                </div>
                                <h2 class="card-title" style="color: white; margin-bottom: 5px;">
                                    <strong>REGISTRATION SUCCESSFUL!</strong>
                                </h2>
                                <p style="opacity: 0.9; font-size: 1.1rem;">
                                    Welcome to Holy Cross College! Your registration has been processed successfully.
                                </p>
                            </div>
                            <div class="card-body p-4 p-md-5">
                                <div class="reference-number-container">
                                    <h3 style="color: #263A56;">
                                        <i class="fas fa-id-card"></i> Your Registration Reference
                                    </h3>
                                    <p class="" style="color: #263A56;;">Use this reference number for all payment transactions and inquiries</p>
                                    <div class="reference-number">
                                        <?= esc(session()->get('referenceno')) ?>
                                    </div>
                                    <p class="note">
                                        <i class="fas fa-exclamation-circle"></i> 
                                        Save this number! You'll need it for payment and future reference.
                                    </p>
                                </div>
                                
                                <div class="info-box">
                                    <p style="color: black">
                                        <i class="fas fa-info-circle" style="color: red"></i>
                                        <strong style="color: red">Important:</strong> Please complete your payment within 
                                        <span class="deadline-badge">
                                            <i class="fas fa-clock" style="color: white"></i> 7 days
                                        </span>
                                        to secure your slot.
                                    </p>
                                </div>
                                
                                <div class="payment-instructions">
                                    <h4 style="color: #263A56;"><i class="fas fa-money-check-alt" style="color: #263A56;"></i> Payment Instructions</h4>
                                    <p class="mb-4" style="color: #263A56;">Follow these steps to complete your payment:</p>
                                    
                                    <div class="instruction-step">
                                        <div class="step-number">1</div>
                                        <div>
                                            <strong style="color: #263A56;">Visit Cashier Office</strong>
                                            <p class="mb-0" style="color: #263A56;"></p>
                                        </div>
                                    </div>
                                    
                                    <div class="instruction-step">
                                        <div class="step-number">2</div>
                                        <div>
                                            <strong style="color: #263A56;">Present Reference Number</strong>
                                            <p class="mb-0" style="color: #263A56;">Show this reference number to the cashier: <code style="color: #fd0000;"><?= esc(session()->get('referenceno')) ?></code></p>
                                        </div>
                                    </div>
                                    
                                    <div class="instruction-step">
                                        <div class="step-number">3</div>
                                        <div>
                                            <strong style="color: #263A56;">Pay Registration Fee</strong>
                                            <p class="mb-0" style="color: #263A56;">Pay the required registration fee amount</p>
                                        </div>
                                    </div>
                                    
                                    <div class="instruction-step">
                                        <div class="step-number">4</div>
                                        <div>
                                            <strong style="color: #263A56;">Keep Receipt</strong>
                                            <p class="mb-0" style="color: #263A56;">Save your payment receipt for verification purposes</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="info-box">
                                    <p style="color: #263A56;">
                                        <i class="fas fa-envelope" style="color: #263A56;"></i>
                                        <strong style="color: #263A56;">Email Confirmation:</strong> A confirmation email with these details has been sent to your registered email address.
                                    </p>
                                </div>
                                
                                <div class="action-buttons">
                                    <a href="<?= base_url() ?>online-registration" class="btn btn-custom btn-primary">
                                        <i class="fas fa-check"></i> DONE
                                    </a>
                                </div>
                                
                                <div class="text-center mt-5">
                                    <small class="" style="color: white">
                                        Need help? Contact the Registrar's Office at 
                                        <strong>registrar.office@holycrosscollegepampanga.edu.ph</strong> 
                                        or call <strong>(045) 123-4567</strong>
                                    </small>
                                </div>
                            </div>
                        </div>
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
        // Add animation to reference number on page load
        document.addEventListener('DOMContentLoaded', function() {
            const refNumber = document.querySelector('.reference-number');
            refNumber.style.animation = 'pulse 2s 3';
        });
    </script>
</body>
</html>