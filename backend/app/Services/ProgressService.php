<?php

namespace App\Services;

use App\Http\Requests\SearchRequest;
use App\Repositories\ProgressDataAccessRepository;
use App\Repositories\ProgressDataAccessRepositoryInterface AS ProgressDataAccess;

class ProgressService
{
    private $ProgressDataAccess;

    public function __construct(ProgressDataAccess $ProgressDataAccess)
    {
        return $this->ProgressDataAccess = $ProgressDataAccess;
    }

    public function search(SearchRequest $request)
    {
        return $this->ProgressDataAccess->search($request);
    }
}
