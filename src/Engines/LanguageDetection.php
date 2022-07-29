<?php
namespace AIStation\Engines;

use AIStation\Engines\Responses\InvalidResponseException;
use AIStation\Engines\Responses\LanguageDetectionResponse;
use AIStation\HttpClient\Message\ResponseMediator;
use Http\Client\Exception;

class LanguageDetection extends BaseEngine {

    /**
     * Given a text, return the language the text is written in
     *
     * @throws Exception
     * @throws InvalidResponseException
     */
    public function predict(string $inputText): LanguageDetectionResponse {
        $response = $this->sdk->getHttpClient()->post('/engines/language-detection/predict', [], json_encode([
            'text' => $inputText,
        ]));
        if($response->getStatusCode() !== 200) {
            throw new InvalidResponseException();
        }
        $content = ResponseMediator::getContent($response);

        return new LanguageDetectionResponse($content);
    }
}
