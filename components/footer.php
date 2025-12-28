<?php
// Calculate base path based on including file location
$script_path = dirname($_SERVER['SCRIPT_NAME']);
$depth = substr_count($script_path, '/');
if ($depth > 0) {
    $base_path = str_repeat('../', $depth);
} else {
    $base_path = '';
}
?>
<footer class="footer-wrapper bg-title footer-layout2 ">
    <div class="widget-area ">
        <div class="container">
            <div class="row g-4 g-lg-5 justify-content-between">
                <!-- Column 1: Logo, About & Social Links -->
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="widget footer-widget ">
                        <div class="th-widget-about">
                            <div class="about-logo mb-3">
                                <a href="<?php echo $base_path; ?>index.php">
                                    <img src="<?php echo $base_path; ?>assets/img/logo/logo-footer.webp" alt="India Day Trip" class="img-fluid" style="height: 70px; width: auto;">
                                </a>
                            </div>
                            <p class="about-text mb-4">
                                Agra’s trusted company for unforgettable Taj Mahal and Golden Triangle tours. Experience safe, memorable, and expertly guided journeys with us—serving travelers with excellence for years.
                            </p>
                            <div class="th-social">
                                <a href="https://www.facebook.com/" aria-label="Facebook" class="me-2"><i
                                        class="fab fa-facebook-f"></i></a>
                                <a href="https://www.twitter.com/" aria-label="Twitter" class="me-2"><i
                                        class="fab fa-twitter"></i></a>
                                <a href="https://www.linkedin.com/" aria-label="LinkedIn" class="me-2"><i
                                        class="fab fa-linkedin-in"></i></a>
                                <a href="https://www.whatsapp.com/" aria-label="WhatsApp" class="me-2"><i
                                        class="fab fa-whatsapp"></i></a>
                                <a href="https://instagram.com/" aria-label="Instagram"><i
                                        class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Column 2: Quick Links -->
                <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6">
                    <div class="widget widget_nav_menu footer-widget ">
                        <h3 class="widget_title">Quick Links</h3>
                        <div class="menu-all-pages-container">
                            <ul class="menu">
                                <li><a href="<?php echo $base_path; ?>index.php">Home</a></li>
                                <li><a href="<?php echo $base_path; ?>about/index.php">About</a></li>
                                <li><a href="<?php echo $base_path; ?>gallery/index.php">Gallery</a></li>
                                <li><a href="<?php echo $base_path; ?>contact/index.php">Contact</a></li>
                                <li><a href="<?php echo $base_path; ?>to_book/index.php">Book Trip</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Column 3: Tours -->
                <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6">
                    <div class="widget widget_nav_menu footer-widget ">
                        <h3 class="widget_title">Tours</h3>
                        <div class="menu-all-pages-container">
                            <ul class="menu">
                                <li><a href="<?php echo $base_path; ?>tour/index.php">All Tours</a></li>
                                <li><a href="<?php echo $base_path; ?>same-day-tours/index.php">Same Day Tours</a></li>
                                <li><a href="<?php echo $base_path; ?>taj-mahal-tours/index.php">Taj Mahal Tours</a></li>
                                <li><a href="<?php echo $base_path; ?>golden-triangle-tours/index.php">Golden Triangle Tours</a></li>
                                <li><a href="<?php echo $base_path; ?>rajasthan-tour-packages/index.php">Rajasthan Tours</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Column 4: Contact Information -->
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                    <div class="widget footer-widget h-100">
                        <h3 class="widget_title">Get In Touch</h3>
                        <div class="">
                            <div class="info-box_text mb-3 d-flex align-items-center">
                                <div class="icon me-3 flex-shrink-0"><img src="<?php echo $base_path; ?>assets/img/icon/location-dot.svg" alt="Location"></div>
                                <div class="details">
                                    <p class="mb-0">Shop No. 2, Gupta Market, Tajganj, Agra, Uttar Pradesh, India</p>
                                </div>
                            </div>
                            <div class="info-box_text mb-3 d-flex align-items-center">
                                <div class="icon me-3 flex-shrink-0"><img src="<?php echo $base_path; ?>assets/img/icon/phone.svg" alt="Phone"></div>
                                <div class="details">
                                    <p class="mb-0"><a href="tel:+918126052755" class="info-box_link">+91 81260 52755</a></p>
                                </div>
                            </div>
                            <div class="info-box_text mb-3 d-flex align-items-center">
                                <div class="icon me-3 flex-shrink-0"><img src="<?php echo $base_path; ?>assets/img/icon/envelope.svg" alt="Email"></div>
                                <div class="details">
                                    <p class="mb-0"><a href="mailto:info@indiadaytrip.com"
                                            class="info-box_link">info@indiadaytrip.com</a></p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-wrap">
        <div class="container">
            <div class="row align-items-center g-3">
                <div class="col-lg-4 col-md-12 text-center text-md-start">
                    <p class="copyright-text mb-0">Copyright 2025 <a href="<?php echo $base_path; ?>index.php" style="color: orange;">India Day Trip</a>. All Rights
                        Reserved.</p>
                </div>
                <div class="col-lg-4 col-md-12 text-center">
                    <p class="copyright-text mb-0">Developed by <a href="https://denexiasolution.com" target="_blank" style="color: orange;">Denexia It Solution</a></p>
                </div>
                <div class="col-lg-4 col-md-12 text-center text-md-end">
                    <div class="footer-links">
                        <a href="<?php echo $base_path; ?>privacy-policy/index.php" style="color: orange;">Privacy Policy</a> |
                        <a href="<?php echo $base_path; ?>terms-conditions/index.php" style="color: orange;">Terms & Conditions</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>