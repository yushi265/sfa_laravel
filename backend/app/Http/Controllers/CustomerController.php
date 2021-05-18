<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\SearchRequest;
use App\Customer;
use App\Gender;
use App\Job;

class CustomerController extends Controller
{
    public function index(SearchRequest $request)
    {
        $genders = Gender::all();
        $jobs = Job::all();

        $customers = Customer::setSearchQuery($request)
                        ->with('gender')
                        ->paginate(10);

        return view('customers.index')->with([
            'customers' => $customers,
            'request' => $request,
            'genders' => $genders,
            'jobs' => $jobs
        ]);
    }

    public function create()
    {
        $genders = Gender::all();
        $jobs = Job::all();
        return view('customers.create',[
            'genders' => $genders,
            'jobs' => $jobs,
        ]);
    }

    public function store(CustomerRequest $request, Customer $customer)
    {
        $customer->fill($request->all())->save();

        return redirect('/customers')->with('message', '登録が完了しました。');
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
        $genders = Gender::all();
        $jobs = Job::all();

        $customer->explodeBirth();

        return view('customers.edit')
            ->with([
                'customer' => $customer,
                'genders' => $genders,
                'jobs' => $jobs,
                ]);
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->fill($request->all())->save();

        return redirect()->action('CustomerController@show', $customer)->with('message', '編集が完了しました。');
    }

    public function delete() {}

}
