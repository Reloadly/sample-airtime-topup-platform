#!/bin/bash

# welcome message
cat /etc/motd

# Update application user id and group id
if [ "$APPLICATION_USER_ID" = "auto" ]
then
    export APPLICATION_USER_ID="$(stat -c '%u' "$APP_ROOT")"
    if [ "$APPLICATION_USER_ID" = "0" ] # workaround for parallels prl_fs (which will always report current user id as owner): fallback to default user id 1000
    then
        export APPLICATION_USER_ID="1000"
    fi
fi
if [ "$APPLICATION_GROUP_ID" = "auto" ]
then
    export APPLICATION_GROUP_ID="$(stat -c '%g' "$APP_ROOT")"
    if [ "$APPLICATION_GROUP_ID" = "0" ] # workaround for parallels prl_fs (which will always report current user id as owner): fallback to default group id 1000
    then
        export APPLICATION_GROUP_ID="1000"
    fi
fi
groupadd -g $APPLICATION_GROUP_ID $APPLICATION_GROUP || true
useradd -m -s /bin/bash -u $APPLICATION_USER_ID -g $APPLICATION_GROUP $APPLICATION_USER || true
usermod -u $APPLICATION_USER_ID $APPLICATION_USER
groupmod -g $APPLICATION_GROUP_ID $APPLICATION_GROUP
chown -R $APPLICATION_USER_ID:$APPLICATION_GROUP_ID /home/$APPLICATION_USER

# Get environment variables to show up in SSH session
eval $(printenv | grep -v -e '^PWD\|^OLDPWD\|^HOME\|^USER\|^TERM' | awk -F= '{print "export " $1"=\""$2"\"" }' > /etc/profile.d/dockerenv.sh)

# Start ssh
service ssh start

# Run post deployment script
if [ "$POST_DEPLOYMENT_SCRIPT" != "" ]; then
    if [ -e "$POST_DEPLOYMENT_SCRIPT" ]; then
        echo "Running POST_DEPLOYMENT_SCRIPT: $POST_DEPLOYMENT_SCRIPT ..."
        echo "(errors will be ignored to avoid failing container startup)"
        bash $POST_DEPLOYMENT_SCRIPT || true
    else
        echo "No POST_DEPLOYMENT_SCRIPT found under path: $POST_DEPLOYMENT_SCRIPT"
    fi
else
    echo "No POST_DEPLOYMENT_SCRIPT defined"
fi

# Start webserver
mkdir -p /var/lock/apache2
mkdir -p /var/run/apache2
mkdir -p /var/log/apache2
/usr/sbin/apache2ctl -D FOREGROUND
