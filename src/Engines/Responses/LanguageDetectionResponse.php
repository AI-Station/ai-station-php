<?php

namespace AIStation\Engines\Responses;

class LanguageDetectionResponse extends BaseResponse
{
    private string $language;
    private float $confidence;

    public function __construct($response) {
        $this->predictionDurationMs = $response['meta']['predictionDurationMs'];
        $this->language = $response['items'][0]["label"];
        $this->confidence = $response['items'][0]["score"];
    }

    /**
     * @return string ar|bg|de|el|en|es|fr|hi|it|ja|nl|pl|pt|ru|sw|th|tr|ur|vi|zh
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @return float
     */
    public function getConfidence()
    {
        return $this->confidence;
    }
}
