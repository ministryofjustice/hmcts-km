<?php

use Roots\Sage\ChangePassword;

$changePassword = ChangePassword\get_page();
$user = wp_get_current_user();

?>

<header class="banner navbar navbar-default navbar-fixed-top" role="banner">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="sidebar-toggle menu-toggle">
                <div class="menu-toggle__hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="menu-toggle__cross">
                    <span></span>
                    <span></span>
                </div>
            </button>
            <a class="navbar-brand" href="<?= esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
        </div>

        <nav class="collapse navbar-collapse" role="navigation">
            <div class="navbar-form navbar-right">
                <?php get_template_part('templates/searchform'); ?>
            </div>
        </nav>
    </div>
</header>
