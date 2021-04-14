#!/bin/sh

uid=$(stat -c %u /srv)
gid=$(stat -c %g /srv)

: ${XDEBUG:=0}
: ${RED:='\033[0;31m'}
: ${GREEN:='\033[0;32m'}
: ${NOCOLOR:='\033[0m'}

if [[ ${uid} == 0 ]] && [[ ${gid} == 0 ]]; then
    if [[ $# -eq 0 ]]; then
        php-fpm --allow-to-run-as-root
    else
        echo "$@"
        exec "$@"
    fi
fi

sed -i -r "s/foo:x:\d+:\d+:/foo:x:$uid:$gid:/g" /etc/passwd
sed -i -r "s/bar:x:\d+:/bar:x:$gid:/g" /etc/group

sed -i "s/user = www-data/user = foo/g" /usr/local/etc/php-fpm.d/www.conf
sed -i "s/group = www-data/group = bar/g" /usr/local/etc/php-fpm.d/www.conf

user=$(grep ":x:$uid:" /etc/passwd | cut -d: -f1)
if [[ $# -eq 0 ]]; then
    php-fpm
else

    if [[ ! ${XDEBUG} = 1 ]]; then
        echo -e "[${RED}xdebug is disabled${NOCOLOR}]"
        rm -f /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
    else
        echo -e "[${GREEN}xdebug is enabled${NOCOLOR}]"
    fi

    echo gosu ${user} "$@"
    exec gosu ${user} "$@"
fi
