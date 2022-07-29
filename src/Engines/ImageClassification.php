<?php
namespace AIStation\Engines;

use AIStation\Engines\Responses\ImageClassificationResponse;
use AIStation\Engines\Responses\InvalidResponseException;
use AIStation\HttpClient\Message\ResponseMediator;
use Http\Client\Exception;
use Intervention\Image\ImageManager;

class ImageClassification extends BaseEngine {

    /**
     * Given an image and a model name, returns the class for this model
     *
     * @param $image mixed The input image. Can be a url, a local path, or in one of many other formats. See https://image.intervention.io/v2/api/make
     * @return ImageClassificationResponse
     * @throws Exception
     * @throws InvalidResponseException
     */
    public function predict($image): ImageClassificationResponse {
        // TODO: Add support to configure the image driver
        $manager = new ImageManager();
        $image = $manager->make($image)->resize(300, 200);

        $response = $this->sdk->getHttpClient()->post('/engines/image-classification/predict', [], json_encode([
            'image' => $image->resize(160, 160)->encode('data-url')->encoded,
        ]));

        if($response->getStatusCode() !== 200) {
            throw new InvalidResponseException();
        }
        $content = ResponseMediator::getContent($response);

        return new ImageClassificationResponse($content);
    }
}
