#!/bin/sh
#fonction pour supprimer des enregistrements dans les fichiers de zone

zone=$1
spr=$2
serial=$(grep "; Serial" /etc/bind/user_zone/$zone | cut -d" " -f8)
nada=""

if [ $(grep -c "$spr" /etc/bind/user_zone/$zone) = 0 ];
	then
		echo "Il n'y a aucun enregistrements à supprimer."
	else
		#Suppression enregistrement dans /etc/bind/user_zone
		ligne=$(grep -n -m 1 "$spr" /etc/bind/user_zone/$zone | cut -d":" -f1)
		int=$(($ligne + 2))
		echo $(sed -i $ligne,$int'd' /etc/bind/user_zone/$zone)

		#Incrémentation de Serial
		remp=$(expr $serial + 1)

		echo $(grep "; Serial" /etc/bind/user_zone/$zone | cut -d" " -f8 | sed -i "s/$serial/$remp/g" /etc/bind/user_zone/$zone)
fi
