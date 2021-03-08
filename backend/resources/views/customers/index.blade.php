@extends('layouts.app')

@section('content')

<div class="container">

    <h4>顧客データベース</h4>

    <form action="{{ url('/customers' )}}" method="get">
        <div class="input-group mb-3 col-md-6">
            <input type="text" class="form-control" placeholder="キーワードを入力してください" name="search" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{$request->search}}">
            <button class="btn btn-outline-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                詳細条件
            </button>
            <button class="btn btn-outline-primary" type="submit" id="button-addon2">検索</button>
            <a href="{{ url('/customers') }}" type='button' class="btn btn-outline-secondary">リセット</a>
        </div>
        <div class="collapse col-md-6" id="collapseExample">
            <div class="card card-body">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="gender_opt">性別</label>
                    <select class="form-select" name="gender_opt" id="gender_opt">
                        <option value="" selected>指定しない</option>
                        @foreach ($genders as $gender)
                            <option value="{{ $gender->gender_id }}" @if ($request->gender_opt == $gender->gender_id) selected @endif>
                                {{ $gender->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="job_opt">職業</label>
                    <select class="form-select" name="job_opt" id="job_opt">
                        <option value="">指定しない</option>
                        @foreach ($jobs as $job)
                            <option value="{{ $job->job_id }}" @if ($request->job_opt == $job->job_id) selected @endif>
                                {{ $job->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">年齢</span>
                    <input type="text" name="min-age" aria-label="First name" class="form-control">
                    <span class="input-group-text">〜</span>
                    <input type="text" name="max-age" aria-label="Last name" class="form-control">
                </div>
                <button class="btn btn-outline-primary" type="submit" id="button-addon2">検索</button>
            </div>
        </div>
    </form>

    <table class="table table-hover table-bordered">
        <tbody>
            <tr>
                <th scope="col" class="text-center col-1">ID</th>
                <th scope="col" class="text-center col-2">名前</th>
                <th scope="col" class="text-center col-1">性別</th>
                <th scope="col" class="text-center col-1">年齢</th>
                <th scope="col" class="text-center col-2">電話番号</th>
                <th scope="col" class="text-center col-5">住所</th>
            </tr>
        </tbody>
        <tbody>
            @forelse ($customers as $customer)
                <tr>
                    <th scope="row" class="text-center">{{ $customer->id }}</th>
                    <td>
                        <a href="{{ url('/customers', $customer->id)}}">{{ $customer->name }}</a>
                    </td>
                    <td class="text-center">
                        {{ $customer->gender->name}}
                    </td>
                    <td class="text-center">{{ $customer->age }}</td>
                    <td class="text-center">{{ $customer->tel }}</td>
                    <td>{{ $customer->address }}</td>
                </tr>
            @empty
                <h5>該当なし</h5>
            @endforelse
            </tbody>
        </table>

<div class="paginate">
    <div class="page">
        {{ $customers->appends(request()->input())->links() }}
    </div>
</div>

@can('admin-higher')
<a class="btn btn-outline-primary" href="{{ action('CustomerController@create') }}" role="button">追加</a>
@endcan
</div>

@endsection
