<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama;

use Generator;

use function json_decode;
use function json_encode;

use JsonException;
use JustSteveKing\Ollama\Concerns\CanCreateRequests;
use JustSteveKing\Ollama\Concerns\CanStreamResponse;
use JustSteveKing\Ollama\Exceptions\OllamaApiException;
use JustSteveKing\Ollama\Requests\Chat;
use JustSteveKing\Ollama\Requests\CreateRequest;
use JustSteveKing\Ollama\Requests\Embeddings;
use JustSteveKing\Ollama\Requests\Model;

use JustSteveKing\Ollama\Requests\Prompt;
use JustSteveKing\Ollama\Responses\ChatResponse;
use JustSteveKing\Ollama\Responses\EmbeddingsResponse;
use JustSteveKing\Ollama\Responses\GenerateResponse;
use JustSteveKing\Ollama\Responses\ListResponse;
use JustSteveKing\Ollama\Responses\StatusResponse;
use JustSteveKing\Sdk\Client;
use JustSteveKing\Tools\Http\Enums\Method;
use JustSteveKing\Tools\Http\Enums\Status;
use Throwable;

final class SDK extends Client
{
    use CanCreateRequests;
    use CanStreamResponse;

    /**
     * Generate the next message in a chat with a provided model. This is a streaming endpoint,
     * so there will be a series of responses. Streaming can be disabled using "stream": false. The final
     * response object will include statistics and additional data from the request.
     *
     * @param Chat $chat
     * @return ChatResponse|Generator
     * @throws OllamaApiException|JsonException
     */
    public function chat(Chat $chat): ChatResponse|Generator
    {
        $payload = $this->payload(
            payload: $chat->toString(),
        );

        $request = $this->request(
            method: Method::POST,
            uri: '/api/chat',
        );

        $request = $request->withBody(
            body: $payload,
        );

        try {
            $response = $this->send(
                request: $request,
            );
        } catch (Throwable $exception) {
            throw new OllamaApiException(
                message: $exception->getMessage(),
                code: $exception->getCode(),
                previous: $exception,
            );
        }

        if ($chat->stream) {
            return $this->stream(
                stream: $response->getBody(),
            );
        }

        return ChatResponse::make(
            /** @phpstan-ignore-next-line */
            data: (array) json_decode(
                json: $response->getBody()->getContents(),
                associative: true,
                flags: JSON_THROW_ON_ERROR,
            ),
        );
    }

    /**
     * Create a model from a Modelfile. It is recommended to set modelfile to the content of the Modelfile
     * rather than just set path. This is a requirement for remote create. Remote model creation must also
     * create any file blobs, fields such as FROM and ADAPTER, explicitly with the server using Create a Blob
     * and the value to the path indicated in the response.
     *
     * @param CreateRequest $model
     * @return StatusResponse|Generator
     * @throws OllamaApiException|JsonException
     */
    public function create(CreateRequest $model): StatusResponse|Generator
    {
        $payload = $this->payload(
            payload: $model->toString(),
        );

        $request = $this->request(
            method: Method::POST,
            uri: '/api/create',
        );

        $request = $request->withBody(
            body: $payload,
        );

        try {
            $response = $this->send(
                request: $request,
            );
        } catch (Throwable $exception) {
            throw new OllamaApiException(
                message: $exception->getMessage(),
                code: $exception->getCode(),
                previous: $exception,
            );
        }

        if ($model->stream) {
            return $this->stream(
                stream: $response->getBody(),
            );
        }

        return StatusResponse::make(
            /** @phpstan-ignore-next-line */
            data: (array) json_decode(
                json: $response->getBody()->getContents(),
                associative: true,
                flags: JSON_THROW_ON_ERROR,
            ),
        );
    }

    /**
     * Generate a response for a given prompt with a provided model. This is a streaming
     * endpoint, so there will be a series of responses. The final response object will include statistics
     * and additional data from the request.
     *
     * @param Prompt $prompt
     * @return GenerateResponse|Generator
     * @throws OllamaApiException|JsonException
     */
    public function generate(Prompt $prompt): GenerateResponse|Generator
    {
        $payload = $this->payload(
            payload: $prompt->toString(),
        );

        $request = $this->request(
            method: Method::POST,
            uri: '/api/generate',
        );

        $request = $request->withBody(
            body: $payload,
        );

        try {
            $response = $this->send(
                request: $request,
            );
        } catch (Throwable $exception) {
            throw new OllamaApiException(
                message: $exception->getMessage(),
                code: $exception->getCode(),
                previous: $exception,
            );
        }

        if ($prompt->stream) {
            return $this->stream(
                stream: $response->getBody(),
            );
        }

        return GenerateResponse::make(
            /** @phpstan-ignore-next-line */
            data: (array) json_decode(
                json: $response->getBody()->getContents(),
                associative: true,
                flags: JSON_THROW_ON_ERROR,
            ),
        );
    }

