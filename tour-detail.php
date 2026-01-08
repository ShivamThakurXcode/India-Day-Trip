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

    <style>
        /* Tour Detail Page Custom Styling */

        /* Hero Section Enhancements */
        .tour-hero {
            background: linear-gradient(135deg, rgba(17, 61, 72, 0.8), rgba(26, 168, 203, 0.8));
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            padding: 120px 0;
            position: relative;
        }

        .tour-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(rgba(3, 2, 19, 0.7), rgba(1, 1, 17, 0.5));
            z-index: 1;
        }

        .tour-hero .container {
            position: relative;
            z-index: 2;
        }

        .tour-badge {
            background: linear-gradient(45deg, #1CA8CB, #113D48);
            color: white;
            padding: 5px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .breadcumb-title {
            color: white;
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .hero-meta {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            margin-top: 30px;
            justify-content: center;
        }

        .hero-meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            font-size: 16px;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            padding: 10px 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hero-meta-item i {
            color: #1CA8CB;
            font-size: 20px;
        }

        /* Tour Details Section */
        .space-top {
            padding-top: 80px;
        }

        .space-extra-bottom {
            padding-bottom: 80px;
        }

        .fade-in {
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Overview Section */
        .tour-highlight {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 30px;
            border-radius: 15px;
            margin-top: 20px;
            border-left: 5px solid #1CA8CB;
        }

        .tour-highlight h4 {
            color: #113D48;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        /* Gallery Section */
        .tour-gallery {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .tour-gallery img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .tour-gallery img:hover {
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        /* Highlights Section */
        .highlight-row {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            margin-bottom: 20px;
        }

        .highlight-row:hover {
            transform: translateY(-5px);
        }

        .highlight-icon {
            flex-shrink: 0;
            width: 60px;
            height: 60px;
            background: linear-gradient(45deg, #1CA8CB, #113D48);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .highlight-content h4 {
            color: #113D48;
            font-size: 1.25rem;
            margin-bottom: 10px;
        }

        /* Tour Info List */
        .tour-info-list .info-item {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            transition: background 0.3s ease;
        }

        .tour-info-list .info-item:hover {
            background: #e9ecef;
        }

        .info-icon {
            color: #1CA8CB;
            font-size: 24px;
        }

        .info-content h6 {
            color: #113D48;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        /* Itinerary Section */
        .itinerary-step {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            position: relative;
            border-left: 5px solid #1CA8CB;
        }

        .itinerary-step-number {
            position: absolute;
            top: -15px;
            left: -15px;
            width: 40px;
            height: 40px;
            background: linear-gradient(45deg, #1CA8CB, #113D48);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .itinerary-step h4 {
            color: #113D48;
            font-size: 1.5rem;
            margin-bottom: 15px;
            margin-top: 10px;
        }

        /* Inclusions/Exclusions */
        .inclusion-list li,
        .exclusion-list li {
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
            position: relative;
            padding-left: 30px;
        }

        .inclusion-list li:last-child,
        .exclusion-list li:last-child {
            border-bottom: none;
        }

        .inclusion-list li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #28a745;
            font-weight: bold;
            font-size: 18px;
        }

        .exclusion-list li::before {
            content: '✗';
            position: absolute;
            left: 0;
            color: #dc3545;
            font-weight: bold;
            font-size: 18px;
        }

        /* Related Tours */
        .bg-light {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef) !important;
        }

        .related-tour-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .related-tour-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }

        .tour-img {
            position: relative;
            overflow: hidden;
            height: 200px;
        }

        .tour-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .related-tour-card:hover .tour-img img {
            transform: scale(1.1);
        }

        .tour-content {
            padding: 20px;
        }

        .tour-title {
            color: #113D48;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 10px;
            transition: color 0.3s ease;
        }

        .related-tour-card:hover .tour-title {
            color: #1CA8CB;
        }

        .tour-destination {
            color: #6E7070;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .tour-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .tour-rating {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #6E7070;
            font-size: 14px;
        }

        .tour-rating i {
            color: #FFB539;
        }

        /* Enhanced Typography */
        .sec-title {
            color: #113D48;
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 30px;
            position: relative;
        }

        .sec-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(45deg, #1CA8CB, #113D48);
            border-radius: 2px;
        }

        /* Improved Overview Section */
        .tour-highlight {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 30px;
            border-radius: 15px;
            margin-top: 20px;
            border-left: 5px solid #1CA8CB;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .tour-highlight h4 {
            color: #113D48;
            font-size: 1.5rem;
            margin-bottom: 15px;
            font-weight: 600;
        }

        /* Enhanced Gallery */
        .tour-gallery img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 15px;
            transition: all 0.4s ease;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .tour-gallery img:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }

        /* Better Highlights */
        .highlight-row {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            padding: 25px;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            margin-bottom: 20px;
            border: 1px solid rgba(28, 168, 203, 0.1);
        }

        .highlight-row:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-color: rgba(28, 168, 203, 0.3);
        }

        .highlight-icon {
            flex-shrink: 0;
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #1CA8CB, #113D48);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
            box-shadow: 0 6px 20px rgba(28, 168, 203, 0.3);
        }

        .highlight-content h4 {
            color: #113D48;
            font-size: 1.3rem;
            margin-bottom: 10px;
            font-weight: 600;
        }

        /* Enhanced Tour Info */
        .tour-info-list .info-item {
            background: linear-gradient(135deg, #f8f9fa, #ffffff);
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            border: 1px solid rgba(28, 168, 203, 0.1);
        }

        .tour-info-list .info-item:hover {
            background: linear-gradient(135deg, #ffffff, #f0f8ff);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border-color: rgba(28, 168, 203, 0.2);
        }

        .info-icon {
            color: #1CA8CB;
            font-size: 28px;
            background: rgba(28, 168, 203, 0.1);
            padding: 10px;
            border-radius: 50%;
        }

        .info-content h6 {
            color: #113D48;
            font-size: 1.2rem;
            margin-bottom: 8px;
            font-weight: 600;
        }

        /* Improved Itinerary */
        .itinerary-step {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-radius: 20px;
            padding: 35px;
            margin-bottom: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            position: relative;
            border-left: 6px solid #1CA8CB;
            transition: all 0.3s ease;
        }

        .itinerary-step:hover {
            transform: translateX(5px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.15);
        }

        .itinerary-step-number {
            position: absolute;
            top: -20px;
            left: -20px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #1CA8CB, #113D48);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 20px;
            box-shadow: 0 6px 20px rgba(28, 168, 203, 0.3);
        }

        .itinerary-step h4 {
            color: #113D48;
            font-size: 1.6rem;
            margin-bottom: 15px;
            margin-top: 10px;
            font-weight: 600;
        }

        /* Enhanced Inclusions/Exclusions */
        .inclusion-list li,
        .exclusion-list li {
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
            position: relative;
            padding-left: 35px;
            transition: all 0.3s ease;
        }

        .inclusion-list li:hover,
        .exclusion-list li:hover {
            background: rgba(28, 168, 203, 0.05);
            padding-left: 40px;
        }

        .inclusion-list li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #28a745;
            font-weight: bold;
            font-size: 20px;
            background: rgba(40, 167, 69, 0.1);
            padding: 5px;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .exclusion-list li::before {
            content: '✗';
            position: absolute;
            left: 0;
            color: #dc3545;
            font-weight: bold;
            font-size: 20px;
            background: rgba(220, 53, 69, 0.1);
            padding: 5px;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Better Related Tours */
        .related-tour-card {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: all 0.4s ease;
            height: 100%;
            border: 1px solid rgba(28, 168, 203, 0.1);
        }

        .related-tour-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            border-color: rgba(28, 168, 203, 0.3);
        }

        .tour-img {
            position: relative;
            overflow: hidden;
            height: 220px;
        }

        .tour-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.4s ease;
        }

        .related-tour-card:hover .tour-img img {
            transform: scale(1.1);
        }

        .tour-content {
            padding: 25px;
        }

        .tour-title {
            color: #113D48;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 10px;
            transition: color 0.3s ease;
        }

        .related-tour-card:hover .tour-title {
            color: #1CA8CB;
        }

        .tour-destination {
            color: #6E7070;
            font-size: 14px;
            margin-bottom: 15px;
            font-weight: 500;
        }

        .tour-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .tour-rating {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #6E7070;
            font-size: 14px;
            font-weight: 500;
        }

        .tour-rating i {
            color: #FFB539;
        }

  
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .breadcumb-title {
                font-size: 2.5rem;
            }

            .hero-meta {
                gap: 20px;
            }

            .tour-gallery {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 15px;
            }

            .tour-gallery img {
                height: auto;
            }

            .highlight-row {
                flex-direction: column;
                text-align: center;
                padding: 20px;
            }

            .highlight-icon {
                align-self: center;
                width: 60px;
                height: 60px;
                font-size: 24px;
            }

            .itinerary-step {
                padding: 25px;
            }

            .itinerary-step-number {
                width: 45px;
                height: 45px;
                font-size: 18px;
            }

            .related-tour-card {
                margin-bottom: 20px;
            }

            .sec-title {
                font-size: 2rem;
            }

            .tour-info-list .info-item {
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .breadcumb-title {
                font-size: 2rem;
            }

            .hero-meta {
                flex-direction: column;
                gap: 15px;
            }

            .tour-gallery {
                grid-template-columns: 1fr;
            }

            .tour-gallery img {
                height: auto;
            }

            .highlight-row {
                padding: 15px;
            }

            .itinerary-step {
                padding: 20px;
            }

            .itinerary-step-number {
                width: 40px;
                height: 40px;
                font-size: 16px;
                top: -15px;
                left: -15px;
            }

            .sec-title {
                font-size: 1.8rem;
            }

            .tour-info-list .info-item {
                padding: 15px;
            }

            .info-icon {
                font-size: 24px;
                padding: 8px;
            }

            .info-content h6 {
                font-size: 1.1rem;
            }
        }
    </style>
</head>

<body>
    <?php include 'components/preloader.php'; ?>
    <?php include 'components/sidebar.php'; ?>

    <?php include 'components/header.php'; ?>

<main>

        <!-- Tour Hero Section -->
        <section class="tour-hero" style="background-image: url('../assets/img/<?php echo json_decode($tour['images'], true)[0] ?? 'default.webp'; ?>');">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center">
                        <span class="tour-badge">Most Popular</span>
                        <h1 class="breadcumb-title"><?php echo htmlspecialchars($tour['title']); ?></h1>
                        <br>
                        <p class="text-white"><?php echo htmlspecialchars($tour['location']); ?> | <?php echo htmlspecialchars(substr($tour['description'], 0, 100)); ?>...</p>

                        <div class="hero-meta">
                            <div class="hero-meta-item">
                                <i class="fas fa-clock"></i>
                                <span><?php echo htmlspecialchars($tour['duration']); ?></span>
                            </div>
                            <div class="hero-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Pickup & Drop: <?php echo htmlspecialchars($tour['location']); ?></span>
                            </div>
                            <div class="hero-meta-item">
                                <i class="fas fa-users"></i>
                                <span>Private Tour</span>
                            </div>
                            <div class="hero-meta-item">
                                <i class="fas fa-star"></i>
                                <span><?php echo number_format($tour['rating'], 1); ?> (<?php echo $tour['reviews'] ?? '0'; ?> reviews)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tour Details Section -->
        <section class="space-top space-extra-bottom fade-in">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <!-- Overview -->
                        <div class="mb-5 pb-3 border-bottom">
                            <h2 class="sec-title mb-5">Tour Overview</h2>
                            <p><?php echo nl2br(htmlspecialchars($tour['description'])); ?></p>

                            <div class="tour-highlight">
                                <h4 class="mb-3"><i class="fas fa-bolt me-2"></i> Why Choose This Tour?</h4>
                                <p><?php echo htmlspecialchars($tour['why_choose'] ?? 'Experience the best of this tour in a comfortable and memorable way.'); ?></p>
                            </div>
                        </div>

                        <!-- Tour Gallery -->
                        <div class="mb-5 pb-3 border-bottom">
                            <h2 class="sec-title mb-5">Tour Gallery</h2>
                            <div class="tour-gallery">
                                <?php
                                $images = json_decode($tour['images'], true) ?: [];
                                $images = array_slice($images, 0, 4); // Limit to 4 images
                                foreach ($images as $image) {
                                    echo '<img src="../assets/img/' . htmlspecialchars($image) . '" alt="' . htmlspecialchars($tour['title']) . '">';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Highlights -->
                        <div class="mb-5 pb-3 border-bottom">
                            <h2 class="sec-title mb-5">Tour Highlights</h2>
                            <div class="row">
                                <?php
                                $highlights = json_decode($tour['highlights'] ?? '[]', true) ?: [];
                                $icons = ['fas fa-sun', 'fas fa-utensils', 'fas fa-landmark', 'fas fa-user-shield', 'fas fa-camera', 'fas fa-hotel'];
                                foreach ($highlights as $index => $highlight) {
                                    $icon = $icons[$index % count($icons)];
                                    echo '<div class="col-md-6">
                                        <div class="highlight-row">
                                            <div class="highlight-icon">
                                                <i class="' . $icon . '"></i>
                                            </div>
                                            <div class="highlight-content">
                                                <h4 class="box-title">' . htmlspecialchars($highlight['title'] ?? $highlight) . '</h4>
                                            </div>
                                        </div>
                                    </div>';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Quick Info Widget -->
                        <div class="mb-5 pb-3">
                            <h2 class="sec-title mb-5">Tour Details</h2>
                            <div class="tour-info-list">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-item d-flex align-items-center mb-2">
                                            <div class="info-icon me-3">
                                                <i class="fas fa-clock"></i>
                                            </div>
                                            <div class="info-content">
                                                <h6 class="mb-1">Duration</h6>
                                                <p class="mb-0"><?php echo htmlspecialchars($tour['duration']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-item d-flex align-items-center mb-2">
                                            <div class="info-icon me-3">
                                                <i class="fas fa-users"></i>
                                            </div>
                                            <div class="info-content">
                                                <h6 class="mb-1">Service</h6>
                                                <p class="mb-0"><?php echo htmlspecialchars($tour['location']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-item d-flex align-items-center mb-2">
                                            <div class="info-icon me-3">
                                                <i class="fas fa-language"></i>
                                            </div>
                                            <div class="info-content">
                                                <h6 class="mb-1">Language</h6>
                                                <p class="mb-0">English, Hindi, Spanish (on request)</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-item d-flex align-items-center mb-2">
                                            <div class="info-icon me-3">
                                                <i class="fas fa-car"></i>
                                            </div>
                                            <div class="info-content">
                                                <h6 class="mb-1">Transport</h6>
                                                <p class="mb-0">Private Luxury Car</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Itinerary -->
                        <div class="mb-5 pb-3 border-bottom">
                            <h2 class="sec-title mb-5">Tour Itinerary</h2>

                                <?php
                                $itinerary = json_decode($tour['itinerary'] ?? '[]', true) ?: [];
                                foreach ($itinerary as $index => $day) {
                                    $stepNum = $index + 1;
                                    $title = is_array($day) && isset($day['title']) ? $day['title'] : 'Step ' . $stepNum;
                                    $description = is_array($day) && isset($day['description']) ? $day['description'] : (is_array($day) && isset($day['points']) ? implode(' ', $day['points']) : $day);
                                    echo '<div class="itinerary-step">
                                        <h4>' . htmlspecialchars($title) . '</h4>
                                        <p>' . htmlspecialchars($description) . '</p>
                                    </div>';
                                }
                                ?>
                                                    </div>

                        <!-- Inclusions/Exclusions -->
                        <div class="mb-5 pb-3">
                            <h2 class="sec-title mb-5">What's Included</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="mb-3"><i class="fas fa-check-circle text-success me-2"></i> Inclusions</h4>
                                    <ul class="inclusion-list">
                                        <?php
                                        $included = json_decode($tour['included'] ?? '[]', true) ?: [];
                                        foreach ($included as $item) {
                                            echo '<li>' . htmlspecialchars($item) . '</li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="mb-3"><i class="fas fa-times-circle text-danger me-2"></i> Exclusions</h4>
                                    <ul class="exclusion-list">
                                        <?php
                                        $excluded = json_decode($tour['excluded'] ?? '[]', true) ?: [];
                                        foreach ($excluded as $item) {
                                            echo '<li>' . htmlspecialchars($item) . '</li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Call to Action Section -->
                        <!-- <section class="cta-section">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <h2>Ready to Experience This Amazing Tour?</h2>
                                        <p>Book your unforgettable journey today and create memories that will last a lifetime. Our expert guides and premium service ensure you have the best experience possible.</p>
                                        <div class="cta-buttons">
                                            <a href="booking.php" class="cta-btn cta-btn-primary">
                                                <i class="fas fa-calendar-check"></i>
                                                Book This Tour
                                            </a>
                                            <a href="contact.php" class="cta-btn cta-btn-secondary">
                                                <i class="fas fa-phone"></i>
                                                Contact Us
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section> -->

                    </div>
                </div>
            </div>
        </section>

        <!-- Related Tours -->
        <section class="space-top space-extra-bottom bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="title-area text-center mb-4">
                            <span class="sub-title" style="color:#113d48;font-weight:600;letter-spacing:1px;">Explore More</span>
                            <h2 class="sec-title" style="font-size:2.1rem;font-weight:700;">Related Tours</h2>
                        </div>
                    </div>
                </div>
                <div class="row gy-4">
                    <?php
                    $relatedTours = getTours($tour['category_name'], 3, $tour['id']);
                    foreach ($relatedTours as $relatedTour): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="related-tour-card">
                                <div class="tour-img">
                                    <img src="../assets/img/<?php echo json_decode($relatedTour['images'], true)[0] ?? 'default.webp'; ?>" alt="<?php echo htmlspecialchars($relatedTour['title']); ?>">
                                </div>
                                <div class="tour-content">
                                    <h3 class="tour-title"><?php echo htmlspecialchars($relatedTour['title']); ?></h3>
                                    <p class="tour-destination"><?php echo htmlspecialchars($relatedTour['location']); ?></p>
                                    <div class="tour-meta">
                                        <div class="tour-rating">
                                            <i class="fas fa-star"></i>
                                            <span><?php echo number_format($relatedTour['rating'], 1); ?> (<?php echo $relatedTour['reviews'] ?? '0'; ?>+)</span>
                                        </div>
                                    </div>
                                    <a href="tour/<?php echo $relatedTour['slug']; ?>" class="th-btn style3">View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

    </main>

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