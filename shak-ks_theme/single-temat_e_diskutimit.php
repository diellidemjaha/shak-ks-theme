<?php
get_header();
?>
<!-- <div class="container bg-light"> -->

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
        <div class="container bg-light">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header text-light m-0">
                        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                        <div class="entry-meta">
                            <?php echo 'Published on ' . get_the_date(); ?>
                        </div>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <?php
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('full', array('class' => 'img-fluid'));
                        }
                        the_content();
                        ?>
                    </div><!-- .entry-content -->
                    
                    <footer class="entry-footer">
                        <?php edit_post_link('Edit', '<span class="edit-link">', '</span>'); ?>
                    </footer><!-- .entry-footer -->
                </article><!-- #post-<?php the_ID(); ?> -->
                
                <!-- Comments Section -->
                <div class="comments-section">
                    <?php comments_template('/comments.php'); ?>
                </div>
                <?php endwhile; ?>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<!-- </div> -->

<?php get_footer(); ?>
