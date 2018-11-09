<?php
global $post;
$values = get_post_custom( $post->ID );
$text = isset( $values['meta_box_text'] ) ? $values['meta_box_text'] : '';
?>

<article <?php post_class('entry'); ?>>
  <div class="entry-wrapper">
    <header>
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <?php get_template_part('templates/entry-meta'); ?>
    </header>
    <div class="entry-content">
        <?php the_content(); ?>
    </div>
    <div class="entry-content">
        <?php echo $text[0]; ?>
    </div>
    <footer>
        <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
    </footer>
  </div>
</article>
