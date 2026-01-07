<?php
if (!isset($tour)) {
    header('Location: index.php');
    exit;
}
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo htmlspecialchars($tour['title']); ?> - India Day Trip</title>
    <meta name="author" content="India Day Trip">
    <meta name="description" content="<?php echo htmlspecialchars(substr($tour['description'], 0, 160)); ?>">
    <meta name="keywords" content="India Day Trip, <?php echo htmlspecialchars($tour['title']); ?>, <?php echo htmlspecialchars($tour['location']); ?>">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="https://indiadaytrip.com/tour/<?php echo $tour['slug']; ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($tour['title']); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars(substr($tour['description'], 0, 160)); ?>">
    <meta property="og:image" content="https://indiadaytrip.com/assets/img/<?php echo $tour['images'] ? json_decode($tour['images'], true)[0] : 'default.webp'; ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://indiadaytrip.com/tour/<?php echo $tour['slug']; ?>">
    <meta property="twitter:title" content="<?php echo htmlspecialchars($tour['title']); ?>">
    <meta property="twitter:description" content="<?php echo htmlspecialchars(substr($tour['description'], 0, 160)); ?>">
    <meta property="twitter:image" content="https://indiadaytrip.com/assets/img/<?php echo $tour['images'] ? json_decode($tour['images'], true)[0] : 'default.webp'; ?>">

    <?php include 'components/links.php'; ?>
</head>

