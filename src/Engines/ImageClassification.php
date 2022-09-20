<?php
namespace AIStation\Engines;

use AIStation\Engines\Models\ImageClassificationModel;
use AIStation\Engines\Responses\ImageClassificationResponse;
use AIStation\HttpClient\Message\InvalidResponseException;
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
    public function predict($image, string $modelName = ''): ImageClassificationResponse {
        // TODO: Add support to configure the image driver
        $manager = new ImageManager();
        $image = $manager->make($image);

        $response = $this->sdk->getHttpClient()->post('/engines/image-classification/predict', [], json_encode([
            'data' => [
                'image' => $image->resize(160, 160)->encode('data-url')->encoded,
            ],
            'modelName' => $modelName,
        ]));

        return new ImageClassificationResponse(ResponseMediator::getContent($response));
    }

    /**
     * Creates, or fetches an image classification model which can be trained in the next steps
     *
     * @param string $modelName A short name that describes this model
     * @param string $class1 A name for the first class of images you want to detect (e.g. cats)
     * @param string $class2 A name for the first class of images you want to detect (e.g. dogs)
     * @return ImageClassificationModel
     */
    public function createModel(string $modelName, string $class1, string $class2): ImageClassificationModel {
        $model = new ImageClassificationModel($this->sdk, $modelName, $class1, $class2);
        $model->initialize();
        return $model;
    }
}
