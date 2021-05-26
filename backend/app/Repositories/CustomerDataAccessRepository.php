<?php

namespace App\Repositories;

use App\Repositories\CustomerDataAccessRepositoryInterface;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\CustomerRequest;
use App\Customer;

class CustomerDataAccessRepository implements  CustomerDataAccessRepositoryInterface
{
    public function search(SearchRequest $request)
    {
        $search = $request->search;
        $gender_opt = $request->gender_opt;
        $job_opt = $request->job_opt;

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

        return $customers;
    }

    public function store(CustomerRequest $request)
    {
        $customer = new Customer();
        $customer->fill($request->all())->save();
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        return $customer->fill($request->all())->save();
    }
}
