<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\Requests;

use function json_encode;

use JsonException;

final readonly class Model
{
    /**
     * @param null|string $model Name of the model to pull
     * @param bool|null $insecure (optional) Allow insecure connections to the library. Only use this if you are pulling from your own library during development.
     * @param bool|null $stream (optional) iI false the response will be returned as a single response object, rather than a stream of objects
     */
    public function __construct(
        public null|string $model,
        public null|bool $insecure = null,
        public null|bool $stream = null,
    ) {
    }

    /**
     * @param array{
     *     model:string,
     *     insecure:null|bool,
     *     stream:null|bool,
     * } $data
     * @return Model
     */
    public static function make(array $data): Model
    {
        return new Model(
            model: $data['model'],
            insecure: $data['insecure'] ?? null,
            stream: $data['stream'] ?? false,
        );
    }

    /**
     * @return array{
     *     model:string,
     *     insecure:null|bool,
     *     stream:null|bool,
     * }
     */
    public function toArray(): array
    {
        return [
            'model' => $this->model,
            'insecure' => $this->insecure,
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
