@extends('layouts.app')

@section('content')

    <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>

    <div class="container">

<div class="card">
  <div class="card-body">
    <h5 class="card-title mb-4 text-center">顧客登録フォーム</h5>

    <form action="{{ url('/customers') }}" method="post" class="h-adr">
        @csrf
        @include('customers.form')
        <button type="submit" class="btn btn-primary w-100 mt-3">登録</button>
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
