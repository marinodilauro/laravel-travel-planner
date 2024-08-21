<?php

namespace App\Http\Controllers;

use App\Models\travel;
use App\Http\Requests\StoreTravelRequest;
use App\Http\Requests\UpdateTravelRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TravelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.travels.index', ['travels' => Travel::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user/travels/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoretravelRequest $request)
    {
        // dd($request);

        // Validate
        $val_data = $request->validated();

        $val_data['user_id'] = Auth::id();

        $slug = Str::slug($request->name, '-');
        $val_data['slug'] = $slug;

        if ($request->has('photo')) {
            $image_path = Storage::put('uploads', $val_data['photo']);
            $val_data['photo'] = $image_path;
        }

        // Create
        // dd($request->all(), $val_data);
        $travel = Travel::create($val_data);

        if ($request->has('technologies')) {
            $travel->technologies();
        }

        // Redirect
        return to_route('user.travels.index')->with('message', "New travel added succesfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Travel $travel)
    {
        return view('user.travels.show', compact('travel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Travel $travel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTravelRequest $request, Travel $travel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Travel $travel)
    {
        //
    }
}
