<?php

namespace App\Http\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class BaseComponent extends Component
{
    use AuthorizesRequests;

    public function successToast(string $message): void
    {
        $this->toast('success', $message);
    }

    public function infoToast(string $message): void
    {
        $this->toast('info', $message);
    }

    public function warningToast(string $message): void
    {
        $this->toast('warning', $message);
    }

    public function errorToast(string $message): void
    {
        $this->toast('error', $message);
    }

    private function toast(string $mode, string $message): void
    {
        $this->emit('trigger-toast', $mode, $message);
    }
}
