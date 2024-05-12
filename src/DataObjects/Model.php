<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\DataObjects;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;

final readonly class Model
{
    public function __construct(
        public string $name,
        public DateTimeInterface $modified_at,
        public int $size,
        public string $digest,
        public ModelDetails $details,
    ) {}

    /**
     * @param array{
     *     name:string,
     *     modified_at:string,
     *     size:int,
     *     digest:string,
     *     details:array{
     *       format:string,
     *       family:string,
     *       famillies:null|array,
     *       parameter_size:string,
     *       quantization_level:string,
     *     }
     * } $data
     * @return Model
     * @throws Exception
     */
    public static function make(array $data): Model
    {
        return new Model(
            name: $data['name'],
            modified_at: new DateTimeImmutable(
                datetime: $data['modified_at'],
            ),
            size: $data['size'],
            digest: $data['digest'],
            details: ModelDetails::make(
                data: $data['details'],
            ),
        );
    }
}