    /**
     * Download a model from the ollama library. Cancelled pulls are resumed from where they left off, and
     * multiple calls will share the same download progress.
     *
     * @param Model $pull
     * @return StatusResponse|Generator
     * @throws OllamaApiException|JsonException
     */
    public function pull(Model $pull): StatusResponse|Generator
    {
        $payload = $this->payload(
            payload: $pull->toString(),
        );

        $request = $this->request(
            method: Method::POST,
            uri: '/api/pull',
        );

        $request = $request->withBody(
            body: $payload,
        );

        try {
            $response = $this->send(
                request: $request,
            );
        } catch (Throwable $exception) {
            throw new OllamaApiException(
                message: $exception->getMessage(),
                code: $exception->getCode(),
                previous: $exception,
            );
        }

        if ($pull->stream) {
            return $this->stream(
                stream: $response->getBody(),
            );
        }

        return StatusResponse::make(
            /** @phpstan-ignore-next-line */
            data: (array) json_decode(
                json: $response->getBody()->getContents(),
                associative: true,
                flags: JSON_THROW_ON_ERROR,
            ),
        );
    }

    /**
     * Upload a model to a model library. Requires registering for ollama.ai and adding a public key first.
     *
     * @param Model $push
     * @return StatusResponse|Generator
     * @throws JsonException
     * @throws OllamaApiException
     */
    public function push(Model $push): StatusResponse|Generator
    {
        $payload = $this->payload(
            payload: $push->toString(),
        );

        $request = $this->request(
            method: Method::POST,
            uri: '/api/push',
        );

        $request = $request->withBody(
            body: $payload,
        );

        try {
            $response = $this->send(
                request: $request,
            );
        } catch (Throwable $exception) {
            throw new OllamaApiException(
                message: $exception->getMessage(),
                code: $exception->getCode(),
                previous: $exception,
            );
        }

        if ($push->stream) {
            return $this->stream(
                stream: $response->getBody(),
            );
        }

        return StatusResponse::make(
            /** @phpstan-ignore-next-line */
            data: (array) json_decode(
                json: $response->getBody()->getContents(),
                associative: true,
                flags: JSON_THROW_ON_ERROR,
            ),
        );
    }

    /**
     * Delete a model and its data.
     *
     * @param string $name
     * @return bool
     * @throws OllamaApiException|JsonException
     */
    public function delete(string $name): bool
    {
        $payload = $this->payload(
            payload: (string) json_encode(
                value: [
                    'model' => $name,
                ],
                flags: JSON_THROW_ON_ERROR,
            ),
        );

        $request = $this->request(
            method: Method::DELETE,
            uri: '/api/delete',
        );

        $request = $request->withBody(
            body: $payload,
        );

        try {
            $response = $this->send(
                request: $request,
            );
        } catch (Throwable $exception) {
            throw new OllamaApiException(
                message: $exception->getMessage(),
                code: $exception->getCode(),
                previous: $exception,
            );
        }

        return $response->getStatusCode() === Status::OK->value;
    }

    /**
     * List models that are available locally.
     *
     * @return ListResponse
     * @throws OllamaApiException|JsonException
     */
    public function list(): ListResponse
    {
        $request = $this->request(
            method: Method::GET,
            uri: '/api/tags',
        );

        try {
            $response = $this->send(
                request: $request,
            );
        } catch (Throwable $exception) {
            throw new OllamaApiException(
                message: $exception->getMessage(),
                code: $exception->getCode(),
                previous: $exception,
            );
        }

        return ListResponse::make(
            /** @phpstan-ignore-next-line */
            data: (array) json_decode(
                json: $response->getBody()->getContents(),
                associative: true,
                flags: JSON_THROW_ON_ERROR,
            ),
        );
    }

    /**
     * Generate embeddings from a model
     *
     * @param Embeddings $embeddings
     * @return EmbeddingsResponse
     * @throws OllamaApiException|JsonException
     */
    public function embeddings(Embeddings $embeddings): EmbeddingsResponse
    {
        $payload = $this->payload(
            payload: $embeddings->toString(),
        );

        $request = $this->request(
            method: Method::POST,
            uri: '/api/embeddings',
        );

        $request = $request->withBody(
            body: $payload,
        );

        try {
            $response = $this->send(
                request: $request,
            );
        } catch (Throwable $exception) {
            throw new OllamaApiException(
                message: $exception->getMessage(),
                code: $exception->getCode(),
                previous: $exception,
            );
        }

        return EmbeddingsResponse::make(
            /** @phpstan-ignore-next-line */
            data: (array) json_decode(
                json: $response->getBody()->getContents(),
                associative: true,
                flags: JSON_THROW_ON_ERROR,
            ),
        );
    }
}
