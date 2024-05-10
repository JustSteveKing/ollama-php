<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\Concerns;

use Generator;
use Psr\Http\Message\StreamInterface;

trait CanStreamResponse
{
    /**
     * @param StreamInterface $stream
     * @return Generator
     */
    protected function stream(StreamInterface $stream): Generator
    {
        while ( ! $stream->eof()) {
            yield $stream->read(
                length: 1024,
            );
        }
    }
}
