<?php
require_once 'config.php';

// Get tours for homepage
$popularTours = getTours(null, 6);
$sameDayTours = getTours('Same Day Tours', 5);
$tajMahalTours = getTours('Taj Mahal Tours', 5);
$goldenTriangleTours = getTours('Golden Triangle Tours', 5);

// Handle routing for detail pages
$type = $_GET['type'] ?? null;
$slug = $_GET['slug'] ?? null;

if ($type && $slug) {
    if ($type === 'tour') {
        // Fetch tour by slug
        $stmt = $pdo->prepare("SELECT * FROM tours WHERE slug = ?");
        $stmt->execute([$slug]);
        $tour = $stmt->fetch();

        if ($tour) {
            // Update view count
            $pdo->prepare("UPDATE tours SET view_count = view_count + 1 WHERE id = ?")->execute([$tour['id']]);

            // Display tour detail page
            include 'tour-detail.php';
            exit;
        }
    } elseif ($type === 'blog') {
        // Fetch blog by slug
        $stmt = $pdo->prepare("SELECT * FROM blogs WHERE slug = ?");
        $stmt->execute([$slug]);
        $blog = $stmt->fetch();

        if ($blog) {
            // Update view count
            $pdo->prepare("UPDATE blogs SET view_count = view_count + 1 WHERE id = ?")->execute([$blog['id']]);

            // Display blog detail page
            include 'blog-detail.php';
            exit;
        }
    }

    // If not found, show 404
    include '404.php';
    exit;
}
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>India Day Trip - Agra Based Tour & Travel Company</title>
    <meta name="author" content="India Day Trip">
    <meta name="description"
        content="India Day Trip - Agra based tour and travel company offering Same Day Tours, Taj Mahal Tours, and Golden Triangle Tours">
    <meta name="keywords" content="India Day Trip, Agra tours, Taj Mahal tours, Golden Triangle tours, Same Day tours">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://indiadaytrip.com">
    <meta property="og:title" content="India Day Trip - Agra Based Tour & Travel Company">
    <meta property="og:description" content="India Day Trip - Agra based tour and travel company offering Same Day Tours, Taj Mahal Tours, and Golden Triangle Tours">
    <meta property="og:image" content="https://indiadaytrip.com/assets/img/hero/hero-agra.webp">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://indiadaytrip.com">
    <meta property="twitter:title" content="India Day Trip - Agra Based Tour & Travel Company">
    <meta property="twitter:description" content="India Day Trip - Agra based tour and travel company offering Same Day Tours, Taj Mahal Tours, and Golden Triangle Tours">
    <meta property="twitter:image" content="https://indiadaytrip.com/assets/img/hero/hero-agra.webp">

    <!-- links  -->
    <?php include 'components/links.php'; ?>

</head>

