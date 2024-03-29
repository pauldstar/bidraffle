<div class="row">
    <div class="col-6">
        <x-timer :raffle="$raffle" />

        <h3>$<span id="raffle-pot-amount">0.00</span></h3>
        <p><span id="raffle-bid-count">0</span> Bids</p>
        <p>Last Bidder: <span id="total-bid-count">Paul Ogbeiwi</span></p>
    </div>
    <div class="col-6">
        <p>Bidded <span id="user-bid-count">0</span> Times</p>
        <p>Remaining Bids: <span id="user-bid-remainder">0</span></p>
        <button
            class="btn btn-{{ $this->bidButtonColor }}"
            id="btn--bid"
            wire:click="bid"
        >
            <span id="user-raffle-status">{{ $this->bidButtonStatus }}</span>:
            <span id="user-raffle-action">Place Bid</span>
        </button>
    </div>
</div>
