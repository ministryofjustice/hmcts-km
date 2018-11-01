<article <?php post_class('entry entry--in-list'); ?>>
  <div class="entry-wrapper clearfix">
    <header>
      <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php

        if (get_post_type() == 'page') {
            get_template_part('templates/page-meta');
        } else {
            get_template_part('templates/entry-meta');
        }

        ?>
    </header>
    <?php if (has_post_thumbnail()) : ?>
      <a href="<?php the_permalink(); ?>">
        <?php the_post_thumbnail('thumbnail', array('class' => 'entry-thumbnail')); ?>
      </a>
    <?php endif; ?>
    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div>
  </div>
</article>
