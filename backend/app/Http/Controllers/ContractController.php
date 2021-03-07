<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Progress;
use App\Contract;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ContractRequest;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contracts = Contract::latest()->paginate(10);
        return view('contracts.index')->with('contracts', $contracts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();
        return view('contracts.create')->with('customers', $customers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContractRequest $request)
    {
        $contract = new Contract();
        $contract->user_id = Auth::id();
        $contract->customer_id = $request->customer_id;
        $contract->contract_type = $request->contract_type;
        $contract->amount = $request->amount;
        $contract->due_date = $request->due_date;
        $contract->save();

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
        return view('contracts.edit')->with('contract', $contract);
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
        $contract->contract_type = $request->contract_type;
        $contract->amount = $request->amount;
        $contract->due_date = $request->due_date;
        $contract->save();
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

    public function search(Request $request)
    {
        $query = Contract::query();

        if ($request->filled('contract_type')) {
            $query->where('contract_type', $request->input('contract_type'));
        }

        $contracts = $query
            ->orderby('created_at', 'desc')
            ->paginate(10);

        return view('contracts.index')->with([
            'contracts' => $contracts,
            'request' => $request,
        ]);
    }
}
