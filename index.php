<?php

spl_autoload_register(function($class) {
    $fn =  $class . '.php';
    if (file_exists($fn)) require $fn;
});

$method = $_GET['method'];

if (empty($method))
    die('Undefined api method');

$handler = new \Api\Handler($method);
echo $handler->validate();