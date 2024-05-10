<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\Resources;

use Generator;
use JustSteveKing\Ollama\Concerns\CanStreamResponse;
use JustSteveKing\Ollama\DataObjects\Chat;
use JustSteveKing\Ollama\Exceptions\OllamaApiException;
use JustSteveKing\Ollama\Requests\NewChat;
use JustSteveKing\Sdk\Concerns\Resources\CanAccessClient;
use JustSteveKing\Sdk\Concerns\Resources\CanCreateRequests;
use JustSteveKing\Tools\Http\Enums\Method;
use Throwable;

final class ChatResource
{
    use CanAccessClient;
    use CanCreateRequests;
    use CanStreamResponse;

    public function ask(NewChat $prompt): Chat|Generator
    {
        $request = $this->request(
            method: Method::POST,
            uri: '/api/chat',
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

        return Chat::make(
            data: (array) json_decode(
                json: $response->getBody()->getContents(),
                associative: true,
                flags: JSON_THROW_ON_ERROR,
            )
        );
    }
}
