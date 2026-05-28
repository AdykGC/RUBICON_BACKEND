<?php namespace App\DTO\Bitrix24\BitrixClientL1V1;

class EventPayload
{
    public function __construct(
        public readonly string $event,
        public readonly array $payload,
        public readonly int $portalId,
    ) {}

    public static function make(
        string $event,
        int $portalId,
        array $payload,
    ): self {
        return new self(
            event: $event,
            payload: $payload,
            portalId: $portalId,
        );
    }
}