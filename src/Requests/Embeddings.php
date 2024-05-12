<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\Requests;

use function json_encode;

use JsonException;
use JustSteveKing\Ollama\DataObjects\Modelfile;

final readonly class Embeddings
{
    /**
     * @param string $model Name of model to generate embeddings from
     * @param string $prompt Text to generate embeddings for
     * @param Modelfile|null $options Additional model parameters listed in the documentation for the Modelfile such as temperature
     * @param int|string|null $keep_alive Controls how long the model will stay loaded into memory following the request (default: 5m)
     */
    public function __construct(
        public string $model,
        public string $prompt,
        public null|Modelfile $options = null,
        public null|int|string $keep_alive = null,
    ) {
    }

    public static function make(array $data): Embeddings
    {
        return new Embeddings(
            model: $data['model'],
            prompt: $data['prompt'],
            options: $data['options'] ? Modelfile::make(
                data: $data['options'],
            ) : null,
            keep_alive: $data['keep_alive'] ?? '5m',
        );
    }

    /**
     * @return array{
     *     model:string,
     *     prompt:string,
     *     options:null|array,
     *     keep_alive:null|int|string,
     * }
     */
    public function toArray(): array
    {
        return [
            'model' => $this->model,
            'prompt' => $this->prompt,
            'options' => $this->options?->toArray(),
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
