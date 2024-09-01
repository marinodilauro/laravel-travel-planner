document.addEventListener('DOMContentLoaded', function () {
  const placeInput = document.getElementById('place');
  const destinationInput = document.getElementById('destination');

  // Inizializza il servizio di autocompletamento di Google Places per il campo "Place"
  const placeAutocomplete = new google.maps.places.Autocomplete(placeInput, {
    types: ['geocode', 'establishment'], // Include indirizzi e punti di interesse
  });

  // Inizializza il servizio di autocompletamento di Google Places per il campo "Destinazione"
  const destinationAutocomplete = new google.maps.places.Autocomplete(destinationInput, {
    types: ['geocode', 'establishment'], // Include indirizzi e punti di interesse
  });

  // Listener per il campo "Place"
  placeAutocomplete.addListener('place_changed', function () {
    const place = placeAutocomplete.getPlace();

    if (!place.geometry || !place.geometry.location) {
      alert("No details available for input: '" + place.name + "'");
      return;
    }

    const latitude = place.geometry.location.lat();
    const longitude = place.geometry.location.lng();

    placeInput.dataset.lat = latitude;
    placeInput.dataset.lon = longitude;

    console.log('Luogo selezionato:', place.name);
    console.log('Coordinate:', latitude, longitude);
  });

  // Listener per il campo "Destinazione"
  destinationAutocomplete.addListener('place_changed', function () {
    const place = destinationAutocomplete.getPlace();

    if (!place.geometry || !place.geometry.location) {
      alert("No details available for input: '" + place.name + "'");
      return;
    }

    const latitude = place.geometry.location.lat();
    const longitude = place.geometry.location.lng();

    destinationInput.dataset.lat = latitude;
    destinationInput.dataset.lon = longitude;

    console.log('Destinazione selezionata:', place.name);
    console.log('Coordinate:', latitude, longitude);
  });
});
