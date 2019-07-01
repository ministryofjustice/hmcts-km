<?php
/**
 * Template Name: Landing Page
 */
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">

            <?php
            while ( have_posts() ) :
                the_post();
            ?>


            <article <?php post_class( 'entry' ); ?>>
                <div class="entry-wrapper">
                    <header>
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header>
                    <div class="entry-content">
                      <?php the_content(); ?>
                    </div>
                </div>
            </article>


                <?php
                $categories = get_field('post_list_categories');

                if(is_array($categories)) {

                    $articles = new WP_Query(
                        array(
                            'post_type' => 'post',
                            'posts_per_page' => -1,
                            'post_status' => 'publish',
                            'category__in' => $categories
                        )
                    );

                    while ($articles->have_posts()) {
                        $articles->the_post();

                        get_template_part('templates/content', 'excerpt');
                    }
                    wp_reset_postdata();
                }

            endwhile;
            ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php


