<?php

use Symfony\Component\HttpFoundation\Request;

if (!in_array(@$_SERVER['REMOTE_ADDR'], array(
  '127.0.0.1',
  '::1',
  '82.237.239.55'
))) {
  header('HTTP/1.0 403 Forbidden');
  exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}


$loader = require_once __DIR__.'/../app/bootstrap.php.cache';
require_once __DIR__.'/../app/AppKernel.php';

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
