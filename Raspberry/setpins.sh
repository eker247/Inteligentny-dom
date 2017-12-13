#!/bin/bash

gpio -1 mode 11 out
gpio -1 mode 32 pwm
gpio pwm-ms
gpio pwmc 192
gpio pwmr 2000

# rgb
gpio -1 mode 37 out
gpio -1 mode 31 out
gpio -1 mode 29 out
