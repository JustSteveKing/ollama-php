<?php

declare(strict_types=1);

namespace JustSteveKing\Ollama\DataObjects;

use JsonException;
use JustSteveKing\Ollama\Enums\Role;
use function json_encode;

final readonly class Message
{
    /**
     * @param Role $role The role of the message, either system, user or assistant
     * @param string $content The content of the message
     * @param null|array<int,string> $images A list of images to include in the message (for multimodal models such as llava)
     */
    public function __construct(
        public Role $role,
        public string $content,
        public null|array $images = null,
    ) {}

    /**
     * @param array{
     *     role:string,
     *     content:string,
     *     images:null|array<int,string>,
     * } $data
     * @return Message
     */
    public static function make(array $data): Message
    {
        return new Message(
            role: Role::from(
                value: $data['role'],
            ),
            content: $data['content'],
            images: $data['images'] ?? null,
        );
    }

    /**
     * @return array{
     *     role:string,
     *     content:string,
     *     images:null|array<int,string>,
     * }
     */
    public function toArray(): array
    {
        return [
            'role' => $this->role->value,
            'content' => $this->content,
            'images' => $this->images,
        ];
    }

    /**
     * @return string
     * @throws JsonException
     */
    public function toString(): string
    {
        return json_encode(
            value: $this->toArray(),
            flags: JSON_THROW_ON_ERROR,
        );
    }
}
