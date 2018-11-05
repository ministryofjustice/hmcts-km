<?php if (has_nav_menu('quick_links')) : ?>
<div class="quick-links well">
  <div class="quick-links-label">Quick links</div>
    <?php

    wp_nav_menu(array(
    'theme_location' => 'quick_links',
    'walker'         => new \Roots\Sage\Nav\Walkers\ButtonNavWalker(),
    'container'      => false,
    'items_wrap'     => '%3$s',
    ));

    ?>
</div>

<?php endif; ?>
