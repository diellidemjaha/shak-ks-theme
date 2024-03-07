<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
        while (have_posts()) :
            the_post();
        ?>
            <div class="container bg-light d-flex flex-column">

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="container text-light mt-2 p-3">
                  <div class="fs-1" style="color:black; text-decoration:none;"  <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                    <div class="entry-meta">
                        <?php
                        echo 'Published on ' . get_the_date();
                        ?>
                    </div>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <?php the_content(); ?>
                </div><!-- .entry-content -->
                
                <footer class="entry-footer">
                    <?php edit_post_link('Edit', '<span class="edit-link">', '</span>'); ?>
            </article><!-- #post-<?php the_ID(); ?> -->
            
            <?php
        endwhile; // End of the loop.
        ?>
    </main><!-- #main -->
</div><!-- #primary -->
</div>

<?php get_footer(); ?>
