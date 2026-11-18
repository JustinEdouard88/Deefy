<?php
require_once 'vendor/autoload.php';

use iutnc\deefy\exception\InvalidPropertyNameException as InvalidPropertyNameException;
use iutnc\deefy\exception\InvalidPropertyValueException as InvalidPropertyValueException;
use iutnc\deefy\dispatch\Dispatcher;
use iutnc\deefy\repository\DeefyRepository;

DeefyRepository::setConfig(__DIR__ . '/config.db.ini');
$repo = DeefyRepository::getInstance();
session_start();

try{
    $dispatcher = new Dispatcher();
    $dispatcher->run(); 
}
catch(InvalidPropertyNameException $ipne){
    echo $ipne->getMessage();
    echo '<pre>' . $ipne->getTraceAsString() . '</pre>';
}
catch(InvalidPropertyValueException $ipve){
    echo $ipve->getMessage();
    echo '<pre>' . $ipve->getTraceAsString() . '</pre>';
}
