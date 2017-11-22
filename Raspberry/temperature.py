#!/usr/bin/python
import sys
import Adafruit_DHT

temps = ""
# for each command line arguments
# print temperature in Celsius degree and humidity in %
for i in range (1, len(sys.argv)):
    humidity, temperature = Adafruit_DHT.read_retry(11, sys.argv[i])
    temps += str('{0:0.1f}'.format(temperature)) + ' '
    
if len(temps) > 0:
    print temps

if len(sys.argv) < 2:
    humidity, temperature = Adafruit_DHT.read_retry(11, 4)
    print '{0:0.1f}'.format(temperature)
