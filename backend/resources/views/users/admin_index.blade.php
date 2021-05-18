@extends('layouts.app')

@section('content')

    <div class="container">

        @if (session('message'))
            <div class="alert alert-primary" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <h4>権限一覧　　
            <a class="btn btn-outline-primary" href="{{ route('register') }}" role="button">ユーザー追加
            </a>
        </h4>

        <form action="{{ action('UserController@admin_set') }}" method="post" name='admin_set'>
            @csrf
            @method('patch')
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th class="text-center col-md-3">ID</th>
                        <th class="">ユーザー</th>
                        <th class="col-md-6 ">権限</th>
                    </tr>
                </tbody>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="text-center ">{{ $user->id }}</td>
                            <td class=" ">{{ $user->name }}</td>
                            <td>
                                @if (Auth::id() === $user->id)
                                    {{ $user->role->name }}
                                    <input type="hidden" name="user_admin_{{ $user->id }}"
                                        value="{{ $user->role_id }}">
                                @else
                                    <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                        name="user_admin_{{ $user->id }}">
                                        <option selected value="{{ $user->role_id }}">
                                            {{ $user->role->name }}
                                        </option>
                                        @foreach ($roles as $role)
                                            @if ($user->role_id !== $role->role_id)
                                                <option value="{{ $role->role_id }}">{{ $role->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button class="btn btn-outline-success" type="submit" id="admin_submit_button">権限を変更する</button>
        </form><br>

    </div>

@endsection
