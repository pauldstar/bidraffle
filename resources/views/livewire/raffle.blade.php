@section('title') Play @endsection

<div>
    <section class="container">
        @include('raffle.dashboard')
        @include('raffle.ad')
    </section>

    @includeWhen(auth()->check(), 'raffle.previous')
</div>

@push('body-scripts')
    <script src="{{ asset('js/raffle.js') }}"></script>
    <script src="{{ asset('js/timer.js') }}"></script>

    <script>
        let $timer = document.getElementById('raffle-timer');

        let timer = new Timer(
            $timer, $timer.dataset.originalClosesAt, $timer.dataset.closesAt
        );

        let raffle = new Raffle(timer);

        raffle.run();
    </script>
@endpush
