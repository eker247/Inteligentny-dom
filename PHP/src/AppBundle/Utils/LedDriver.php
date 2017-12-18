<?php
namespace AppBundle\Utils;

class LedDriver
{
    public $R = 37;
    public $G = 31;
    public $B = 29;
    public function readColor() 
    {
        $r = exec("gpio -1 read $this->R");
        $g = exec("gpio -1 read $this->G");
        $b = exec("gpio -1 read $this->B");
        $color = ($r != 0) ? "#f" : "#0";
        $color .= ($g != 0) ? "f" : "0";
        $color .= ($b != 0) ? "f" : "0"; 
        return $color;
    }
    
    public function setColor($color) 
    {
        $r = ($color[1] == 'f') ? 1 : 0;
        $g = ($color[2] == 'f') ? 1 : 0;
        $b = ($color[3] == 'f') ? 1 : 0;
//        var_dump("rgb = $r $g $b");
        exec("/home/pi/Desktop/Przyklad/rgb.sh $r $g $b");
    }
}
