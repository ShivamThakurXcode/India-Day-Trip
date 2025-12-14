<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <header class="th-header header-layout1 header-layout2">
        <div class="header-top">
            <div class="container th-container">
                <div class="row justify-content-center justify-content-lg-between align-items-center">
                    <div class="col-auto d-none d-md-block">
                        <div class="header-links">
                            <ul>
                                <li class="d-none d-xl-inline-block">
                                    <i class="fa-sharp fa-regular fa-location-dot"></i>
                                    <span>Shop No. 2, Gupta Market, Tajganj, Agra</span>
                                </li>
                                <li class="d-none d-xl-inline-block">
                                    <i class="fa-regular fa-clock"></i>
                                    <span>Daily: 8.00 am - 8.00 pm</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-auto">
                        <!-- Social links or other elements -->
                    </div>
                </div>
            </div>
        </div>
        <div class="sticky-wrapper">
            <div class="menu-area" data-bg-src="<?php echo get_template_directory_uri(); ?>/assets/img/bg/line-pattern.png">
                <div class="container th-container">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            <div class="header-logo">
                                <a href="<?php echo home_url(); ?>">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo/logo-header.png" alt="<?php bloginfo('name'); ?>" style="height: 60px; width: auto;">
                                </a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <nav class="main-menu d-none d-xl-inline-block">
                                <?php
                                wp_nav_menu(array(
                                    'theme_location' => 'primary',
                                    'menu_class' => '',
                                    'container' => false,
                                    'fallback_cb' => false,
                                ));
                                ?>
                            </nav>
                            <button type="button" class="th-menu-toggle d-block d-xl-none">
                                <i class="far fa-bars"></i>
                            </button>
                        </div>
                        <div class="col-auto d-none d-xl-block">
                            <div class="header-button">
                                <a href="<?php echo get_permalink(get_page_by_path('to-book')); ?>" class="th-btn style3 th-icon">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>