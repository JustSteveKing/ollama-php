<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\Requests;

use function array_map;
use function json_encode;

use JsonException;
use JustSteveKing\Ollama\DataObjects\Message;
use JustSteveKing\Ollama\DataObjects\Modelfile;

final readonly class Chat
{
    /**
     * @param string $model The model name
     * @param array<int,Message> $messages The messages of the chat, this can be used to keep a chat memory
     * @param string $format The format to return a response in. Currently, the only accepted value is json
     * @param bool $stream If false the response will be returned as a single response object, rather than a stream of objects
     * @param int|string $keep_alive Controls how long the model will stay loaded into memory following the request (default: 5m)
     * @param Modelfile|null $options Additional model parameters listed in the documentation for the Modelfile such as temperature
     */
    public function __construct(
        public string $model,
        public array $messages,
        public string $format = 'json',
        public bool $stream = false,
        public int|string $keep_alive = '5m',
        public null|Modelfile $options = null,
    ) {}

    /**
     * @param array{
     *     model:string,
     *     messages:array<int,array{
     *         role:string,
     *         content:string,
     *         images:null|array<int,string>,
     *     }>,
     *     format:null|string,
     *     stream:null|bool,
     *     keep_alive:null|int|string,
     *     options:null|array{
     *      mirostat:null|int,
     *      mirostat_eta:null|float,
     *      mirostat_tau:null|float,
     *      num_ctx:null|int,
     *      repeat_last_n:null|int,
     *      repeat_penalty:null|float,
     *      temperature:null|float,
     *      seed:null|int,
     *      stop:null|string,
     *      tfs_z:null|float,
     *      num_predict:null|int,
     *      top_k:null|int,
     *      top_p:null|float,
     *  },
     * } $data
     * @return Chat
     */
    public static function make(array $data): Chat
    {
        return new Chat(
            model: $data['model'],
            messages: array_map(
                callback: static fn(array $message): Message => Message::make(
                    data: $message,
                ),
                array: $data['messages'],
            ),
            format: $data['format'] ?? 'json',
            stream: $data['stream'] ?? false,
            keep_alive: $data['keep_alive'] ?? '5m',
            options: $data['options'] ? Modelfile::make(
                data: $data['options'],
            ) : null,
        );
    }

    /**
     * @return array{
     *     model:string,
     *     messages:array,
     *     format:string,
     *     stream:bool,
     *     keep_alive:int|string,
     *     options:null|array,
     * }}
     */
    public function toArray(): array
    {
        return [
            'model' => $this->model,
            'messages' => array_map(
                callback: static fn(Message $message): array => $message->toArray(),
                array: $this->messages,
            ),
            'format' => $this->format,
            'stream' => $this->stream,
            'keep_alive' => $this->keep_alive,
            'options' => $this->options?->toArray(),
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
