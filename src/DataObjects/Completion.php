<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\DataObjects;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;

final readonly class Completion
{
    /**
     * @param string $model
     * @param string $response Empty if the response was streamed, if not streamed, this will contain the full response
     * @param bool $done
     * @param array|null $context An encoding of the conversation used in this response, this can be sent in the next request to keep a conversational memory
     * @param null|int $total_duration Time spent generating the response
     * @param null|int $load_duration Time spent in nanoseconds loading the model
     * @param null|int $prompt_eval_count Number of tokens in the prompt
     * @param null|int $prompt_eval_duration Time spent in nanoseconds evaluating the prompt
     * @param null|int $eval_count Number of tokens in the response
     * @param null|int $eval_duration Time in nanoseconds spent generating the response
     * @param null|DateTimeInterface $createdAt
     */
    public function __construct(
        public string $model,
        public string $response,
        public bool $done,
        public null|array $context = null,
        public null|int $total_duration = null,
        public null|int $load_duration = null,
        public null|int $prompt_eval_count = null,
        public null|int $prompt_eval_duration = null,
        public null|int $eval_count = null,
        public null|int $eval_duration = null,
        public null|DateTimeInterface $createdAt = null,
    ) {}

    /**
     * @param array{
     *     model:string,
     *     response:string,
     *     done:bool,
     *     context:null|array,
     *     total_duration:int,
     *     load_duration:int,
     *     prompt_eval_count:int,
     *     prompt_eval_duration:int,
     *     eval_count:int,
     *     eval_duration:int,
     *     created_at:string,
     * } $data
     * @return Completion
     * @throws Exception
     */
    public static function make(array $data): Completion
    {
        return new Completion(
            model: $data['model'],
            response: $data['response'],
            done: $data['done'],
            context: $data['context'] ?? null,
            total_duration: $data['total_duration'] ?? null,
            load_duration: $data['load_duration'] ?? null,
            prompt_eval_count: $data['prompt_eval_count'] ?? null,
            prompt_eval_duration: $data['prompt_eval_duration'] ?? null,
            eval_count: $data['eval_count'] ?? null,
            eval_duration: $data['eval_duration'] ?? null,
            createdAt: $data['created_at'] ? new DateTimeImmutable(
                datetime: $data['created_at'],
            ) : null,
        );
    }

    /**
     * @return array{
     *     model:string,
     *     response:string,
     *     done:bool,
     *     context:null|array,
     *     total_duration:int,
     *     load_duration:int,
     *     prompt_eval_count:int,
     *     prompt_eval_duration:int,
     *     eval_count:int,
     *     eval_duration:int,
     *     created_at:string,
     * }
     */
    public function toArray(): array
    {
        return [
            'model' => $this->model,
            'response' => $this->response,
            'done' => $this->done,
            'context' => $this->context,
            'total_duration' => $this->total_duration,
            'load_duration' => $this->load_duration,
            'prompt_eval_count' => $this->prompt_eval_count,
            'prompt_eval_duration' => $this->prompt_eval_duration,
            'eval_count' => $this->eval_count,
            'eval_duration' => $this->eval_duration,
            'created_at' => $this->createdAt,
        ];
    }
}
