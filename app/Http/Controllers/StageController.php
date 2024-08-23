<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\Travel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreStageRequest;
use App\Http\Requests\UpdateStageRequest;

class StageController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStageRequest $request, Travel $travel)
    {
        // dd($request);

        // Validate
        $val_data = $request->validated();

        $val_data['travel_id'] = $travel->id;

        $slug = Str::slug($request->name, '-');
        $val_data['slug'] = $slug;

        if ($request->has('photo')) {
            $image_path = Storage::put('uploads', $val_data['photo']);
            $val_data['photo'] = $image_path;
        }

        // Create
        // dd($request->all(), $val_data);
        $stage = Stage::create($val_data);

        // Redirect
        return to_route('user.travels.index')->with('message', "Nuova tappa aggiunta!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Stage $stage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stage $stage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStageRequest $request, Stage $stage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stage $stage)
    {
        //
    }
}
