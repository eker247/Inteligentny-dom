#!/bin/bash

while [ true ] ; do
pir=$(gpio -1 read 12)
if [ $pir == 1 ] ; then
	gpio -1 write 11 1;
	sleep 60;
else
	gpio -1 write 11 0;
fi;

done;


