<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Progress;
use App\Contract;
use App\UserRole;

class UserController extends Controller
{
    public function home()
    {
        $latest_progresses = Progress::with('customer', 'user')->latest()->limit(3)->get();
        $latest_contracts = Contract::with('customer', 'contract_type')->latest()->limit(3)->get();
        return view('home')->with(['latest_progresses' => $latest_progresses, 'latest_contracts' => $latest_contracts]);
    }

    public function admin_index()
    {
        $users = User::with('role')->get();
        $roles = UserRole::all();

        return view('users.admin_index')->with(['users' => $users, 'roles' => $roles]);
    }

    public function admin_set(Request $request)
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->role_id = $request->input('user_admin_'.$user->id);
            $user->save();
        }
        return redirect()->back();
    }
}
