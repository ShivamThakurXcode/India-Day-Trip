<?php
/**
 * Generate a URL-friendly slug from a string
 *
 * @param string $string The string to convert to slug
 * @param string $table The table name to check uniqueness
 * @param int $id The ID to exclude from uniqueness check (for updates)
 * @return string The generated slug
 */
function generateSlug($string, $table = null, $id = null) {
    // Convert to lowercase
    $slug = strtolower($string);

    // Replace non-letter or digits with -
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);

    // Trim leading/trailing -
    $slug = trim($slug, '-');

    // Remove multiple consecutive -
    $slug = preg_replace('/-+/', '-', $slug);

    // If table is provided, ensure uniqueness
    if ($table && isset($GLOBALS['pdo'])) {
        $originalSlug = $slug;
        $counter = 1;

        while (true) {
            $query = "SELECT COUNT(*) FROM $table WHERE slug = ?";
            $params = [$slug];

            if ($id) {
                $query .= " AND id != ?";
                $params[] = $id;
            }

            $stmt = $GLOBALS['pdo']->prepare($query);
            $stmt->execute($params);
            $count = $stmt->fetchColumn();

            if ($count == 0) {
                break;
            }

            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
    }

    return $slug;
}

/**
 * Get database connection
 */
function getDBConnection() {
    static $pdo = null;

    if ($pdo === null) {
        require_once 'config.php';
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    return $pdo;
}

/**
 * Render a tour card
 *
 * @param array $tour Tour data from database
 * @param string $style 'grid' or 'list' for different layouts
 * @return string HTML for the tour card
 */
function renderTourCard($tour, $style = 'grid') {
    $containerClass = ($style === 'swiper') ? '' : "col-xxl-4 col-lg-4 col-md-6 mb-4";
    $imagePath = $tour['images'] ? json_decode($tour['images'], true)[0] : 'default.webp';
    $imageUrl = "../assets/img/{$imagePath}";
    $detailUrl = "../tour/{$tour['slug']}";
    $rating = number_format($tour['rating'], 1);
    $priceDisplay = $tour['pricing'] ? '₹' . number_format($tour['pricing'], 0) : '';

    // Generate star rating HTML
    $starsHtml = '';
    $fullStars = floor($tour['rating']);
    $hasHalfStar = $tour['rating'] - $fullStars >= 0.5;

    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $fullStars) {
            $starsHtml .= '<i class="fa-solid fa-star"></i>';
        } elseif ($i == $fullStars + 1 && $hasHalfStar) {
            $starsHtml .= '<i class="fa-solid fa-star-half-alt"></i>';
        } else {
            $starsHtml .= '<i class="fa-regular fa-star"></i>';
        }
    }

    $html = "<style>
                .tour-card-description {
                    display: -webkit-box !important;
                    -webkit-line-clamp: 2 !important;
                    -webkit-box-orient: vertical !important;
                    overflow: hidden !important;
                    text-overflow: ellipsis !important;
                    line-height: 1.4 !important;
                    max-height: 2.8em !important;
                }
                .tour-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
                }
                .tour-card:hover .tour-card-image img {
                    transform: scale(1.05);
                }
                .tour-card-btn-whatsapp:hover {
                    background: #25D366;
                    color: white;
                }
                .tour-card-btn-book:hover {
                    background: #0056b3;
                }
                @media (max-width: 767px) {
                    .tour-card {
                        height: auto !important;
                        margin-bottom: 20px;
                    }
                    .tour-card-content {
                        height: auto !important;
                    }
                    .col-xxl-4.col-lg-4.col-md-6 {
                        flex: 0 0 100%;
                        max-width: 100%;
                    }
                }
                @media (min-width: 768px) and (max-width: 1023px) {
                    .col-xxl-4.col-lg-4.col-md-6 {
                        flex: 0 0 50%;
                        max-width: 50%;
                    }
                }
                @media (min-width: 1024px) {
                    .col-xxl-4.col-lg-4.col-md-6 {
                        flex: 0 0 33.333%;
                        max-width: 33.333%;
                    }
                }
            </style>
            <div class='{$containerClass}'>
                <div class='tour-card' style='height: 460px; min-width: 310px; background: #FFFFFF; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); overflow: hidden; transition: transform 0.3s ease, box-shadow 0.3s ease;'>
                    <div class='tour-card-image' style='position: relative; height: 200px; overflow: hidden;'>
                        <img src='{$imageUrl}' alt='" . htmlspecialchars($tour['title']) . "' style='width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;'>
                        <div class='tour-card-ribbon' style='position: absolute; bottom: 0; left: 0; right: 0; background: rgba(238, 238, 238, 0.15); padding: 2px 12px; display: flex; justify-content: space-between; align-items: center; color: #ffffffff; backdrop-filter: blur(8px);'>
                            <span style='font-size: 14px; width: fit-content;'><i class='fa-light fa-clock' style='margin-right: 5px;'></i>" . htmlspecialchars($tour['duration']) . "</span>
                            <span class='tour-card-location' style='font-size: 14px; width: fit-content; max-width: 60%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;' ><i class='fa-solid fa-map-marker-alt' style='margin-right: 5px;'></i>" . htmlspecialchars($tour['location']) . "</span>
                          
                        </div>
                    </div>
                    <div class='tour-card-content' style='padding: 16px; height: calc(100% - 200px); display: flex; flex-direction: column;'>
                        <h3 class='tour-card-title' style='font-size: 18px; font-weight: 600; color: #333; margin: 0 0 8px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4;'>
                            <a href='{$detailUrl}' style='color: inherit; text-decoration: none;'>" . htmlspecialchars($tour['title']) . "</a>
                        </h3>
                        <p class='tour-card-description' style='font-size: 14px; margin-top:auto; color: #666; margin: 0 0 12px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; line-height: 1.4; flex-grow: 1; max-height: 2.8em;'>
                            " . htmlspecialchars($tour['description']) . "
                        </p>
                        <div class='tour-card-details' style='display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; margin-top: auto;'>
                            <span class='tour-card-price' style='font-size: 18px; font-weight: bold; color: #1CA8CB;'>{$priceDisplay}</span>
                              <span  style='font-size: 14px; color: #ffa008ff;''>{$starsHtml} {$rating}</span>
                            
                        </div>
                        <hr style='margin: 12px 0; border: none; border-bottom: 1px solid #EAEAEA;'>
                        <div class='tour-card-actions' style='display: flex; gap: 10px; margin-top: auto;'>
                            <a href='https://wa.me/918126052755?text=" . urlencode("Hi, I'm interested in the tour: " . $tour['title']) . "' class='tour-card-btn tour-card-btn-whatsapp' style='flex: 1; padding: 10px 12px; border: 2px solid #25D366; border-radius: 50px; background: transparent; color: #25D366; text-decoration: none; text-align: center; font-size: 14px; font-weight: 500; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 5px;' aria-label='Inquire about " . htmlspecialchars($tour['title']) . " via WhatsApp'>
                                <i class='fab fa-whatsapp'></i> Inquire
                            </a>
                            <a href='{$detailUrl}' class='tour-card-btn tour-card-btn-book' style='flex: 1; padding: 10px 12px; border: none; border-radius: 50px; background: #1CA8CB; color: white; text-decoration: none; text-align: center; font-size: 14px; font-weight: 500; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 5px;' aria-label='Book " . htmlspecialchars($tour['title']) . " now'>
                                <i class='fa-solid fa-calendar-check'></i> Book Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>";

    return $html;
}

