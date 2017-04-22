<?php

$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';

$mapPath = '//localhost/fruskac/map/dist/index.html?' . $_SERVER['QUERY_STRING'];

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
            ),
            'color' => array(
                'lakes' => '#448b89',
                'waterfalls' => '#26b1b7',
                'fishponds' => '#26b1b7',
                'monasteries' => '#ac860c',
                'monuments' => '#666666',
                'springs' => '#4d84a6',
                'misc' => '#928e91',
                'picnic-areas' => '#4f452f',
                'meadows' => '#9ca22f',
                'lookouts' => '#8c1bdd'
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
            ),
            'color' => '#d2003b'
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
