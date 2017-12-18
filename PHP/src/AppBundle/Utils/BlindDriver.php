<?php
namespace AppBundle\Utils;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 *
 */
class BlindDriver
{
    // numery przekaźników dla każdej lampy
    private $rooms = [
        'Pokój 1' => 32,
        'Pokój 2' => 32,
        'Kuchnia' => 32,
        'Łazienka' => 32,
        'Korytarz' => 32,
    ];

    public function RelayOn($id)
    {
        exec("echo 1 >/home/pi/Desktop/Przyklad/blind_status.txt");
        exec("/home/pi/Desktop/Przyklad/servo.sh $id 100");
    }

    public function RelayOff($id)
    {
        exec("echo 1 >/home/pi/Desktop/Przyklad/blind_status.txt");
        exec("/home/pi/Desktop/Przyklad/servo.sh $id 0");
    }

    public function SwitchBlind($id)
    {
        // if there is no room with the id
        if ( !array_key_exists($id, $this->rooms)){
            throw new Exception("Nie ma takiego pomieszczenia", 1);
        }
        $pin = $this->rooms[$id];
        if ($this->RelayStat($pin)) {
            $this->RelayOff($pin);
        }
        else {
            $this->RelayOn($pin);
        }
    }

    public function RelayStat($id)
    {
        // return exec('gpio -1 read ' . $id);
        return exec('tail -n 1 /home/pi/Desktop/Przyklad/blind_status.txt');
    }

    public function BlindStatuses()
    {
        $status = ['Góra', 'Dół'];
        $blinds = [];     // table of rooms and blinds statuses
        foreach ($this->rooms as $key => $value) {
            $blinds[$key] = $status[(int) $this->RelayStat($value)];
        }
        return $blinds;
    }
}
