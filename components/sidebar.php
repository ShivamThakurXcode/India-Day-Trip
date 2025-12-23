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
<div class="sidemenu-wrapper sidemenu-info">
    <div class="sidemenu-content"><button class="closeButton sideMenuCls"><i class="far fa-times"></i></button>
        <div class="widget">
            <div class="th-widget-about">
                <div class="about-logo"><a href="<?php echo $base_path; ?>index.php"><img src="<?php echo $base_path; ?>assets/img/logo/logo-header.png"
                            alt="India Day Trip" style="height: 50px; width: auto;"></a>
                </div>
                <p class="about-text">India Day Trip is an Agra-based tour and travel company specializing in Same
                    Day Tours, Taj Mahal Tours, and Golden Triangle Tours.</p>
                <div class="th-social"><a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a> <a
                        href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a> <a
                        href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a> <a
                        href="https://www.whatsapp.com/"><i class="fab fa-whatsapp"></i></a></div>
            </div>
        </div>
        <div class="widget">
            <h3 class="widget_title">Recent Posts</h3>
            <div class="recent-post-wrap">
                <div class="recent-post">
                    <div class="media-img"><a href="<?php echo $base_path; ?>blog/blog-details.php?slug=best-time-to-visit-taj-mahal"><img
                                src="<?php echo $base_path; ?>assets/img/blog/recent-post-1-1.jpg" alt="Blog Image"></a></div>
                    <div class="media-body">
                        <div class="recent-post-meta"><a href="<?php echo $base_path; ?>blog/"><i class="far fa-calendar"></i>Sep 09,
                                2024</a></div>
                        <h4 class="post-title"><a class="text-inherit" href="<?php echo $base_path; ?>blog/blog-details.php?slug=best-time-to-visit-taj-mahal">Best Time to Visit
                                Taj Mahal</a></h4>
                    </div>
                </div>
                <div class="recent-post">
                    <div class="media-img"><a href="<?php echo $base_path; ?>blog/blog-details.php?slug=perfect-5-day-golden-triangle-itinerary"><img
                                src="<?php echo $base_path; ?>assets/img/blog/recent-post-1-2.jpg" alt="Blog Image"></a></div>
                    <div class="media-body">
                        <div class="recent-post-meta"><a href="<?php echo $base_path; ?>blog/"><i class="far fa-calendar"></i>Sep 10,
                                2024</a></div>
                        <h4 class="post-title"><a class="text-inherit" href="<?php echo $base_path; ?>blog/blog-details.php?slug=perfect-5-day-golden-triangle-itinerary">Golden Triangle
                                Itinerary Guide</a></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="widget">
            <h3 class="widget_title">Get In Touch</h3>
            <div class="th-widget-contact">
                <div class="info-box_text">
                    <div class="icon"><img src="<?php echo $base_path; ?>assets/img/icon/phone.svg" alt="img"></div>
                    <div class="details">
                        <p><a href="tel:+918126052755" class="info-box_link">+91 81260 52755/2h</a></p>
                    </div>
                </div>
                <div class="info-box_text">
                    <div class="icon"><img src="<?php echo $base_path; ?>assets/img/icon/envelope.svg" alt="img"></div>
                    <div class="details">
                        <p><a href="mailto:info@indiadaytrip.com" class="info-box_link">info@indiadaytrip.com</a>
                        </p>
                    </div>
                </div>
                <div class="info-box_text">
                    <div class="icon"><img src="<?php echo $base_path; ?>assets/img/icon/location-dot.svg" alt="img"></div>
                    <div class="details">
                        <p>Shop No. 2, Gupta Market, Tajganj, Agra</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>