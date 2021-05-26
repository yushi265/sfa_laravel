<?php

namespace App\Services;

use App\Repositories\CustomerDataAccessRepositoryInterface as CustomerDataAccess;
use App\Http\Requests\SearchRequest;

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
}
