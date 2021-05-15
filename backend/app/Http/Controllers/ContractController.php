<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Contract;
use App\Contract_type;
use App\Http\Requests\ContractRequest;
use App\Http\Requests\SearchRequest;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SearchRequest $request)
    {
        $contract_types = Contract_type::all();

        $contracts = Contract::getSearchQuery($request)
            ->with('contract_type', 'customer')
            ->latest()
            ->paginate(10);

        return view('contracts.index')->with([
            'contracts' => $contracts,
            'request' => $request,
            'contract_types' => $contract_types,
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
        $contract_types = Contract_type::all();

        return view('contracts.create')->with([
            'customers' => $customers,
            'contract_types' => $contract_types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContractRequest $request, Contract $contract)
    {
        $contract->user_id = $request->user()->id;
        $contract->fill($request->all())->save();

        return redirect('/contracts');
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
    public function edit(Contract $contract)
    {
        $contract_types = Contract_type::all();

        return view('contracts.edit')->with([
            'contract' => $contract,
            'contract_types' => $contract_types
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContractRequest $request, Contract $contract)
    {
        $contract->fill($request->all())->save();

        return redirect('/contracts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contract)
    {
        $contract->delete();

        return redirect('/contracts');
    }

}
