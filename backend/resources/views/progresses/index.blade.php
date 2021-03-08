@extends('layouts.app')

@section('content')

<div class="container">

    <h4>進捗一覧　　
        <a class="btn btn-outline-primary" href="{{ action('ProgressController@create') }}" role="button">追加</a>
    </h4>

    <form action="{{ action('ProgressController@search') }}" method="get">
        <div class="input-group mb-3 col-md-6">
            <input type="text" class="form-control" placeholder="内容を検索" name="search" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{$request->input('search')}}">
            <select class="form-select col-md-3" name="status" id="inputGroupSelect04" aria-label="Example select with button addon">
                <option value="">状態</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status->status_id }}" @if ($request->status == $status->status_id) selected @endif>
                        {{ $status->name }}
                    </option>
                @endforeach
            </select>
            <button class="btn btn-outline-primary" type="submit" id="button-addon2">検索</button>
            <a href="{{ url('/progresses') }}" type='button' class="btn btn-outline-secondary">リセット</a>
        </div>
    </form>

@forelse ($progresses as $progress)
    <div class="row">
        <div class="col-10">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="text-center col-5">{{ $progress->user->name }}</td>
                        <td class="">
                            <a href="{{ action('CustomerController@show', $progress->customer->id)}}">{{$progress->customer->id}}　:　{{ $progress->customer->name }}</a>
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th scope="row" class="text-center">状態</th>
                        <td>{{ $progress->status->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">内容</th>
                        <td>{{ $progress->body }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-2">
            @can('admin-higher')
                <a class="btn btn-outline-success" href="{{ action('ProgressController@edit', $progress) }}" role="button">編集</a>
                <form action="{{ action('ProgressController@destroy', $progress) }}" method="post">
                    @csrf
                    @method('delete')
                    <button class="btn btn-outline-danger" type="submit" value="{{ $progress->id }}" role="button">削除</button>
                </form>
            @endcan
        </div>
    </div>
    @empty
    該当する進捗はありません
    @endforelse
    <div class="paginate">
        <div class="page">
            {{ $progresses->appends(request()->input())->links() }}
        </div>
    </div>
</div>

@endsection
