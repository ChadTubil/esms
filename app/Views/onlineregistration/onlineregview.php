<!doctype html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>ONLINE REGISTRATION | Holy Cross College Pampanga</title>
        <!-- Favicon -->
        <link rel="shortcut icon" href="<?= base_url(); ?>/public/assets/images/favicon.ico" />
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
            /* Bouncing Animation */
            @keyframes bounce {
                0%, 20%, 50%, 80%, 100% {
                    transform: translateY(0);
                }
                40% {
                    transform: translateY(-10px);
                }
                60% {
                    transform: translateY(-5px);
                }
            }
            
            .bounce-btn {
                animation: bounce 2s infinite;
                transition: all 0.3s ease;
            }
            
            .bounce-btn:hover {
                animation: none;
                transform: translateY(-3px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            }
            
            /* Optional: Add a pulsing effect to draw attention */
            @keyframes pulse {
                0% {
                    box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.7);
                }
                70% {
                    box-shadow: 0 0 0 10px rgba(13, 110, 253, 0);
                }
                100% {
                    box-shadow: 0 0 0 0 rgba(13, 110, 253, 0);
                }
            }
            
            .pulse-btn {
                animation: pulse 2s infinite;
            }
            
            /* Combine both animations */
            .animated-btn {
                animation: bounce 2s infinite, pulse 2s infinite;
                animation-delay: 0s, 1s;
            }
            
            .animated-btn:hover {
                animation: none;
                transform: translateY(-3px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2) !important;
            }
        </style>
        
    </head>
    <body class=" " data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0" tabindex="0">
        <div class="wrapper">
            <section class="login-content">
                <div class="row m-0 align-items-center vh-100" style="background-color: #263A56">            
                    <div class="col-md-6">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div style="background-color: #263A56; text-align: center;">
                                    <img src="<?= base_url(); ?>public/assets/images/logo4.png" alt="" style="width: 50%">
                                    <h1 style="color: white;"><strong>HOLY CROSS COLLEGE<br>ONLINE REGISTRATION</strong></h1>
                                    <br>
                                    <!-- Add the 'animated-btn' class to the button -->
                                    <button class="btn animated-btn" style="width: 100%; height: 50px; font-size: 1.2rem; background-color: #FECC09; border-color: #000000;"
                                        onclick="window.location.href='<?= base_url(); ?>online-registration-2'">
                                        <strong style="color: #000000">START REGISTRATION</strong>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
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
        
        <script>
            // Optional: Add JavaScript to control the animation
            document.addEventListener('DOMContentLoaded', function() {
                const button = document.querySelector('.animated-btn');
                
                // Pause animation when button is hovered (already handled by CSS)
                // You can add more interactive features here if needed
                
                // Example: Stop animation after 10 seconds
                setTimeout(() => {
                    button.style.animationIterationCount = 'infinite'; // Keep it infinite
                }, 10000);
            });
        </script>
    </body>
</html>