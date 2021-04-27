<?php

namespace Tests\Unit\Http\Livewire\Raffle;

use App\Http\Livewire\Raffle;
use Livewire\Livewire;
use Livewire\Testing\TestableLivewire;
use Tests\TestCase;

class PlaceBidTest extends TestCase
{
    private TestableLivewire $raffle;

    protected function setUp(): void
    {
        parent::setUp();
        $this->raffle = Livewire::test(Raffle::class);
    }

    public function testGuestCantBid()
    {
        $this->raffle->call('bid')->assertForbidden();
    }
}
