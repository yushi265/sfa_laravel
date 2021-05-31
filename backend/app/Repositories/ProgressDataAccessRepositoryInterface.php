<?php

namespace App\Repositories;

use App\Http\Requests\SearchRequest;

interface ProgressDataAccessRepositoryInterface
{
    public function search(SearchRequest $request);
}
