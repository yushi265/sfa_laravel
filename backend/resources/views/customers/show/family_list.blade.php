<div class="card col-sm">
    <div class="card-body">
        <div>
            <h4>世帯構成</h4>
        </div>
        {{-- <div class="row mb-2 mb-2">
            <div class="col-sm text-center">
                普通預金
            </div>
            <div class="col-sm">
                ￥{{ number_format($customer->amount_of_ordinary) }}
            </div>
        </div> --}}
        @forelse ($customer->family_members as $member)
            @include('customers.list', ['customer' => $member])
        @empty
            <div class="card col-sm">
                <div class="card-body">
                    世帯がありません
                </div>
            </div>
        @endforelse
    </div>
</div>
