<div class="card col-sm">
    <div class="card-body">
        <div class="row mb-2 mb-2">
            <div class="col-sm-1">
                <h4>{{ $customer->id }}</h4>
            </div>
            <div class="col-sm-9">
                <h4>{{ $customer->name }}（{{ $customer->ruby }}）</h4>
            </div>
            <div class="col-sm-2">
                @can('admin-higher')
                    <a class="btn btn-outline-primary" href="{{ action('CustomerController@edit', $customer) }}"
                        role="button">編集</a><br><br>
                @endcan
            </div>
        </div>
        <div class="row mb-2 mb-2">
            <div class="col-sm">
                性別
            </div>
            <div class="col-sm">
                {{ $customer->gender->name }}
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm">
                年齢
            </div>
            <div class="col-sm">
                {{ $customer->age }}
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm">
                生年月日
            </div>
            <div class="col-sm">
                {{ $customer->birth }}
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm">
                電話番号
            </div>
            <div class="col-sm">
                {{ $customer->tel }}
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm">
                住所
            </div>
            <div class="col-sm">
                {{ $customer->address }}
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm">
                メールアドレス
            </div>
            <div class="col-sm">
                {{ $customer->mail }}
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm">
                職業
            </div>
            <div class="col-sm">
                {{ $customer->job->name }}
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm">
                勤務先
            </div>
            <div class="col-sm">
                {{ $customer->company }}
            </div>
        </div>
    </div>
</div>
