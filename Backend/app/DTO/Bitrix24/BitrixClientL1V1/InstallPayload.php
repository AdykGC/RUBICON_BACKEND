<?php namespace App\DTO\Bitrix24\BitrixClientL1V1;

use Illuminate\Http\Request;

class InstallPayload
{
    public function __construct(
        public readonly string $memberId,
        public readonly string $domain,
        public readonly string $accessToken,
        public readonly ?string $refreshToken,
        public readonly int $expiresIn,
        public readonly ?string $applicationToken,
        public readonly ?string $scope,
        public readonly ?string $endpoint,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            memberId: $request->input('member_id')?: $request->input('MEMBER_ID'),
            domain: $request->input('DOMAIN'),
            accessToken: $request->input('AUTH_ID'),
            refreshToken: $request->input('REFRESH_ID'),
            expiresIn: (int) $request->input('AUTH_EXPIRES', 3600),
            applicationToken: $request->input('APPLICATION_TOKEN'),
            scope: $request->input('APPLICATION_SCOPE'),
            endpoint: $request->input('SERVER_ENDPOINT'),
        );
    }
}