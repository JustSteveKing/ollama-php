<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\Requests;

use JsonException;
use JustSteveKing\Ollama\DataObjects\Message;
use JustSteveKing\Ollama\DataObjects\Modelfile;
use function json_encode;

final readonly class NewChat
{
    /**
     * @param string $model
     * @param array<int,Message> $messages
     * @param string|null $format
     * @param Modelfile|null $options
     * @param bool $stream
     * @param string $keep_alive
     */
    public function __construct(
        public string $model,
        public array $messages,
        public null|string $format = 'json',
        public null|Modelfile $options = null,
        public bool $stream = false,
        public string $keep_alive = '5m',
    ) {}

    /**
     * @param array{
     *     model:string,
     *     messages:array,
     *     format:null|string,
     *     options:null|array,
     *     stream:bool,
     *     keep_alive:string,
     * } $data
     * @return NewChat
     */
    public static function make(array $data): NewChat
    {
        return new NewChat(
            model: $data['model'],
            messages: array_map(
                callback: static fn (array $message): Message => Message::make(
                    data: $message,
                ),
                array: $data['messages'],
            ),
            format: $data['format'] ?? 'json',
            options: $data['options'] ? Modelfile::make(
                data: $data['options'],
            ) : null,
            stream: $data['stream'] ?? false,
            keep_alive: $data['keep_alive'] ?? '5m',
        );
    }

    /**
     * @return array{
     *     model:string,
     *     messages:array<int,Message>,
     *     format:null|string,
     *     options:null|Modelfile,
     *     stream:bool,
     *     keep_alive:string,
     * }
     */
    public function toArray(): array
    {
        return [
            'model' => $this->model,
            'messages' => $this->messages,
            'format' => $this->format,
            'options' => $this->options,
            'stream' => $this->stream,
            'keep_alive' => $this->keep_alive,
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
