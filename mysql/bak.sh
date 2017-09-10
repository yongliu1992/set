#!/bin/bash

backupdir=/cron
time=` date +%Y%m%d%H `
/yourpath/mysqldump -u yourusername -pyourpassword yourdbname | gzip > $backupdir/name1$time.sql.gz

#
find $backupdir -name "name_*.sql.gz" -type f -mtime +5 -exec rm {} \; > /dev/null 2>&1