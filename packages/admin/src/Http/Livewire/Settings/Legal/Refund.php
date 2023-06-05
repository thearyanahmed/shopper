<?php

declare(strict_types=1);

namespace Shopper\Http\Livewire\Settings\Legal;

use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Shopper\Core\Traits\Attributes\WithLegalActions;

class Refund extends Component
{
    use WithLegalActions;

    public string $title = 'Refund policy';

    protected $listeners = [
        'trix:valueUpdated' => 'onTrixValueUpdate',
    ];

    public function onTrixValueUpdate(string $value): void
    {
        $this->content = $value;
    }

    public function store(): void
    {
        $this->storeValues(__($this->title), $this->content, $this->isEnabled);

        Notification::make()
            ->title(__('shopper::layout.status.updated'))
            ->body(__('Your refund policy has been successfully updated'))
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('shopper::livewire.settings.legal.refund');
    }
}
