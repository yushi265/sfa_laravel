@extends('layouts.app')

@section('content')

    <div class="container">

        @if (session('message'))
        <div class="alert alert-primary" role="alert">
            {{ session('message') }}
        </div>
        @endif

        @include('customers.show.details', ['customer' => $customer])

        @include('customers.show.suggests', ['customer' => $customer])

        @include('customers.show.deposit_status', ['customer' => $customer])

        @include('customers.show.family_list', ['customer' => $customer])

        @include('customers.show.progresses', ['customer' => $customer])

        <br><br>
        <a href="{{ route('customers.index') }}">←戻る</a>
    </div>

@endsection
