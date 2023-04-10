#!/bin/sh

echo "APP_ENV: $APP_ENV"

if [ "$APP_ENV" = "dev" ]; then
   echo "Launching DEV" 
elif [ "$APP_ENV" = "docker" ]; then
    echo "Launching PRE"
else
   echo "Launching PRO"
fi
