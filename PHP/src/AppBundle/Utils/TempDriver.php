<?php
namespace AppBundle\Utils;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 *
 */
class TempDriver
{
    // room => [0, 1, 2, 3]
    // 0 - DHT11 pin
    // 1 - actual temperature
    // 2 - required temperature
    // 3 - tolerance
    // 4 - servo pin
    // works only 'Pokój 1' becouse other have incorrect servo pin number
    // each shows the same temperature - the same DHT11 pin number
    private $rooms = [
        'Pokój 1' => [4, 22, 22, 1, 32],
        'Pokój 2' => [4, 22, 22, 1, 41],
        'Kuchnia' => [4, 21, 20, 3, 41],
        'Łazienka' => [4, 22, 22, 1, 41],
        'Korytarz' => [4, 20, 19, 2, 41],
    ];

    public function __construct()
    {
        if (file_exists("rooms_temp")) {
            $this->rooms = unserialize(file_get_contents("rooms_temp"));
        }
    }

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
        $this->sensorsReadTemp();
        return $this->rooms;
    }

    // read current temperatures in rooms
    private function sensorsReadTemp()
    {
        // python's script using to read data from sensors
        $cmd = "python /home/eker/Pulpit/tmp.py ";
        // read pin numbers for each room
        foreach ($this->rooms as $key => $value) {
            $cmd .= (string)$value[0] . ' ';
        }
        // var_dump($cmd);
        // exec return string, getFloats changes it to floats array
        // $temps = $this->getFloats(exec($cmd));
        $temps = [20, 21, 22, 19, 19];
        $i = 0;
        // for each room set current temperature
        foreach ($this->rooms as $key => $value) {
            $this->rooms[$key][1] = $temps[$i++];
        }
    }

    // change string with floats separated by 'mark' to array with floats
    private function getFloats(string $str, $mark = ' ')
    {
        $j = 0;
        $numbers = [];
        $tmp = "";
        for ($i = 0; $i < strlen($str); $i++){
            if ($str[$i] != ' ') {
                $tmp .= $str[$i];
            }
            else {
                $numbers[$j++] = floatval($tmp);
                $tmp = "";
            }
            $numbers[$j] = floatval($tmp);
        }
        return $numbers;
    }

    // set temoeratures in file
    public function setTemps($post)
    {
        // var_dump($post["required_tempPokój_1"]);
        foreach ($this->rooms as $key => $value) {
            // var_dump($post["required_temp" . str_replace(' ', '_', $key)]);
            $this->rooms[$key][2] = abs($post['required_temp' . str_replace(' ', '_', $key)]);
            $this->rooms[$key][3] = abs($post['tolerance' . str_replace(' ', '_', $key)]);
        }
        $serialized = serialize($this->rooms);
        file_put_contents("rooms_temp", $serialized);
    }

}
