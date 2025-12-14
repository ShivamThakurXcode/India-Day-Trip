<?php get_header(); ?>

<div class="breadcumb-wrapper" data-bg-src="<?php echo get_template_directory_uri(); ?>/assets/img/bg/breadcumb-bg.jpg">
    <div class="container">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title"><?php the_title(); ?></h1>
            <ul class="breadcumb-menu">
                <li><a href="<?php echo home_url(); ?>">Home</a></li>
                <li><?php the_title(); ?></li>
            </ul>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="content">
                <?php
                while (have_posts()) :
                    the_post();
                    the_content();
                endwhile;
                ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>