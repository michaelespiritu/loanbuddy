<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Company $company)
    {
        return Inertia::render('Employee/Create', [
            'company' => $company
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:'.User::class,
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make('password'),
        ]);

        $employeeRecord = $user->employee_record()->create(['role'=> $request->role]);

        $company->employees()->attach($employeeRecord);

        $user->assignRole('employee');

        return Redirect::route('company.show', $company)->with([
            'status' => 'Company Created'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company, Employee $employee)
    {
        $request->validate([
            'role' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
        ]);

        if ($employee->user->email != $request->email) {
            $request->validate([
                'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            ]);
        }

        if ($employee->user->username != $request->username) {
            $request->validate([
                'username' => 'required|string|lowercase|max:255|unique:'.User::class,
            ]);
        }

        $employee->update($request->all());

        $employee->user()->update($request->except(['role']));

        return Redirect::route('company.show', $company)->with([
            'status' => 'Employee Updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
