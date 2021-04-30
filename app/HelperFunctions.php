<?php

if (! function_exists('successMsg')) {
    function successMsg($msg) {
        return ['type' => 'success', 'msg' => $msg];
    }
}

if (! function_exists('date_create_dmy')) {
    function date_create_dmy($date)
    {
        $year = substr($date, 4, 4);
        $month = substr($date, 2, 2);
        $day = substr($date, 0, 2);
        return date_create($year.$month.$day);
    }
}
if (! function_exists('fandomList')) {
    function fandomList()
    {
        return [
            'cenário-original',
            'worm',
            'harry-potter',
            'naruto',
            'multiplos',
            'outro',
        ];
    }
}
if (! function_exists('ratingNames')) {
    function ratingNames()
    {
        return [
            '10' => 'Masterpiece',
            '9' => 'Great',
            '8' => 'Very Good',
            '7' => 'Good',
            '6' => 'Fine',
            '5' => 'Average',
            '4' => 'Bad',
            '3' => 'Very Bad',
            '2' => 'Horrible',
            '1' => 'Appalling',
        ];
    }
}
