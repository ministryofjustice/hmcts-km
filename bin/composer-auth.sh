#!/bin/bash

# Create composer auth file
if [ ! -z $COMPOSER_USER ] && [ ! -z $COMPOSER_PASS ]
then
	cat <<- EOF >> auth.json
		{
			"http-basic": {
				"composer.wp.dsd.io": {
					"username": "$COMPOSER_USER",
					"password": "$COMPOSER_PASS"
				}
			}
		}
	EOF
fi
