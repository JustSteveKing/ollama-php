<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\DataObjects;

use JsonException;

final readonly class Modelfile
{
    /**
     * @param int $mirostat Enable Mirostat sampling for controlling perplexity. (default: 0, 0 = disabled, 1 = Mirostat, 2 = Mirostat 2.0)
     * @param float $mirostat_eta Influences how quickly the algorithm responds to feedback from the generated text. A lower learning rate will result in slower adjustments, while a higher learning rate will make the algorithm more responsive. (Default: 0.1)
     * @param float $mirostat_tau Controls the balance between coherence and diversity of the output. A lower value will result in more focused and coherent text. (Default: 5.0)
     * @param int $num_ctx Sets the size of the context window used to generate the next token. (Default: 2048)
     * @param int $repeat_last_n Sets how far back for the model to look back to prevent repetition. (Default: 64, 0 = disabled, -1 = num_ctx)
     * @param float $repeat_penalty Sets how strongly to penalize repetitions. A higher value (e.g., 1.5) will penalize repetitions more strongly, while a lower value (e.g., 0.9) will be more lenient. (Default: 1.1)
     * @param float $temperature The temperature of the model. Increasing the temperature will make the model answer more creatively. (Default: 0.8)
     * @param int $seed Sets the random number seed to use for generation. Setting this to a specific number will make the model generate the same text for the same prompt. (Default: 0)
     * @param null|string $stop Sets the stop sequences to use. When this pattern is encountered the LLM will stop generating text and return. Multiple stop patterns may be set by specifying multiple separate stop parameters in a modelfile.
     * @param float $tfs_z Tail free sampling is used to reduce the impact of less probable tokens from the output. A higher value (e.g., 2.0) will reduce the impact more, while a value of 1.0 disables this setting. (default: 1)
     * @param int $num_predict Maximum number of tokens to predict when generating text. (Default: 128, -1 = infinite generation, -2 = fill context)
     * @param int $top_k Reduces the probability of generating nonsense. A higher value (e.g. 100) will give more diverse answers, while a lower value (e.g. 10) will be more conservative. (Default: 40)
     * @param float $top_p Works together with top-k. A higher value (e.g., 0.95) will lead to more diverse text, while a lower value (e.g., 0.5) will generate more focused and conservative text. (Default: 0.9)
     */
    public function __construct(
        public int $mirostat,
        public float $mirostat_eta,
        public float $mirostat_tau,
        public int $num_ctx,
        public int $repeat_last_n,
        public float $repeat_penalty,
        public float $temperature,
        public int $seed,
        public null|string $stop,
        public float $tfs_z,
        public int $num_predict,
        public int $top_k,
        public float $top_p,
    ) {}

    /**
     * @param array{
     *      mirostat:int,
     *      microstat_eta:float,
     *      mirostat_tau:float,
     *      num_ctx:int,
     *      repeat_last_n:int,
     *      repeat_penalty:float,
     *      temperature:float,
     *      seed:int,
     *      stop:null|string,
     *      tfs_z:float,
     *      num_predict:int,
     *      top_k:int,
     *      top_p:float,
     *  } $data
     * @return Modelfile
     */
    public static function make(array $data): Modelfile
    {
        return new Modelfile(
            mirostat: $data['mirostat'] ?? 0,
            mirostat_eta: $data['mirostat_eta'] ?? 0.1,
            mirostat_tau: $data['mirostat_tau'] ?? 5.0,
            num_ctx: $data['num_ctx'] ?? 2048,
            repeat_last_n: $data['repeat_last_n'] ?? 64,
            repeat_penalty: $data['repeat_penalty'] ?? 1.1,
            temperature: $data['temperature'] ?? 0.8,
            seed: $data['seed'] ?? 0,
            stop: $data['stop'] ??  null,
            tfs_z: $data['tfs_z'] ?? 1,
            num_predict: $data['num_predict'] ?? 128,
            top_k: $data['top_k'] ?? 40,
            top_p: $data['top_p'] ?? 0.9,
        );
    }

    /**
     * @return array{
     *     mirostat:int,
     *     microstat_eta:float,
     *     mirostat_tau:float,
     *     num_ctx:int,
     *     repeat_last_n:int,
     *     repeat_penalty:float,
     *     temperature:float,
     *     seed:int,
     *     stop:null|string,
     *     tfs_z:float,
     *     num_predict:int,
     *     top_k:int,
     *     top_p:float,
     * }
     */
    public function toArray(): array
    {
        return [
            'mirostat' => $this->mirostat,
            'mirostat_eta' => $this->mirostat_eta,
            'mirostat_tau' => $this->mirostat_tau,
            'num_ctx' => $this->num_ctx,
            'repeat_last_n' => $this->repeat_last_n,
            'repeat_penalty' => $this->repeat_penalty,
            'temperature' => $this->temperature,
            'seed' => $this->seed,
            'stop' => $this->stop,
            'tfs_z' => $this->tfs_z,
            'num_predict' => $this->num_predict,
            'top_k' => $this->top_k,
            'top_p' => $this->top_p,
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
