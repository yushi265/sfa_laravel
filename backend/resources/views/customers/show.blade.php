@extends('layouts.app')

@section('content')

<div class="container">
    <h4>　　{{ $customer->id}}　　{{ $customer->name}}（{{ $customer->ruby }}）</h4>
    <div class="row">
        <div class="col-7">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th scope="row" class="text-center">性別</th>
                        <td class="">
                            {{ $customer->gender->name }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">年齢</th>
                        <td>{{ $customer->age}}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">生年月日</th>
                        <td>{!! str_replace('-', '/', $customer->birth) !!}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">電話番号</th>
                        <td>{{ $customer->tel}}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">住所</th>
                        <td>{{ $customer->address}}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">メールアドレス</th>
                        <td>{{ $customer->mail}}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">職業</th>
                        <td>{{ $customer->job->name}}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">勤務先</th>
                        <td>{{ $customer->company}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="suggest col-5">
            <h4>提案</h4>
            <ul>
                @empty($suggests)
                <li>提案はありません<br>積極的に情報収集をしましょう！</li>
                @endempty
                @foreach ($suggests as $suggest)
                <li>{{$suggest}}</li>
                @endforeach
            </ul>
        </div>
    </div>

    @can('admin-higher')
    <a class="btn btn-outline-primary" href="{{ action('CustomerController@edit', $customer) }}" role="button">編集</a><br><br>
    @endcan

    <h4>預金状況</h4>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th scope="col" class="text-center col-md-4">普通預金</th>
                <th scope="col" class="text-center col-md-4">定期預金</th>
                <th scope="col" class="text-center col-md-4">融資</th>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <td class="text-center">￥{{ number_format($deposit_status['ordinary']) }}</td>
                <td class="text-center">￥{{ number_format($deposit_status['time']) }}</td>
                <td class="text-center">￥{{ number_format($deposit_status['loan']) }}</td>
            </tr>
        </tbody>
    </table>

    <h4>世帯構成</h4>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th scope="col" class="text-center col-1">ID</th>
                <th scope="col" class="text-center col-2">名前</th>
                <th scope="col" class="text-center col-1">性別</th>
                <th scope="col" class="text-center col-1">年齢</th>
                <th scope="col" class="text-center col-2">生年月日</th>
                <th scope="col" class="text-center col-2">職業</th>
                <th scope="col" class="text-center col-3">勤務先</th>
            </tr>
        </tbody>
        <tbody>
            @forelse ($family_members as $member)
                <tr>
                    <th scope="row" class="text-center">{{ $member->id }}</th>
                    <td>
                        <a href="{{ url('/customers', $member->id)}}">{{ $member->name }}</a>
                    </td>
                    <td class="text-center">
                        {{ $member->gender->name}}
                    </td>
                    <td class="text-center">{{ $member->age }}</td>
                    <td class="text-center">{!! str_replace('-', '/', $customer->birth) !!}</td>
                    <td>{{ $member->job->name }}</td>
                    <td>{{ $member->company }}</td>
                </tr>
            @empty
                <tr>
                    <th>該当なし</th>
                </tr>
            @endforelse
            </tbody>
        </table>

    <br>
    <h4>活動記録(最新５件)</h4>
    @forelse ($progresses as $progress)
        <div class="row">
        <div class="col-11">
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
                        <td>
                            @switch($progress->status_id)
                                @case(1)
                                    有効情報
                                    @break
                                @case(5)
                                    進捗
                                    @break
                                @default
                                    契約成立
                            @endswitch
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">内容</th>
                        <td>{{ $progress->body }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-1">
            @can('admin-higher')
                <a class="btn btn-outline-success" href="{{ action('ProgressController@edit', $progress) }}" role="button">編集</a>
                <form action="{{ action('ProgressController@destroy', $progress) }}" method="post">
                    @csrf
                    @method('delete')
                    <button class="btn btn-outline-danger" type="submit" value="{{ $progress->id }}" role="button">削除</button>
                </form>
            {{-- @elsecan('user-higher')
                @if ($progress->user->id === $auth->id)
                    <a class="btn btn-outline-success" href="#" role="button">編集</a>
                @endif --}}
            @endcan
        </div>
    </div>
    @empty
    まだ進捗はありません
    @endforelse


    <br><br>
    <a href="{{ url('/customers') }}">←戻る</a>
</div>

@endsection
