#!/bin/bash
# Clear symfony dev cache and apply new chmod
sudo php app/console cache:clear --env=dev

sudo chmod -R 777 app/cache app/logs
echo chmod in app/cache -> Ok

sudo chmod -R 777 /var/lib/php5
echo chmod in /var/lib/php5 -> Ok

exit 0