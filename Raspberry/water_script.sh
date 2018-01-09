#!/bin/bash

gpio -1 mode 40 out

while [ true ]; do
    stat=$(gpio -1 read 40);
    if [ $stat -eq 1 ]; then
        echo 'OFF' > /home/pi/Desktop/Przyklad/water_status.txt
		/home/pi/Desktop/Przyklad/servo.sh 32 0
    fi
    sleep 3;
done;