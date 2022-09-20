<?php

namespace AIStation\Engines\Models;

use AIStation\HttpClient\Message\ResponseMediator;
use AIStation\Sdk;

class BaseModel
{
    protected string $modelName;
    protected Sdk $sdk;

    public function __construct(Sdk $sdk, string $modelName) {
        $this->modelName = $modelName;
        $this->sdk = $sdk;
    }

    /**
     * Trains the model. Expects that the user has already provided some data for training the model
     *
     * @return array
     * @throws \AIStation\HttpClient\Message\InvalidResponseException
     * @throws \Http\Client\Exception
     */
    public function train() {
        $response = $this->sdk->getHttpClient()->post('/engines/image-classification/train-model', [], json_encode([
            'modelName' => $this->modelName,
        ]));

        return ResponseMediator::getContent($response);
    }
}
