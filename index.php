<?php

if (is_front_page()) {
    get_template_part('templates/quick-links');
}

get_template_part('templates/page-header');

?>

<?php if (!have_posts()) : ?>
  <div class="entry">
    <div class="alert alert-warning">
      <?php _e('Sorry, no results were found.', 'sage'); ?>
    </div>
  </div>
<?php endif; ?>

<?php

while (have_posts()) {
    the_post();
    get_template_part('templates/content-excerpt');
}