<body>

    <!-- prelaoder -->
    <?php include 'components/preloader.php'; ?>
    <!-- sidemenu -->
    <?php include 'components/sidebar.php'; ?>

    <!-- popup search box -->
    <div class="popup-search-box"><button class="searchClose"><i class="fal fa-times"></i></button>
        <form action="#"><input type="text" placeholder="What are you looking for?"> <button type="submit"><i
                    class="fal fa-search"></i></button></form>
    </div>
    <div class="th-menu-wrapper onepage-nav">
        <div class="th-menu-area text-center"><button class="th-menu-toggle"><i class="fal fa-times"></i></button>
            <div class="mobile-logo"><a href="index.php"><img src="assets/img/logo/logo-header.webp"
                        alt="India Day Trip"></a>
            </div>
            <div class="th-mobile-menu">
                <ul>
                    <li><a class="active" href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li class="menu-item-has-children"><a href="#">Tours</a>
                        <ul class="sub-menu">
                            <li><a href="same-day-tours.php">Same Day Tours</a></li>
                            <li><a href="taj-mahal-tours.php">Taj Mahal Tours</a></li>
                            <li><a href="golden-triangle-tours.php">Golden Triangle Tours</a></li>
                            <li><a href="agra-tours.php">Agra Tours</a></li>
                        </ul>
                    </li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </div>


    <!-- header  -->

    <?php include 'components/header.php'; ?>


    <div class="hero-2" id="hero">
        <div class="hero2-overlay" data-bg-src="assets/img/bg/line-pattern.webp"></div>
        <div class="swiper hero-slider-2" id="heroSlide2">
            <div class="swiper-wrapper">
                <div class="swiper-slide hero-agra">
                    <div class="hero-inner">
                        <div class="th-hero-bg" data-bg-src="assets/img/hero/hero-agra.webp"></div>
                        <div class="container">
                            <div class="hero-style2">
                                <h1 class="hero-title" data-ani="slideinup" data-ani-delay="0.4s">Discover <span
                                        class="hero-text">The Beauty of Agra</span></h1>
                                <p class="hero-desc" data-ani="slideinup" data-ani-delay="0.5s">Experience the wonder of the Taj Mahal with Agra's trusted travel experts.</p>
                                <div class="btn-group" data-ani="slideinup" data-ani-delay="0.6s"><a
                                        href="tour/index.php" class="th-btn white-btn th-icon">Explore Agra
                                        Tours</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide hero-delhi">
                    <div class="hero-inner">
                        <div class="th-hero-bg" data-bg-src="assets/img/hero/hero-delhi.webp"></div>
                        <div class="container">
                            <div class="hero-style2">
                                <h1 class="hero-title" data-ani="slideinup" data-ani-delay="0.4s">Explore <span
                                        class="hero-text">The Heart of Delhi</span></h1>
                                <p class="hero-desc" data-ani="slideinup" data-ani-delay="0.5s">Experience Delhi's rich history and vibrant culture with India Day Trip.</p>
                                <div class="btn-group" data-ani="slideinup" data-ani-delay="0.6s"><a
                                        href="tour/index.php" class="th-btn white-btn th-icon">Explore Delhi
                                        Tours</a></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide hero-jaipur">
                    <div class="hero-inner">
                        <div class="th-hero-bg" data-bg-src="assets/img/hero/hero-jaipur.webp"></div>
                        <div class="container">
                            <div class="hero-style2">
                                <h1 class="hero-title" data-ani="slideinup" data-ani-delay="0.4s">Experience <span
                                        class="hero-text">The Pink City of Jaipur</span></h1>
                                <p class="hero-desc" data-ani="slideinup" data-ani-delay="0.5s">Discover Jaipur's royal charm and vibrant bazaars.</p>
                                <div class="btn-group" data-ani="slideinup" data-ani-delay="0.6s"><a
                                        href="tour/index.php" class="th-btn white-btn th-icon">Explore
                                        Jaipur
                                        Tours</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="th-swiper-custom">
                <div class="swiper-pagination"></div>
                <div class="hero-icon"><button data-slider-prev="#heroSlide2, #heroSlide3"
                        class="hero-arrow slider-prev"><img src="assets/img/icon/hero-arrow-left.svg" alt=""></button>
                    <button data-slider-next="#heroSlide2, #heroSlide3" class="hero-arrow slider-next"><img
                            src="assets/img/icon/hero-arrow-right.svg" alt=""></button>
                </div>
            </div>
        </div>
        <div class="swiper heroThumbs style2" id="heroSlide3">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="hero-inner">
                        <div class="hero-card">
                            <div class="hero-img"><img src="assets/img/hero/hero-agra.webp" alt="Agra Tour"></div>
                            <div class="hero-card_content">
                                <h3 class="box-title">Agra Day Tour</h3>
                                <span><i
                                        class="fa-light fa-clock"></i>1 Day</span> <a href="same-day-tours.php"
                                    class="th-btn style2">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="hero-inner">
                        <div class="hero-card">
                            <div class="hero-img"><img src="assets/img/hero/hero-delhi.webp" alt="Delhi Tour"></div>
                            <div class="hero-card_content">
                                <h3 class="box-title">Delhi City Tour</h3>
                                <span><i
                                        class="fa-light fa-clock"></i>1 Day</span> <a href="golden-triangle-tours.php"
                                    class="th-btn style2">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="hero-inner">
                        <div class="hero-card">
                            <div class="hero-img"><img src="assets/img/hero/hero-jaipur.webp" alt="Jaipur Tour"></div>
                            <div class="hero-card_content">
                                <h3 class="box-title">Jaipur Heritage Tour</h3>
                                <span><i
                                        class="fa-light fa-clock"></i>1 Day</span> <a href="golden-triangle-tours.php"
                                    class="th-btn style2">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="scroll-down"><a href="#destination-sec" class="scroll-wrap"><span><img
                        src="assets/img/icon/down-arrow.svg" alt=""></span>Scroll Down</a></div>
    </div>

    <section class="category-area bg-top-center background-image" style="background-image: url(&quot;assets/img/bg/category_bg_1.webp&quot;);">
        <div class="container th-container">
            <div class="title-area text-center">
                <span class="sub-title">Wonderful Place For You</span>
                <h2 class="sec-title">Top Destinations</h2>
            </div>
            <div class="swiper th-slider has-shadow categorySlider background-image swiper-initialized swiper-horizontal swiper-backface-hidden"
                id="categorySlider1"
                data-slider-options='{"spaceBetween": "50","breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"},"1400":{"slidesPerView":"5"}}}'
                style="background-image: url(&quot;assets/img/bg/category_bg_1.webp&quot;);">
                <div class="swiper-wrapper" id="swiper-wrapper-custom" aria-live="off" style="transition-duration: 1000ms;">
                    <div class="swiper-slide" style="width: 236.8px; margin-right: 50px;" role="group" aria-label="1 / 8" data-swiper-slide-index="0">
                        <div class="category-card single" style="transform: translate(0px, 10px) rotate(-3deg); transform-origin: right top;">
                            <div class="box-img global-img">
                                <img src="assets/img/destination/d-delhi.webp" alt="Delhi">
                            </div>
                            <h3 class="box-title"><a href="tour/index.php">Delhi</a></h3>
                            <a class="line-btn" href="tour/index.php">See packages</a>
                        </div>
                    </div>
                    <div class="swiper-slide" style="width: 236.8px; margin-right: 50px;" role="group" aria-label="2 / 8" data-swiper-slide-index="1">
                        <div class="category-card single" style="transform: translate(0px, 0px) rotate(-1deg); transform-origin: right top;">
                            <div class="box-img global-img">
                                <img src="assets/img/destination/d-agra.webp" alt="Agra">
                            </div>
                            <h3 class="box-title"><a href="tour/index.php">Agra</a></h3>
                            <a class="line-btn" href="tour/index.php">See packages</a>
                        </div>
                    </div>
                    <div class="swiper-slide" style="width: 236.8px; margin-right: 50px;" role="group" aria-label="3 / 8" data-swiper-slide-index="2">
                        <div class="category-card single" style="transform: translate(0px, 0px) rotate(1deg); transform-origin: left top;">
                            <div class="box-img global-img">
                                <img src="assets/img/destination/d-jaipur.webp" alt="Jaipur">
                            </div>
                            <h3 class="box-title"><a href="tour/index.php">Jaipur</a></h3>
                            <a class="line-btn" href="tour/index.php">See packages</a>
                        </div>
                    </div>
                    <div class="swiper-slide" style="width: 236.8px; margin-right: 50px;" role="group" aria-label="4 / 8" data-swiper-slide-index="3">
                        <div class="category-card single" style="transform: translate(0px, 22px) rotate(4deg); transform-origin: left top;">
                            <div class="box-img global-img">
                                <img src="assets/img/destination/d-amritsar.webp" alt="Amritsar">
                            </div>
                            <h3 class="box-title"><a href="tour/index.php">Amritsar</a></h3>
                            <a class="line-btn" href="tour/index.php">See packages</a>
                        </div>
                    </div>
                    <div class="swiper-slide" style="width: 236.8px; margin-right: 50px;" role="group" aria-label="5 / 8" data-swiper-slide-index="4">
                        <div class="category-card single" style="transform: translate(0px, 49px) rotate(7deg); transform-origin: left top;">
                            <div class="box-img global-img">
                                <img src="assets/img/destination/d-ranthambore.webp" alt="Ranthambore">
                            </div>
                            <h3 class="box-title"><a href="tour/index.php">Ranthambore</a></h3>
                            <a class="line-btn" href="tour/index.php">See packages</a>
                        </div>
                    </div>
                    <div class="swiper-slide" style="width: 236.8px; margin-right: 50px;" role="group" aria-label="6 / 8" data-swiper-slide-index="5">
                        <div class="category-card single" style="transform: translate(0px, 89px) rotate(11deg); transform-origin: right top;">
                            <div class="box-img global-img">
                                <img src="assets/img/destination/d-varansi.webp" alt="Varanasi">
                            </div>
                            <h3 class="box-title"><a href="tour/index.php">Varanasi</a></h3>
                            <a class="line-btn" href="tour/index.php">See packages</a>
                        </div>
                    </div>
                    <div class="swiper-slide" style="width: 236.8px; margin-right: 50px;" role="group" aria-label="7 / 8" data-swiper-slide-index="6">
                        <div class="category-card single" style="transform: translate(0px, 62px) rotate(9deg); transform-origin: right top;">
                            <div class="box-img global-img">
                                <img src="assets/img/destination/d-amritsar.webp" alt="Amritsar">
                            </div>
                            <h3 class="box-title"><a href="tour/index.php">Amritsar</a></h3>
                            <a class="line-btn" href="tour/index.php">See packages</a>
                        </div>
                    </div>
                    <div class="swiper-slide" style="width: 236.8px; margin-right: 50px;" role="group" aria-label="8 / 8" data-swiper-slide-index="7">
                        <div class="category-card single" style="transform: translate(0px, 36px) rotate(6deg); transform-origin: right top;">
                            <div class="box-img global-img">
                                <img src="assets/img/destination/d-jaipur.webp" alt="Jaipur">
                            </div>
                            <h3 class="box-title"><a href="tour/index.php">Jaipur</a></h3>
                            <a class="line-btn" href="tour/index.php">See packages</a>
                        </div>
                    </div>
                </div>
                <div class="slider-pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal">
                    <span class="swiper-pagination-bullet swiper-pagination-bullet-active" aria-label="Go to Slide 01" tabindex="0" aria-current="true"></span>
                    <span class="swiper-pagination-bullet" aria-label="Go to Slide 02" tabindex="0"></span>
                    <span class="swiper-pagination-bullet" aria-label="Go to Slide 03" tabindex="0"></span>
                    <span class="swiper-pagination-bullet" aria-label="Go to Slide 04" tabindex="0"></span>
                    <span class="swiper-pagination-bullet" aria-label="Go to Slide 05" tabindex="0"></span>
                    <span class="swiper-pagination-bullet" aria-label="Go to Slide 06" tabindex="0"></span>
                    <span class="swiper-pagination-bullet" aria-label="Go to Slide 07" tabindex="0"></span>
                    <span class="swiper-pagination-bullet" aria-label="Go to Slide 08" tabindex="0"></span>
                </div>
                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
            </div>
        </div>
    </section>

    <!-- Most Popular Tour -->
    <section class="tour-area position-relative bg-top-center overflow-hidden space background-image arrow-wrap"
        id="service-sec" style="background-image: url(&quot;assets/img/bg/tour_bg_1.jpg&quot;);">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="title-area text-center">
                        <span class="sub-title">Best Place For You</span>
                        <h2 class="sec-title">Most Popular Tour</h2>
                        <p class="sec-text">Discover our most popular tours across India, featuring iconic destinations
                            like the Taj Mahal, Delhi, and the Golden Triangle.</p>
                    </div>
                </div>
            </div>
            <div class="slider-area tour-slider">
                <div class="swiper th-slider has-shadow slider-drag-wrap swiper-initialized swiper-horizontal swiper-backface-hidden"
                    data-slider-options="{&quot;breakpoints&quot;:{&quot;0&quot;:{&quot;slidesPerView&quot;:1},&quot;576&quot;:{&quot;slidesPerView&quot;:&quot;1&quot;},&quot;768&quot;:{&quot;slidesPerView&quot;:&quot;2&quot;},&quot;992&quot;:{&quot;slidesPerView&quot;:&quot;2&quot;},&quot;1200&quot;:{&quot;slidesPerView&quot;:&quot;3&quot;},&quot;1300&quot;:{&quot;slidesPerView&quot;:&quot;4&quot;}}}">
                    <div class="swiper-wrapper">
                        <?php foreach ($popularTours as $tour): ?>
                            <div class="swiper-slide">
                                <?php echo renderTourCard($tour, 'swiper'); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose India Day Trip -->
    <div class="feature-area overflow-hidden" id="feature-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="title-area text-center"><span class="sub-title style1">Why Choose India Day Trip</span>
                        <h2 class="sec-title">Premium Travel Experience</h2>
                        <p class="feature-text">India Day Trip offers exceptional travel experiences with expert guides,
                            comfortable transportation, and personalized itineraries.</p>
                    </div>
                </div>
            </div>
            <div class="row gy-4 justify-content-center">
                <div class="col-md-6 col-xl-3">
                    <div class="feature-item th-ani">
                        <div class="feature-item_icon"><img src="assets/img/icon/feature_1_1.svg" alt="icon"></div>
                        <div class="media-body">
                            <h3 class="box-title">Expert Guides</h3>
                            <p class="feature-item_text">Knowledgeable local guides who bring India's rich history and
                                culture to life.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="feature-item th-ani">
                        <div class="feature-item_icon"><img src="assets/img/icon/feature_1_2.svg" alt="icon"></div>
                        <div class="media-body">
                            <h3 class="box-title">Comfortable Transport</h3>
                            <p class="feature-item_text">Air-conditioned vehicles with professional drivers for a smooth
                                journey.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="feature-item th-ani">
                        <div class="feature-item_icon"><img src="assets/img/icon/feature_1_3.svg" alt="icon"></div>
                        <div class="media-body">
                            <h3 class="box-title">Flexible Itineraries</h3>
                            <p class="feature-item_text">Customizable, flexible tour plans. Tailored options. Fit your
                                schedule.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="feature-item th-ani">
                        <div class="feature-item_icon"><img src="assets/img/icon/feature_1_4.svg" alt="icon"></div>
                        <div class="media-body">
                            <h3 class="box-title">24/7 Support</h3>
                            <p class="feature-item_text">Round-the-clock assistance to ensure a hassle-free travel
                                experience.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- About India Day Trip -->
    <div class="about-area position-relative overflow-hidden space" id="about-sec">
        <div class="container">
            <div class="row gy-4">
                <div class="col-xl-6">
                    <div class="img-box15 pe-xl-4">
                        <div class="img1 global-img"><img src="assets/img/home/about-1.webp" alt="About India Day Trip">
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="ps-xl-4">
                        <div class="title-area mb-20"><span class="sub-title style1">About India Day Trip</span>
                            <h2 class="sec-title mb-20">Your Trusted Travel Partner in Agra</h2>
                            <p class="sec-text2 mb-50">India Day Trip is an Agra-based tour and travel company
                                specializing in Same Day Tours, Taj Mahal Tours, and Golden Triangle Tours. With years
                                of experience, we provide exceptional travel experiences across India's most iconic
                                destinations.</p>
                        </div>
                        <div class="about-item-wrap style2">
                            <div class="about-item style4">
                                <div class="about-item_img"><img src="assets/img/icon/about_2_1.svg" alt=""></div>
                                <div class="about-item_centent">
                                    <h5 class="box-title">Hassle-Free Booking</h5>
                                    <p class="about-item_text">Easy online booking process with secure payment options
                                        and instant confirmation.</p>
                                </div>
                            </div>
                            <div class="about-item style4">
                                <div class="about-item_img"><img src="assets/img/icon/about_2_2.svg" alt=""></div>
                                <div class="about-item_centent">
                                    <h5 class="box-title">Cultural Immersion</h5>
                                    <p class="about-item_text">Authentic experiences that connect you with India's rich
                                        heritage and traditions.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="brand-area overflow-hidden ">
        <div class="container th-container">
            <div class="swiper th-slider brandSlider1 swiper-initialized swiper-horizontal" id="brandSlider1"
                data-slider-options="{&quot;breakpoints&quot;:{&quot;0&quot;:{&quot;slidesPerView&quot;:1},&quot;576&quot;:{&quot;slidesPerView&quot;:&quot;2&quot;},&quot;768&quot;:{&quot;slidesPerView&quot;:&quot;3&quot;},&quot;992&quot;:{&quot;slidesPerView&quot;:&quot;3&quot;},&quot;1200&quot;:{&quot;slidesPerView&quot;:&quot;6&quot;},&quot;1400&quot;:{&quot;slidesPerView&quot;:&quot;8&quot;}}}">
                <div class="swiper-wrapper" id="swiper-wrapper-14336910b8e5e5239" aria-live="off"
                    style="transition-duration: 0ms; transform: translate3d(-720px, 0px, 0px); transition-delay: 0ms;">
                    <div class="swiper-slide" role="group" aria-label="8 / 12" data-swiper-slide-index="7"
                        style="width: 156px; margin-right: 24px;">
                        <div class="brand-box"><a href=""><img class="original" src="assets/img/brand/brand_1_8.svg"
                                    alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_8.svg"
                                    alt="Brand Logo"></a></div>
                    </div>
                    <div class="swiper-slide" role="group" aria-label="9 / 12" data-swiper-slide-index="8"
                        style="width: 156px; margin-right: 24px;">
                        <div class="brand-box"><a href=""><img class="original" src="assets/img/brand/brand_1_4.svg"
                                    alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_4.svg"
                                    alt="Brand Logo"></a></div>
                    </div>
                    <div class="swiper-slide" role="group" aria-label="10 / 12" data-swiper-slide-index="9"
                        style="width: 156px; margin-right: 24px;">
                        <div class="brand-box"><a href=""><img class="original" src="assets/img/brand/brand_1_3.svg"
                                    alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_3.svg"
                                    alt="Brand Logo"></a></div>
                    </div>
                    <div class="swiper-slide swiper-slide-prev" role="group" aria-label="11 / 12"
                        data-swiper-slide-index="10" style="width: 156px; margin-right: 24px;">
                        <div class="brand-box"><a href=""><img class="original" src="assets/img/brand/brand_1_2.svg"
                                    alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_2.svg"
                                    alt="Brand Logo"></a></div>
                    </div>
                    <div class="swiper-slide swiper-slide-active" role="group" aria-label="12 / 12"
                        data-swiper-slide-index="11" style="width: 156px; margin-right: 24px;">
                        <div class="brand-box"><a href=""><img class="original" src="assets/img/brand/brand_1_1.svg"
                                    alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_1.svg"
                                    alt="Brand Logo"></a></div>
                    </div>
                    <div class="swiper-slide swiper-slide-next" role="group" aria-label="1 / 12"
                        data-swiper-slide-index="0" style="width: 156px; margin-right: 24px;">
                        <div class="brand-box"><a href=""><img class="original" src="assets/img/brand/brand_1_1.svg"
                                    alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_1.svg"
                                    alt="Brand Logo"></a></div>
                    </div>
                    <div class="swiper-slide" role="group" aria-label="2 / 12" data-swiper-slide-index="1"
                        style="width: 156px; margin-right: 24px;">
                        <div class="brand-box"><a href=""><img class="original" src="assets/img/brand/brand_1_2.svg"
                                    alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_2.svg"
                                    alt="Brand Logo"></a></div>
                    </div>
                    <div class="swiper-slide" role="group" aria-label="3 / 12" data-swiper-slide-index="2"
                        style="width: 156px; margin-right: 24px;">
                        <div class="brand-box"><a href=""><img class="original" src="assets/img/brand/brand_1_3.svg"
                                    alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_3.svg"
                                    alt="Brand Logo"></a></div>
                    </div>
                    <div class="swiper-slide" role="group" aria-label="4 / 12" data-swiper-slide-index="3"
                        style="width: 156px; margin-right: 24px;">
                        <div class="brand-box"><a href=""><img class="original" src="assets/img/brand/brand_1_4.svg"
                                    alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_4.svg"
                                    alt="Brand Logo"></a></div>
                    </div>
                    <div class="swiper-slide" role="group" aria-label="5 / 12" data-swiper-slide-index="4"
                        style="width: 156px; margin-right: 24px;">
                        <div class="brand-box"><a href=""><img class="original" src="assets/img/brand/brand_1_5.svg"
                                    alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_5.svg"
                                    alt="Brand Logo"></a></div>
                    </div>
                    <div class="swiper-slide" role="group" aria-label="6 / 12" data-swiper-slide-index="5"
                        style="width: 156px; margin-right: 24px;">
                        <div class="brand-box"><a href=""><img class="original" src="assets/img/brand/brand_1_6.svg"
                                    alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_6.svg"
                                    alt="Brand Logo"></a></div>
                    </div>
                    <div class="swiper-slide" role="group" aria-label="7 / 12" data-swiper-slide-index="6"
                        style="width: 156px; margin-right: 24px;">
                        <div class="brand-box"><a href=""><img class="original" src="assets/img/brand/brand_1_7.svg"
                                    alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_7.svg"
                                    alt="Brand Logo"></a></div>
                    </div>
                </div><span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
            </div>
        </div>
    </div> -->

    <!-- Same Day Tours Slider -->
    <section class="tour-area position-relative overflow-hidden pt-5 pb-5">
        <div class="container">
            <div class="mb-30 text-center text-md-start">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-7">
                        <div class="title-area mb-md-0">
                            <h3 class="sec-title">Same Day Tours</h3>
                        </div>
                    </div>
                    <div class="col-md-auto">
                        <a href="/same-day-tours/index.php" class="th-btn style4 th-icon">See All Tours</a>
                    </div>
                </div>
            </div>
            <div class="slider-area tour-slider">
                <div class="swiper th-slider has-shadow slider-drag-wrap" id="sameDayToursSlider"
                    data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"},"1300":{"slidesPerView":"4"}}}'>
                    <div class="swiper-wrapper">
                        <?php foreach ($sameDayTours as $tour): ?>
                            <div class="swiper-slide">
                                <?php echo renderTourCard($tour, 'grid'); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Taj Mahal Tours Slider -->
    <section class="tour-area position-relative overflow-hidden pb-5">
        <div class="container">
            <div class="mb-30 text-center text-md-start">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-7">
                        <div class="title-area mb-md-0">
                            <h3 class="sec-title">Taj Mahal Tours</h3>
                        </div>
                    </div>
                    <div class="col-md-auto">
                        <a href="/taj-mahal-tours/index.php" class="th-btn style4 th-icon">See All Tours</a>
                    </div>
                </div>
            </div>
            <div class="slider-area tour-slider">
                <div class="swiper th-slider has-shadow slider-drag-wrap" id="tajMahalToursSlider"
                    data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"},"1300":{"slidesPerView":"4"}}}'>
                    <div class="swiper-wrapper">
                        <?php foreach ($tajMahalTours as $tour): ?>
                            <div class="swiper-slide">
                                <?php echo renderTourCard($tour, 'grid'); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Golden Triangle Tours Slider -->
    <section class="tour-area position-relative overflow-hidden space-bottom">
        <div class="container">
            <div class="mb-30 text-center text-md-start">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-7">
                        <div class="title-area mb-md-0">
                            <h3 class="sec-title">Golden Triangle Tours</h3>
                        </div>
                    </div>
                    <div class="col-md-auto">
                        <a href="/golden-triangle-tours/index.php" class="th-btn style4 th-icon">See All Tours</a>
                    </div>
                </div>
            </div>
            <div class="slider-area tour-slider">
                <div class="swiper th-slider has-shadow slider-drag-wrap" id="goldenTriangleToursSlider"
                    data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"},"1300":{"slidesPerView":"4"}}}'>
                    <div class="swiper-wrapper">
                        <?php foreach ($goldenTriangleTours as $tour): ?>
                            <div class="swiper-slide">
                                <?php echo renderTourCard($tour, 'grid'); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Travel Gallery -->
    <div class="gallery-area">
        <div class="container th-container shape-mockup-wrap">
            <div class="title-area text-center"><span class="sub-title">Capture Your Memories</span>
                <h2 class="sec-title">Travel Gallery</h2>
            </div>
            <div class="row gy-10 gx-10 justify-content-center align-items-center">
                <div class="col-md-6 col-lg-2">
                    <div class="gallery-card">
                        <div class="box-img global-img"><a href="assets/img/gallery/hg1.webp" class="popup-image">
                                <div class="icon-btn"><i class="fal fa-magnifying-glass-plus"></i></div><img
                                    src="assets/img/gallery/hg1.webp" alt="Taj Mahal">
                            </a></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-2">
                    <div class="gallery-card">
                        <div class="box-img global-img"><a href="assets/img/gallery/hg2.webp" class="popup-image">
                                <div class="icon-btn"><i class="fal fa-magnifying-glass-plus"></i></div><img
                                    src="assets/img/gallery/hg2.webp" alt="Agra Fort">
                            </a></div>
                    </div>
                    <div class="gallery-card">
                        <div class="box-img global-img"><a href="assets/img/gallery/hg3.webp" class="popup-image">
                                <div class="icon-btn"><i class="fal fa-magnifying-glass-plus"></i></div><img
                                    src="assets/img/gallery/hg3.webp" alt="Amber Fort">
                            </a></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-2">
                    <div class="gallery-card">
                        <div class="box-img global-img"><a href="assets/img/gallery/hg4.webp" class="popup-image">
                                <div class="icon-btn"><i class="fal fa-magnifying-glass-plus"></i></div><img
                                    src="assets/img/gallery/hg4.webp" alt="Qutub Minar">
                            </a></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-2">
                    <div class="gallery-card">
                        <div class="box-img global-img"><a href="assets/img/gallery/hg5.webp" class="popup-image">
                                <div class="icon-btn"><i class="fal fa-magnifying-glass-plus"></i></div><img
                                    src="assets/img/gallery/hg5.webp" alt="India Gate">
                            </a></div>
                    </div>
                    <div class="gallery-card">
                        <div class="box-img global-img"><a href="assets/img/gallery/hg6.webp" class="popup-image">
                                <div class="icon-btn"><i class="fal fa-magnifying-glass-plus"></i></div><img
                                    src="assets/img/gallery/hg6.webp" alt="Hawa Mahal">
                            </a></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-2">
                    <div class="gallery-card">
                        <div class="box-img global-img"><a href="assets/img/gallery/hg7.webp" class="popup-image">
                                <div class="icon-btn"><i class="fal fa-magnifying-glass-plus"></i></div><img
                                    src="assets/img/gallery/hg7.webp" alt="City Palace">
                            </a></div>
                    </div>
                </div>
            </div>
            <div class="shape-mockup d-none d-xl-block" style="top: -25%; left: 0%;"><img
                    src="assets/img/shape/line.webp" alt="shape"></div>
            <div class="shape-mockup movingX d-none d-xl-block" style="top: 30%; left: -3%;"><img class="gmovingX"
                    src="assets/img/shape/shape_4.webp" alt="shape"></div>
        </div>
    </div>


    <section class="testi-area overflow-hidden space-top pb-5" id=" testi-sec">
        <div class="container-fluid p-0">
            <div class="title-area mb-20 text-center"><span class="sub-title text-anime-style-2">Testimonial</span>
                <h2 class="sec-title text-anime-style-3">What Client Say About us</h2>
            </div>
            <div class="slider-area">
                <div class="swiper th-slider testiSlider1 has-shadow" id="testiSlider1"
                    data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"767":{"slidesPerView":"2","centeredSlides":"true"},"992":{"slidesPerView":"2","centeredSlides":"true"},"1200":{"slidesPerView":"2.5","centeredSlides":"true"},"1400":{"slidesPerView":"2.5","centeredSlides":"true"}}}'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="testi-card">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile">
                                        <div class="testi-card_avater"><img src="assets/img/testimonial/testi_1_1.jpg"
                                                alt="testimonial"></div>
                                        <div class="media-body">
                                            <h3 class="box-title">Maria Doe</h3><span
                                                class="testi-card_desig">Traveller</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review"><i class="fa-solid fa-star"></i> <i
                                            class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i
                                            class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i></div>
                                </div>
                                <p class="testi-card_text">“A home that perfectly blends sustainability with luxury
                                    until I discovered Ecoland Residence. From the moment I stepped into this community,
                                    I knew it was where I wanted to live. The commitment to eco-friendly living”</p>
                                <div class="testi-card-quote"><img src="assets/img/icon/testi-quote.svg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-card">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile">
                                        <div class="testi-card_avater"><img src="assets/img/testimonial/testi_1_2.jpg"
                                                alt="testimonial"></div>
                                        <div class="media-body">
                                            <h3 class="box-title">Andrew Simon</h3><span
                                                class="testi-card_desig">Traveller</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review"><i class="fa-solid fa-star"></i> <i
                                            class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i
                                            class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i></div>
                                </div>
                                <p class="testi-card_text">“A home that perfectly blends sustainability with luxury
                                    until I discovered Ecoland Residence. From the moment I stepped into this community,
                                    I knew it was where I wanted to live. The commitment to eco-friendly living”</p>
                                <div class="testi-card-quote"><img src="assets/img/icon/testi-quote.svg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-card">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile">
                                        <div class="testi-card_avater"><img src="assets/img/testimonial/testi_1_1.jpg"
                                                alt="testimonial"></div>
                                        <div class="media-body">
                                            <h3 class="box-title">Alex Jordan</h3><span
                                                class="testi-card_desig">Traveller</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review"><i class="fa-solid fa-star"></i> <i
                                            class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i
                                            class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i></div>
                                </div>
                                <p class="testi-card_text">“A home that perfectly blends sustainability with luxury
                                    until I discovered Ecoland Residence. From the moment I stepped into this community,
                                    I knew it was where I wanted to live. The commitment to eco-friendly living”</p>
                                <div class="testi-card-quote"><img src="assets/img/icon/testi-quote.svg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-card">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile">
                                        <div class="testi-card_avater"><img src="assets/img/testimonial/testi_1_2.jpg"
                                                alt="testimonial"></div>
                                        <div class="media-body">
                                            <h3 class="box-title">Maria Doe</h3><span
                                                class="testi-card_desig">Traveller</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review"><i class="fa-solid fa-star"></i> <i
                                            class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i
                                            class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i></div>
                                </div>
                                <p class="testi-card_text">“A home that perfectly blends sustainability with luxury
                                    until I discovered Ecoland Residence. From the moment I stepped into this community,
                                    I knew it was where I wanted to live. The commitment to eco-friendly living”</p>
                                <div class="testi-card-quote"><img src="assets/img/icon/testi-quote.svg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-card">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile">
                                        <div class="testi-card_avater"><img src="assets/img/testimonial/testi_1_1.jpg"
                                                alt="testimonial"></div>
                                        <div class="media-body">
                                            <h3 class="box-title">Angelina Rose</h3><span
                                                class="testi-card_desig">Traveller</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review"><i class="fa-solid fa-star"></i> <i
                                            class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i
                                            class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i></div>
                                </div>
                                <p class="testi-card_text">“A home that perfectly blends sustainability with luxury
                                    until I discovered Ecoland Residence. From the moment I stepped into this community,
                                    I knew it was where I wanted to live. The commitment to eco-friendly living”</p>
                                <div class="testi-card-quote"><img src="assets/img/icon/testi-quote.svg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-card">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile">
                                        <div class="testi-card_avater"><img src="assets/img/testimonial/testi_1_1.jpg"
                                                alt="testimonial"></div>
                                        <div class="media-body">
                                            <h3 class="box-title">Maria Doe</h3><span
                                                class="testi-card_desig">Traveller</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review"><i class="fa-solid fa-star"></i> <i
                                            class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i
                                            class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i></div>
                                </div>
                                <p class="testi-card_text">“A home that perfectly blends sustainability with luxury
                                    until I discovered Ecoland Residence. From the moment I stepped into this community,
                                    I knew it was where I wanted to live. The commitment to eco-friendly living”</p>
                                <div class="testi-card-quote"><img src="assets/img/icon/testi-quote.svg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-card">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile">
                                        <div class="testi-card_avater"><img src="assets/img/testimonial/testi_1_2.jpg"
                                                alt="testimonial"></div>
                                        <div class="media-body">
                                            <h3 class="box-title">Andrew Simon</h3><span
                                                class="testi-card_desig">Traveller</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review"><i class="fa-solid fa-star"></i> <i
                                            class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i
                                            class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i></div>
                                </div>
                                <p class="testi-card_text">“A home that perfectly blends sustainability with luxury
                                    until I discovered Ecoland Residence. From the moment I stepped into this community,
                                    I knew it was where I wanted to live. The commitment to eco-friendly living”</p>
                                <div class="testi-card-quote"><img src="assets/img/icon/testi-quote.svg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-card">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile">
                                        <div class="testi-card_avater"><img src="assets/img/testimonial/testi_1_1.jpg"
                                                alt="testimonial"></div>
                                        <div class="media-body">
                                            <h3 class="box-title">Alex Jordan</h3><span
                                                class="testi-card_desig">Traveller</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review"><i class="fa-solid fa-star"></i> <i
                                            class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i
                                            class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i></div>
                                </div>
                                <p class="testi-card_text">“A home that perfectly blends sustainability with luxury
                                    until I discovered Ecoland Residence. From the moment I stepped into this community,
                                    I knew it was where I wanted to live. The commitment to eco-friendly living”</p>
                                <div class="testi-card-quote"><img src="assets/img/icon/testi-quote.svg" alt="img">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slider-pagination"></div>
                </div>
            </div>
        </div>
        <div class="shape-mockup d-none d-xl-block" data-bottom="-2%" data-right="0%"><img
                src="assets/img/shape/line2.webp" alt="shape"></div>
        <div class="shape-mockup movingX d-none d-xl-block" data-top="30%" data-left="5%"><img
                src="assets/img/shape/shape_7.webp" alt="shape"></div>
    </section>

    <section class="overflow-hidden space-bottom pt-5">
        <div class="container">
            <div class="row justify-content-lg-between justify-content-center align-items-end">
                <div class="col-lg">
                    <div class="title-area text-center text-lg-start"><span class="sub-title">Travel Tips &
                            Insights</span>
                        <h2 class="sec-title">Latest from Our Blog</h2>
                    </div>
                </div>
                <div class="col-lg-auto d-none d-lg-block">
                    <div class="sec-btn"><a href="/blog/index.php" class="th-btn style4 th-icon">See More Articles</a></div>
                </div>
            </div>
            <div class="row gx-24 gy-30">
                <div class="col-xl-8">
                    <div class="blog-grid2 style2 th-ani">
                        <div class="blog-img global-img"><img src="assets/img/blog/blog-agra.webp"
                                alt="Best Time to Visit Taj Mahal"></div>
                        <div class="blog-grid2_content">
                            <div class="blog-meta"><a class="author" href="blog/">Sep 09, 2024</a> <a
                                    href="blog/">6 min read</a></div>
                            <h3 class="box-title"><a href="blog/best-time-to-visit-taj-mahal-a-complete-guide/">Best Time to Visit Taj Mahal: A Complete
                                    Guide</a></h3><a href="blog/best-time-to-visit-taj-mahal-a-complete-guide/" class="th-btn style4 th-icon">Read
                                More</a>
                        </div>
                    </div>
                    <div class="blog-grid2 th-ani style2 mt-24">
                        <div class="blog-img global-img"><img src="assets/img/blog/blog-tour.webp"
                                alt="Golden Triangle Itinerary"></div>
                        <div class="blog-grid2_content">
                            <div class="blog-meta"><a class="author" href="blog/">Sep 10, 2024</a> <a
                                    href="blog/">8 min read</a></div>
                            <h3 class="box-title"><a href="blog/perfect-5-day-golden-triangle-itinerary/">Perfect 5-Day Golden Triangle
                                    Itinerary</a></h3><a href="blog/perfect-5-day-golden-triangle-itinerary/" class="th-btn style4 th-icon">Read
                                More</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="blog-grid2 th-ani">
                        <div class="blog-img global-img"><img src="assets/img/blog/blog-delhi.webp"
                                alt="Agra Local Cuisine"></div>
                        <div class="blog-grid2_content">
                            <div class="blog-meta"><a class="author" href="blog/">Sep 05, 2024</a> <a
                                    href="blog/">6 min read</a></div>
                            <h3 class="box-title">
                                <a href="blog/must-try-local-places-foods-in-delhi/">Must-Try Local Places & Foods in Delhi</a>
                            </h3><a href="blog/must-try-local-places-foods-in-delhi/" class="th-btn style4 th-icon">Read
                                More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- footer -->

    <?php include 'components/footer.php'; ?>

    <div id="login-form" class="popup-login-register mfp-hide">
        <ul class="nav" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation"><button class="nav-menu" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="false">Login</button></li>
            <li class="nav-item" role="presentation"><button class="nav-menu active" id="pills-profile-tab"
                    data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab"
                    aria-controls="pills-profile" aria-selected="true">Register</button></li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <h3 class="box-title mb-30">Sign in to your account</h3>
                <div class="th-login-form">
                    <form action="https://html.themehour.net/tourm/demo/mail.php" method="POST"
                        class="login-form ajax-contact">
                        <div class="row">
                            <div class="form-group col-12"><label>Username or email</label> <input type="text"
                                    class="form-control" name="email" id="email" required="required"></div>
                            <div class="form-group col-12"><label>Password</label> <input type="password"
                                    class="form-control" name="pasword" id="pasword" required="required"></div>
                            <div class="form-btn mb-20 col-12"><button class="th-btn btn-fw th-radius2">Send
                                    Message</button></div>
                        </div>
                        <div id="forgot_url"><a href="my-account.php">Forgot password?</a></div>
                        <p class="form-messages mb-0 mt-3"></p>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade active show" id="pills-profile" role="tabpanel"
                aria-labelledby="pills-profile-tab">
                <h3 class="th-form-title mb-30">Sign in to your account</h3>
                <form action="https://html.themehour.net/tourm/demo/mail.php" method="POST"
                    class="login-form ajax-contact">
                    <div class="row">
                        <div class="form-group col-12"><label>Username*</label> <input type="text" class="form-control"
                                name="usename" id="usename" required="required"></div>
                        <div class="form-group col-12"><label>First name*</label> <input type="text"
                                class="form-control" name="firstname" id="firstname" required="required"></div>
                        <div class="form-group col-12"><label>Last name*</label> <input type="text" class="form-control"
                                name="lastname" id="lastname" required="required"></div>
                        <div class="form-group col-12"><label for="new_email">Your email*</label> <input type="text"
                                class="form-control" name="new_email" id="new_email" required="required"></div>
                        <div class="form-group col-12"><label for="new_email_confirm">Confirm email*</label> <input
                                type="text" class="form-control" name="new_email_confirm" id="new_email_confirm"
                                required="required"></div>
                        <div class="statement"><span class="register-notes">A password will be emailed to you.</span>
                        </div>
                        <div class="form-btn mt-20 col-12"><button class="th-btn btn-fw th-radius2">Sign up</button>
                        </div>
                    </div>
                    <p class="form-messages mb-0 mt-3"></p>
                </form>
            </div>
        </div>
    </div>

    <!-- script  -->

    <?php include 'components/script.php'; ?>

</body>

</html>