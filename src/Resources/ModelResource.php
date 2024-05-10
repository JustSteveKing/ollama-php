<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\Resources;

use Generator;
use JsonException;
use JustSteveKing\Ollama\Concerns\CanStreamResponse;
use JustSteveKing\Ollama\DataObjects\Model;
use JustSteveKing\Ollama\Exceptions\OllamaApiException;
use JustSteveKing\Ollama\Requests\NewModel;
use JustSteveKing\Sdk\Concerns\Resources\CanAccessClient;
use JustSteveKing\Sdk\Concerns\Resources\CanCreateRequests;
use JustSteveKing\Tools\Http\Enums\Method;
use Ramsey\Collection\Collection;
use Throwable;
use function array_map;

final class ModelResource
{
    use CanAccessClient;
    use CanCreateRequests;
    use CanStreamResponse;

    /**
     * @return Collection<Model>
     * @throws OllamaApiException|JsonException
     */
    public function list(): Collection
    {
        $request = $this->request(
            method: Method::GET,
            uri: '/api/tags',
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

        return (new Collection(
            collectionType: Model::class,
            data: array_map(
                callback: fn (array $model) => Model::make(
                    data: $model,
                ),
                array: (array) json_decode(
                    json: $response->getBody()->getContents(),
                    associative: true,
                    flags: JSON_THROW_ON_ERROR,
                )['models'],
            ),
        ));
    }

    public function create(NewModel $data): true|Generator
    {
        $request = $this->request(
            method: Method::POST,
            uri: '/api/create',
        );

        $payload = $this->payload(
            payload: $data->toString(),
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

        if ($data->stream) {
            return $this->stream(
                stream: $response->getBody(),
            );
        }

        return true;
    }
}
