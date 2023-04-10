<VirtualHost *:1080>
        ServerName simtest-app-suport-tecdigitals-dev.apps.sandbox-m2.ll9k.p1.openshiftapps.com
        ServerAdmin suport.tecdigitals@ticxcat.cat
        DocumentRoot /var/www/html/public
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

