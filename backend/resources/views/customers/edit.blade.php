@extends('layouts.app')

@section('content')


<div class="container">
    <form action="{{ action('CustomerController@update', $customer) }}" method="post">
        @csrf
        {{ method_field('patch') }}
        @include('customers.form')
        <button type="submit" class="btn btn-outline-primary">更新</button>
    </form>
    <br>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <a href="{{ url('/customers') }}">←戻る</a>

        @endsection
