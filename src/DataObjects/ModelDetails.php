<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\DataObjects;

final readonly class ModelDetails
{
    public function __construct(
        public string $format,
        public string $family,
        public null|array $families,
        public string $parameter_size,
        public string $quantization_level,
    ) {}

    public static function make(array $data): ModelDetails
    {
        return new ModelDetails(
            format: $data['format'],
            family: $data['family'],
            families: $data['families'] ?? null,
            parameter_size: $data['parameter_size'],
            quantization_level: $data['quantization_level'],
        );
    }
}
