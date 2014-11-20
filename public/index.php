<?php

require_once(__DIR__ . '/../vendor/autoload.php');

$toolchain = new \Toolchain\Toolchain();
$toolchain->init(); 
$toolchain->run();