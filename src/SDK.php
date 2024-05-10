<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama;

use JustSteveKing\Ollama\Resources\ChatResource;
use JustSteveKing\Ollama\Resources\CompletionResource;
use JustSteveKing\Ollama\Resources\ModelResource;
use JustSteveKing\Sdk\Client;

final class SDK extends Client
{
    public function chats(): ChatResource
    {
        return new ChatResource(
            client:  $this,
        );
    }

    /**
     * @return CompletionResource
     */
    public function completions(): CompletionResource
    {
        return new CompletionResource(
            client: $this,
        );
    }

    /**
     * @return ModelResource
     */
    public function models(): ModelResource
    {
        return new ModelResource(
            client: $this,
        );
    }
}
