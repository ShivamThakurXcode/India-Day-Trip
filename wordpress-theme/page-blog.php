<?php
/*
Template Name: Blog
*/
get_header();
?>

<div class="breadcumb-wrapper" data-bg-src="<?php echo get_template_directory_uri(); ?>/assets/img/bg/breadcumb-bg.jpg">
    <div class="container">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Our Blog</h1>
            <ul class="breadcumb-menu">
                <li><a href="<?php echo home_url(); ?>">Home</a></li>
                <li>Blog</li>
            </ul>
        </div>
    </div>
</div>

<section class="overflow-hidden space-bottom pt-5">
    <div class="container">
        <div class="row justify-content-lg-between justify-content-center align-items-end mb-4">
            <div class="col-lg">
                <div class="title-area text-center text-lg-start">
                    <span class="sub-title">Travel Tips & Insights</span>
                    <h2 class="sec-title">Latest from Our Blog</h2>
                </div>
            </div>
        </div>
        <div class="row gy-30">
            <div class="col-lg-4 col-md-6">
                <div class="blog-grid2 th-ani">
                    <div class="blog-img global-img">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/blog/blog-agra.png" alt="Best Time to Visit Taj Mahal">
                    </div>
                    <div class="blog-grid2_content">
                        <div class="blog-meta">
                            <a class="author" href="#">Sep 09, 2024</a>
                            <a href="#">6 min read</a>
                        </div>
                        <h3 class="box-title">
                            <a href="<?php echo get_permalink(get_page_by_path('blog-details')); ?>?slug=best-time-to-visit-taj-mahal">Best Time to Visit Taj Mahal: A Complete Guide</a>
                        </h3>
                        <p class="blog-text">Discover the best seasons to visit the Taj Mahal, including weather, crowds, and special events.</p>
                        <a href="<?php echo get_permalink(get_page_by_path('blog-details')); ?>" class="th-btn style4 th-icon">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="blog-grid2 th-ani">
                    <div class="blog-img global-img">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/blog/blog-delhi.png" alt="Must-Try Local Places & Foods in Delhi">
                    </div>
                    <div class="blog-grid2_content">
                        <div class="blog-meta">
                            <a class="author" href="#">Sep 05, 2024</a>
                            <a href="#">6 min read</a>
                        </div>
                        <h3 class="box-title">
                            <a href="<?php echo get_permalink(get_page_by_path('blog-details')); ?>?slug=must-try-local-places-foods-in-delhi">Must-Try Local Places & Foods in Delhi</a>
                        </h3>
                        <p class="blog-text">Explore Delhi's vibrant food scene and hidden gems that locals love.</p>
                        <a href="<?php echo get_permalink(get_page_by_path('blog-details')); ?>" class="th-btn style4 th-icon">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="blog-grid2 th-ani">
                    <div class="blog-img global-img">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/blog/blog-tour.png" alt="Perfect 5-Day Golden Triangle Itinerary">
                    </div>
                    <div class="blog-grid2_content">
                        <div class="blog-meta">
                            <a class="author" href="#">Sep 10, 2024</a>
                            <a href="#">8 min read</a>
                        </div>
                        <h3 class="box-title">
                            <a href="<?php echo get_permalink(get_page_by_path('blog-details')); ?>?slug=perfect-5-day-golden-triangle-itinerary">Perfect 5-Day Golden Triangle Itinerary</a>
                        </h3>
                        <p class="blog-text">Plan your ideal Golden Triangle tour with this detailed 5-day itinerary covering Delhi, Agra, and Jaipur.</p>
                        <a href="<?php echo get_permalink(get_page_by_path('blog-details')); ?>" class="th-btn style4 th-icon">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>