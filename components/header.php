<?php
// Calculate base path based on including file location
$script_path = dirname($_SERVER['SCRIPT_NAME']);
$depth = substr_count($script_path, '/');
if ($depth > 0) {
    $base_path = str_repeat('../', $depth);
} else {
    $base_path = '';
}
$current_page = $_SERVER['SCRIPT_NAME'];
?>
<header class="th-header header-layout1 header-layout2">
    <div class="header-top">
        <div class="container th-container">
            <div class="row justify-content-center justify-content-lg-between align-items-center">
                <div class="col-auto d-none d-md-block">
                    <div class="header-links">
                        <ul>
                            <li class="d-none d-xl-inline-block"><i class="fa-sharp fa-regular fa-location-dot"></i>
                                <span>Shop No. 2, Gupta Market, Tajganj, Agra</span>
                            </li>
                            <li class="d-none d-xl-inline-block"><i class="fa-regular fa-clock"></i> <span>Daily:
                                    8.00 am - 8.00 pm</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-auto">

                </div>
            </div>
        </div>
    </div>
    <div class="sticky-wrapper">
        <div class="menu-area" data-bg-src="<?php echo $base_path; ?>../assets/img/bg/line-pattern.webp">
            <div class="container th-container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto">
                        <div class="header-logo"><a href="<?php echo $base_path; ?>index.php"><img src="<?php echo $base_path; ?>../assets/img/logo/logo-header.webp"
                                    alt="India Day Trip" style="height: 60px; width: auto;"></a></div>
                    </div>
                    <div class="col-auto">
                        <nav class="main-menu d-none d-xl-inline-block">
                            <ul>
                                <li><a class="<?php echo ($current_page == '/index.php') ? 'active' : ''; ?>" href="<?php echo $base_path; ?>../index.php">Home</a></li>
                                <li><a class="<?php echo ($current_page == '../about/index.php') ? 'active' : ''; ?>" href="<?php echo $base_path; ?>../about/index.php">About</a></li>
                                <li class="menu-item-has-children"><a class="<?php echo (in_array($current_page, ['/tour/index.php', '/same-day-tours/index.php', '/taj-mahal-tours/index.php', '/golden-triangle-tours/index.php', '/rajasthan-tour-packages/index.php'])) ? 'active' : ''; ?>" href="#">Tours</a>
                                    <ul class="sub-menu">
                                        <li><a class="<?php echo ($current_page == '/tour/index.php') ? 'active' : ''; ?>" href="<?php echo $base_path; ?>../tour/index.php">All Tours</a></li>
                                        <li><a class="<?php echo ($current_page == '/same-day-tours/index.php') ? 'active' : ''; ?>" href="<?php echo $base_path; ?>../same-day-tours/index.php">Same Day Tours</a></li>
                                        <li><a class="<?php echo ($current_page == '/taj-mahal-tours/index.php') ? 'active' : ''; ?>" href="<?php echo $base_path; ?>../taj-mahal-tours/index.php">Taj Mahal Tours</a></li>
                                        <li><a class="<?php echo ($current_page == '/golden-triangle-tours/index.php') ? 'active' : ''; ?>" href="<?php echo $base_path; ?>../golden-triangle-tours/index.php">Golden Triangle Tours</a></li>
                                        <li><a class="<?php echo ($current_page == '/rajasthan-tour-packages/index.php') ? 'active' : ''; ?>" href="<?php echo $base_path; ?>../rajasthan-tour-packages/index.php">Rajasthan Tours</a></li>
                                    </ul>
                                </li>
                                <li><a class="<?php echo ($current_page == '/search-tours.php') ? 'active' : ''; ?>" href="<?php echo $base_path; ?>../search-tours.php">Search Tours</a></li>
                                <li><a class="<?php echo (strpos($current_page, '/blog/') === 0) ? 'active' : ''; ?>" href="<?php echo $base_path; ?>../blog/index.php">Blog</a></li>
                                <li><a class="<?php echo ($current_page == '/contact/index.php') ? 'active' : ''; ?>" href="<?php echo $base_path; ?>../contact/index.php">Contact Us</a></li>
                            </ul>
                        </nav><button type="button" class="th-menu-toggle d-block d-xl-none"><i
                                class="far fa-bars"></i></button>
                    </div>
                    <div class="col-auto d-none d-xl-block">
                        <div class="header-button"><a href="<?php echo $base_path; ?>to_book/index.php" class="th-btn style3 th-icon">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </header>
    
    <?php include 'fixed-buttons.php'; ?>