<?php namespace App\DTO\Bitrix24\BitrixClientL1V1;

use Illuminate\Http\Request;

class UninstallPayload
{
    public function __construct(
        public readonly ?string $memberId,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            memberId: $request->input('member_id')?: $request->input('MEMBER_ID'),
        );
    }
}