<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Progress;
use App\Customer;
use App\Status;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProgressRequest;
use App\Http\Requests\SearchRequest;

class ProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SearchRequest $request)
    {
        $statuses = Status::all();

        $progresses = Progress::getSearchQuery($request)->with('customer', 'user', 'status')->latest()->paginate(10);

        return view('progresses.index')->with([
            'progresses' => $progresses,
            'request' => $request,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();
        $statuses = Status::all();
        return view('progresses.create')->with(['customers' => $customers, 'statuses' => $statuses]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgressRequest $request, Progress $progress)
    {
        $progress->user_id = $request->user()->id;
        $progress->fill($request->all())->save();

        return redirect('/progresses');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Progress $progress)
    {
        $statuses = Status::all();

        return view('progresses.edit')->with(['progress' => $progress, 'statuses' => $statuses]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProgressRequest $request, Progress $progress)
    {
        $progress->fill($request->all())->save();

        return redirect('/progresses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Progress $progress)
    {
        $progress->delete();

        return redirect('/progresses');
    }

}
