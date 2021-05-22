<h1
    x-data="timer()"
    x-init="init"
    id="raffle-timer"
    x-ref="timer"
    :class="timerClass"
    data-closes-at="{{ $raffle->closes_at->timestamp }}"
    data-original-closes-at="{{ $raffle->original_closes_at->timestamp }}"
    x-text="timer"
></h1>

@push('body-scripts')
    <script src="{{ asset('js/timer.js') }}"></script>
@endpush
