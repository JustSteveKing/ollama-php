<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\Requests;

use JsonException;
use JustSteveKing\Ollama\DataObjects\Modelfile;
use function json_encode;

final readonly class NewModel
{
    /**
     * @param string $name Name of the model to create
     * @param Modelfile|null $modelfile Contents of the Modelfile
     * @param bool $stream If false the response will be returned as a single response object, rather than a stream of objects
     * @param string|null $path Path to the Modelfile
     */
    public function __construct(
        public string $name,
        public null|Modelfile $modelfile,
        public bool $stream = false,
        public null|string $path = null,
    ) {}

    /**
     * @param array{
     *     name:string,
     *     modelfile:null|array,
     *     stream:null|bool,
     *     path:null|string,
     * } $data
     * @return NewModel
     */
    public static function make(array $data): NewModel
    {
        return new NewModel(
            name: $data['name'],
            modelfile: $data['modelfile'] ? Modelfile::make(
                data: $data['modelfile']
            ) : null,
            stream: $data['stream'] ?? false,
            path: $data['path'] ?? null,
        );
    }

    /**
     * @return array{
     *     name:string,
     *     modelfile:null|array,
     *     stream:bool,
     *     path:null|string,
     * }
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'modelfile' => $this->modelfile?->toArray(),
            'stream' => $this->stream,
            'path' => $this->path,
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
