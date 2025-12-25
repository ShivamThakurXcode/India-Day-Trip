<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Popular Tours - India Day Trip | Taj Mahal & Golden Triangle</title>
    <meta name="author" content="India Day Trip">
    <meta name="description" content="Explore our popular tours including Same Day Tours, Taj Mahal Tours, and Golden Triangle Tours. Book your Agra-based adventure with India Day Trip.">
    <meta name="keywords" content="Popular tours India, Taj Mahal tours, Golden Triangle tours, Same Day tours Agra, Delhi tours, Jaipur tours">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://indiadaytrip.com/tour/">
    <meta property="og:title" content="Popular Tours - India Day Trip | Taj Mahal & Golden Triangle">
    <meta property="og:description" content="Explore our popular tours including Same Day Tours, Taj Mahal Tours, and Golden Triangle Tours. Book your Agra-based adventure with India Day Trip.">
    <meta property="og:image" content="https://indiadaytrip.com/assets/img/destination/d-agra.webp">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://indiadaytrip.com/tour/">
    <meta property="twitter:title" content="Popular Tours - India Day Trip | Taj Mahal & Golden Triangle">
    <meta property="twitter:description" content="Explore our popular tours including Same Day Tours, Taj Mahal Tours, and Golden Triangle Tours. Book your Agra-based adventure with India Day Trip.">
    <meta property="twitter:image" content="https://indiadaytrip.com/assets/img/destination/d-agra.webp">

    <?php
    require_once '../config.php';
    
    $tours = getTours();
    ?>
    
    <?php include '../components/links.php'; ?>
    </head>
    
    <body>
    <?php include '../components/preloader.php'; ?>
    <?php include '../components/sidebar.php'; ?>
    <?php include '../components/header.php'; ?>

    <div class="breadcumb-wrapper" data-bg-src="../assets/img/bg/breadcumb-bg.webp">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Popular Tours</h1>
                <ul class="breadcumb-menu">
                    <li><a href="../index.php">Home</a></li>
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
                                <?php foreach ($tours as $tour): ?>
                                    <?php echo renderTourCard($tour, 'grid'); ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-list" role="tabpanel" aria-labelledby="tab-tour-list">
                            <div class="row gy-30">
                                <?php foreach ($tours as $tour): ?>
                                    <?php echo renderTourCard($tour, 'list'); ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4">
                    <aside class=" sidebar-area">
                    <div class="widget widget_categories">
                        <h3 class="widget_title">Tour Categories</h3>
                        <ul>
                            <li>
                                <a href="../same-day-tours/index.php">
                                    <img src="../assets/img/theme-img/map.svg" alt="">Same Day Tours</a>
                                <span>(5)</span>
                            </li>
                            <li>
                                <a href="../taj-mahal-tours/index.php">
                                    <img src="../assets/img/theme-img/map.svg" alt="">Taj Mahal Tours</a>
                                <span>(5)</span>
                            </li>
                            <li>
                                <a href="../golden-triangle-tours/index.php">
                                    <img src="../assets/img/theme-img/map.svg" alt="">Golden Triangle Tours</a>
                                <span>(5)</span>
                            </li>
                            <li>
                                <a href="../rajsthan-tours/index.php">
                                    <img src="../assets/img/theme-img/map.svg" alt="">Rajasthan Tours</a>
                                <span>(5)</span>
                            </li>
                        </ul>
                    </div>
                    <div class="widget">
                        <h3 class="widget_title">Recent Posts</h3>
                        <div class="recent-post-wrap">
                            <div class="recent-post">
                                <div class="media-img">
                                    <a href="../gallery/index.php">
                                        <img src="../assets/img/blog/recent-post-1-1.jpg" alt="Blog Image">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="post-title">
                                        <a class="text-inherit" href="../gallery/index.php">Best Time to Visit Taj Mahal</a>
                                    </h4>
                                    <div class="recent-post-meta">
                                        <a href="../index.php">
                                            <i class="fa-regular fa-calendar"></i>22/6/ 2025
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="recent-post">
                                <div class="media-img">
                                    <a href="../gallery/index.php">
                                        <img src="../assets/img/blog/recent-post-1-2.jpg" alt="Blog Image">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="post-title">
                                        <a class="text-inherit" href="../gallery/index.php">Delhi Street Food Guide</a>
                                    </h4>
                                    <div class="recent-post-meta">
                                        <a href="../index.php">
                                            <i class="fa-regular fa-calendar"></i>25/6/ 2025
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="recent-post">
                                <div class="media-img">
                                    <a href="../gallery/index.php">
                                        <img src="../assets/img/blog/recent-post-1-3.jpg" alt="Blog Image">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="post-title">
                                        <a class="text-inherit" href="../gallery/index.php">Golden Triangle Itinerary</a>
                                    </h4>
                                    <div class="recent-post-meta">
                                        <a href="../index.php">
                                            <i class="fa-regular fa-calendar"></i>27/6/ 2025
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget widget_tag_cloud">
                        <h3 class="widget_title">Popular Tags</h3>
                        <div class="tagcloud">
                            <a href="../index.php">Taj Mahal</a>
                            <a href="../index.php">Delhi</a>
                            <a href="../index.php">Agra</a>
                            <a href="../index.php">Jaipur</a>
                            <a href="../index.php">Golden Triangle</a>
                            <a href="../index.php">Same Day</a>
                            <a href="../index.php">Heritage</a>
                            <a href="../index.php">Travel</a>
                        </div>
                    </div>
                    <div class="widget widget_offer" data-bg-src="../assets/img/bg/widget_bg_1.jpg">
                        <div class="offer-banner">
                            <div class="offer">
                                <h6 class="box-title">Need Help? We Are Here To Help You</h6>
                                <div class="banner-logo">
                                    <img src="../assets/img/logo2.svg" alt="Tourm">
                                </div>
                                <div class="offer">
                                    <h6 class="offer-title">You Get Online support</h6>
                                    <a class="offter-num" href="%2b256214203215.html">+256 214 203 215</a>
                                </div>
                                <a href="../contact/index.php" class="th-btn style2 th-icon">Read More</a>
                            </div>
                        </div>
                    </div>
                    </aside>
                </div>
            </div>
            <div class="shape-mockup shape1 d-none d-xxl-block" data-bottom="7%" data-right="-8%">
                <img src="../assets/img/shape/shape_1.webp" alt="shape">
            </div>
            <div class="shape-mockup shape2 d-none d-xl-block" data-bottom="1%" data-right="-7%">
                <img src="../assets/img/shape/shape_2.webp" alt="shape">
            </div>
            <div class="shape-mockup shape3 d-none d-xxl-block" data-bottom="-2%" data-right="-12%">
                <img src="../assets/img/shape/shape_3.webp" alt="shape">
            </div>
        </div>
    </section>

    <?php include '../components/footer.php'; ?>

    <div class="scroll-top">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;"></path>
        </svg>
    </div>

    <?php include '../components/script.php'; ?>
</body>

</html>

