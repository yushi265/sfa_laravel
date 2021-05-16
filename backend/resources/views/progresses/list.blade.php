<div class="card col-sm">
    <div class="card-body">
        <div class="row mb-2 mb-2">
            <div class="col-sm-4 text-center">
                {{ $progress->user->name }}
            </div>
            <div class="col-sm-4">
                <a style="color:black;" href="{{ action('CustomerController@show', $progress->customer->id) }}">{{ $progress->customer->id }}　:　{{ $progress->customer->name }}</a>
            </div>
            @can('admin-higher')
                <div class="col-sm-2">
                    <a class="btn btn-outline-success" href="{{ action('ProgressController@edit', $progress) }}"
                        role="button">編集</a>
                </div>
                <div class="col-sm-2">
                    <form action="{{ action('ProgressController@destroy', $progress) }}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-outline-danger" type="submit" value="{{ $progress->id }}"
                            role="button">削除</button>
                    </form>
                @endcan
            </div>
        </div>
        <div class="row mb-2 mb-2">
            <div class="col-sm-4 text-center">
                状態
            </div>
            <div class="col-sm-8">
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
            </div>
        </div>
        <div class="row mb-2 mb-2">
            <div class="col-sm-4 text-center">
                内容
            </div>
            <div class="col-sm-8">
                {{ $progress->body }}
            </div>
        </div>
    </div>
</div>
