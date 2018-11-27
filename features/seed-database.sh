#!/bin/sh

alias wp="wp --allow-root"

wp db reset --yes

wp core install --url=hmctskm.docker --title="HMCTS KM" --admin_user=admin --admin_password=password --admin_email=admin@example.com --skip-email
wp user create subscriber subscriber@example.com --role=subscriber --user_pass=password
wp option update timezone_string "Europe/London"
wp rewrite structure "/%postname%/"
wp plugin activate --all

PAGE_ID=$(wp post create --post_type=page --post_title="Knowledge article page" --post_name="knowledge-article-page" --post_status=publish --post_content="Page dummy content" --porcelain)
PAGE2_ID=$(wp post create --post_type=page --post_title="Knowledge article page two" --post_name="knowledge-article-page-two" --post_status=publish --porcelain)
wp post create --post_type=post --post_title="Knowledge article post" --post_name="knowledge-article-post" --post_status=publish --post_content="Post dummy content."
wp menu create "Lefthand main menu"
wp menu location assign "Lefthand main menu" primary_navigation
wp menu item add-post "Lefthand main menu" $PAGE_ID
wp menu item add-post "Lefthand main menu" $PAGE2_ID
