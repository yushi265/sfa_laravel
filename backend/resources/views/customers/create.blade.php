@extends('layouts.app')

@section('content')

<script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>

<div class="container">
    <form action="{{ url('/customers') }}" method="post" class="h-adr">
        @csrf
        <span class="p-country-name" style="display:none;">Japan</span>
        <div class="row g-2">
            <div class="col-md-5">
                <div class="form-floating mb-3">
                    <input type="text" name="name" class="form-control" id="name" placeholder="名前" value="{{old('name')}}">
                    <label for="name">名前</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating mb-3">
                    <input type="text" name="ruby" class="form-control" id="ruby" placeholder="フリガナ" value="{{old('ruby')}}">
                    <label for="ruby">フリガナ</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating">
                    <select class="form-select" name="gender_id" id="gender_id" aria-label="Floating label select example">
                        <option value="" selected>選んでください</option>
                        @foreach ($genders as $gender)
                            <option value="{{ $gender->gender_id }}" @if(old('gender_id') == $gender->gender_id) selected  @endif>{{ $gender->name }}</option>
                        @endforeach
                    </select>
                    <label for="gender_id">性別</label>
                </div>
            </div>

            <div class="row g-2">
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <input type=text class="form-control p-postal-code" size="8" maxlength="8" name="postal_code" id="postal_code" placeholder="郵便番号" value="{{old('postal_code')}}">
                        <label for="address">郵便番号</label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-floating mb-3">
                        <input type=text class="form-control p-region p-locality p-street-address p-extended-address" name="address" id="address" placeholder="住所" value="{{old('address')}}">
                        <label for="address">住所</label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-floating mb-3">
                        <input type=text class="form-control" name="birth" id="birth" placeholder="住所" value="{{old('birth')}}">
                        <label for="birth">生年月日　例:2000-03-25</label>
                    </div>
                </div>
            </div>

            <div class="row g-2">
                <div class="col-md">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="tel" id="tel" placeholder="電話番号" value="{{old('tel')}}">
                        <label for="tel">電話番号</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="mail" id="mail" placeholder="メールアドレス" value="{{old('mail')}}">
                        <label for="mail">メールアドレス</label>
                    </div>
                </div>
            </div>

            <div class="row g-2">
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" name="job_id" id="job_id" aria-label="Floating label select example">
                            <option value="" selected>選んでください</option>
                            @foreach ($jobs as $job)
                                <option value="{{ $job->job_id }}" @if(old('job_id') == $job->job_id) selected  @endif>
                                    {{ $job->name }}
                                </option>
                            @endforeach
                        </select>
                        <label for="job_id">職業</label>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="company" id="company" placeholder="勤務先" value="{{old('company')}}">
                        <label for="company">勤務先</label>
                    </div>
                </div>
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
