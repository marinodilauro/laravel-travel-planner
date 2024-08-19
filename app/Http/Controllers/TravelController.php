<?php

namespace App\Http\Controllers;

use App\Models\travel;
use App\Http\Requests\StoretravelRequest;
use App\Http\Requests\UpdatetravelRequest;

class TravelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Travel::orderByDesc('id');
        return view('user.travels.index', compact('travels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoretravelRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(travel $travel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(travel $travel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatetravelRequest $request, travel $travel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(travel $travel)
    {
        //
    }
}
