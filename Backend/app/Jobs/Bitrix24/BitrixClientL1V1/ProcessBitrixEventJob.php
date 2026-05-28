<?php namespace App\Jobs\Bitrix24\BitrixClientL1V1;

use App\Actions\Bitrix24\BitrixClientL1V1\HandleDealAddedAction;
use App\Actions\Bitrix24\BitrixClientL1V1\HandleDealUpdatedAction;
use App\Actions\Bitrix24\BitrixClientL1V1\HandleAppUninstallAction;
use App\DTO\Bitrix24\BitrixClientL1V1\EventPayload;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessBitrixEventJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public function __construct(
        public EventPayload $payload,
    ) {}

    public function handle(): void
    {
        match ($this->payload->event) {
            'ONCRMDEALADD' => app(HandleDealAddedAction::class)->execute($this->payload),
            'ONCRMDEALUPDATE' => app( HandleDealUpdatedAction::class )->execute($this->payload),
            'ONAPPUNINSTALL' => app( HandleAppUninstallAction::class )->execute($this->payload),
            default => null,
        };
    }
    public function backoff(): array
    {
        return [10, 30, 60];
    }
}
