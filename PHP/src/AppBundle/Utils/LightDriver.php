<?php
namespace AppBundle\Utils;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 *
 */
class LightDriver
{
    // numery przekaźników dla każdej lampy
    private $rooms = [
        'Pokój 1' => 11,
        'Pokój 2' => 11,
        'Kuchnia' => 11,
        'Łazienka' => 11,
        'Korytarz' => 11,
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

    public function RelayStat($id)
    {
        return exec('gpio -1 read ' . $id);
    }

    public function LampStatuses()
    {
        $status = ['OFF', 'ON'];
        $lamps = [];     // table of rooms and lamp status
        $i = 0;
        foreach ($this->rooms as $key => $value) {
            $lamps[$key] = $status[(int) $this->RelayStat($value)];
        }
        return $lamps;
    }
}
