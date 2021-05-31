<?php

namespace App\Repositories;

use App\Http\Requests\ProgressRequest;
use App\Repositories\ProgressDataAccessRepositoryInterface;
use App\Http\Requests\SearchRequest;
use App\Progress;

class ProgressDataAccessRepository implements ProgressDataAccessRepositoryInterface
{
    public function search(SearchRequest $request)
    {
        $query = Progress::query();
        $search = $request->search;
        $status = $request->status;

        if ($request->filled('status')) {
            $query->where(function ($query) use ($status) {
                $query->where('status_id', $status);
            });
        }

        if ($request->filled('search')) {
            $query
                ->where('body', 'like', '%' . $search . '%')
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('customer', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
        }

        $progresses = $query->with('customer', 'user', 'status')->latest()->paginate(10);

        return $progresses;
    }

    public function store(ProgressRequest $request)
    {
        $progress = new Progress();
        $progress->user_id = $request->user()->id;
        $progress->fill($request->all())->save();

        return $progress;
    }

    public function update(ProgressRequest $request, Progress $progress)
    {
        $progress->fill($request->all())->save();

        return $progress;
    }
}
