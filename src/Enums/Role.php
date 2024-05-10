<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\Enums;

enum Role: string
{
    case User = 'user';
    case System = 'system';
    case Assistant = 'assistant';
}
