<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\Responses;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use JustSteveKing\Ollama\DataObjects\Message;

final readonly class ChatResponse
{
    public function __construct(
        public string $model,
        public DateTimeInterface $created_at,
        public Message $message,
        public bool $done,
        public null|int $total_duration,
        public null|int $load_duration,
        public null|int $prompt_eval_count,
        public null|int $prompt_eval_duration,
        public null|int $eval_count,
        public null|int $eval_duration,
    ) {}

    /**
     * @param array{
     *     model:string,
     *     created_at:string,
     *     message:array{
     *       role:string,
     *       content:string,
     *       images:null|array<int,string>,
     *     },
     *     done:bool,
     *     total_duration:null|int,
     *     load_duration:null|int,
     *     prompt_eval_count:null|int,
     *     prompt_eval_duration:null|int,
     *     eval_count:null|int,
     *     eval_duration:null|int,
     * } $data
     * @return ChatResponse
     * @throws Exception
     */
    public static function make(array $data): ChatResponse
    {
        return new ChatResponse(
            model: $data['model'],
            created_at: new DateTimeImmutable(
                datetime: $data['created_at'],
            ),
            message: Message::make(
                data: $data['message'],
            ),
            done: $data['done'],
            total_duration: $data['total_duration'] ?? null,
            load_duration: $data['load_duration'] ?? null,
            prompt_eval_count: $data['prompt_eval_count'] ?? null,
            prompt_eval_duration: $data['prompt_eval_duration'] ?? null,
            eval_count: $data['eval_count'] ?? null,
            eval_duration: $data['eval_duration'] ?? null,
        );
    }
}
