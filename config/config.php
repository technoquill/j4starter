<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

use J4Starter\Template;
use J4Starter\TemplateAsset;

$template = new Template($this);

try {
    (new TemplateAsset($this->getWebAssetManager()))
        ->disableDefaults()
        ->autoload();
} catch (JsonException|Exception $e) {

}

$this->setMetaData('viewport', 'width=device-width, initial-scale=1');
$this->setGenerator(null);


