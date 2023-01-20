<?php
// this just gives us a function that prints data and dies.
function dd($data) {
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die();
}