<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use App\Customer;
use App\Progress;
use App\Contract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = DB::table('customers')->paginate(10);
        $customers = Customer::setAllCustomersAge($customers);
        return view('customers.index')->with('customers', $customers);
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(CustomerRequest $request)
    {
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->ruby = $request->ruby;
        $customer->gender = $request->gender;
        $customer->birth = $request->birth;
        $customer->tel = $request->tel;
        $customer->address = $request->address;
        $customer->job = $request->job;
        if(isset($request->mail))
        {
            $customer->mail = $request->mail;
        }
        if(isset($request->company))
        {
            $customer->company = $request->company;
        }
        $customer->save();
        return redirect('/customers');
    }

    public function show(Customer $customer)
    {
        $customer->age = Customer::getAge($customer->birth);
        $deposit_status = Contract::getDepositStatus($customer->id);

        $query = Customer::query();
        $family_members = $query
                            ->whereNotIn('id', [$customer->id])
                            ->where('tel', $customer->tel)
                            ->get();
        $family_members->age = Customer::setAllCustomersAge($family_members);

        $suggests = Customer::getSuggests($customer, $deposit_status, $family_members);

        return view('customers.show')
                ->with([
                    'customer' => $customer,
                    'deposit_status' => $deposit_status,
                    'family_members' => $family_members,
                    'suggests' => $suggests,
                ]);
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit')->with('customer', $customer);
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->name = $request->name;
        $customer->ruby = $request->ruby;
        $customer->gender = $request->gender;
        $customer->birth = $request->birth;
        $customer->tel = $request->tel;
        $customer->address = $request->address;
        $customer->mail = $request->mail;
        $customer->job = $request->job;
        $customer->company = $request->company;
        $customer->save();
        return redirect()->action('CustomerController@show', $customer);
    }

    public function delete() {}

    public function search(Request $request)
    {
        $search = $request->search;
        $query = Customer::query();
        $customers = $query
            ->where('name', 'like', '%' . $search . '%')
            ->orWhere('ruby', 'like', '%' . $search . '%')
            ->orWhere('gender', 'like', '%' . $search . '%')
            ->orWhere('tel', 'like', '%' . $search . '%')
            ->orWhere('address', 'like', '%' . $search . '%')
            ->orWhere('job', 'like', '%' . $search . '%')
            ->orWhere('company', 'like', '%' . $search . '%')
            ->paginate(10);

        $customers = Customer::setAllCustomersAge($customers);

        return view('customers.index')->with([
            'customers' => $customers,
            'search' => $search,
        ]);
    }

}
