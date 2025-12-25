<?php
if (!isset($blog)) {
    header('Location: index.php');
    exit;
}
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo htmlspecialchars($blog['title']); ?> - India Day Trip Blog</title>
    <meta name="author" content="India Day Trip">
    <meta name="description" content="<?php echo htmlspecialchars(substr(strip_tags($blog['content']), 0, 160)); ?>">
    <meta name="keywords" content="India Day Trip, Blog, <?php echo htmlspecialchars($blog['title']); ?>">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="https://indiadaytrip.com/blog/<?php echo $blog['slug']; ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($blog['title']); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars(substr(strip_tags($blog['content']), 0, 160)); ?>">
    <?php if ($blog['featured_image']): ?>
        <meta property="og:image" content="https://indiadaytrip.com/assets/img/blogs/<?php echo $blog['featured_image']; ?>">
    <?php endif; ?>

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://indiadaytrip.com/blog/<?php echo $blog['slug']; ?>">
    <meta property="twitter:title" content="<?php echo htmlspecialchars($blog['title']); ?>">
    <meta property="twitter:description" content="<?php echo htmlspecialchars(substr(strip_tags($blog['content']), 0, 160)); ?>">
    <?php if ($blog['featured_image']): ?>
        <meta property="twitter:image" content="https://indiadaytrip.com/assets/img/blogs/<?php echo $blog['featured_image']; ?>">
    <?php endif; ?>

    <?php include 'components/links.php'; ?>
</head>

<body>
    <?php include 'components/preloader.php'; ?>
    <?php include 'components/sidebar.php'; ?>

    <?php include 'components/header.php'; ?>

    <!-- Blog Detail Section -->
    <section class="space-top space-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <article class="blog-post">
                        <?php if ($blog['featured_image']): ?>
                            <div class="blog-featured-image">
                                <img src="assets/img/blogs/<?php echo $blog['featured_image']; ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>" class="img-fluid">
                            </div>
                        <?php endif; ?>

                        <header class="blog-header">
                            <h1 class="blog-title"><?php echo htmlspecialchars($blog['title']); ?></h1>

                            <div class="blog-meta">
                                <span class="author"><i class="fas fa-user"></i> <?php echo htmlspecialchars($blog['author']); ?></span>
                                <span class="date"><i class="fas fa-calendar"></i> <?php echo date('F j, Y', strtotime($blog['publication_date'])); ?></span>
                                <span class="views"><i class="fas fa-eye"></i> <?php echo $blog['view_count']; ?> views</span>
                            </div>
                        </header>

                        <div class="blog-content">
                            <?php echo $blog['content']; ?>
                        </div>

                        <?php if ($blog['tags']): ?>
                            <div class="blog-tags">
                                <h4>Tags:</h4>
                                <?php
                                $tags = json_decode($blog['tags'], true);
                                foreach ($tags as $tag): ?>
                                    <span class="tag"><?php echo htmlspecialchars($tag); ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($blog['categories']): ?>
                            <div class="blog-categories">
                                <h4>Categories:</h4>
                                <?php
                                $categories = json_decode($blog['categories'], true);
                                foreach ($categories as $category): ?>
                                    <span class="category"><?php echo htmlspecialchars($category); ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </article>
                </div>

                <div class="col-lg-4">
                    <div class="blog-sidebar">
                        <div class="author-info">
                            <h4>About the Author</h4>
                            <p><strong><?php echo htmlspecialchars($blog['author']); ?></strong></p>
                            <p>Travel enthusiast and content creator at India Day Trip.</p>
                        </div>

                        <div class="recent-posts">
                            <h4>Recent Posts</h4>
                            <?php
                            $stmt = $pdo->query("SELECT title, slug FROM blogs WHERE id != {$blog['id']} ORDER BY created_at DESC LIMIT 5");
                            while ($recent = $stmt->fetch()): ?>
                                <div class="recent-post-item">
                                    <a href="blog/<?php echo $recent['slug']; ?>"><?php echo htmlspecialchars($recent['title']); ?></a>
                                </div>
                            <?php endwhile; ?>
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