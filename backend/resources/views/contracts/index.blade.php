@extends('layouts.app')

@section('content')

    <div class="container">

        @if (session('message'))
            <div class="alert alert-primary" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <h4>成約一覧
            @can('admin-higher')
                <a class="btn btn-outline-primary" href="{{ action('ContractController@create') }}" role="button">追加</a>
            @endcan
        </h4>

        <form action="{{ action('ContractController@index') }}" method="get">
            <div class="input-group mb-3 col-md-6">
                <input type="text" class="form-control" placeholder="キーワードを入力" name="search"
                    aria-label="Recipient's username" aria-describedby="button-addon2"
                    value="{{ $request->input('search') }}">
                <select class="form-select col-md-4" name="contract_type_id" id="inputGroupSelect04"
                    aria-label="Example select with button addon">
                    <option value="" selected>種別</option>
                    @foreach ($contract_types as $type)
                        <option value="{{ $type->contract_type_id }}" @if ($request->contract_type_id == $type->contract_type_id) selected @endif>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
                <button class="btn btn-outline-primary" type="submit" id="button-addon2">検索</button>
                <a href="{{ url('/contracts') }}" type='button' class="btn btn-outline-secondary">リセット</a>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger col-md-6">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>

        @forelse ($contracts as $contract)
            <div class="row">
                <div class="col-10">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th scope="row" class="text-center col-md-3">顧客名</th>
                                <td class="col-md-4"><a
                                        href="{{ action('CustomerController@show', $contract->customer_id) }}">{{ $contract->customer->name }}</a>
                                </td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <th scope="row" class="text-center">成約種類</th>
                                <td>{{ $contract->contract_type->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-center">金額</th>
                                <td>￥{{ number_format($contract->amount) }}</td>
                            </tr>
                            @if ($contract->contract_type_id !== 2)
                                <tr>
                                    <th scope="row" class="text-center">満期日</th>
                                    <td>{!! str_replace('-', '/', $contract->due_date) !!}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="col-2">
                    @can('admin-higher')
                        <a class="btn btn-outline-success" href="{{ action('ContractController@edit', $contract) }}"
                            role="button">編集</a>
                        <form action="{{ action('ContractController@destroy', $contract) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-outline-danger" type="submit" value="{{ $contract->id }}"
                                role="button">削除</button>
                        </form>
                    @endcan
                </div>
            </div>
        @empty
            まだ成約はありません
        @endforelse
        <div class="paginate">
            <div class="page">
                {{ $contracts->appends(request()->input())->links() }}
            </div>
        </div>
    </div>

@endsection
