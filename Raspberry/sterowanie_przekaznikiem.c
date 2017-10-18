#include <wiringPi.h>
#include <stdio.h>
 
#define RelayPn 0
 
int main(void)
{
if(wiringPiSetup() == -1){ //If wiringpi initialization failed, printf 
printf("Wiring Pi Initialization Faild");
return 1;
}
pinMode(RelayPn, OUTPUT);
 
while(1){
digitalWrite(RelayPn, LOW);
delay(1000);
digitalWrite(RelayPn, HIGH);
delay(1000);
}
 
return 0;
}