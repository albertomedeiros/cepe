<?php

$begin = new DateTime( date($calendar['year'] . '-' . $calendar['month'] . '-01') );
$end = new DateTime( date('Y-m-d', strtotime("+1 months", strtotime(date($calendar['year'] . '-' . $calendar['month'] . '-01')))));
$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

foreach ($period as $dt) {
    $has_diary = 'data';
    $date = sprintf('%s%s%s', $dt->format( "d" ), $calendar['month'], $calendar['year']);

    foreach ($this->diaries as $diary) {
        if ($diary == $date) {
            $has_diary = 'data has_diary';
        }
    }

    echo "<div class='$has_diary'><section><a href=''><div>"  . "<strong>" . $dt->format( "d" ) . "</strong>" . "<p>" . $this->weekdays[(int)$dt->format( "N" )] . "</p>" . "</div></a></section></div>";
}
