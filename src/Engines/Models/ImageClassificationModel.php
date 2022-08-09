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
            'name' => $this->modelName,
            'class1' => $this->class1,
            'class2' => $this->class2,
        ]));

        return ResponseMediator::getContent($response);
    }

    protected function getClassNames() {
        return [$this->class1, $this->class2];
    }

    public function addImage($image, string $className, string $fileName = null) {
        if(!in_array($className, $this->getClassNames())) {
            $validClassNames = implode(", ", $this->getClassNames());
            throw new \InvalidArgumentException("The given class name ${$className} does not exist on this model. Valid class names are: ${$validClassNames}");
        }
        $manager = new ImageManager();
        $image = $manager->make($image);
        if(!$fileName) {
            $fileName = $image->filename;
        }
        if(!$fileName) {
            $fileName = rand() . '-' . round(microtime(true) * 1000) . '.jpg';
        }

        $response = $this->sdk->getHttpClient()->post('/engines/image-classification/add-training-sample', [], json_encode([
            'name' => $this->modelName,
            'image' => $image->resize(160, 160)->encode('data-url')->encoded,
            'className' => $className,
            'fileName' => $fileName,
        ]));

        return ResponseMediator::getContent($response);
    }
}
