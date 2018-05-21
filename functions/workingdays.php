<?php

date_default_timezone_set("America/Chicago"); //Set Time zone to CST

function datetimenow(){
    $now = new DateTime();
    $now-> modify('-12 hours');
    $now = $now->format('Y-m-d H:i:s');

    return $now;
}


function number_of_working_days($from, $to) {
    $workingDays = [1, 2, 3, 4, 5]; # date format = N (1 = Monday, ...)
    $holidayDays = ['*-12-25', '*-01-01']; # variable and fixed holidays

    $from = new DateTime($from);
    $to = new DateTime($to);
    $to->modify('+1 day');
    $interval = new DateInterval('P1D');
    $periods = new DatePeriod($from, $interval, $to);

    $days = 0;
    foreach ($periods as $period) {
        if (!in_array($period->format('N'), $workingDays)) continue;
        if (in_array($period->format('Y-m-d'), $holidayDays)) continue;
        if (in_array($period->format('*-m-d'), $holidayDays)) continue;
        $days++;
    }
    return $days;
}

function hours_of_working_days($from, $to){

    $from = new DateTime($from);
    $to = new DateTime($to);
    $hours = $from->diff($to);

    $hours = $hours->format('%h');
    return $hours;

}
?>