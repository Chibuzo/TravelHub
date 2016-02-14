<?php
/**
 * Project: travelhub.
 * User:    Iroegbu
 * Date:    2/12/2016
 * Time:    4:33 AM
 */

/**
 * @param $number
 * @return string
 */
function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}