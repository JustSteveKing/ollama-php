<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\DataObjects;

final readonly class ModelDetails
{
    public function __construct(
        public string $format,
        public string $family,
        public array $families,
        public string $parameterSize,
        public string $quantizationLevel,
    ) {}

    /**
     * @param array{
     *     format:string,
     *     family:string,
     *     families:null|array<int,string>,
     *     parameter_size:string,
     *     quantization_level:string,
     * } $data
     * @return ModelDetails
     */
    public static function make(array $data): ModelDetails
    {
        return new ModelDetails(
            format: $data['format'],
            family: $data['family'],
            families: $data['families'] ?? [],
            parameterSize: $data['parameter_size'],
            quantizationLevel: $data['quantization_level'],
        );
    }
}
