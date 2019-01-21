#!/bin/bash

mysqldump -p ct > /root/ct-backup.sql
chmod 600 /root/ct-backup.sql
tar cfJ /root/ct-backup.sql.tar.xz /root/ct-backup.sql
chmod 600 /root/ct-backup.sql.tar.xz
rm /root/ct-backup.sql
