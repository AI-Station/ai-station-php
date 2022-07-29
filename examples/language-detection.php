<?php

use AIStation\Engines\LanguageDetection;
use AIStation\Options;
use AIStation\Sdk;

require_once __DIR__ . '/../vendor/autoload.php';

$options = new Options([
    'uri' => 'http://localhost:8081/api'
]);
$sdk = new Sdk($options);
$languageDetection = new LanguageDetection($sdk);

$strings = [
    'How are you?',
    'Heute scheint die Sonne',
    'Je m\'appelle Julien',
    'Vamos a la zapatería',
];

foreach($strings as $string) {
    var_dump($string);
    $prediction = $languageDetection->predict($string);
    var_dump($prediction->getLanguage());
    var_dump($prediction->getConfidence());
    var_dump($prediction->getPredictionDurationMs());
}
