# AI Station PHP
This is the PHP SDK for AI Station

## Installation
```sh
composer require aistation/aistation
```

## Usage

Example for language detection:

```php
use AIStation\Engines\LanguageDetection;
use AIStation\Options;
use AIStation\Sdk;

$options = new Options([
    // This expects you to have AI Station running locally
    'uri' => 'http://localhost:8081/api'
]);
$sdk = new Sdk($options);

$languageDetection = new LanguageDetection($sdk);
$prediction = $languageDetection->predict('How are you?');

// This will be "en"
var_dump($prediction->getLanguage());
```


## Acknowledgements
Thanks to https://github.com/bramdevries/example-php-sdk for inspiring the structure of this SDK.
