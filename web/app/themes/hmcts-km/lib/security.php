<?php

# Restrict access to particular paths. Block /?author= access allowing the attacker to get usernames.

add_action('template_redirect', 'author_page_redirect');

function author_page_redirect()
{
    if (is_author()) {
        wp_redirect(home_url());
    }
}