<body>
    <?php include 'components/preloader.php'; ?>
    <?php include 'components/sidebar.php'; ?>

    <?php include 'components/header.php'; ?>

    <div class="breadcumb-wrapper" data-bg-src="../assets/img/bg/breadcumb-bg.webp">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title"><?php echo htmlspecialchars($tour['title']); ?></h1>
                <ul class="breadcumb-menu">
                    <li><a href="index.php">Home</a></li>
                    <li><?php echo htmlspecialchars($tour['title']); ?></li>
                </ul>
            </div>
        </div>
    </div>

    <section class="space arrow-wrap">
        <div class="container shape-mockup-wrap">
            <?php if ($tour['images']): ?>
                <div class="slider-area tour-slider1 mb-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="tour-slider-img">
                                <img src="../assets/img/<?php echo json_decode($tour['images'], true)[0]; ?>" alt="<?php echo htmlspecialchars($tour['title']); ?>" style="width: 100%; height: auto;" />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <?php
                                $images = json_decode($tour['images'], true);
                                $gridImages = array_slice($images, 1, 4); // Next 4 images
                                foreach ($gridImages as $image): ?>
                                    <div class="col-6 mb-2">
                                        <div class="tour-slider-img">
                                            <img src="../assets/img/<?php echo $image; ?>" alt="<?php echo htmlspecialchars($tour['title']); ?>" style="width: 100%; height: auto;" />
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-xxl-9 col-lg-8">
                    <div class="tour-page-single">
                        <h2 class="box-title"><?php echo htmlspecialchars($tour['title']); ?></h2>
                        <div class="page-content">
                            <div class="page-meta mb-45">
                                <a class="page-tag" href="tour.php">Featured</a>
                                <span class="ratting"><i class="fa-sharp fa-solid fa-star"></i><span><?php echo number_format($tour['rating'], 1); ?></span></span>
                            </div>

                            <div class="tour-snapshot">
                                
                                <div class="tour-snap-wrapp">
                                         <div class="tour-snap">
                                        <?php if ($tour['pricing']): ?>
                                            <div class="icon"><i class="fas fa-rupee-sign"></i></div>
                                            <span class="price" > <span class="title">Price:</span><?php echo number_format($tour['pricing'], 2); ?></span>
                                <?php endif; ?>
                                    </div>
                                    <div class="tour-snap">
                                        <div class="icon"><i class="fa-light fa-clock"></i></div>
                                        <div class="content"><span class="title">Duration:</span> <span><?php echo htmlspecialchars($tour['duration']); ?></span></div>
                                    </div>
                                    <div class="tour-snap">
                                        <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
                                        <div class="content"><span class="title">Location:</span> <?php echo htmlspecialchars($tour['location']); ?></div>
                                    </div>
                               
                                </div>
                            </div>

                            <p class="box-text mb-30"><?php echo nl2br(htmlspecialchars($tour['description'])); ?></p>

                            <h2 class="box-title">Highlights</h2>
                            <p class="box-text mb-30">Experience the magic of this tour with key highlights designed for memorable adventures.</p>
                            <div class="checklist mb-50">
                                <ul>
                                    <?php
                                    $highlights = json_decode($tour['highlights'] ?? '[]', true) ?: [];
                                    foreach ($highlights as $highlight) {
                                        echo '<li>' . htmlspecialchars($highlight) . '</li>';
                                    }
                                    ?>
                                </ul>
                            </div>

                            <h2 class="box-title">Included and Excluded</h2>
                            <p class="blog-text mb-35">Everything you need for a seamless experience is included. Focus on enjoying while we handle the logistics.</p>
                            <div class="destination-checklist">
                                <div class="checklist style2 style4">
                                    <ul>
                                        <?php
                                        $included = json_decode($tour['included'] ?? '[]', true) ?: [];
                                        foreach ($included as $item) {
                                            echo '<li>' . htmlspecialchars($item) . '</li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="checklist style5">
                                    <ul>
                                        <?php
                                        $excluded = json_decode($tour['excluded'] ?? '[]', true) ?: [];
                                        foreach ($excluded as $item) {
                                            echo '<li>' . htmlspecialchars($item) . '</li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>

                            <h3 class="page-title mt-50 mb-0">Tour Plan</h3>
                            <ul class="nav nav-tabs tour-tab mt-10" role="tablist">
                                <?php
                                $itinerary = json_decode($tour['itinerary'] ?? '[]', true) ?: [];
                                foreach ($itinerary as $index => $day) {
                                    $dayNum = $index + 1;
                                    $active = $index === 0 ? 'active' : '';
                                    $dayTitle = is_array($day) && isset($day['title']) ? $day['title'] : 'Day ' . $dayNum;
                                    echo '<li class="nav-item" role="presentation">';
                                    echo '<button class="nav-link ' . $active . '" id="day-tab' . $dayNum . '" data-bs-toggle="tab" data-bs-target="#day-tab' . $dayNum . '-pane" type="button" role="tab" aria-controls="day-tab' . $dayNum . '-pane" aria-selected="' . ($index === 0 ? 'true' : 'false') . '">' . htmlspecialchars($dayTitle) . '</button>';
                                    echo '</li>';
                                }
                                ?>
                            </ul>
                            <div class="tab-content">
                                <?php
                                foreach ($itinerary as $index => $day) {
                                    $dayNum = $index + 1;
                                    $active = $index === 0 ? 'show active' : '';
                                    echo '<div class="tab-pane fade ' . $active . '" id="day-tab' . $dayNum . '-pane" role="tabpanel" aria-labelledby="day-tab' . $dayNum . '" tabindex="0">';
                                    echo '<div class="tour-grid-plan">';
                                    echo '<div class="checklist">';
                                    echo '<ul>';
                                    if (is_array($day) && isset($day['points']) && is_array($day['points'])) {
                                        foreach ($day['points'] as $point) {
                                            echo '<li>' . htmlspecialchars($point) . '</li>';
                                        }
                                    } else {
                                        echo '<li>No itinerary details available</li>';
                                    }
                                    echo '</ul>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4">
                    <aside class="sidebar-area">


                        <div class="widget">
                            <h3 class="widget_title">Trusted by Travelers</h3>
                            <div class="tripadvisor-box">
                                <div class="d-flex align-items-center">
                                    <img src="../assets/img/icon/tripadvisor.svg" alt="TripAdvisor" style="width: 40px; height: 40px; margin-right: 10px;" />
                                
                                    <div>
                                        <div class="rating">
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <span>4.8/5</span>
                                        </div>
                                        <p class="mb-0">Based on 500+ reviews</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget widget_tag_cloud">
                            <h3 class="widget_title">Popular Tags</h3>
                            <div class="tagcloud">
                                <a href="tour.php"><?php echo htmlspecialchars($tour['location']); ?></a>
                                <a href="tour.php"><?php echo htmlspecialchars($tour['duration']); ?></a>
                                <a href="tour.php">India</a>
                                <a href="tour.php">Travel</a>
                                <a href="tour.php">Adventure</a>
                            </div>
                        </div>
                        <div class="widget widget_offer background-image" style="background-image: url('../assets/img/bg/widget_bg_1.webp');">
                            <div class="offer-banner">
                                <div class="offer">
                                    <h6 class="box-title">Need Help? We Are Here To Help You</h6>
                                    <div class="banner-logo">
                                        <img src="../assets/img/logo/logo-header.webp" alt="Tourm" />
                                    </div>
                                    <div class="offer">
                                        <h6 class="offer-title">You Get Online support</h6>
                                        <a class="offter-num" href="+918126052755">+91 8126052755</a>
                                    </div>
                                    <a href="contact.php" class="th-btn style2 th-icon">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>

    <?php include 'components/footer.php'; ?>

    <div id="login-form" class="popup-login-register mfp-hide">
        <ul class="nav" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation"><button class="nav-menu" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="false">Login</button></li>
            <li class="nav-item" role="presentation"><button class="nav-menu active" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="true">Register</button></li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <h3 class="box-title mb-30">Sign in to your account</h3>
                <div class="th-login-form">
                    <form action="https://html.themehour.net/tourm/demo/mail.php" method="POST" class="login-form ajax-contact">
                        <div class="row">
                            <div class="form-group col-12"><label>Username or email</label> <input type="text" class="form-control" name="email" id="email" required="required"></div>
                            <div class="form-group col-12"><label>Password</label> <input type="password" class="form-control" name="pasword" id="pasword" required="required"></div>
                            <div class="form-btn mb-20 col-12"><button class="th-btn btn-fw th-radius2">Send Message</button></div>
                        </div>
                        <div id="forgot_url"><a href="my-account.php">Forgot password?</a></div>
                        <p class="form-messages mb-0 mt-3"></p>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade active show" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <h3 class="th-form-title mb-30">Sign in to your account</h3>
                <form action="https://html.themehour.net/tourm/demo/mail.php" method="POST" class="login-form ajax-contact">
                    <div class="row">
                        <div class="form-group col-12"><label>Username*</label> <input type="text" class="form-control" name="usename" id="usename" required="required"></div>
                        <div class="form-group col-12"><label>First name*</label> <input type="text" class="form-control" name="firstname" id="firstname" required="required"></div>
                        <div class="form-group col-12"><label>Last name*</label> <input type="text" class="form-control" name="lastname" id="lastname" required="required"></div>
                        <div class="form-group col-12"><label for="new_email">Your email*</label> <input type="text" class="form-control" name="new_email" id="new_email" required="required"></div>
                        <div class="form-group col-12"><label for="new_email_confirm">Confirm email*</label> <input type="text" class="form-control" name="new_email_confirm" id="new_email_confirm" required="required"></div>
                        <div class="statement"><span class="register-notes">A password will be emailed to you.</span></div>
                        <div class="form-btn mt-20 col-12"><button class="th-btn btn-fw th-radius2">Sign up</button></div>
                    </div>
                    <p class="form-messages mb-0 mt-3"></p>
                </form>
            </div>
        </div>
    </div>

    <?php include 'components/script.php'; ?>
</body>

</html>