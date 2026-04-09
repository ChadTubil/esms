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
        }
        
        /* Program selection buttons */
        .program-buttons-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            padding-bottom: 20px;
        }
        
        .program-button {
            flex: 1;
            min-width: 250px;
            max-width: 300px;
            background: linear-gradient(135deg, #263A56 0%, #3A5680 100%);
            color: white;
            padding: 40px 20px;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .program-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            background: linear-gradient(135deg, #3A5680 0%, #4A6BA0 100%);
        }
        
        .program-button h3 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            font-weight: bold;
        }
        
        .program-button p {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        /* Disclaimer styling */
        .disclaimer-box {
            background-color: #fff8e1;
            border-left: 4px solid #ffc107;
            padding: 20px;
            border-radius: 4px;
        }
        
        .disclaimer-title {
            color: #d32f2f;
            font-weight: bold;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .disclaimer-title i {
            font-size: 1.5rem;
        }
        
        .disclaimer-content ul {
            padding-left: 20px;
        }
        
        .disclaimer-content li {
            margin-bottom: 10px;
            line-height: 1.6;
        }

        /* Modal styling */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        
        .modal-content {
            background-color: white;
            width: 90%;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: modalSlideIn 0.3s ease-out;
        }
        
        @keyframes modalSlideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .modal-header {
            background-color: #263A56;
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .modal-header h3 {
            margin: 0;
            font-size: 1.3rem;
        }
        
        .modal-body {
            padding: 25px 20px;
            color: #333;
        }
        
        .modal-body p {
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .modal-footer {
            padding: 15px 20px;
            background-color: #f8f9fa;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        .modal-btn {
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .modal-btn-primary {
            background-color: #263A56;
            color: white;
        }
        
        .modal-btn-primary:hover {
            background-color: #3A5680;
        }
        
        .modal-btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        
        .modal-btn-secondary:hover {
            background-color: #5a6268;
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
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="conatiner-fluid content-inner" style="background-color: #263A56">
        <div class="row">
            <div class="col-lg-1 col-sm-12"></div>
            <div class="col-lg-10 col-sm-12">
                <div class="container">
                    <div class="rounded nav navbar">
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
            
            <!-- Program Selection Card -->
            <div class="col-lg-12 col-sm-12" style="margin-top: 70px;">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h2 class="card-title" style="color: black; margin-bottom: 5px;">SELECT EDUCATIONAL LEVEL</h2>
                            <p class="text-muted">Choose your desired program to proceed with registration</p>
                        </div>
                        
                        <div class="program-buttons-container">
                            <!-- Grade School Button -->
                            <button class="program-button" onclick="selectProgram('grade-school')">
                                <div class="program-icon" style="font-size: 3rem; margin-bottom: 15px;">
                                    <i class="fas fa-graduation-cap" style="color: white"></i>
                                </div>
                                <h3 style="color: white">IBED</h3>
                                <p>Kindergarten to Grade 10</p>
                                <div class="select-indicator" style="margin-top: 15px; font-size: 0.8rem;">
                                    <i class="fas fa-arrow-right"></i> CLICK TO SELECT
                                </div>
                            </button>
                            
                            <!-- Senior High School Button -->
                            <button class="program-button" onclick="selectProgram('shs')">
                                <div class="program-icon" style="font-size: 3rem; margin-bottom: 15px;">
                                    <i class="fas fa-user-graduate" style="color: white"></i>
                                </div>
                                <h3 style="color: white">SENIOR HIGH SCHOOL</h3>
                                <p>Grade 11 and Grade 12</p>
                                <div class="select-indicator" style="margin-top: 15px; font-size: 0.8rem;">
                                    <i class="fas fa-arrow-right" style="color: white"></i> CLICK TO SELECT
                                </div>
                            </button>
                            
                            <!-- College Button -->
                            <button class="program-button" onclick="selectProgram('college')">
                                <div class="program-icon" style="font-size: 3rem; margin-bottom: 15px;">
                                    <i class="fas fa-university" style="color: white"></i>
                                </div>
                                <h3 style="color: white">COLLEGE</h3>
                                <p>Undergraduate Programs</p>
                                <div class="select-indicator" style="margin-top: 15px; font-size: 0.8rem;">
                                    <i class="fas fa-arrow-right"></i> CLICK TO SELECT
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Disclaimer Card -->
            <div class="col-lg-12 col-sm-12" style="margin-top: 20px;">
                <div class="card">
                    <div class="disclaimer-box">
                        <div class="disclaimer-title">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>IMPORTANT DISCLAIMER</span>
                        </div>
                        <div class="disclaimer-content" style="color: black;">
                            <p>Please read the following information carefully before proceeding with the online registration:</p>
                            <ul>
                                <li>This online registration system is for <strong>NEW STUDENTS ONLY</strong>. Current students should follow the re-enrollment process through their student portal.</li>
                                <li>All information provided must be accurate and complete. Falsification of information may result in cancellation of admission.</li>
                                <li>Required documents must be prepared beforehand for submission:
                                    <ul>
                                        <li>Birth Certificate (PSA/NSO Certified)</li>
                                        <li>Report Card (Form 138) for Grade School and SHS applicants</li>
                                        <li>Transcript of Records for College applicants</li>
                                        <li>2x2 ID Picture (white background)</li>
                                        <li>Good Moral Certificate</li>
                                    </ul>
                                </li>
                                <li>Submission of this registration form does not guarantee admission. All applications will undergo evaluation and screening.</li>
                                <li>After online registration, you will receive an email with further instructions regarding examination schedule (if applicable), interview, and submission of physical documents.</li>
                                <li>For inquiries, please contact the Registrar's Office at (045) 123-4567 or email registrar@hcc.edu.ph.</li>
                                <li>In compliance with the Philippine Data Privacy Act of 2012 (RA 10173), HCC College informs you that the personal data you provide in this registration form will be collected, processed, and stored for legitimate educational and administrative purposes.</li>
                            </ul>
                            <div class="text-left mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="agreeDisclaimer">
                                    <label class="form-check-label" for="agreeDisclaimer">
                                        I have read, understood, and agree to the Terms, Conditions, and Data Privacy Notice stated above. I voluntarily provide my personal information for the purposes described.
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Disclaimer Warning Modal -->
        <div class="modal-overlay" id="disclaimerModal">
            <div class="modal-content">
                <div class="modal-header" style="justify-content: left;">
                    <i class="fas fa-exclamation-circle"></i>
                    <h3 style="color: white;">Disclaimer Required</h3>
                </div>
                <div class="modal-body">
                    <p>Please agree to the disclaimer by checking the box before selecting a program.</p>
                    <p>You must read and accept the terms and conditions to proceed with the registration process.</p>
                </div>
                <div class="modal-footer">
                    <button class="modal-btn modal-btn-secondary" onclick="closeModal()">Close</button>
                    <button class="modal-btn modal-btn-primary" onclick="goToDisclaimer()">Go to Disclaimer</button>
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
    
    <script>
        // Variable to store which program was selected
        let selectedProgram = null;
        
        function selectProgram(program) {
            // Check if user agreed to disclaimer
            const agreeCheckbox = document.getElementById('agreeDisclaimer');
            
            if (!agreeCheckbox.checked) {
                // Store the selected program
                selectedProgram = program;
                
                // Show modal instead of alert
                showModal();
                return;
            }
            
            // If checkbox is checked, proceed with registration
            proceedWithRegistration(program);
        }
        
        function showModal() {
            const modal = document.getElementById('disclaimerModal');
            modal.style.display = 'flex';
            
            // Prevent body scrolling when modal is open
            document.body.style.overflow = 'hidden';
        }
        
        function closeModal() {
            const modal = document.getElementById('disclaimerModal');
            modal.style.display = 'none';
            
            // Restore body scrolling
            document.body.style.overflow = 'auto';
            
            // Reset selected program
            selectedProgram = null;
        }
        
        function goToDisclaimer() {
            // Close the modal
            closeModal();
            
            // Scroll to the disclaimer section
            const disclaimerSection = document.querySelector('.disclaimer-box');
            if (disclaimerSection) {
                disclaimerSection.scrollIntoView({ behavior: 'smooth' });
                
                // Highlight the checkbox
                const checkbox = document.getElementById('agreeDisclaimer');
                checkbox.focus();
                
                // Add a temporary highlight effect
                checkbox.parentElement.style.backgroundColor = '#e8f4fd';
                checkbox.parentElement.style.padding = '10px';
                checkbox.parentElement.style.borderRadius = '5px';
                checkbox.parentElement.style.transition = 'all 0.3s';
                
                // Remove highlight after 3 seconds
                setTimeout(() => {
                    checkbox.parentElement.style.backgroundColor = '';
                    checkbox.parentElement.style.padding = '';
                    checkbox.parentElement.style.borderRadius = '';
                }, 3000);
            }
        }
        
        function proceedWithRegistration(program) {
            // Program selection logic
            switch(program) {
                case 'grade-school':
                    // alert('Grade School program selected. Redirecting to Grade School registration form...');
                    window.location.href = '<?= base_url(); ?>kiosk-registration-gs';
                    break;
                case 'shs':
                    // alert('Senior High School program selected. Redirecting to SHS registration form...');
                    window.location.href = '<?= base_url(); ?>kiosk-registration-shs';
                    break;
                case 'college':
                    // alert('College program selected. Redirecting to College registration form...');
                    window.location.href = '<?= base_url(); ?>kiosk-registration-college';
                    break;
            }
            
            // You can replace the alert with actual redirection code
            // Example: window.location.href = 'your-registration-page-url';
        }
        
        // Check if user checks the disclaimer checkbox after modal was shown
        document.getElementById('agreeDisclaimer').addEventListener('change', function() {
            if (this.checked && selectedProgram) {
                // If checkbox is checked and a program was previously selected
                proceedWithRegistration(selectedProgram);
                selectedProgram = null;
            }
        });
        
        // Close modal when clicking outside of it
        document.getElementById('disclaimerModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('disclaimerModal');
            if (e.key === 'Escape' && modal.style.display === 'flex') {
                closeModal();
            }
        });
        
        // Add click effect to program buttons
        document.addEventListener('DOMContentLoaded', function() {
            const programButtons = document.querySelectorAll('.program-button');
            
            programButtons.forEach(button => {
                button.addEventListener('mousedown', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                
                button.addEventListener('mouseup', function() {
                    this.style.transform = 'translateY(-5px)';
                });
                
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>