<link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicons/favicon.png">
<link rel="shortcut icon" type="image/png" href="assets/img/favicons/favicon.png">

<link rel="manifest" href="assets/img/favicons/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="theme-color" content="#ffffff">
<link rel="preconnect" href="https://fonts.googleapis.com/">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com/">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&amp;family=Manrope:wght@200..800&amp;family=Montez&amp;display=swap"
    rel="stylesheet">
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/css/fontawesome.min.css">
<link rel="stylesheet" href="../assets/css/magnific-popup.min.css">
<link rel="stylesheet" href="../assets/css/swiper-bundle.min.css">
<link rel="stylesheet" href="../assets/css/style.css">
<style>
    /* Color Switcher Enhancement */
    .color-switch-btns button {
        position: relative;
        transition: all 0.3s ease;
    }

    .color-switch-btns button.active {
        transform: scale(1.2);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        border: 2px solid #fff;
    }

    .color-switch-btns button:hover {
        transform: scale(1.1);
    }

    /* Tour Slider Section Header Styling */
    .tour-area .row.align-items-center {
        margin-bottom: 30px;
    }

    .tour-area .title-area .sec-title {
        font-size: 28px;
        font-weight: 700;
        color: var(--title-color);
        margin-bottom: 0;
    }

    /* Tour Location Styling */
    .tour-location {
        font-size: 14px;
        color: #666;
        margin-bottom: 5px;
    }

    @media (max-width: 767px) {
        .tour-area .row.align-items-center {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 15px;
        }

        .tour-area .row.align-items-center .col-auto:last-child {
            width: 100%;
        }

        .tour-area .row.align-items-center .col-auto:last-child .line-btn {
            width: 100%;
            text-align: center;
            display: inline-block;
        }

        .tour-area .title-area .sec-title {
            font-size: 24px;
        }
    }
</style>