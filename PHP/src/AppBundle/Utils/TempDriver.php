<?php
namespace AppBundle\Utils;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 *
 */
class TempDriver
{
    // room => [0, 1, 2, 3]
    // 0 - pin's number
    // 1 - actual temperature
    // 2 - required temperature
    // 3 - tolerance
    private $rooms = [
        'Pokój 1' => [11, 22, 22, 1],
        'Pokój 2' => [11, 22, 22, 1],
        'Kuchnia' => [11, 21, 20, 3],
        'Łazienka' => [11, 22, 22, 1],
        'Korytarz' => [11, 20, 19, 2],
    ];

    public function RelayOn($id)
    {
        exec('gpio -1 write ' . $id . ' 1');
    }

    public function RelayOff($id)
    {
        exec('gpio -1 write ' . $id . ' 0');
    }

    public function SwitchLight($id)
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

    public function TempStat($id)
    {
        return exec('gpio -1 read ' . $id);
    }

    public function TempStatuses()
    {
        // $temps = [];
        // foreach ($rooms as $key => $value) {
        //     $temps[$key];
        // }
        return $this->rooms;
    }
}
