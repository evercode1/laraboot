@extends('layouts.master')

@section('title')

    <title>Test Page</title>

@endsection

@section('content')

    <h1>This is My Test Page</h1>

    @if(count($Beatles) > 0)

        @foreach($Beatles as $Beatle)

            {{ $Beatle }} <br>

        @endforeach

    @else

        <h1> Sorry, nothing to show...</h1>

    @endif

@endsection