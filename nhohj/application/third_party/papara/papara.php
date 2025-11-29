<?php

$paparaid  = '2535771835';
$cronsecret     = 'yy9psaWZg2HhxGEKA8CCywpFSaWQYn8G';

date_default_timezone_set("Europe/Istanbul");

function createLink($tutar, $desc)
{
 $paparaurl = "https://www.papara.com/personal/qr?amount=" . $miktar . "&description=" . $string . "&accountNumber=" . $paparaid . "&currency=0";
    return $paparaurl;
}