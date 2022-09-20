<?php

namespace AIStation\Engines\Models;

use AIStation\HttpClient\Message\ResponseMediator;
use AIStation\Sdk;
use Intervention\Image\ImageManager;

class ImageClassificationModel extends BaseModel
{
    private string $class1;
    private string $class2;

    public function __construct(Sdk $sdk, string $modelName, string $class1, string $class2)
    {
        parent::__construct($sdk, $modelName);
        $this->class1 = $class1;
        $this->class2 = $class2;
    }

    public function initialize()
    {
        $response = $this->sdk->getHttpClient()->post('/engines/image-classification/initialize-model', [], json_encode([
            'modelName' => $this->modelName,
            'data' => [
                'class1' => $this->class1,
                'class2' => $this->class2,
            ],
        ]));

        return ResponseMediator::getContent($response);
    }

    protected function getClassNames() {
        return [$this->class1, $this->class2];
    }

    /**
     * @param $image
     * @param string $className
     * @param string|null $fileName You shouldn't specify the file name, as by default it's autogenerated as the md5 hash of the image contents
     * @return array
     * @throws \AIStation\HttpClient\Message\InvalidResponseException
     * @throws \Http\Client\Exception
     */
    public function addImage($image, string $className, string $fileName = null) {
        if(!in_array($className, $this->getClassNames())) {
            $validClassNames = implode(", ", $this->getClassNames());
            throw new \InvalidArgumentException("The given class name ${$className} does not exist on this model. Valid class names are: ${$validClassNames}");
        }
        $manager = new ImageManager();
        $image = $manager->make($image);
        $imageData = $image->resize(160, 160)->encode('data-url')->encoded;
        if(!$fileName) {
            $fileName = md5($imageData) . '.jpg';
        }

        $response = $this->sdk->getHttpClient()->post('/engines/image-classification/add-training-sample', [], json_encode([
            'modelName' => $this->modelName,
            'data' => [
                'image' => $imageData,
                'className' => $className,
                'fileName' => $fileName,
            ],
        ]));

        return ResponseMediator::getContent($response);
    }
}
