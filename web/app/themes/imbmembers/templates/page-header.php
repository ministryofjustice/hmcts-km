<?php use Roots\Sage\Titles; ?>

<h1 class="page-header">
    <?= Titles\title(); ?>
    <?php if (is_archive() || is_search()) : ?>
    <small><?php echo sprintf(_n('%d post', '%d posts', $wp_query->post_count), $wp_query->post_count); ?></small>
    <?php endif; ?>
</h1>
