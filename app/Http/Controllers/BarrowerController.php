<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Barrower;
use Illuminate\Http\Request;
use App\Models\BarrowerDetail;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\BarrowerResource;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreBarrowerRequest;
use App\Http\Requests\UpdateBarrowerRequest;

class BarrowerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Barrower/Create');
    }

    /**
     * Display a listing of the resource.
     */
    public function barrowerDetail(Barrower $barrower)
    {
        return Inertia::render('Barrower/Details', [
            'barrower' => BarrowerResource::make($barrower)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Barrower::create(['user_id'=>1]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:'.User::class,
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            // 'loan_amount' => 'required|string|max:255',
            // 'interest' => 'required|integer',
            // 'duration' => 'required|integer',
            // 'frequency_of_payment' => 'required|integer',
            // 'start_of_payment_date' => 'required|integer',
            // 'penalty' => 'required|integer',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make('password'),
        ]);

        $user->assignRole('barrower');

        $barrower = $user->barrower_record()->create([
            'created_by' => auth()->user()->id,
            'company_id' => auth()->user()->employee->company->id,
        ]);


        return Redirect::route('barrower.detail', $barrower)->with([
            'status' => 'Barrower Created'
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function createLoan(Request $request, Barrower $barrower)
    {
        $request->validate([
            'loan_amount' => 'required|max:255',
            'interest' => 'required|integer',
            'duration' => 'required|integer',
            'frequency_of_payment' => 'required',
            'start_of_payment_date' => 'required|date',
        ]);

        $barrower->loans()->create($request->all());

        return Redirect::back()->with([
            'status' => 'Barrower Created'
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Barrower $barrower)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barrower $barrower)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBarrowerRequest $request, Barrower $barrower)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barrower $barrower)
    {
        //
    }
}
