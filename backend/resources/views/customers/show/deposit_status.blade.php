<div class="card col-sm">
    <div class="card-body">
        <div>
            <h4>預金状況</h4>
        </div>
        <div class="row mb-2 mb-2">
            <div class="col-sm text-center">
                普通預金
            </div>
            <div class="col-sm">
                ￥{{ number_format($customer->amount_of_ordinary) }}
            </div>
        </div>
        <div class="row mb-2 mb-2">
            <div class="col-sm text-center">
                定期預金
            </div>
            <div class="col-sm">
                ￥{{ number_format($customer->amount_of_time) }}
            </div>
        </div>
        <div class="row mb-2 mb-2">
            <div class="col-sm text-center">
                融資
            </div>
            <div class="col-sm">
                ￥{{ number_format($customer->amount_of_loan) }}
            </div>
        </div>
    </div>
</div>
