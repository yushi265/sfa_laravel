<div class="card m-1">
    <div class="card-body customer-list pt-2 pb-2">
        <a style="color:black;" href="{{ action('CustomerController@show', ['customer' => $customer])}}">
            <div class="row">
                <div class="col-sm-1">
                    {{ $customer->id }}
                </div>
                <div class="col-sm-4">
                    {{ $customer->name }}
                </div>
                <div class="col-sm-7">
                    {{ $customer->address }}
                </div>
            </div>
        </a>
    </div>
</div>
