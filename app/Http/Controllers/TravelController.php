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
        $travels = Travel::where('user_id', '=', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('user.travels.index', compact('travels'));
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

        // Se l'utente carica una foto, salvala
        if ($request->has('photo')) {
            $image_path = Storage::put('uploads', $val_data['photo']);
            $val_data['photo'] = $image_path;
        } else {
            //  Fetch photos from Google Places API
            $google_api_key = env('GOOGLE_MAPS_API_KEY');
            $place = $val_data['destination'];
            $response = Http::get('https://maps.googleapis.com/maps/api/place/findplacefromtext/json', [
                'input' => $place,
                'inputtype' => 'textquery',
                'fields' => 'photos',
                'key' => $google_api_key,
            ]);


            if ($response->successful() && !empty($response->json()['candidates'])) {
                $photos = $response->json()['candidates'][0]['photos'];
                // dd($photos);
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
                'address' => $val_data['destination'],
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
                return redirect()->back()->withErrors(['destination' => 'Unable to geocode the provided location. Please enter a valid destination.']);
            }
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

        // Se non ci sono tappe, utilizza le coordinate della destinazione
        if (!$firstStage) {
            $destinationCoordinates = [
                'latitude' => $travel->latitude,
                'longitude' => $travel->longitude,
            ];
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
        return view('user.travels.edit', compact('travel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTravelRequest $request, Travel $travel)
    {
        // Validate
        $val_data = $request->validated();

        // Aggiorna lo slug solo se il nome del viaggio è stato cambiato
        if ($request->name !== $travel->name) {
            $slug = Str::slug($request->name, '-');
            $val_data['slug'] = $slug;
        }

        // Ottieni una foto dalle API di Google Places
        $google_api_key = env('GOOGLE_MAPS_API_KEY');
        $destination = $val_data['destination'];
        $response = Http::get('https://maps.googleapis.com/maps/api/place/findplacefromtext/json', [
            'input' => $destination,
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


        // Esegui la geocodifica solo se la destinazione è cambiata o se non ci sono coordinate
        if (($request->destination !== $travel->destination) || empty($val_data['latitude']) || empty($val_data['longitude'])) {
            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address' => $val_data['destination'],
                'key' => env('GOOGLE_MAPS_API_KEY'),
            ]);

            // Debug della risposta
            if ($response->failed()) {
                return redirect()->back()->withErrors(['destination' => 'Google Maps API request failed.']);
            }

            $responseData = $response->json();

            if (!empty($responseData['results'])) {
                $location = $responseData['results'][0]['geometry']['location'];
                $val_data['latitude'] = $location['lat'];
                $val_data['longitude'] = $location['lng'];
            } else {
                // Geocodifica fallita
                return redirect()->back()->withErrors(['destination' => 'Unable to geocode the provided location. Please enter a valid address or place.']);
            }
        }

        // Aggiorna il viaggio
        $travel->update($val_data);

        // Reindirizzamento alla pagina di visualizzazione del viaggio
        return redirect()->route('user.travels.show', $travel->slug)->with('message', 'Viaggio aggiornato con successo!');
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
        return to_route('user.travels.index')->with('message', "$travel->name eliminato!");
    }
}
