#!/bin/sh
chmod -R 707 *
rsync -auvz --delete --exclude 'app/Config/core.php' --exclude '*.wav' --exclude '.DS_store' --exclude='app/tmp/*' . root@noumenon.jp:/var/www/roudoku/
