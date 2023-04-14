#!/bin/sh

echo "APP_KEY: $APP_KEY_CM"

sed -i '/^APP_ENV=/s/=.*/='"$APP_ENV_CM"'/' .env
sed -i '/^APP_KEY=/s/=.*/='"$APP_KEY_CM"'/' .env
sed -i '/^APP_DEBUG=/s/=.*/='"$APP_DEBUG_CM"'/' .env
sed -i '/^APP_URL=/s|=.*|='"$APP_URL_CM"'|' .env
sed -i '/^DB_CONNECTION=/s/=.*/='"$DB_CONNECTION_CM"'/' .env
sed -i '/^DB_HOST=/s/=.*/='"$DB_HOST_CM"'/' .env
sed -i '/^DB_PORT=/s/=.*/='"$DB_PORT_CM"'/' .env
sed -i '/^DB_DATABASE=/s/=.*/='"$DB_DATABASE_CM"'/' .env
sed -i '/^DB_USERNAME=/s/=.*/='"$DB_USERNAME_CM"'/' .env
sed -i '/^DB_PASSWORD=/s/=.*/='"$DB_PASSWORD_CM"'/' .env

php artisan migrate

/usr/sbin/apache2ctl -D FOREGROUND;
