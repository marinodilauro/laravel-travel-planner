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
    public function create()
    {
        //
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

        // Se l'utente ha caricato una foto
        if ($request->has('photo')) {
            $image_path = Storage::put('uploads', $request->file('photo'));
            $val_data['photo'] = $image_path;
        } else {
            // Altrimenti, tenta di ottenere una foto dalle API di Google Places
            $google_api_key = env('GOOGLE_MAPS_API_KEY');
            $place = $val_data['place'];
            $response = Http::get('https://maps.googleapis.com/maps/api/place/findplacefromtext/json', [
                'input' => $place,
                'inputtype' => 'textquery',
                'fields' => 'photos',
                'key' => $google_api_key,
            ]);

            if ($response->successful() && !empty($response->json()['candidates'])) {
                $photos = $response->json()['candidates'][0]['photos'];

                // Seleziona una foto casuale dall'array di foto disponibili
                $random_photo = $photos[array_rand($photos)];
                $photo_reference = $random_photo['photo_reference'];

                // Costruisci l'URL della foto con dimensioni specifiche
                $photo_url = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=600&maxheight=600&photoreference={$photo_reference}&key={$google_api_key}";

                // Salva l'URL della foto nel database
                $val_data['photo'] = $photo_url;
            } else {
                $val_data['photo'] = null;  // O un'immagine di default
            }
        }

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
        return view('user.stages.edit', compact('stage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreStageRequest $request, Stage $stage)
    {
        // Validate
        $val_data = $request->validated();

        // Aggiorna lo slug solo se il nome del luogo è stato cambiato
        if ($request->place !== $stage->place) {
            $slug = Str::slug($request->place, '-');
            $val_data['slug'] = $slug;
        }

        // Aggiorna il giorno
        $val_data['day'] = $request->input('day');

        // Ottieni una foto dalle API di Google Places
        $google_api_key = env('GOOGLE_MAPS_API_KEY');
        $place = $val_data['place'];
        $response = Http::get('https://maps.googleapis.com/maps/api/place/findplacefromtext/json', [
            'input' => $place,
            'inputtype' => 'textquery',
            'fields' => 'photos',
            'key' => $google_api_key,
        ]);

        if ($response->successful() && !empty($response->json()['candidates'])) {
            $photos = $response->json()['candidates'][0]['photos'];

            // Seleziona una foto casuale dall'array di foto disponibili
            $random_photo = $photos[array_rand($photos)];
            $photo_reference = $random_photo['photo_reference'];

            // Costruisci l'URL della foto con dimensioni specifiche
            $photo_url = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=600&maxheight=600&photoreference={$photo_reference}&key={$google_api_key}";

            // Salva l'URL della foto nel database
            $val_data['photo'] = $photo_url;
        } else {
            $val_data['photo'] = null;  // O un'immagine di default
        }


        // Esegui la geocodifica solo se il luogo non ha già coordinate o se è stato cambiato
        if (($request->place !== $stage->place) || empty($val_data['latitude']) || empty($val_data['longitude'])) {
            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address' => $val_data['place'],
                'key' => env('GOOGLE_MAPS_API_KEY'),
            ]);

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

        // Aggiorna lo stage
        $stage->update($val_data);

        // Reindirizzamento alla pagina del viaggio
        return redirect()->route('user.travels.show', $stage->travel->slug)->with('message', 'Tappa aggiornata con successo!');
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
