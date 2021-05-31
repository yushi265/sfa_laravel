<?php

namespace App\Repositories;

use App\Http\Requests\ProgressRequest;
use App\Http\Requests\SearchRequest;
use App\Progress;

interface ProgressDataAccessRepositoryInterface
{
    public function search(SearchRequest $request);
    public function store(ProgressRequest $request);
    public function update(ProgressRequest $request, Progress $progress);
}
