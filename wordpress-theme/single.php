<?php get_header(); ?>

<div class="breadcumb-wrapper" data-bg-src="<?php echo get_template_directory_uri(); ?>/assets/img/bg/breadcumb-bg.jpg">
    <div class="container">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title"><?php the_title(); ?></h1>
            <ul class="breadcumb-menu">
                <li><a href="<?php echo home_url(); ?>">Home</a></li>
                <li><a href="<?php echo get_permalink(get_page_by_path('blog')); ?>">Blog</a></li>
                <li><?php the_title(); ?></li>
            </ul>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <article class="blog-post">
                <?php
                while (have_posts()) :
                    the_post();
                ?>
                    <div class="blog-img global-img mb-4">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                    <div class="blog-meta mb-3">
                        <span class="author">By <?php the_author(); ?> | </span>
                        <span><?php echo get_the_date(); ?> | </span>
                        <span><?php echo get_post_meta(get_the_ID(), 'read_time', true) ?: '5 min read'; ?></span>
                    </div>
                    <h1 class="blog-title mb-4"><?php the_title(); ?></h1>
                    <div class="blog-content">
                        <?php the_content(); ?>
                    </div>
                <?php endwhile; ?>
            </article>
        </div>
        <div class="col-lg-4">
            <div class="sidebar">
                <div class="widget">
                    <h3 class="widget-title">Recent Posts</h3>
                    <ul>
                        <?php
                        $recent_posts = wp_get_recent_posts(array('numberposts' => 5, 'post_status' => 'publish'));
                        foreach ($recent_posts as $post) :
                        ?>
                            <li><a href="<?php echo get_permalink($post['ID']); ?>"><?php echo $post['post_title']; ?></a></li>
                        <?php endforeach;
                        wp_reset_postdata(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>