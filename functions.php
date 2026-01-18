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
 * @return string HTML for the tour card
 */
function renderTourCard($tour) {
    $imagePath = $tour['images'] ? json_decode($tour['images'], true)[0] : 'taj_mahal_tour/taj_mahal-1.webp';
    $imageUrl = "assets/img/{$imagePath}";
    $detailUrl = "tours/{$tour['slug']}";
    $rating = number_format($tour['rating'], 1);
    $ratingPercent = $tour['rating'] * 20; // For width percentage, assuming 5 stars = 100%

    $titleParts = explode(' ', $tour['title']);
    $dataType = strtolower($titleParts[0] . '-' . $titleParts[1]);
    $dataLocation = strtolower(str_replace(' - ', ' ', $tour['location']));
    $dataDuration = htmlspecialchars($tour['duration']);
    $displayLocation = htmlspecialchars($tour['location']) . ' - Delhi';
    $displayDuration = htmlspecialchars($tour['duration']) . ' Day';
    $altText = ' Discover the Majestic ' . $titleParts[0] . ' ' . $titleParts[1];

    $html = '<div class="tour-box th-ani gsap-cursor" data-type="' . $dataType . '" data-location="' . $dataLocation . '" data-duration="' . $dataDuration . '">
                                            <div class="tour-box_img global-img">
                                                <img src="' . $imageUrl . '" alt="' . $altText . '">
                                            </div>
                                            <div class="tour-content">
                                                <h3 class="box-title">
                                                    <a href="' . $detailUrl . '">' . htmlspecialchars($tour['title']) . '</a>
                                                </h3>
                                                <div class="tour-rating">
                                                    <div class="star-rating" role="img" aria-label="Rated ' . $rating . ' out of 5">
                                                        <span style="width: ' . $ratingPercent . '%">Rated <strong class="rating">' . $rating . '</strong> out of 5</span>
                                                    </div>
                                                    <a href="#" class="woocommerce-review-link">(' . rand(50, 200) . '+ Reviews)</a>
                                                </div>
                                                <h4 class="tour-box_price">
                                                    <span class="currency"> <i class="fas fa-location"></i> ' . $displayLocation . '</span>
                                                </h4>
                                                <div class="tour-action">
                                                    <span><i class="fa-light fa-clock"></i>' . $displayDuration . '</span>
                                                    <a href="' . $detailUrl . '" class="th-btn text-nowrap style4 th-icon">Read More</a>
                                                </div>
                                            </div>
                                        </div>';

    return $html;
}

/**
 * Get tours by category
 *
 * @param string $category Category name or null for all
 * @param int $limit Number of tours to fetch
 * @param int $exclude_id Tour ID to exclude
 * @param string $search Search term
 * @param string $orderby Sort order
 * @return array Array of tours
 */
function getTours($category = null, $limit = null, $exclude_id = null, $search = null, $orderby = null, $location = null, $duration = null, $price_min = null, $price_max = null, $rating = null) {
    global $pdo;

    $query = "SELECT t.*, c.name as category_name FROM tours t LEFT JOIN categories c ON t.category_id = c.id WHERE 1=1";
    $params = [];

    if ($category) {
        $query .= " AND c.name = ?";
        $params[] = $category;
    }

    if ($exclude_id) {
        $query .= " AND t.id != ?";
        $params[] = $exclude_id;
    }

    if ($search) {
        $query .= " AND (t.title LIKE ? OR t.description LIKE ?)";
        $params[] = '%' . $search . '%';
        $params[] = '%' . $search . '%';
    }

    if ($location) {
        $query .= " AND t.location = ?";
        $params[] = $location;
    }

    if ($duration) {
        $query .= " AND t.duration LIKE ?";
        $params[] = '%' . $duration . '%';
    }

    if ($price_min !== null) {
        $query .= " AND t.pricing >= ?";
        $params[] = $price_min;
    }

    if ($price_max !== null) {
        $query .= " AND t.pricing <= ?";
        $params[] = $price_max;
    }

    if ($rating) {
        $query .= " AND t.rating >= ?";
        $params[] = $rating;
    }

    $orderClause = " ORDER BY t.created_at DESC";
    if ($orderby) {
        switch ($orderby) {
            case 'popularity':
                $orderClause = " ORDER BY t.rating DESC";
                break;
            case 'rating':
                $orderClause = " ORDER BY t.rating DESC";
                break;
            case 'date':
                $orderClause = " ORDER BY t.created_at DESC";
                break;
            case 'price':
                $orderClause = " ORDER BY t.pricing ASC";
                break;
            case 'price-desc':
                $orderClause = " ORDER BY t.pricing DESC";
                break;
            default:
                $orderClause = " ORDER BY t.created_at DESC";
        }
    }
    $query .= $orderClause;

    if ($limit) {
        $query .= " LIMIT " . (int)$limit;
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

/**
 * Render a tour box (specific style)
 *
 * @param array $tour Tour data from database
 * @return string HTML for the tour box
 */
function renderTourBox($tour) {
    $imagePath = $tour['images'] ? json_decode($tour['images'], true)[0] : 'default.webp';
    $imageUrl = "assets/img/{$imagePath}";
    $detailUrl = "tours/{$tour['slug']}";
    $rating = number_format($tour['rating'], 1);
    $ratingPercent = $tour['rating'] * 20; // For width percentage

    $html = '<div class="tour-box th-ani gsap-cursor" data-type="' . htmlspecialchars(strtolower(str_replace(' ', '-', $tour['title']))) . '" data-location="' . htmlspecialchars($tour['location']) . '" data-duration="' . htmlspecialchars($tour['duration']) . '">
                                            <div class="tour-box_img global-img">
                                                <img src="' . $imageUrl . '" alt=" Discover the Majestic ' . htmlspecialchars($tour['title']) . '">
                                            </div>
                                            <div class="tour-content">
                                                <h3 class="box-title">
                                                    <a href="' . $detailUrl . '">' . htmlspecialchars($tour['title']) . '</a>
                                                </h3>
                                                <div class="tour-rating">
                                                    <div class="star-rating" role="img" aria-label="Rated ' . $rating . ' out of 5">
                                                        <span style="width: ' . $ratingPercent . '%">Rated <strong class="rating">' . $rating . '</strong> out of 5</span>
                                                    </div>
                                                    <a href="#" class="woocommerce-review-link">(' . rand(50, 200) . '+ Reviews)</a>
                                                </div>
                                                <h4 class="tour-box_price">
                                                    <span class="currency"> <i class="fas fa-location"></i> ' . htmlspecialchars($tour['location']) . '</span>
                                                </h4>
                                                <div class="tour-action">
                                                    <span><i class="fa-light fa-clock"></i>' . htmlspecialchars($tour['duration']) . '</span>
                                                    <a href="' . $detailUrl . '" class="th-btn text-nowrap style4 th-icon">Read More</a>
                                                </div>
                                            </div>
                                        </div>';

    return $html;
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
