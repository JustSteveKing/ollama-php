<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\Responses;

final readonly class EmbeddingsResponse
{
    /**
     * @param array<int,float|int> $embedding
     */
    public function __construct(
        public array $embedding,
    ) {}

    /**
     * @param array{
     *     embedding:array<int,float|int>
     * } $data
     * @return EmbeddingsResponse
     */
    public static function make(array $data): EmbeddingsResponse
    {
        return new EmbeddingsResponse(
            embedding: $data['embedding'],
        );
    }
}
