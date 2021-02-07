@extends('app')

@section('title') Play @endsection

@section('content')
    @livewire('raffle', ['raffle' => $raffle])
    @includeWhen(auth()->check(), 'raffle.previous')
@endsection
