@extends('layouts.app')

@section('content')

<div class="container">

    <h4>顧客データベース</h4>

    <form action="{{ url('/customers' )}}" method="get">
        <div class="input-group mb-3 col-md-6">
            <input type="text" class="form-control" placeholder="キーワードを入力してください" name="search" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{$search}}">
            <button class="btn btn-outline-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                詳細設定
            </button>
            <button class="btn btn-outline-primary" type="submit" id="button-addon2">検索</button>
            <a href="{{ url('/customers') }}" type='button' class="btn btn-outline-secondary">リセット</a>
        </div>
        <div class="collapse col-md-6" id="collapseExample">
            <div class="card card-body">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">性別</label>
                    <select class="form-select" id="inputGroupSelect01">
                        <option selected>指定しない</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">職業</label>
                    <select class="form-select" id="inputGroupSelect01">
                        <option selected>指定しない</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">年齢</span>
                    <input type="text" aria-label="First name" class="form-control">
                    <span class="input-group-text">〜</span>
                    <input type="text" aria-label="Last name" class="form-control">
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
