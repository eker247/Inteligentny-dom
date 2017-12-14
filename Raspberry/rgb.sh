#!/bin/bash

# LED's pins
R=37
G=31
B=29

vR=$1
vG=$2
vB=$3

gpio -1 mode $R out
gpio -1 mode $G out
gpio -1 mode $B out

gpio -1 write $R $vR
gpio -1 write $G $vG
gpio -1 write $B $vB
