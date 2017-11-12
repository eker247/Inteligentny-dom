#!/usr/bin/python

import RPi.GPIO as GPIO
import time
import sys

# logs("start")

GPIO.setmode(GPIO.BCM)
GPIO.setup(3, GPIO.OUT)
GPIO.output(3, 0)
GPIO.setup(2, GPIO.IN)
GPIO.setup(4, GPIO.IN)

# check the file is a time to turn on the light
def is_night() :
    lines = open("/var/www/html/godziny.txt", "r")
    start = lines.readline()
    end = lines.readline()
    now = time.strftime("%H:%M") + "\n"
    if ( ((start < end) and (start <= now and now < end)) or ((end < start) and (now < end or start <= now)) ) :
        return True
    else :
        return False

def is_running() :
   file = open("/var/www/html/is_running.txt", "r")
   return float(file.readline()) > time.time()

# is too bright to light on
def light_sensor() :
    return GPIO.input(2)

# does anybody move
def pir_sensor() :
    return GPIO.input(4)

def light_on() :
    GPIO.output(3, 1)
    return

def light_off() :
    GPIO.output(3, 0)
    return

def logs(dane) :
    open("/var/www/html/logs.txt", "a").write(time.strftime("%H:%M:%S") + " " + dane + "\n")

wlaczone = False

#while 1 :
#    print light_sensor()
#    time.sleep(0.2)


# logs("still works")

if len(sys.argv) > 1 :
    if sys.argv[1] == "light_on" :
        light_on()
        wlaczone = True
        logs("wlaczone")
    elif sys.argv[1] == "light_off" :
        light_off()     
        wlaczone = True
        logs("wylaczone")

if not wlaczone and not is_running() and is_night() :
    logs("line 66")
    for x in range(0, 10) :
        if is_running() :
            light_on()
            logs("line 70")
            break
#        if is_night() :
        for y in range(0, 30) :
            if ( pir_sensor() and not light_sensor() ) :
                light_on()
                open("/var/www/html/is_running.txt", "w").write(str(time.time()+60))
                logs("line 77")
                break
            else :
                light_off()
            time.sleep(0.2)
#        else:
#            light_off()
#            time.sleep(6)
    logs("line 85")
else :
    logs("nie spelnia wymogow")