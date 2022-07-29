<?php

namespace AIStation\Engines\Responses;

class ImageClassificationResponse extends BaseResponse
{
    /**
     * @var string
     */
    private $class;

    public function __construct($response) {
        $this->predictionDurationMs = $response['meta']['predictionDurationMs'];
        $this->class = $response['items'][0];
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }
}
