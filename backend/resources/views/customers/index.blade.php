@extends('layouts.app')

@section('content')

    <div class="container">

        <h4>顧客データベース</h4>

        <form action="{{ url('/customers') }}" method="get">
            @include('customers.search_bar', ['request' => $request])
        </form>

        @forelse ($customers as $customer)
            @if ($loop->first)
                @include('customers.description')
            @endif
            @include('customers.list', ['customer' => $customer])
        @empty
            <div class="card">
                <div class="card-body">該当なし</div>
            </div>
        @endforelse

        <div class="paginate">
            <div class="page">
                {{ $customers->appends(request()->input())->links() }}
            </div>
        </div>

        @can('admin-higher')
            <a class="btn btn-outline-primary" href="{{ action('CustomerController@create') }}" role="button">追加</a>
        @endcan
    </div>

@endsection
