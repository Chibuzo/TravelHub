<?php

class Utility
{
    public static function ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }


    public static function superUnique(array $array)
    {
        $result = array_map("unserialize", array_unique(array_map("serialize", $array)));

        foreach ($result AS $key => $value) {
            if (is_array($value)) {
                $result[$key] = self::superUnique($value);
            }
        }
        return $result;
    }
}