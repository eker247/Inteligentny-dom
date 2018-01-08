<?php
namespace AppBundle\Utils;
use Symfony\Component\Config\Definition\Exception\Exception;

class WaterValveDriver
{
    public function change()
    {
        try {
            $status = $this->status();
        }
        catch (Exception $ex) {
            var_dump($ex->getMessage());
            return;
        }
        if ($status = 'ON') {
            $value = 0;
        }
        else {
            $value = 100;
        }
        exec("/home/Desktop/Przyklad/serwo.sh " . $value);
    }

    public function status()
    {
        $status = exec("cat /home/Desktop/Przyklad/water_status.txt");
        if ($status == 'ON') {
            return 'OTWARTY';
        }
        else if ($status == "OFF") {
            return 'ZAMKNIĘTY';
        }
        else {
            throw new Exception(
                "Problem przy przetwarzaniu pliku water_status.txt.
                Sprawdź czy nie został zmieniony lub usunięty.");
        }
    }
}
