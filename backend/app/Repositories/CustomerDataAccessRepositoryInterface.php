<?php

namespace App\Repositories;

use App\Http\Requests\SearchRequest;

interface CustomerDataAccessRepositoryInterface
{
    public function search(SearchRequest $request);
}
