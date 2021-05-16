<div class="card col-sm">
    <div class="card-body">
        <div>
            <h4>活動記録</h4>
        </div>
        {{-- <div class="row mb-2 mb-2">
            <div class="col-sm text-center">

            </div>
            <div class="col-sm">
                ￥{{ number_format($customer->amount_of_ordinary) }}
            </div>
        </div> --}}
        @forelse ($customer->progresses as $progress)
            @include('progresses.list', ['progress' => $progress])
        @empty
            <div class="card col-sm">
                <div class="card-body">
                    進捗がありません
                </div>
            </div>
        @endforelse
    </div>
</div>
