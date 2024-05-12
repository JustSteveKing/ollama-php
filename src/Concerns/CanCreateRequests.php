<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\Concerns;

use Http\Discovery\Psr17FactoryDiscovery;
use JustSteveKing\Ollama\SDK;
use JustSteveKing\Tools\Http\Enums\Method;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @mixin SDK
 */
trait CanCreateRequests
{
    public function request(Method $method, string $uri): RequestInterface
    {
        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            method: $method->value,
            uri: "{$this->url()}{$uri}",
        );
    }

    /**
     * Create a new Stream for sending data to the API using PSR-17 discovery.
     */
    public function payload(string $payload): StreamInterface
    {
        return Psr17FactoryDiscovery::findStreamFactory()->createStream(
            content: $payload,
        );
    }
}
