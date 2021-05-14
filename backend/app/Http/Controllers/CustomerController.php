<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\SearchRequest;
use App\Customer;
use App\Progress;
use App\Contract;
use App\Gender;
use App\Job;
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
        $genders = Gender::all();
        $jobs = Job::all();
        return view('customers.create')
                ->with(['genders' => $genders, 'jobs' => $jobs]);
    }

    public function store(CustomerRequest $request, Customer $customer)
    {
        $customer->fill($request->all());
        $customer->save();

        return redirect('/customers');
    }

    public function show(Customer $customer)
    {
        $customer->age = getAge($customer->birth);

        $query = Customer::query();
        $family_members = $query
                            ->whereNotIn('id', [$customer->id])
                            ->where('tel', $customer->tel)
                            ->with('gender', 'job')
                            ->get();
        $family_members->age = Customer::setAllCustomersAge($family_members);

        $suggests = Customer::getSuggests($customer, $family_members);

        $progresses = Progress::where('customer_id', $customer->id)
                                ->latest()
                                ->limit(5)
                                ->get();
        $progresses->load('customer', 'user');

        return view('customers.show')
                ->with([
                    'customer' => $customer,
                    'family_members' => $family_members,
                    'suggests' => $suggests,
                    'progresses' => $progresses,
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
        $customer->fill($request->all());
        $customer->save();

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
