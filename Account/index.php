<?php

use Account\Infra\Kernel;
use Symfony\Component\HttpFoundation\Request;

require 'vendor/autoload.php';

$kernel = new Kernel('dev', true);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);