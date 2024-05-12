<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\Requests;

use function json_encode;

use JsonException;

final readonly class CreateRequest
{
    /**
     * @param string $model Name of the model to create
     * @param string|null $path (optional): Path to the Modelfile
     * @param string|null $modelfile (optional): Contents of the Modelfile
     * @param bool|null $stream (optional): If false the response will be returned as a single response object, rather than a stream of objects
     */
    public function __construct(
        public string $model,
        public null|string $path = null,
        public null|string $modelfile = null,
        public null|bool $stream = null,
    ) {}

    /**
     * @param array{
     *     model:string,
     *     path:null|string,
     *     modelfile:null|string,
     *     stream:null|bool,
     * } $data
     * @return CreateRequest
     */
    public static function make(array $data): CreateRequest
    {
        return new CreateRequest(
            model: $data['model'],
            path: $data['path'] ?? null,
            modelfile: $data['modelfile'] ?? null,
            stream: $data['stream'] ?? false,
        );
    }

    /**
     * @return array{
     *     model:string,
     *     path:null|string,
     *     modelfile:null|string,
     *     stream:null|bool,
     * }
     */
    public function toArray(): array
    {
        return [
            'model' => $this->model,
            'path' => $this->path,
            'modelfile' => $this->modelfile,
            'stream' => $this->stream,
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
