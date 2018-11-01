#!/bin/sh

alias wp="wp --allow-root"

wp db reset --yes
wp core install --url=imbmembers.docker --title="IMB Members" --admin_user=admin --admin_password=password --admin_email=admin@example.com --skip-email
wp user create subscriber subscriber@example.com --role=subscriber --user_pass=password
wp option update timezone_string "Europe/London"
wp rewrite structure "/%year%/%monthnum%/%postname%/"
wp plugin activate --all
PAGE_ID=$(wp post create --post_type=page --post_title="Change My Password" --post_name="change-password" --post_status=publish --porcelain)
wp post meta update $PAGE_ID "_wp_page_template" "change-password.php"
