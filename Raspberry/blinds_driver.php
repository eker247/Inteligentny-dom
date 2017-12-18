<?php
# minimum time of blind turned on/off
$DIF = 60;

# How often check the loop
$SLEEP = 15;

while (true) {

    # last blind's status
    $blindStatus = 0;

    # datas from www are stored in below file
    $file = fopen("blind_status.txt", "r");

    # html wants this state
    $stat = fread($file, 1);
    fread($file, 1);

    # time of last clic
    $lastTime = fread($file, 12);
        G  ra
    fclose($file);
    $currentTime = time();

    # html changes status in file in less then $DIF seconds
    $change = $currentTime - $lastTime < $DIF;

    #curren state of fotoresistor
    $fotoresistor = exec("gpio -1 read 16");
    if ($blindStatus == 0 && $stat == 1 && $change) {
        print("option 1\n");
        blindUp();
    }
    else if ($blindStatus == 1 && $stat == 0 && $change) {
        print("option 2\n");
        blindDown();
    }
    else if (!$fotoresistor) {
        print("option 3\n");
        exec("echo '0 0' > blind_status.txt");
        blindDown();
    }
    else {
        print("option 4\n");
        exec("echo '1 0' > blind_status.txt");
        blindUp();
    }

    print("Koniec\n");
    sleep($SLEEP);
}

function blindDown() {
    exec("/home/pi/Desktop/Przyklad/servo.sh 32 0");
}

function blindUp() {
    exec("/home/pi/Desktop/Przyklad/servo.sh 32 100");
}
