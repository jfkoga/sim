#!/bin/sh

#echo "APP_ENV: $APP_ENV"

#if [ "$APP_ENV_CM" = "dev" ]; then
	sed -i '/^APP_KEY=/s/=.*/='"$APP_KEY_CM"'/' .env
#elif [ "$APP_ENV_CM" = "pre" ]; then
#  	sed '/^APP_KEY=/s/=.*/='"$APP_KEY_CM"'/' .env
#else
#fi
