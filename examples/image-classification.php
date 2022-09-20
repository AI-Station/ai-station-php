<?php

use AIStation\Engines\ImageClassification;
use AIStation\Options;
use AIStation\Sdk;

require_once __DIR__ . '/../vendor/autoload.php';

$options = new Options([
    // 'uri' => 'https://api.aistation.sopamo.de/api'
    'uri' => 'http://localhost:8081/api'
]);
$sdk = new Sdk($options);
$imageClassification = new ImageClassification($sdk);


$model = $imageClassification->createModel('dogs-cats', 'dog', 'cat');

//$cats = scandir('./data/cats');
//$i = 0;
//foreach($cats as $cat) {
//    if(str_contains($cat, '.jpg')) {
//        if($i++ > 30) {
//            break;
//        }
//        try {
//            $model->addImage('./data/cats/' . $cat, 'cat');
//        } catch (\Exception $e) {
//            echo $e->getMessage();
//        }
//    }
//}
//$dogs = scandir('./data/dogs');
//$i = 0;
//foreach($dogs as $dog) {
//    if(str_contains($dog, '.jpg')) {
//        if($i++ > 30) {
//            break;
//        }
//        try {
//            $model->addImage('./data/dogs/' . $dog, 'dog');
//        } catch (\Exception $e) {
//            echo $e->getMessage();
//        }
//    }
//}
//$model->train();
//exit;
$prediction = $imageClassification->predict('https://images.unsplash.com/photo-1552053831-71594a27632d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=724&q=80', 'dogs-cats');
var_dump('dog', $prediction->getClass());
$prediction = $imageClassification->predict('https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1686&q=80', 'dogs-cats');
var_dump('cat', $prediction->getClass());

