<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\Responses;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;

use function trim;

final readonly class GenerateResponse
{
    /**
     * @param string $model
     * @param DateTimeInterface $created_at
     * @param string $response
     * @param bool $done
     * @param null|array $context
     * @param null|int $total_duration
     * @param null|int $load_duration
     * @param null|int $prompt_eval_count
     * @param null|int $prompt_eval_duration
     * @param null|int $eval_count
     * @param null|int $eval_duration
     */
    public function __construct(
        public string $model,
        public DateTimeInterface $created_at,
        public string $response,
        public bool $done,
        public null|array $context,
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
     *     response:string,
     *     done:bool,
     *     context:null|array,
     *     total_duration:null|int,
     *     load_duration:null|int,
     *     prompt_eval_count:null|int,
     *     prompt_eval_duration:null|int,
     *     eval_count:null|int,
     *     eval_duration:null|int,
     * } $data
     * @return GenerateResponse
     * @throws Exception
     */
    public static function make(array $data): GenerateResponse
    {
        return new GenerateResponse(
            model: $data['model'],
            created_at: new DateTimeImmutable(
                datetime: $data['created_at'],
            ),
            response: trim($data['response']),
            done: $data['done'],
            context: $data['context'] ?? null,
            total_duration: $data['total_duration'] ?? null,
            load_duration: $data['load_duration'] ?? null,
            prompt_eval_count: $data['prompt_eval_count'] ?? null,
            prompt_eval_duration: $data['prompt_eval_duration'] ?? null,
            eval_count: $data['eval_count'] ?? null,
            eval_duration: $data['eval_duration'] ?? null,
        );
    }
}
