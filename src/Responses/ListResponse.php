<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\Responses;

use function array_map;

use Exception;
use JustSteveKing\Ollama\DataObjects\Model;

final readonly class ListResponse
{
    /**
     * @param null|array<int,Model> $models
     */
    public function __construct(
        public null|array $models,
    ) {
    }

    /**
     * @param array{
     *     models:null|array,
     * } $data
     * @return ListResponse
     * @throws Exception
     */
    public static function make(array $data): ListResponse
    {
        return new ListResponse(
            models: array_map(
                callback: static fn (array $model): Model => Model::make(
                    data: $model,
                ),
                array: $data['models'] ?? [],
            ),
        );
    }
}
