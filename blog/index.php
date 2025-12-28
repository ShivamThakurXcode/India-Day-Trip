<?php
require_once '../config.php';
require_once '../functions.php';

// Get all published blogs
$blogs = getBlogs(null, null, 'published');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - India Day Trip</title>
    <?php include '../components/links.php'; ?>
</head>
<body>
    <?php include '../components/header.php'; ?>

    <!-- Breadcrumb -->
    <div class="breadcrumb-area" style="background-image: url('../assets/img/bg/breadcumb-bg.webp');">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <h1>Blog</h1>
                        <ul>
                            <li><a href="../index.php">Home</a></li>
                            <li>Blog</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blog Area -->
    <div class="blog-area pt-120 pb-120">
        <div class="container">
            <div class="row">
                <?php if (empty($blogs)): ?>
                    <div class="col-12">
                        <p>No blog posts available yet.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($blogs as $blog): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="blog-card">
                                <?php if ($blog['featured_image']): ?>
                                    <div class="blog-card-image">
                                        <img src="../assets/img/blog/<?php echo htmlspecialchars($blog['featured_image']); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
                                    </div>
                                <?php endif; ?>
                                <div class="blog-card-content">
                                    <h3><a href="blog/<?php echo htmlspecialchars($blog['slug']); ?>"><?php echo htmlspecialchars($blog['title']); ?></a></h3>
                                    <div class="blog-meta">
                                        <span>By <?php echo htmlspecialchars($blog['author']); ?></span>
                                        <span><?php echo date('M d, Y', strtotime($blog['publication_date'])); ?></span>
                                    </div>
                                    <p><?php echo htmlspecialchars($blog['excerpt'] ?: substr(strip_tags($blog['content']), 0, 150) . '...'); ?></p>
                                    <a href="blog/<?php echo htmlspecialchars($blog['slug']); ?>" class="read-more">Read More</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include '../components/footer.php'; ?>
    <?php include '../components/script.php'; ?>
</body>
</html>