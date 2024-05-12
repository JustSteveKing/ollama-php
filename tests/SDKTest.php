<?php

declare(strict_types=1);

use JustSteveKing\Ollama\Responses\ChatResponse;
use JustSteveKing\Ollama\Responses\EmbeddingsResponse;
use JustSteveKing\Ollama\Responses\GenerateResponse;
use JustSteveKing\Ollama\Responses\ListResponse;
use JustSteveKing\Ollama\Responses\StatusResponse;
use JustSteveKing\Sdk\Client;

test('an SDK can be created', function (): void {
    expect(
        sdk(),
    )->toBeInstanceOf(Client::class);
});

test('can send a chat request', function (): void {
    expect(
        mockClient('ollama/chat')->chat(
            chat: newChat(),
        ),
    )->toBeInstanceOf(ChatResponse::class);
});

test('it can send a create request', function (): void {
    expect(
        mockClient('ollama/create')->create(
            model: newCreate(),
        )
    )->toBeInstanceOf(StatusResponse::class);
});

test('it can send a generate request', function (): void {
    expect(
        mockClient('ollama/generate')->generate(
            prompt: newPrompt(),
        ),
    )->toBeInstanceOf(GenerateResponse::class);
});

test('it can send a pull request', function (): void {
    expect(
        mockClient('ollama/pull')->pull(
            pull: newModel()
        ),
    )->toBeInstanceOf(StatusResponse::class);
});

test('it can send a push request', function (): void {
    expect(
        mockClient('ollama/push')->push(
            push: newModel()
        ),
    )->toBeInstanceOf(StatusResponse::class);
});

test('it can send a delete request', function (): void {
    expect(
        mockClient('ollama/push')->delete(
            name: 'test',
        ),
    )->toBeBool()->toEqual(true);
});

test('it can send a list request', function (): void {
    expect(
        mockClient('ollama/list')->list(),
    )->toBeInstanceOf(ListResponse::class);
});

test('it can send an embedding request', function (): void {
    expect(
        mockClient('ollama/embeddings')->embeddings(
            embeddings: newEmbeddings(),
        ),
    )->toBeInstanceOf(EmbeddingsResponse::class);
});
