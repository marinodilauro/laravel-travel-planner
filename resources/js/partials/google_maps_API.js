document.addEventListener('DOMContentLoaded', function () {
  const mapDiv = document.getElementById('map');

  // Verifica che l'elemento mappa esista prima di procedere
  if (!mapDiv) {
    console.error("L'elemento map non è stato trovato.");
    return;
  }

  // Imposta le opzioni della mappa
  const mapOptions = {
    zoom: 10,
    center: { lat: 0, lng: 0 }, // Placeholder, verrà aggiornato
  };

  // Crea la mappa
  const map = new google.maps.Map(mapDiv, mapOptions);

  // Se esistono le coordinate della prima tappa, centra la mappa su di esse
  if (window.firstStageCoordinates) {
    console.log(firstStageCoordinates);
    map.setCenter({
      lat: window.firstStageCoordinates.latitude,
      lng: window.firstStageCoordinates.longitude,
    });
  } else if (window.destinationCoordinates) {
    // Altrimenti, centra la mappa sulla destinazione del viaggio
    map.setCenter({
      lat: window.destinationCoordinates.latitude,
      lng: window.destinationCoordinates.longitude,
    });
  }

  // Toggle mappa/immagine di copertina del viaggio
  const mapBtn = document.querySelector('.map_btn');
  const travelImage = document.querySelector('.travel_image');
  const foreground = document.querySelector('.foreground');
  const dragHandle = document.getElementById('drag_handle');
  const detailsSection = document.querySelector('.travel_details');
  const chips = document.querySelector('.chips');
  const headerImage = document.querySelector('.header_image');

  // Inizialmente nasconde il div mappa e la handle
  mapDiv.style.display = 'none';
  dragHandle.style.display = 'none';

  mapBtn.addEventListener('click', function () {

    if (mapDiv.style.display === 'none') {

      // Nascondi l'immagine del viaggio e mostra la mappa
      travelImage.style.display = 'none';
      foreground.style.display = 'none';
      mapDiv.style.display = 'block';
      dragHandle.style.display = 'block';
      detailsSection.style.borderRadius = '1.75rem';
      mapBtn.classList.add('active');

    } else {

      // Mostra l'immagine del viaggio e nascondi la mappa
      travelImage.style.display = 'block';
      foreground.style.display = 'block';
      mapDiv.style.display = 'none';
      dragHandle.style.display = 'none';
      detailsSection.style.borderRadius = '0';
      detailsSection.style.top = '38vh';
      chips.style.top = '24%';
      headerImage.style.height = '38vh';
      mapBtn.classList.remove('active');

    }
  });

  // Tappe recuperate dal backend (Laravel)
  const stages = window.travelStages;

  stages.forEach(stage => {

    console.log('Tappa:', stage);

    const latitude = parseFloat(stage.latitude);
    const longitude = parseFloat(stage.longitude);

    if (!isNaN(latitude) && !isNaN(longitude)) {

      console.log('Aggiungo marker per la tappa con coordinate:', latitude, longitude);

      const marker = new google.maps.Marker({
        position: { lat: latitude, lng: longitude },
        map: map,
        title: stage.place
        // Nessuna icona personalizzata specificata, viene usato il marker predefinito
      });

      // Aggiungi un popup al marker
      const infowindow = new google.maps.InfoWindow({
        content: stage.place,
      });

      marker.addListener('click', function () {
        infowindow.open(map, marker);
      });
    }
  });
  console.log(map);
  // Se non ci sono tappe, centra la mappa sulla destinazione del viaggio
  if (stages.length === 0 && window.destinationCoordinates) {
    map.setCenter({
      lat: window.destinationCoordinates.latitude,
      lng: window.destinationCoordinates.longitude,
    });
  }
});
