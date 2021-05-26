<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\SearchRequest;
use App\Services\CustomerService;
use App\Customer;

class CustomerController extends Controller
{
    private $CustomerService;

    public function __construct(CustomerService $CustomerService)
    {
        $this->CustomerService = $CustomerService;
    }

    public function index(SearchRequest $request)
    {
        $customers = $this->CustomerService->search($request);

        return view('customers.index')->with([
            'customers' => $customers,
            'request' => $request,
        ]);
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(CustomerRequest $request)
    {
        $this->CustomerService->store($request);

        return redirect()
                ->route('customers.index')
                ->with('message', '登録が完了しました。');
    }

    public function show(Customer $customer)
    {
        $customer->load('progresses.customer', 'progresses.user');

        return view('customers.show', [
                    'customer' => $customer,
                ]);
    }

    public function edit(Customer $customer)
    {
        $customer->explodeBirth();

        return view('customers.edit', ['customer' => $customer]);
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer = $this->CustomerService->update($request, $customer);

        return redirect()
            ->route('customers.show', ['customer' => $customer])
            ->with('message', '編集が完了しました。');
    }

    public function delete() {}

}
