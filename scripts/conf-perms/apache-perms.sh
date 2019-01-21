#!/bin/bash

chown -R root /var/www/example.com
chgrp -R apache /var/www/example.com
chmod -R 750 /var/www/example.com
#chmod -R g-s /var/www/example.com
chmod g+s /var/www/example.com
