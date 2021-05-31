<?php

namespace App\Http\Controllers;

use App\Services\ProgressService;
use Illuminate\Http\Request;
use App\Progress;
use App\Customer;
use App\Http\Requests\ProgressRequest;
use App\Http\Requests\SearchRequest;

class ProgressController extends Controller
{
    private $ProgressService;

    public function __construct(ProgressService $ProgressService)
    {
        return $this->ProgressService = $ProgressService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SearchRequest $request)
    {
        $progresses = $this->ProgressService->search($request);

        return view('progresses.index')->with([
            'progresses' => $progresses,
            'request' => $request,
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
        return view('progresses.create')->with(['customers' => $customers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgressRequest $request)
    {
        $this->ProgressService->store($request);

        return redirect('/progresses')->with('message', '登録が完了しました。');
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
        return view('progresses.edit')->with(['progress' => $progress]);
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
        $this->ProgressService->update($request, $progress);

        return redirect('/progresses')->with('message', '編集が完了しました。');
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
