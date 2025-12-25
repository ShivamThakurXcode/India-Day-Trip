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
    <meta property="og:image" content="https://indiadaytrip.com/assets/img/tours/<?php echo $tour['images'] ? json_decode($tour['images'], true)[0] : 'default.jpg'; ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://indiadaytrip.com/tour/<?php echo $tour['slug']; ?>">
    <meta property="twitter:title" content="<?php echo htmlspecialchars($tour['title']); ?>">
    <meta property="twitter:description" content="<?php echo htmlspecialchars(substr($tour['description'], 0, 160)); ?>">
    <meta property="twitter:image" content="https://indiadaytrip.com/assets/img/tours/<?php echo $tour['images'] ? json_decode($tour['images'], true)[0] : 'default.jpg'; ?>">

    <?php include 'components/links.php'; ?>
</head>

<body>
    <?php include 'components/preloader.php'; ?>
    <?php include 'components/sidebar.php'; ?>

    <?php include 'components/header.php'; ?>

    <!-- Tour Detail Section -->
    <section class="space-top space-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="tour-detail">
                        <h1 class="tour-title"><?php echo htmlspecialchars($tour['title']); ?></h1>

                        <?php if ($tour['images']): ?>
                            <div class="tour-gallery">
                                <?php
                                $images = json_decode($tour['images'], true);
                                foreach ($images as $image): ?>
                                    <img src="assets/img/tours/<?php echo $image; ?>" alt="<?php echo htmlspecialchars($tour['title']); ?>" class="img-fluid mb-3">
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <div class="tour-meta">
                            <span class="location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($tour['location']); ?></span>
                            <span class="duration"><i class="fas fa-clock"></i> <?php echo htmlspecialchars($tour['duration']); ?></span>
                            <?php if ($tour['pricing']): ?>
                                <span class="price"><i class="fas fa-rupee-sign"></i> <?php echo number_format($tour['pricing'], 2); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="tour-description">
                            <h3>Description</h3>
                            <p><?php echo nl2br(htmlspecialchars($tour['description'])); ?></p>
                        </div>

                        <?php if ($tour['itinerary']): ?>
                            <div class="tour-itinerary">
                                <h3>Itinerary</h3>
                                <div><?php echo nl2br(htmlspecialchars($tour['itinerary'])); ?></div>
                            </div>
                        <?php endif; ?>

                        <div class="tour-rating">
                            <div class="star-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star <?php echo $i <= $tour['rating'] ? 'filled' : ''; ?>"></i>
                                <?php endfor; ?>
                                <span><?php echo number_format($tour['rating'], 1); ?> / 5.0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="tour-sidebar">
                        <div class="booking-card">
                            <h3>Book This Tour</h3>
                            <div class="tour-price">
                                <?php if ($tour['pricing']): ?>
                                    <span class="price">₹<?php echo number_format($tour['pricing'], 2); ?></span>
                                <?php else: ?>
                                    <span class="price">Price on Request</span>
                                <?php endif; ?>
                            </div>
                            <div class="availability">
                                <span>Available Spots: <?php echo $tour['availability']; ?></span>
                            </div>
                            <a href="to_book/index.php" class="btn btn-primary btn-block">Book Now</a>
                        </div>

                        <div class="tour-info">
                            <h4>Tour Information</h4>
                            <ul>
                                <li><strong>Location:</strong> <?php echo htmlspecialchars($tour['location']); ?></li>
                                <li><strong>Duration:</strong> <?php echo htmlspecialchars($tour['duration']); ?></li>
                                <li><strong>Rating:</strong> <?php echo number_format($tour['rating'], 1); ?>/5</li>
                                <li><strong>Views:</strong> <?php echo $tour['view_count']; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'components/footer.php'; ?>

    <?php include 'components/script.php'; ?>
</body>
</html>