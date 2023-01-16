<?php
/*
 * This file is the first file to be called by webserver. It will be used as a router.
 * It processes the request and sends it through to the relevant 'view' file.
 */

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    // these handle 'example.com/' and 'example.com' respectively
    case '/':
    case '':
}

