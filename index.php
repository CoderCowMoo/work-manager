<?php
// to stop the annoying CORS error
/*
 * This file is the first file to be called by webserver. It will be used as a router.
 * It processes the request and sends it through to the relevant 'view' file. Therefore,
 * it is essential that this file has no output in production as its output is decided
 * by the relevant 'views'.
 */

// if code isnt accessible at base url, i.e. 'example.com' or 'localhost'
$base_url = '';
// first get request uri without params
$request = strtok($_SERVER['REQUEST_URI'], '?');
// if base_url is present remove it, otherwise it does nothing.
$request = str_replace($base_url, '', $request);

// all view directories will be relative to current directory using __DIR__
switch ($request) {
    // these handle 'example.com/' and 'example.com' respectively
    case '/':
    case '':
        require __DIR__ . '/views/homepage.php';
        break;

    case '/updatedb':
        require __DIR__ . '/controllers/updatedb.php';
        break;
    default:
        // if no view is found, return a 404: (Not Found)
        http_response_code(404);
        require __DIR__ . '/views/404.php';

}

