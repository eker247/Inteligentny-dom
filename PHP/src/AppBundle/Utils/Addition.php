<?php
namespace AppBundle\Utils;

/**
 *
 */
class Addition
{
    static public function ek_serialize($array)
    {
        $str = "";
        foreach ($array as $key => $value) {
            $str .= $key . ',';
            foreach ($value as $item) {
                $str .= $item . ',';
            }
        }
        return $str;
    }

    static public function ek_unserialize($str)
    {
        $arr = [];
        $tmp = "";
        $key = "";
        $j = 0;
        for ($i = 0; $i < strlen($str); $i++){
            if ($str[$i] != ',') {
                $tmp .= $str[$i];
            }
            else {
                // var_dump($tmp);
                if (strlen((float)$tmp) != strlen($tmp)) {
                    // var_dump($tmp);
                    $key = $tmp;
                    $arr[$key] = [];
                    $j = 0;
                }
                else {
                    $arr[$key][$j++] = (float)$tmp;
                }
                $tmp = "";
            }
        }
        return $arr;
    }
}
