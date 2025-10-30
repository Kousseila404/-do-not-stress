#!/bin/sh
#fonction pour ajouter des enregistrements

alias=$1
addr=$2
hostname=$3

res_part=$(echo $addr | cut -d"." -f-3)
host_part=$(echo $addr | cut -d"." -f4)
serial=$(grep "; Serial" /etc/bind/user_zone/$hostname | cut -d" " -f8)

#partie itinet
echo "$alias	IN	A	$addr" >> /etc/bind/user_zone/$hostname

remp=$(expr $serial + 1)

echo $(grep "; Serial" /etc/bind/user_zone/$hostname | cut -d" " -f8 | sed -i "s/$serial/$remp/g" /etc/bind/user_zone/$hostname)
