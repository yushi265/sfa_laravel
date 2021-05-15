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
    public function index()
    {
        $customers = Customer::orderBy('id', 'asc')->paginate(10);
        $customers = Customer::setAllCustomersAge($customers);
        return view('customers.index')->with('customers', $customers);
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

    public function store(CustomerRequest $request)
    {
        $customer= new Customer();
        $customer->fill($request->all())->save();

        return redirect('/customers');
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
            ->with(['customer' => $customer, 'genders' => $genders, 'jobs' => $jobs]);
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->fill($request->all())->save();

        return redirect()->action('CustomerController@show', $customer);
    }

    public function delete() {}

    public function search(SearchRequest $request)
    {
        $genders = Gender::all();
        $jobs = Job::all();

        $search = $request->search;
        $gender_opt = $request->gender_opt;
        $job_opt = $request->job_opt;

        // ddd($job_opt);
        $query = Customer::query();

        if ($request->filled('gender_opt')) {
            $query->where('gender_id', $gender_opt);
        };

        if ($request->filled('job_opt')) {
            $query->where('job_id', $job_opt);
        };

        if ($request->filled('min_age')) {
            $min_birth = date("Y-m-d", strtotime("-" . $request->min_age . " year"));
            $query->where('birth', '<=', $min_birth);
        }

        if ($request->filled('max_age')) {
            $max_birth = date("Y-m-d", strtotime("-" . $request->max_age + 1 . " year"));
            $query->where('birth', '>', $max_birth);
        }

        $query->where(function ($query) use ($search) {
            $query
                ->where('name', 'like', '%' . $search . '%')
                ->orWhere('ruby', 'like', '%' . $search . '%')
                ->orWhere('tel', $search)
                ->orWhere('address', 'like', '%' . $search . '%')
                ->orWhere('company', 'like', '%' . $search . '%');
        });

        $customers = $query->with('gender')->paginate(10);

        $customers = Customer::setAllCustomersAge($customers);

        return view('customers.index')->with([
            'customers' => $customers,
            'request' => $request,
            'genders' => $genders,
            'jobs' => $jobs
        ]);
    }

}
