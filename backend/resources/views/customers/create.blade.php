@extends('layouts.app')

@section('content')

    <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>

    <div class="container">


        <form action="{{ url('/customers') }}" method="post" class="h-adr">
            @csrf
            <span class="p-country-name" style="display:none;">Japan</span>
            @include('customers.form')
            <div class="col-md-2">
                <div class="form-floating mb-3">
                    <input type=text class="form-control p-postal-code" size="8" maxlength="8" name="postal_code"
                        id="postal_code" placeholder="郵便番号" value="{{ old('postal_code') }}">
                    <label for="address">郵便番号</label>
                </div>
            </div>
            <button type="submit" class="btn btn-outline-primary">登録</button>
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
