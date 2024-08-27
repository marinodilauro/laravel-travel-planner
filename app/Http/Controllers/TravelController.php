<?php

namespace App\Http\Controllers;

use App\Models\Travel;
use App\Models\Stages;
use App\Http\Requests\StoreTravelRequest;
use App\Http\Requests\UpdateTravelRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

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
        return view('user.travels.create');
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

        // Geocoding the position
        $response = Http::get("https://api.tomtom.com/search/2/geocode/{$request->destination}.json", [
            'key' => '7Ja8sBNIfLOZqGSKQ0JmEQeYrsKGdGsw'
        ]);

        // Manage geocoding
        if ($response->successful() && !empty($response->json()['results'])) {
            $location = $response->json()['results'][0]['position'];
            $val_data['latitude'] = $location['lat'];
            $val_data['longitude'] = $location['lon'];
        } else {
            // Geocoding failed
            return redirect()->back()->withErrors(['destination' => 'Unable to geocode the provided location. Please enter a valid address or place.']);
        }

        // Create
        // dd($request->all(), $val_data);
        Travel::create($val_data);

        // Redirect
        return to_route('user.travels.index')->with('message', "Nuovo viaggio aggiunto!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Travel $travel)
    {
        // Calcola la durata del viaggio in giorni
        $start_date = Carbon::parse($travel->start_date);
        $end_date = Carbon::parse($travel->end_date);
        $duration = $end_date->diffInDays($start_date) + 1;

        // Carica il viaggio con i suoi stage
        $travel = Travel::with('stages')->findOrFail($travel->id);

        // Recupera la prima tappa (se esiste)
        $firstStage = $travel->stages->first();

        // Se non ci sono tappe, ottieni le coordinate della destinazione
        if (!$firstStage) {
            $response = Http::get("https://api.tomtom.com/search/2/geocode/{$travel->destination}.json", [
                'key' => '7Ja8sBNIfLOZqGSKQ0JmEQeYrsKGdGsw'
            ]);

            $destinationCoordinates = $response->json()['results'][0]['position'];
        } else {
            $destinationCoordinates = null;
        }

        return view('user.travels.show', compact('travel', 'duration', 'firstStage', 'destinationCoordinates'));
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
        // Deleting images from assets
        if ($travel->photo) {
            Storage::delete($travel->photo);
        }

        // Deleting travels
        $travel->delete();

        // Redirect
        return to_route('admin.travels.index')->with('message', "$travel->name eliminato!");
    }
}
