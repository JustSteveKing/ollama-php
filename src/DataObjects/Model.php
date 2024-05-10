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
        public int $size,
        public string $digest,
        public ModelDetails $details,
        public null|DateTimeInterface $modifiedAt,
    ) {}

    /**
     * @param array{
     *     name:string,
     *     size:int,
     *     digest:string,
     *     details:array{
     *         format:string,
     *         family:string,
     *         families:null|array<int,string>,
     *         parameter_size:string,
     *         quantization_level:string,
     *     },
     *     modified_at:null|string
     * } $data
     * @return Model
     * @throws Exception
     */
    public static function make(array $data): Model
    {
        return new Model(
            name: $data['name'],
            size: $data['size'],
            digest: $data['digest'],
            details: ModelDetails::make(
                data: $data['details'],
            ),
            modifiedAt: $data['modified_at'] ? new DateTimeImmutable(
                datetime: $data['modified_at'],
            ) : null,
        );
    }
}
