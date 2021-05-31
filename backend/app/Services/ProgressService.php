<?php

namespace App\Services;

use App\Http\Requests\ProgressRequest;
use App\Http\Requests\SearchRequest;
use App\Repositories\ProgressDataAccessRepository;
use App\Repositories\ProgressDataAccessRepositoryInterface AS ProgressDataAccess;
use App\Progress;

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

    public function store(ProgressRequest $request)
    {
        return $this->ProgressDataAccess->store($request);
    }

    public function update(ProgressRequest $request, Progress $progress)
    {
        return $this->ProgressDataAccess->update($request, $progress);
    }
}
