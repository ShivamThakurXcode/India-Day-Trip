<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <?php get_header(); ?>

    <!-- Hero Section -->
    <div class="hero-2" id="hero">
        <div class="hero2-overlay" data-bg-src="<?php echo get_template_directory_uri(); ?>/assets/img/bg/line-pattern.png"></div>
        <div class="swiper hero-slider-2" id="heroSlide2">
            <div class="swiper-wrapper">
                <div class="swiper-slide hero-agra">
                    <div class="hero-inner">
                        <div class="th-hero-bg" data-bg-src="<?php echo get_template_directory_uri(); ?>/assets/img/hero/hero-agra.png"></div>
                        <div class="container">
                            <div class="hero-style2">
                                <h1 class="hero-title" data-ani="slideinup" data-ani-delay="0.4s">Discover <span class="hero-text">The Beauty of Agra</span></h1>
                                <p class="hero-desc" data-ani="slideinup" data-ani-delay="0.5s">Experience the wonder of the Taj Mahal with Agra's trusted travel experts.</p>
                                <div class="btn-group" data-ani="slideinup" data-ani-delay="0.6s">
                                    <a href="<?php echo get_permalink(get_page_by_path('tour')); ?>" class="th-btn white-btn th-icon">Explore Agra Tours</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide hero-delhi">
                    <div class="hero-inner">
                        <div class="th-hero-bg" data-bg-src="<?php echo get_template_directory_uri(); ?>/assets/img/hero/hero-delhi.png"></div>
                        <div class="container">
                            <div class="hero-style2">
                                <h1 class="hero-title" data-ani="slideinup" data-ani-delay="0.4s">Explore <span class="hero-text">The Heart of Delhi</span></h1>
                                <p class="hero-desc" data-ani="slideinup" data-ani-delay="0.5s">Experience Delhi's rich history and vibrant culture with India Day Trip.</p>
                                <div class="btn-group" data-ani="slideinup" data-ani-delay="0.6s">
                                    <a href="<?php echo get_permalink(get_page_by_path('tour')); ?>" class="th-btn white-btn th-icon">Explore Delhi Tours</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide hero-jaipur">
                    <div class="hero-inner">
                        <div class="th-hero-bg" data-bg-src="<?php echo get_template_directory_uri(); ?>/assets/img/hero/hero-jaipur.png"></div>
                        <div class="container">
                            <div class="hero-style2">
                                <h1 class="hero-title" data-ani="slideinup" data-ani-delay="0.4s">Experience <span class="hero-text">The Pink City of Jaipur</span></h1>
                                <p class="hero-desc" data-ani="slideinup" data-ani-delay="0.5s">Discover Jaipur's royal charm and vibrant bazaars.</p>
                                <div class="btn-group" data-ani="slideinup" data-ani-delay="0.6s">
                                    <a href="<?php echo get_permalink(get_page_by_path('tour')); ?>" class="th-btn white-btn th-icon">Explore Jaipur Tours</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="th-swiper-custom">
                <div class="swiper-pagination"></div>
                <div class="hero-icon">
                    <button data-slider-prev="#heroSlide2, #heroSlide3" class="hero-arrow slider-prev">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/hero-arrow-left.svg" alt="">
                    </button>
                    <button data-slider-next="#heroSlide2, #heroSlide3" class="hero-arrow slider-next">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/hero-arrow-right.svg" alt="">
                    </button>
                </div>
            </div>
        </div>
        <div class="swiper heroThumbs style2" id="heroSlide3">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="hero-inner">
                        <div class="hero-card">
                            <div class="hero-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hero/hero-agra.png" alt="Agra Tour">
                            </div>
                            <div class="hero-card_content">
                                <h3 class="box-title">Agra Day Tour</h3>
                                <span><i class="fa-light fa-clock"></i>1 Day</span>
                                <a href="<?php echo get_permalink(get_page_by_path('same-day-tours')); ?>" class="th-btn style2">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="hero-inner">
                        <div class="hero-card">
                            <div class="hero-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hero/hero-delhi.png" alt="Delhi Tour">
                            </div>
                            <div class="hero-card_content">
                                <h3 class="box-title">Delhi City Tour</h3>
                                <span><i class="fa-light fa-clock"></i>1 Day</span>
                                <a href="<?php echo get_permalink(get_page_by_path('golden-triangle-tours')); ?>" class="th-btn style2">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="hero-inner">
                        <div class="hero-card">
                            <div class="hero-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hero/hero-jaipur.png" alt="Jaipur Tour">
                            </div>
                            <div class="hero-card_content">
                                <h3 class="box-title">Jaipur Heritage Tour</h3>
                                <span><i class="fa-light fa-clock"></i>1 Day</span>
                                <a href="<?php echo get_permalink(get_page_by_path('golden-triangle-tours')); ?>" class="th-btn style2">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="scroll-down">
            <a href="#destination-sec" class="scroll-wrap">
                <span><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/down-arrow.svg" alt=""></span>Scroll Down
            </a>
        </div>
    </div>

    <!-- Categories/Destinations Section -->
    <section class="category-area bg-top-center background-image" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/bg/category_bg_1.webp');">
        <div class="container th-container">
            <div class="title-area text-center">
                <span class="sub-title">Wonderful Place For You</span>
                <h2 class="sec-title">Top Destinations</h2>
            </div>
            <div class="swiper th-slider has-shadow categorySlider background-image swiper-initialized swiper-horizontal swiper-backface-hidden" id="categorySlider1" data-slider-options='{"spaceBetween": "50","breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"},"1400":{"slidesPerView":"5"}}}'>
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="category-card single">
                            <div class="box-img global-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/destination/d-delhi.png" alt="Delhi">
                            </div>
                            <h3 class="box-title"><a href="<?php echo get_permalink(get_page_by_path('tour')); ?>">Delhi</a></h3>
                            <a class="line-btn" href="<?php echo get_permalink(get_page_by_path('tour')); ?>">See packages</a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="category-card single">
                            <div class="box-img global-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/destination/d-agra.png" alt="Agra">
                            </div>
                            <h3 class="box-title"><a href="<?php echo get_permalink(get_page_by_path('tour')); ?>">Agra</a></h3>
                            <a class="line-btn" href="<?php echo get_permalink(get_page_by_path('tour')); ?>">See packages</a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="category-card single">
                            <div class="box-img global-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/destination/d-jaipur.png" alt="Jaipur">
                            </div>
                            <h3 class="box-title"><a href="<?php echo get_permalink(get_page_by_path('tour')); ?>">Jaipur</a></h3>
                            <a class="line-btn" href="<?php echo get_permalink(get_page_by_path('tour')); ?>">See packages</a>
                        </div>
                    </div>
                    <!-- Add more destinations as needed -->
                </div>
                <div class="slider-pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal">
                    <span class="swiper-pagination-bullet swiper-pagination-bullet-active"></span>
                    <span class="swiper-pagination-bullet"></span>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Tours Section -->
    <section class="tour-area position-relative bg-top-center overflow-hidden space background-image arrow-wrap" id="service-sec" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/bg/tour_bg_1.jpg');">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="title-area text-center">
                        <span class="sub-title">Best Place For You</span>
                        <h2 class="sec-title">Most Popular Tour</h2>
                        <p class="sec-text">Discover our most popular tours across India, featuring iconic destinations like the Taj Mahal, Delhi, and the Golden Triangle.</p>
                    </div>
                </div>
            </div>
            <div class="slider-area tour-slider">
                <div class="swiper th-slider has-shadow slider-drag-wrap">
                    <div class="swiper-wrapper">
                        <?php
                        $popular_tours = get_posts(array(
                            'post_type' => 'tour',
                            'posts_per_page' => 6,
                            'meta_key' => 'is_popular',
                            'meta_value' => '1'
                        ));
                        foreach ($popular_tours as $tour) :
                            $thumbnail = get_the_post_thumbnail_url($tour->ID, 'medium');
                        ?>
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img">
                                        <a href="<?php echo get_permalink($tour->ID); ?>">
                                            <img src="<?php echo $thumbnail ?: get_template_directory_uri() . '/assets/img/tours-image/default.png'; ?>" alt="<?php echo get_the_title($tour->ID); ?>">
                                        </a>
                                    </div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="<?php echo get_permalink($tour->ID); ?>"><?php echo get_the_title($tour->ID); ?></a></h3>
                                        <p class="tour-location"><?php echo get_post_meta($tour->ID, 'location', true); ?></p>
                                        <div class="tour-rating">
                                            <div class="star-rating">
                                                <span>Rated <strong class="rating">5.00</strong> out of 5</span>
                                            </div>
                                        </div>
                                        <div class="tour-action">
                                            <span><i class="fa-light fa-clock"></i><?php echo get_post_meta($tour->ID, 'duration', true); ?></span>
                                            <a href="<?php echo get_permalink(get_page_by_path('to-book')); ?>" class="th-btn style4 th-icon">Book Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <div class="feature-area overflow-hidden" id="feature-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="title-area text-center">
                        <span class="sub-title style1">Why Choose India Day Trip</span>
                        <h2 class="sec-title">Premium Travel Experience</h2>
                        <p class="feature-text">India Day Trip offers exceptional travel experiences with expert guides, comfortable transportation, and personalized itineraries.</p>
                    </div>
                </div>
            </div>
            <div class="row gy-4 justify-content-center">
                <div class="col-md-6 col-xl-3">
                    <div class="feature-item th-ani">
                        <div class="feature-item_icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/feature_1_1.svg" alt="icon">
                        </div>
                        <div class="media-body">
                            <h3 class="box-title">Expert Guides</h3>
                            <p class="feature-item_text">Knowledgeable local guides who bring India's rich history and culture to life.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="feature-item th-ani">
                        <div class="feature-item_icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/feature_1_2.svg" alt="icon">
                        </div>
                        <div class="media-body">
                            <h3 class="box-title">Comfortable Transport</h3>
                            <p class="feature-item_text">Air-conditioned vehicles with professional drivers for a smooth journey.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="feature-item th-ani">
                        <div class="feature-item_icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/feature_1_3.svg" alt="icon">
                        </div>
                        <div class="media-body">
                            <h3 class="box-title">Flexible Itineraries</h3>
                            <p class="feature-item_text">Customizable, flexible tour plans. Tailored options. Fit your schedule.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="feature-item th-ani">
                        <div class="feature-item_icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/feature_1_4.svg" alt="icon">
                        </div>
                        <div class="media-body">
                            <h3 class="box-title">24/7 Support</h3>
                            <p class="feature-item_text">Round-the-clock assistance to ensure a hassle-free travel experience.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div class="about-area position-relative overflow-hidden space" id="about-sec">
        <div class="container">
            <div class="row gy-4">
                <div class="col-xl-6">
                    <div class="img-box15 pe-xl-4">
                        <div class="img1 global-img">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/home/about-1.png" alt="About India Day Trip">
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="ps-xl-4">
                        <div class="title-area mb-20">
                            <span class="sub-title style1">About India Day Trip</span>
                            <h2 class="sec-title mb-20">Your Trusted Travel Partner in Agra</h2>
                            <p class="sec-text2 mb-50">India Day Trip is an Agra-based tour and travel company specializing in Same Day Tours, Taj Mahal Tours, and Golden Triangle Tours. With years of experience, we provide exceptional travel experiences across India's most iconic destinations.</p>
                        </div>
                        <div class="about-item-wrap style2">
                            <div class="about-item style4">
                                <div class="about-item_img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/about_2_1.svg" alt="">
                                </div>
                                <div class="about-item_centent">
                                    <h5 class="box-title">Hassle-Free Booking</h5>
                                    <p class="about-item_text">Easy online booking process with secure payment options and instant confirmation.</p>
                                </div>
                            </div>
                            <div class="about-item style4">
                                <div class="about-item_img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/about_2_2.svg" alt="">
                                </div>
                                <div class="about-item_centent">
                                    <h5 class="box-title">Cultural Immersion</h5>
                                    <p class="about-item_text">Authentic experiences that connect you with India's rich heritage and traditions.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Section -->
    <div class="gallery-area">
        <div class="container th-container shape-mockup-wrap">
            <div class="title-area text-center">
                <span class="sub-title">Capture Your Memories</span>
                <h2 class="sec-title">Travel Gallery</h2>
            </div>
            <div class="row gy-10 gx-10 justify-content-center align-items-center">
                <div class="col-md-6 col-lg-2">
                    <div class="gallery-card">
                        <div class="box-img global-img">
                            <a href="<?php echo get_template_directory_uri(); ?>/assets/img/gallery/hg1.png" class="popup-image">
                                <div class="icon-btn"><i class="fal fa-magnifying-glass-plus"></i></div>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/gallery/hg1.png" alt="Taj Mahal">
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Add more gallery images -->
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <section class="testi-area overflow-hidden space-top pb-5" id="testi-sec">
        <div class="container-fluid p-0">
            <div class="title-area mb-20 text-center">
                <span class="sub-title text-anime-style-2">Testimonial</span>
                <h2 class="sec-title text-anime-style-3">What Client Say About us</h2>
            </div>
            <div class="slider-area">
                <div class="swiper th-slider testiSlider1 has-shadow" id="testiSlider1" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"767":{"slidesPerView":"2","centeredSlides":"true"},"992":{"slidesPerView":"2","centeredSlides":"true"},"1200":{"slidesPerView":"2.5","centeredSlides":"true"},"1400":{"slidesPerView":"2.5","centeredSlides":"true"}}}'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="testi-card">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile">
                                        <div class="testi-card_avater">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/testimonial/testi_1_1.jpg" alt="testimonial">
                                        </div>
                                        <div class="media-body">
                                            <h3 class="box-title">Maria Doe</h3>
                                            <span class="testi-card_desig">Traveller</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>
                                <p class="testi-card_text">"A home that perfectly blends sustainability with luxury until I discovered Ecoland Residence. From the moment I stepped into this community, I knew it was where I wanted to live. The commitment to eco-friendly living"</p>
                                <div class="testi-card-quote">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/testi-quote.svg" alt="img">
                                </div>
                            </div>
                        </div>
                        <!-- Add more testimonials -->
                    </div>
                    <div class="slider-pagination"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section class="overflow-hidden space-bottom pt-5">
        <div class="container">
            <div class="row justify-content-lg-between justify-content-center align-items-end">
                <div class="col-lg">
                    <div class="title-area text-center text-lg-start">
                        <span class="sub-title">Travel Tips & Insights</span>
                        <h2 class="sec-title">Latest from Our Blog</h2>
                    </div>
                </div>
                <div class="col-lg-auto d-none d-lg-block">
                    <div class="sec-btn">
                        <a href="<?php echo get_permalink(get_page_by_path('blog')); ?>" class="th-btn style4 th-icon">See More Articles</a>
                    </div>
                </div>
            </div>
            <div class="row gx-24 gy-30">
                <?php
                $recent_posts = get_posts(array('posts_per_page' => 3));
                foreach ($recent_posts as $post) :
                    setup_postdata($post);
                ?>
                    <div class="col-xl-8">
                        <div class="blog-grid2 style2 th-ani">
                            <div class="blog-img global-img">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                            <div class="blog-grid2_content">
                                <div class="blog-meta">
                                    <a class="author" href="#"><?php echo get_the_date(); ?></a>
                                    <a href="#"><?php echo get_post_meta(get_the_ID(), 'read_time', true) ?: '5 min read'; ?></a>
                                </div>
                                <h3 class="box-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <a href="<?php the_permalink(); ?>" class="th-btn style4 th-icon">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                wp_reset_postdata(); ?>
            </div>
        </div>
    </section>

    <?php get_footer(); ?>

    <div class="scroll-top">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;"></path>
        </svg>
    </div>

    <?php wp_footer(); ?>
</body>

</html>