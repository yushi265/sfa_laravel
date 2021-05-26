<?php

namespace App\Services;

use App\Repositories\CustomerDataAccessRepositoryInterface as CustomerDataAccess;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\CustomerRequest;
use App\Customer;

class CustomerService
{
    private $CustomerDataAccess;

    public function __construct(CustomerDataAccess $CustomerDataAccess)
    {
        $this->CustomerDataAccess = $CustomerDataAccess;
    }

    public function search(SearchRequest $request)
    {
        return $this->CustomerDataAccess->search($request);
    }

    public function store(CustomerRequest $request)
    {
        $this->CustomerDataAccess->store($request);
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $this->CustomerDataAccess->update($request, $customer);

        return $customer;
    }
}
