@extends('layouts.app')

@section('content')

    <div class="container">

        @include('customers.show.details', ['customer' => $customer])

        @include('customers.show.suggests', ['customer' => $customer])

        @include('customers.show.deposit_status', ['customer' => $customer])

        @include('customers.show.family_list', ['customer' => $customer])

        @include('customers.show.progresses', ['customer' => $customer])

            <br><br>
            <a href="{{ url('/customers') }}">←戻る</a>
        </div>

    @endsection
