@section('title') Play @endsection

<div>
    <section class="container">
        @include('raffle.dashboard')
        @include('raffle.ad')
    </section>

    @includeWhen(auth()->check(), 'raffle.previous')
</div>
