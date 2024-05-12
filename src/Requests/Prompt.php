<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\Requests;

use function json_encode;

use JsonException;
use JustSteveKing\Ollama\DataObjects\Modelfile;

final readonly class Prompt
{
    /**
     * Generate a response for a given prompt with a provided model. This is a streaming endpoint,
     *  so there will be a series of responses. The final response object will include statistics and
     *  additional data from the request.
     *
     * @param string $model The name of the model to use for the chat.
     * @param string $prompt The prompt to send to the model.
     * @param string|null $system (Optional) Override the model system prompt.
     * @param string|null $template (Optional) Override the model template.
     * @param bool|null $raw (Optional) Bypass the prompt template and pass the prompt directly to the model.
     * @param array|null $images (Optional) Images to be included, either as Uint8Array or base64 encoded strings.
     * @param string|null $format (Optional) Set the expected format of the response (json).
     * @param bool|null $stream (Optional) Set the expected format of the response (json).
     * @param int|string|null $keep_alive (Optional) How long to keep the model loaded.
     * @param Modelfile|null $options (Optional) Options to configure the runtime.
     */
    public function __construct(
        public string $model,
        public string $prompt,
        public null|string $system = null,
        public null|string $template = null,
        public null|bool $raw = null,
        public null|array $images = null,
        public null|string $format = 'json',
        public null|bool $stream = false,
        public null|int|string $keep_alive = '5m',
        public null|Modelfile $options = null,
    ) {}

    /**
     * @param array{
     *     model:string,
     *     prompt:string,
     *     system:null|string,
     *     template:null|string,
     *     raw:null|bool,
     *     images:null|array<int,string>,
     *     format:null|string,
     *     stream:null|bool,
     *     keep_alive:null|int|string,
     *     options:null|array{
     *       mirostat:null|int,
     *       mirostat_eta:null|float,
     *       mirostat_tau:null|float,
     *       num_ctx:null|int,
     *       repeat_last_n:null|int,
     *       repeat_penalty:null|float,
     *       temperature:null|float,
     *       seed:null|int,
     *       stop:null|string,
     *       tfs_z:null|float,
     *       num_predict:null|int,
     *       top_k:null|int,
     *       top_p:null|float,
     *     },
     * } $data
     * @return Prompt
     */
    public static function make(array $data): Prompt
    {
        return new Prompt(
            model: $data['model'],
            prompt: $data['prompt'],
            system: $data['system'] ?? null,
            template: $data['template'] ?? null,
            raw: $data['raw'] ?? null,
            images: $data['images'] ?? null,
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
     *     prompt:string,
     *     system:null|string,
     *     template:null|string,
     *     raw:null|bool,
     *     images:null|array<int,string>,
     *     format:null|string,
     *     stream:null|bool,
     *     keep_alive:null|int|string,
     *     options:null|array,
     * }
     */
    public function toArray(): array
    {
        return [
            'model' => $this->model,
            'prompt' => $this->prompt,
            'system' => $this->system,
            'template' => $this->template,
            'raw' => $this->raw,
            'images' => $this->images,
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
