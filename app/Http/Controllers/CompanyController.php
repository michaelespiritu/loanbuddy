<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\CompanyResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\EmployeeResource;
use Illuminate\Support\Facades\Redirect;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(Company::count()) {
            return Inertia::render('Company/Index', [
                'companies' => CompanyResource::collection(
                    Company::query()
                    ->with('owner')
                    ->latest()
                    ->when($request->input('search'), function ($query, $search) {
                        $query->where('name', 'like', "%{$search}%");
                    })
                    ->paginate(5)
                    ->withQueryString()
                ),
                'filters' => $request->only(['search']),
                'status' => session('status'),
            ]);
        } else {
            return redirect(route('company.create'));
        }
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Company/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        $company = $user->userCompany()->create(['name'=>$request->company_name]);

        $company->employees()->create(['role'=> 'Owner', 'user_id'=> $user->id]);

        $user->assignRole('company owner');

        if ($request->hasFile('logo')) {
            $file = $request->file('logo')->store('images', 'public');
            $path = Storage::url($file);
            $company->update(['company_logo' => $path]);
        }

        return Redirect::route('company.index')->with([
            'status' => 'Company Created'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return Inertia::render('Company/Show', [
            'company' => $company,
            'employees' => EmployeeResource::collection($company->employees),
            'status' => session('status')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function ownerShow()
    {
        return Inertia::render('MyCompany/Show', [
            'company' => Auth::user()->userCompany,
            'employees' => EmployeeResource::collection(Auth::user()->userCompany->employees),
            'status' => session('status')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $company->update($request->all());

        $redirect = Redirect::route('company.show', $company);

        if ($request->path == '/my-company') {
            $redirect = Redirect::route('company.ownerShow');
        }

        return $redirect->with([
            'status' => 'Company Information Updated'
        ]);
    }

}