/**
 * Get tours by category
 *
 * @param string $category Category name or null for all
 * @param int $limit Number of tours to fetch
 * @return array Array of tours
 */
function getTours($category = null, $limit = null) {
    global $pdo;

    $query = "SELECT t.*, c.name as category_name FROM tours t LEFT JOIN categories c ON t.category_id = c.id WHERE 1=1";
    $params = [];

    if ($category) {
        $query .= " AND c.name = ?";
        $params[] = $category;
    }

    $query .= " ORDER BY t.created_at DESC";

    if ($limit) {
        $query .= " LIMIT " . (int)$limit;
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

/**
 * Render a blog card
 *
 * @param array $blog Blog data from database
 * @param string $style 'grid' or 'list' for different layouts
 * @return string HTML for the blog card
 */
function renderBlogCard($blog, $style = 'grid', $detailUrlPrefix = 'blog/') {
    $containerClass = ($style === 'swiper') ? '' : "col-xxl-4 col-lg-4 col-md-6 mb-4";
    $imagePath = $blog['featured_image'] ?: 'default.webp';
    $imageUrl = "../assets/img/blog/{$imagePath}";
    $detailUrl = $detailUrlPrefix . $blog['slug'];
    $excerpt = $blog['excerpt'] ?: substr(strip_tags($blog['content']), 0, 150) . '...';

    $html = "<style>
                .blog-card-description {
                    display: -webkit-box !important;
                    -webkit-line-clamp: 3 !important;
                    -webkit-box-orient: vertical !important;
                    overflow: hidden !important;
                    text-overflow: ellipsis !important;
                    line-height: 1.4 !important;
                    max-height: 4.2em !important;
                }
                .blog-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
                }
                .blog-card:hover .blog-card-image img {
                    transform: scale(1.05);
                }
                @media (max-width: 767px) {
                    .blog-card {
                        height: auto !important;
                        margin-bottom: 20px;
                    }
                    .blog-card-content {
                        height: auto !important;
                    }
                }
            </style>
            <div class='{$containerClass}'>
                <div class='blog-card' style='height: 400px; min-width: 310px; background: #FFFFFF; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); overflow: hidden; transition: transform 0.3s ease, box-shadow 0.3s ease;'>
                    <div class='blog-card-image' style='position: relative; height: 200px; overflow: hidden;'>
                        <img src='{$imageUrl}' alt='" . htmlspecialchars($blog['title']) . "' style='width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;'>
                    </div>
                    <div class='blog-card-content' style='padding: 16px; height: calc(100% - 200px); display: flex; flex-direction: column;'>
                        <h3 class='blog-card-title' style='font-size: 18px; font-weight: 600; color: #333; margin: 0 0 8px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4;'>
                            <a href='{$detailUrl}' style='color: inherit; text-decoration: none;'>" . htmlspecialchars($blog['title']) . "</a>
                        </h3>
                        <p class='blog-card-description' style='font-size: 14px; color: #666; margin: 0 0 12px 0; flex-grow: 1;'>
                            " . htmlspecialchars($excerpt) . "
                        </p>
                        <div class='blog-card-meta' style='display: flex; justify-content: space-between; align-items: center; font-size: 12px; color: #999;'>
                            <span>By " . htmlspecialchars($blog['author']) . "</span>
                            <span>" . date('M d, Y', strtotime($blog['publication_date'])) . "</span>
                        </div>
                    </div>
                </div>
            </div>";

    return $html;
}

/**
 * Get blogs by category or all
 *
 * @param string $category Category name or null for all
 * @param int $limit Number of blogs to fetch
 * @param string $status 'published' or null for all
 * @return array Array of blogs
 */
function getBlogs($category = null, $limit = null, $status = 'published') {
    global $pdo;

    $query = "SELECT b.*, c.name as category_name FROM blogs b LEFT JOIN categories c ON b.category_id = c.id WHERE 1=1";
    $params = [];

    if ($status) {
        $query .= " AND b.status = ?";
        $params[] = $status;
    }

    if ($category) {
        $query .= " AND c.name = ?";
        $params[] = $category;
    }

    $query .= " ORDER BY b.publication_date DESC";

    if ($limit) {
        $query .= " LIMIT " . (int)$limit;
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

/**
 * Get blog comments
 *
 * @param int $blog_id Blog ID
 * @param string $status 'approved' or null for all
 * @return array Array of comments
 */
function getBlogComments($blog_id, $status = 'approved') {
    global $pdo;

    $query = "SELECT * FROM blog_comments WHERE blog_id = ?";
    $params = [$blog_id];

    if ($status) {
        $query .= " AND status = ?";
        $params[] = $status;
    }

    $query .= " ORDER BY created_at DESC";

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

/**
 * Check if admin is logged in
 */
function checkAdminLogin() {
    if (!isset($_SESSION['admin_id'])) {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            ob_clean();
            echo json_encode(['success' => false, 'message' => 'Session expired. Please login again.']);
            exit;
        } else {
            header('Location: login.php');
            exit;
        }
    }
}

?>
