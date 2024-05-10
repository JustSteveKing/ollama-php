<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\DataObjects;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use JsonException;
use function json_encode;

final readonly class Chat
{
    /**
     * @param string $model
     * @param Message $message
     * @param bool $done
     * @param int $total_duration
     * @param int $load_duration
     * @param int $prompt_eval_count
     * @param int $prompt_eval_duration
     * @param int $eval_count
     * @param int $eval_duration
     * @param DateTimeInterface $createdAt
     */
    public function __construct(
        public string $model,
        public Message $message,
        public bool $done,
        public int $total_duration,
        public int $load_duration,
        public int $prompt_eval_count,
        public int $prompt_eval_duration,
        public int $eval_count,
        public int $eval_duration,
        public DateTimeInterface $createdAt,
    ) {}

    /**
     * @param array{
     *     model:string,
     *     message:array{
     *         role:string,
     *         content:string,
     *         images:null|array<int,string>,
     *     },
     *     done:bool,
     *     total_duration:int,
     *     load_duration:int,
     *     prompt_eval_count:int,
     *     prompt_eval_duration:int,
     *     eval_count:int,
     *     eval_duration:int,
     *     created_at:string,
     * } $data
     * @return Chat
     * @throws Exception
     */
    public static function make(array $data): Chat
    {
        return new Chat(
            model: $data['model'],
            message: Message::make(
                data: $data['message'],
            ),
            done: (bool) $data['done'],
            total_duration: (int) $data['total_duration'],
            load_duration: (int) $data['load_duration'],
            prompt_eval_count: (int) $data['prompt_eval_count'],
            prompt_eval_duration: (int) $data['prompt_eval_duration'],
            eval_count: (int) $data['eval_count'],
            eval_duration: (int) $data['eval_duration'],
            createdAt: new DateTimeImmutable(
                datetime: $data['created_at'],
            ),
        );
    }

    /**
     * @return array{
     *     model:string,
     *     message:array,
     *     done:bool,
     *     total_duration:int,
     *     load_duration:int,
     *     prompt_eval_count:int,
     *     prompt_eval_duration:int,
     *     eval_count:int,
     *     eval_duration:int,
     *     created_at:DateTimeInterface,
     * }
     */
    public function toArray(): array
    {
        return [
            'model' => $this->model,
            'message' => $this->message->toArray(),
            'done' => $this->done,
            'total_duration' => $this->total_duration,
            'load_duration' => $this->load_duration,
            'prompt_eval_count' => $this->prompt_eval_count,
            'prompt_eval_duration' => $this->prompt_eval_duration,
            'eval_count' => $this->eval_count,
            'eval_duration' => $this->eval_duration,
            'created_at' => $this->createdAt,
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
