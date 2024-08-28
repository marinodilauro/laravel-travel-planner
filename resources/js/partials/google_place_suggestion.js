document.addEventListener('DOMContentLoaded', function () {
  const placeInput = document.getElementById('place');

  // Inizializza il servizio di autocompletamento di Google Places
  const autocomplete = new google.maps.places.Autocomplete(placeInput, {
    types: ['geocode', 'establishment'], // Include indirizzi e punti di interesse
  });

  // Quando l'utente seleziona un luogo dall'elenco dei suggerimenti
  autocomplete.addListener('place_changed', function () {
    const place = autocomplete.getPlace();

    if (!place.geometry || !place.geometry.location) {
      alert("No details available for input: '" + place.name + "'");
      return;
    }

    // Recupera le coordinate del luogo selezionato
    const latitude = place.geometry.location.lat();
    const longitude = place.geometry.location.lng();

    // Associa le coordinate al campo di input (puoi usare hidden fields o dataset)
    placeInput.dataset.lat = latitude;
    placeInput.dataset.lon = longitude;

    console.log('Luogo selezionato:', place.name);
    console.log('Coordinate:', latitude, longitude);
  });
});
