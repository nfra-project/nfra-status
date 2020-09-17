#!/bin/bash

## Scan the container for security updates

set -e

origSource="$(cat /etc/apt/sources.list)"

echo  "$origSource" | grep security > /etc/apt/sources.list

apt-get update > /dev/null
list=$(apt-get --simulate upgrade | grep -e ^Inst | awk '{print $2}')
for pkgName in $list
do
    text="$(apt-get -qq changelog $pkgName)"
    text=$(echo "$text" | grep -Pzo '(?s)^.*?--.*?\n' | tr -d '\0')

    printf "%s %q\n" $pkgName "$text"
done;

echo "$origSource" > /etc/apt/sources.list

[[ $list="" ]] && echo "OK"