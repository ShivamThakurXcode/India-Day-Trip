<?php
/*
Template Name: Tour
*/
get_header();
?>

<div class="breadcumb-wrapper" data-bg-src="<?php echo get_template_directory_uri(); ?>/assets/img/bg/breadcumb-bg.jpg">
    <div class="container">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Popular Tours</h1>
            <ul class="breadcumb-menu">
                <li><a href="<?php echo home_url(); ?>">Home</a></li>
                <li>Popular Tours</li>
            </ul>
        </div>
    </div>
</div>
<section class="space">
    <div class="container">
        <div class="th-sort-bar">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-4">
                    <div class="search-form-area">
                        <form class="search-form">
                            <input type="text" placeholder="Search">
                            <button type="submit">
                                <i class="fa-light fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-md-auto">
                    <div class="sorting-filter-wrap">
                        <div class="nav" role="tablist">
                            <a class="active" href="#" id="tab-destination-grid" data-bs-toggle="tab" data-bs-target="#tab-grid" role="tab" aria-controls="tab-grid" aria-selected="true">
                                <i class="fa-light fa-grid-2"></i>
                            </a>
                            <a href="#" id="tab-destination-list" data-bs-toggle="tab" data-bs-target="#tab-list" role="tab" aria-controls="tab-list" aria-selected="false" class="">
                                <i class="fa-solid fa-list"></i>
                            </a>
                        </div>
                        <form class="woocommerce-ordering" method="get">
                            <select name="orderby" class="orderby" aria-label="destination order">
                                <option value="menu_order" selected="selected">Default Sorting</option>
                                <option value="popularity">Sort by popularity</option>
                                <option value="rating">Sort by average rating</option>
                                <option value="date">Sort by latest</option>
                                <option value="price">Sort by price: low to high</option>
                                <option value="price-desc">Sort by price: high to low</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-9 col-lg-8">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade active show" id="tab-grid" role="tabpanel" aria-labelledby="tab-tour-grid">
                        <div class="row gy-24 gx-24">
                            <!-- Tour listings would go here, but for brevity, showing a few -->
                            <div class="col-xxl-4 col-lg-4 col-md-6">
                                <div class="tour-box th-ani">
                                    <div class="tour-box_img global-img">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/tours-image/delhi-food-taste.png" alt="Old Delhi Food Tasting Tour">
                                    </div>
                                    <div class="tour-content">
                                        <h3 class="box-title">
                                            <a href="<?php echo get_permalink(get_page_by_path('to-book')); ?>">Old Delhi Food Tasting Tour</a>
                                        </h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong> out of 5 based on <span class="rating">4.8</span>(4.8 Rating)</span>
                                            </div>
                                            <a href="<?php echo get_permalink(get_page_by_path('to-book')); ?>" class="woocommerce-review-link">(<span class="count">4.8</span> Rating)</a>
                                        </div>
                                        <div class="tour-action">
                                            <span>
                                                <i class="fa-light fa-clock"></i>4 Hours
                                            </span>
                                            <a href="<?php echo get_permalink(get_page_by_path('contact')); ?>" class="th-btn style4">Book Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Add more tour boxes as needed -->
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-list" role="tabpanel" aria-labelledby="tab-tour-list">
                        <div class="row gy-30">
                            <!-- List view tours -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-lg-4">
                <aside class="sidebar-area">
                    <div class="widget widget_categories">
                        <h3 class="widget_title">Tour Categories</h3>
                        <ul>
                            <li>
                                <a href="<?php echo get_permalink(get_page_by_path('same-day-tours')); ?>">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/theme-img/map.svg" alt="">Same Day Tours</a>
                                <span>(5)</span>
                            </li>
                            <li>
                                <a href="<?php echo get_permalink(get_page_by_path('taj-mahal-tours')); ?>">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/theme-img/map.svg" alt="">Taj Mahal Tours</a>
                                <span>(5)</span>
                            </li>
                            <li>
                                <a href="<?php echo get_permalink(get_page_by_path('golden-triangle-tours')); ?>">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/theme-img/map.svg" alt="">Golden Triangle Tours</a>
                                <span>(5)</span>
                            </li>
                            <li>
                                <a href="<?php echo get_permalink(get_page_by_path('rajasthan-tour-packages')); ?>">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/theme-img/map.svg" alt="">Rajasthan Tours</a>
                                <span>(5)</span>
                            </li>
                        </ul>
                    </div>
                    <!-- Other sidebar widgets -->
                </aside>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>