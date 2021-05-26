<?php

namespace App\Repositories;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\CustomerRequest;
use App\Customer;

interface CustomerDataAccessRepositoryInterface
{
    public function search(SearchRequest $request);
    public function store(CustomerRequest $request);
    public function update(CustomerRequest $request, Customer $customer);
}
