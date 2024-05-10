<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\Resources;

use Generator;
use JsonException;
use JustSteveKing\Ollama\Concerns\CanStreamResponse;
use JustSteveKing\Ollama\DataObjects\Completion;
use JustSteveKing\Ollama\Exceptions\OllamaApiException;
use JustSteveKing\Ollama\Requests\NewCompletion;
use JustSteveKing\Sdk\Concerns\Resources\CanAccessClient;
use JustSteveKing\Sdk\Concerns\Resources\CanCreateRequests;
use JustSteveKing\Tools\Http\Enums\Method;
use Throwable;
use function json_decode;

final class CompletionResource
{
    use CanAccessClient;
    use CanCreateRequests;
    use CanStreamResponse;

    /**
     * @param NewCompletion $prompt
     * @return Completion|Generator
     * @throws OllamaApiException|JsonException
     */
    public function create(NewCompletion $prompt): Completion|Generator
    {
        $request = $this->request(
            method: Method::POST,
            uri: '/api/generate',
        );

        $payload = $this->payload(
            payload: $prompt->toString(),
        );

        $request = $request->withBody(
            body: $payload,
        );

        try {
            $response = $this->client->send(
                request: $request,
            );
        } catch (Throwable $exception) {
            throw new OllamaApiException(
                message: $exception->getMessage(),
                previous: $exception,
            );
        }

        if ($prompt->stream) {
            return $this->stream(
                stream: $response->getBody(),
            );
        }

        return Completion::make(
            data: (array) json_decode(
                json: $response->getBody()->getContents(),
                associative: true,
                flags: JSON_THROW_ON_ERROR,
            ),
        );
    }
}
