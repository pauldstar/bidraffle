<section class="container">
    <div class="row">
        <div class="col-6">
            <h1
                id="raffle-timer"
                data-closes-at="{{ $raffle->closes_at->timestamp }}"
                data-original-closes-at="{{ $raffle->original_closes_at->timestamp }}"
            >--:--:--</h1>

            <h3>$<span id="raffle-pot-amount">0.00</span></h3>
            <p><span id="raffle-bid-count">0</span> Bids</p>
            <p>Last Bidder: <span id="total-bid-count">Paul Ogbeiwi</span></p>
        </div>
        <div class="col-6">
            <p>Bidded <span id="user-bid-count">0</span> Times</p>
            <p>Remaining Bids: <span id="user-bid-remainder">0</span></p>
            <button class="btn btn-outline-primary" id="btn--bid">
                <span id="user-raffle-status">Losing</span>:
                <span id="user-raffle-action">Place Bid</span>
            </button>
        </div>
    </div>

    <x-modal id="modal--video">
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <!-- 16:9 aspect ratio -->
        <div class="embed-responsive embed-responsive-16by9">
            <iframe
                id="iframe--video"
                class="embed-responsive-item"
                allowscriptaccess="always"
                allowfullscreen="allowfullscreen"
                allow="autoplay"
            ></iframe>
        </div>
    </x-modal>
</section>

@push('body-scripts')
    <script src="{{ asset('js/raffle-timer.js') }}"></script>
    <script src="{{ asset('js/ad-video.js') }}"></script>
@endpush

@push('styles')
    <style>
        #modal--video .modal-dialog {
            max-width: 800px;
            margin: 30px auto;
        }

        #modal--video .modal-body {
            position: relative;
            padding: 0;
        }

        #modal--video .close {
            position: absolute;
            right: -30px;
            top: 0;
            z-index: 999;
            font-size: 2rem;
            font-weight: normal;
            color: #fff;
            opacity: 1;
            padding: 0;
            border: 0;
            background-color: transparent;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        #iframe--video {
            background: #000000;
        }

        .embed-responsive {
            position: relative;
            display: block;
            width: 100%;
            padding: 0;
            overflow: hidden;
        }

        .embed-responsive .embed-responsive-item, .embed-responsive embed, .embed-responsive iframe, .embed-responsive object, .embed-responsive video {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        .embed-responsive-16by9::before {
            padding-top: 56.25%;
        }

        .embed-responsive::before {
            display: block;
            content: "";
        }
    </style>
@endpush()
