<?php

use AIStation\Engines\ImageClassification;
use AIStation\Options;
use AIStation\Sdk;

require_once __DIR__ . '/../vendor/autoload.php';

$options = new Options([
    'uri' => 'http://localhost:8081/api'
]);
$sdk = new Sdk($options);
$imageClassification = new ImageClassification($sdk);

//$prediction = $imageClassification->predict('https://images.unsplash.com/photo-1659030662155-55e55f0743a0?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=987&q=80');
//var_dump($prediction);

$model = $imageClassification->createModel('hats', 'hat', 'nohat');
var_dump($model->addImage('https://images.unsplash.com/photo-1521369909029-2afed882baee?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2340&q=80', 'hat'));
var_dump($model->train());
