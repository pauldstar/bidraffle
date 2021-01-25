@extends('app')

@section('title') Play @endsection

@section('content')
    @livewire('raffle', ['raffle' => $raffle])
    @include('raffle.previous')
@endsection
