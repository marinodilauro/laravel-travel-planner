<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\Travel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreStageRequest;
use App\Http\Requests\UpdateStageRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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
    public function create($travel)
    {
        /*         $travel = Travel::where('slug', $travel)->firstOrFail();
        return view('user.stages.create', compact('travel')); */
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStageRequest $request, Travel $travel)
    {

        // Validate
        $val_data = $request->validated();

        // Set the travel_id
        $val_data['travel_id'] = $travel->id;

        // Set the day
        $val_data['day'] = $request->input('day');

        // Create slug
        $slug = Str::slug($request->place, '-');
        $val_data['slug'] = $slug;

        // Handle photo upload if present
        if ($request->hasFile('photo')) {
            $image_path = Storage::put('uploads', $request->file('photo'));
            $val_data['photo'] = $image_path;
        }

        // Geocode only if the place does not have coordinates
        /*         if (empty($val_data['latitude']) || empty($val_data['longitude'])) {
            $response = Http::get('https://api.tomtom.com/search/2/search/' . urlencode($val_data['place']) . '.json', [
                'key' => '7Ja8sBNIfLOZqGSKQ0JmEQeYrsKGdGsw',
                'limit' => 1
            ]);

            // Geocoding manage
            if ($response->successful() && !empty($response->json()['results'])) {
                $location = $response->json()['results'][0]['position'];
                $val_data['latitude'] = $location['lat'];
                $val_data['longitude'] = $location['lon'];
            } else {
                // Geocoding failed
                return redirect()->back()->withErrors(['place' => 'Unable to geocode the provided location. Please enter a valid address or place.']);
            }
        } */

        // Esegui la geocodifica solo se il luogo non ha già coordinate
        if (empty($val_data['latitude']) || empty($val_data['longitude'])) {
            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address' => $val_data['place'],
                'key' => env('GOOGLE_MAPS_API_KEY'),
            ]);
            // dd($response->json());
            // Debug della risposta
            if ($response->failed()) {
                return redirect()->back()->withErrors(['place' => 'Google Maps API request failed.']);
            }

            $responseData = $response->json();

            if (!empty($responseData['results'])) {
                $location = $responseData['results'][0]['geometry']['location'];
                $val_data['latitude'] = $location['lat'];
                $val_data['longitude'] = $location['lng'];
            } else {
                // Geocodifica fallita
                return redirect()->back()->withErrors(['place' => 'Unable to geocode the provided location. Please enter a valid address or place.']);
            }
        }

        //Create the stage
        Stage::create($val_data);

        // Reindirizzamento alla pagina del viaggio
        return redirect()->route('user.travels.show', $travel->slug)->with('message', 'Nuova tappa aggiunta!');
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
        // Recupera il Travel associato allo Stage
        $travel = $stage->travel;

        // Deleting images from assets
        if ($stage->photo) {
            Storage::delete($stage->photo);
        }

        // Deleting stages
        $stage->delete();

        // Redirect
        return redirect()->route('user.travels.show', $travel->slug)->with('message', "$stage->place eliminato!");
    }
}
