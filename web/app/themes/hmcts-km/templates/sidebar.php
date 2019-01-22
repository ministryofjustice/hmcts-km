<?php

use Roots\Sage\ChangePassword;

$changePassword = ChangePassword\get_page();
$user = wp_get_current_user();

?>

<div class="search hidden-md hidden-lg hidden-sm">
    <?php get_template_part('templates/searchform'); ?>
</div>
<nav class="widget widget_menu">
    <?php

    if (has_nav_menu('primary_navigation')) {
        wp_nav_menu(array(
        'theme_location' => 'primary_navigation',
        'walker'         => new \Roots\Sage\Nav\Walkers\TreeNavWalker(),
        ));
    }

    ?>
</nav>
<hr class="hidden-md hidden-lg hidden-sm">
<div class="widget widget_logout hidden-md hidden-lg hidden-sm">
    <a href="<?= wp_logout_url() ?>" class="btn btn-block btn-link"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout</a>
</div>
