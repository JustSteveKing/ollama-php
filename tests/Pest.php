<?php

declare(strict_types=1);

use Http\Mock\Client;
use JustSteveKing\Ollama\DataObjects\Message;
use JustSteveKing\Ollama\Enums\Role;
use JustSteveKing\Ollama\Requests\Chat;
use JustSteveKing\Ollama\Requests\CreateRequest;
use JustSteveKing\Ollama\Requests\Embeddings;
use JustSteveKing\Ollama\Requests\Model;
use JustSteveKing\Ollama\Requests\Prompt;
use JustSteveKing\Ollama\SDK;
use JustSteveKing\Ollama\Tests\PackageTestCase;
use JustSteveKing\Sdk\Contracts\ClientContract;
use JustSteveKing\Tools\Http\Enums\Status;
use Nyholm\Psr7\Response;

uses(PackageTestCase::class)->in(__DIR__);

/**
 * @param string $apiToken
 * @param string $url
 * @return SDK
 */
function sdk(string $apiToken = '', string $url = 'http://localhost:11434'): SDK
{
    return new SDK(
        apiToken: $apiToken,
        url: $url,
    );
}

/**
 * @param string $fixture
 * @return ClientContract
 * @throws JsonException
 */
function mockClient(string $fixture): ClientContract
{
    $mock = new Client();

    $mock->addResponse(
        response: new Response(
            status: Status::OK->value,
            headers: [
                'Content-Type' => 'application/json',
            ],
            body: (string) json_encode(
                value: fixture(
                    name: $fixture,
                ),
                flags: JSON_THROW_ON_ERROR,
            ),
        ),
    );

    return (new SDK(
        apiToken: '',
        url: 'http://localhost:11434',
    ))->client(
        client: $mock,
    );
}

/**
 * @param string $name
 * @return array
 * @throws JsonException
 */
function fixture(string $name): array
{
    $filename = __DIR__ . "/Fixtures/{$name}.json";

    if ( ! file_exists(filename: $filename)) {
        throw new InvalidArgumentException(
            message: 'Failed to fetch fixture.',
        );
    }

    return (array) json_decode(
        json: file_get_contents(
            filename: $filename,
        ),
        associative: true,
        flags: JSON_THROW_ON_ERROR,
    );
}

function newChat(): Chat
{
    return new Chat(
        model: 'llama3',
        messages: [
            new Message(
                role: Role::User,
                content: 'test',
            ),
        ],
    );
}

function newCreate(): CreateRequest
{
    return new CreateRequest(
        model: 'llama3',
        path: null,
        modelfile: null,
        stream: false,
    );
}

function newPrompt(): Prompt
{
    return new Prompt(
        model: 'llama3',
        prompt: 'test',
    );
}

function newModel(): Model
{
    return new Model(
        model: 'llama3',
    );
}

function newEmbeddings(): Embeddings
{
    return new Embeddings(
        model: 'llama3',
        prompt: 'test',
    );
}
