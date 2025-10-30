#!/bin/sh

pseudo=$1
ip=$2

#ajout de zone dans /etc/bind/named.conf.local
echo "
zone \"$pseudo.itinet.local {
	type master;
	file \"/etc/bind/user_zone/$pseudo\";
};" >> /etc/bind/named.conf.local

#ajout de zone dans /etc/bind/user_zone
echo "$TTL    604800
@       IN      SOA     ns1.itinet.local. root.itinet.local. (
                              1         ; Serial
                         604800         ; Refresh
                          86400         ; Retry
                        2419200         ; Expire
                         604800 )       ; Negative Cache TTL
;
@       IN      NS      ns1.itinet.local.
ns1     IN      A       192.168.0.12" >> /etc/bind/user_zone/$pseudo
