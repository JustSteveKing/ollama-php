<?php

declare(strict_types=1);

use JustSteveKing\Ollama\Requests\NewCompletion;

require __DIR__ . '/vendor/autoload.php';

$sdk = new \JustSteveKing\Ollama\SDK(
    apiToken: '',
    url: 'http://localhost:11434',
);
$sdk->setup();

$model = $sdk->models()->create(new \JustSteveKing\Ollama\Requests\NewModel(
    name:  "mario",
   modelfile: null,
   stream: false
));

