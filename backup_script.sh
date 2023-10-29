#!/bin/sh
# MySQL Backup Script

# Directory where you want the backup files to be placed
backupdir="/STORAGE/BACKUPS"

# List all of the MySQL databases that you want to backup in here, 
# each seperated by a space
databases="DBNAME"

# MySQL dump command, use the full path name here
mysqldumpcmd="mysqldump"

# MySQL Username and password
userpassword=" --user=UNAME --password=PASSWORD"

# MySQL dump options
dumpoptions=" --quick --add-drop-table --add-locks --extended-insert --lock-tables"

# Get the current timestamp
TS=`date +%Y%m%d%H%M%S`

# Create our backup directory if not already there
mkdir -p ${backupdir}
if [ ! -d ${backupdir} ] 
then
   echo "Not a directory: ${backupdir}"
   exit 1
fi

# Dump all of our databases
echo "Dumping MySQL Databases"
for database in $databases
do
   $mysqldumpcmd $userpassword $dumpoptions $database > ${backupdir}/${TS}-${database}.sql
done


# CRONTAB example
# Every Day, Every Hour, 

# 0 * * * * /ANY_PATH/backup_script.sh > /var/log/daily-backup.log 2>&1
