<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Barrower;
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Barrower::create(['user_id'=>1]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBarrowerRequest $request)
    {
        //
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
