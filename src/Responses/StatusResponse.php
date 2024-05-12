<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\Responses;

final readonly class StatusResponse
{
    public function __construct(
        public string $status,
    ) {}

    /**
     * @param array{
     *     status:string,
     * } $data
     * @return StatusResponse
     */
    public static function make(array $data): StatusResponse
    {
        return new StatusResponse(
            status: $data['status'],
        );
    }
}
