@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4 text-center">顧客編集フォーム</h5>
                <form action="{{ action('CustomerController@update', $customer) }}" method="post">
                    @csrf
                    {{ method_field('patch') }}
                    @include('customers.form')
                    <button type="submit" class="btn btn-primary w-100 mt-3">更新</button>
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
            </div>
        </div>

        <a href="{{ url('/customers') }}">←戻る</a>

    @endsection
