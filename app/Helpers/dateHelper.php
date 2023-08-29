<?php

use Carbon\Carbon;

/**
 * Get date format
 */
function getFormatedDate($value)
{
    $carbon = new Carbon($value);
    return $carbon->toDateTimeString();
}
/**
 * Get format date and time
 */
function getFormatedDateTime($value)
{
    $carbon = new Carbon($value);
    return $carbon->toDayDateTimeString();
}

/**
 * Get date
 */
function dateFormat($string)
{
    return Carbon::parse($string)->format('Y-m-d');
}
function timeFormat($string)
{
    return Carbon::parse($string)->format('H:i:s');
}
function dayTimeFormat($string)
{
    return Carbon::parse($string)->format('g:i A');
}
function getFormatDayName($string)
{
    return Carbon::parse($string)->format('D, F d, Y g:i A');
}
function getDefaultFormat($string)
{
    return Carbon::parse($string)->format('m d, Y g:i A');
}
/**
 * Get current date
 */
function currentDateFormat()
{
    $mytime = Carbon::now();
    return $mytime->toDateTimeString();
}

/**
 * Add days, month or week on current date
 */
function addDaysInDate($terms, $type){
    $date = date("Y-m-d H:i:s");
    return   date('Y-m-d H:i:s', strtotime($date .$terms." ".$type));
}
