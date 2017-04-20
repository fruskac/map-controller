<?php

$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';

$mapPath = '//localhost/fruskac/map/dist/index.html';

$fullscreen = '//localhost/fruskac/map-controller/dist/index.php';

$data = array(
    array(
        'url' => '//localhost/fruskac/data/locations-'.$lang.'.json',
        'name' => 'locations',
        'type' => 'FRUSKAC_TYPE_MARKER',
        'options' => array(
            'visible' => true,
            'show' => array(
                'lakes',
                'monasteries',
                'misc'
            )
        )
    ),
    array(
        'url' => '//localhost/fruskac/data/tourism-'.$lang.'.json',
        'name' => 'tourism',
        'type' => 'FRUSKAC_TYPE_MARKER',
        'options' => array(
            'visible' => true,
            'show' => array(
                'households'
            )
        )
    ),
    array(
        'url' => '//localhost/fruskac/data/marathon.json',
        'name' => 'marathons',
        'type' => 'FRUSKAC_TYPE_TRACK'
    ),
    array(
        'url' => '//localhost/fruskac/data/protection.json',
        'name' => 'protection',
        'type' => 'FRUSKAC_TYPE_KML'
    ),
    array(
        'url' => '//localhost/fruskac/data/time.json',
        'name' => 'time',
        'type' => 'FRUSKAC_TYPE_MARKER'
    ),
);

