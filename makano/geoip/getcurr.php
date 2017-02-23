<?php

include("geoip.inc");

$gi = geoip_open("/home/polka/domains/knigionline.com/public_html/geoip/GeoIP.dat",GEOIP_STANDARD);

$cc = geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR']);

geoip_close($gi);

$c_c = array(
    'UA' => 'UAH',
    'RU' => 'RUR',

    'EU' => 'EUR',
    'BE' => 'EUR',
    'BG' => 'EUR',
    'CZ' => 'EUR',
    'DK' => 'EUR',
    'DE' => 'EUR',
    'EE' => 'EUR',
    'IE' => 'EUR',
    'EL' => 'EUR',
    'ES' => 'EUR',
    'FR' => 'EUR',
    'IT' => 'EUR',
    'CY' => 'EUR',
    'LV' => 'EUR',
    'LT' => 'EUR',
    'LU' => 'EUR',
    'HU' => 'EUR',
    'MT' => 'EUR',
    'NL' => 'EUR',
    'AT' => 'EUR',
    'PL' => 'EUR',
    'PT' => 'EUR',
    'RO' => 'EUR',
    'SI' => 'EUR',
    'SK' => 'EUR',
    'FI' => 'EUR',
    'SE' => 'EUR',
    'UK' => 'EUR',
    'HR' => 'EUR',
    'IS' => 'EUR',
    'TR' => 'EUR',

    '*' => 'USD'
);


return isset($c_c[$cc]) ? $c_c[$cc] : $c_c['*'];
