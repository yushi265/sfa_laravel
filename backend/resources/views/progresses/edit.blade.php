@extends('layouts.app')

@section('content')

<div class="container">
    <form action="{{ action('ProgressController@update', $progress) }}" method="post">
        @csrf
        @method('patch')
            <div class="col-md-8">
                <div class="form-floating mb-3">
                    <h4>ID：{{ $progress->customer->id }}　{{ $progress->customer->name }}</h4>
                    <input type="hidden" name="customer_id" value="{{ $progress->customer_id }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating mb-3">
                    <select class="form-select" name="status_id" id="status_id" aria-label="Floating label select example" required>
                        @foreach (App\Status::all() as $status)
                            <option value={{ $status->status_id}}
                                @if (old('status_id', $progress->status_id == $status->status_id))
                                    selected
                                @endif>{{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                    <label for="status">状態</label>
                </div>
            </div>
            <div class="col-md">
                <div class="form-floating mb-3">
                    <input type="text" name="body" class="form-control" id="body" placeholder="内容" value="{{ old('body', $progress->body) }}" required>
                    <label for="body">内容</label>
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

    <a href="{{ url('/progresses') }}">←戻る</a>

        @endsection
