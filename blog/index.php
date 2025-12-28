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
    <div class="breadcumb-wrapper" data-bg-src="../assets/img/bg/breadcumb-bg.webp">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Blog</h1>
                <ul class="breadcumb-menu">
                    <li><a href="../index.php">Home</a></li>
                    <li>Blog</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Blog Area -->
    <section class="space">
        <div class="container">
            <div class="row">
                <?php 
                require_once '../config.php';
                require_once '../functions.php';
                
                // Get all published blogs
                $blogs = getBlogs(null, null, 'published');
                
                if (empty($blogs)): ?>
                    <div class="col-12">
                        <p class="text-center">No blog posts available yet.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($blogs as $blog): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="blog-card">
                                <?php if ($blog['featured_image']): ?>
                                    <div class="blog-card-image">
                                        <img src="../assets/img/blog/<?php echo htmlspecialchars($blog['featured_image']); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>" class="w-100">
                                    </div>
                                <?php endif; ?>
                                <div class="blog-card-content">
                                    <h3 class="blog-title">
                                        <a href="blog/<?php echo htmlspecialchars($blog['slug']); ?>"><?php echo htmlspecialchars($blog['title']); ?></a>
                                    </h3>
                                    <div class="blog-meta">
                                        <span class="blog-author">By <?php echo htmlspecialchars($blog['author']); ?></span>
                                        <span class="blog-date"><?php echo date('M d, Y', strtotime($blog['publication_date'])); ?></span>
                                    </div>
                                    <p class="blog-excerpt"><?php echo htmlspecialchars($blog['excerpt'] ?: substr(strip_tags($blog['content']), 0, 150) . '...'); ?></p>
                                    <a href="blog/<?php echo htmlspecialchars($blog['slug']); ?>" class="th-btn style3 th-icon">Read More</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include '../components/footer.php'; ?>
    <?php include '../components/script.php'; ?>
</body>
</html>