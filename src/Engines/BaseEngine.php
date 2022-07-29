<?php

namespace AIStation\Engines;

use AIStation\Sdk;

class BaseEngine implements EngineInterface
{
    protected Sdk $sdk;

    public function __construct(Sdk $sdk) {
        $this->sdk = $sdk;
    }
}
