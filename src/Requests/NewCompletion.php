<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\Requests;

use JsonException;
use JustSteveKing\Ollama\DataObjects\Modelfile;

final readonly class NewCompletion
{
    /**
     * @param string $model The model name
     * @param string $prompt The prompt to generate a response for
     * @param array|null $images A list of base64-encoded images (for multimodal models such as llava)
     * @param string|null $format The format to return a response in. Currently, the only accepted value is json
     * @param null|Modelfile $options Additional model parameters listed in the documentation for the Modelfile such as temperature
     * @param string|null $system System message to (overrides what is defined in the Modelfile)
     * @param string|null $template The prompt template to use (overrides what is defined in the Modelfile)
     * @param array|null $context The context parameter returned from a previous request to /generate, this can be used to keep a short conversational memory
     * @param bool $stream If false the response will be returned as a single response object, rather than a stream of objects
     * @param bool $raw If true no formatting will be applied to the prompt. You may choose to use the raw parameter if you are specifying a full templated prompt in your request to the API
     * @param string $keep_alive Controls how long the model will stay loaded into memory following the request (default: 5m)
     */
    public function __construct(
        public string $model,
        public string $prompt,
        public null|array $images = null,
        public null|string $format = null,
        public null|Modelfile $options = null,
        public null|string $system = null,
        public null|string $template = null,
        public null|array $context = null,
        public bool $stream = false,
        public bool $raw = false,
        public string $keep_alive = '5m',
    ) {}

    /**
     * @param array{
     *     model:string,
     *     prompt:string,
     *     images:null|array,
     *     format:null|string,
     *     options:null|array,
     *     system:null|string,
     *     template:null|string,
     *     context:null|array,
     *     stream:bool,
     *     raw:bool,
     *     keep_alive:string,
     * } $data
     * @return NewCompletion
     */
    public static function make(array $data): NewCompletion
    {
        return new NewCompletion(
            model: $data['model'],
            prompt: $data['prompt'],
            images: $data['images'],
            format: $data['format'],
            options: $data['options'] ? Modelfile::make(
                data: $data['options'],
            ) : null,
            system: $data['system'],
            template: $data['template'],
            context: $data['context'],
            stream: $data['stream'] ?? false,
            raw: $data['raw'] ?? false,
            keep_alive: $data['keep_alive'] ?? '5m',
        );
    }

    /**
     * @return array{
     *     model:string,
     *     prompt:string,
     *     images:null|array,
     *     format:null|string,
     *     options:null|array,
     *     system:null|string,
     *     template:null|string,
     *     context:null|array,
     *     stream:bool,
     *     raw:bool,
     *     keep_alive:string,
     * }
     */
    public function toArray(): array
    {
        return [
            'model' => $this->model,
            'prompt' => $this->prompt,
            'images' => $this->images,
            'format' => $this->format,
            'options' => $this->options?->toArray(),
            'system' => $this->system,
            'template' => $this->template,
            'context' => $this->context,
            'stream' => $this->stream,
            'raw' => $this->raw,
            'keep_alive' => $this->keep_alive,
        ];
    }

    /**
     * @return string
     * @throws JsonException
     */
    public function toString(): string
    {
        return json_encode(
            value: $this->toArray(),
            flags: JSON_THROW_ON_ERROR,
        );
    }
}

