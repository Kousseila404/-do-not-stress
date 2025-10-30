#!/bin/sh

zone=$1

#suppression zone dans /etc/bind/named.conf.local
suppr=$(grep -n -m1 "$zone" /etc/bind/named.conf.local | cut -d":" -f1)
rate=$(($suppr + 3))

echo $(sed -i $suppr,$rate'd' /etc/bind/named.conf.local)

#suppression de zones dans /etc/bind
echo $(rm /etc/bind/user_zone/$zone)
