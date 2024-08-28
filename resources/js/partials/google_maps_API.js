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
    center: { lat: 0, lng: 0 },// Placeholder, verrà aggiornato
    streetViewControl: true // Attiva il controllo Street View
  };

  // Crea la mappa
  const map = new google.maps.Map(mapDiv, mapOptions);
  const streetView = map.getStreetView();

  // Bottone per uscire da Street View
  const exitStreetViewBtn = document.getElementById('exitStreetView');

  // Monitorare l'entrata e l'uscita dalla modalità Street View
  streetView.addListener('visible_changed', function () {
    if (streetView.getVisible()) {
      // Se Street View è visibile, mostra il bottone per uscire
      exitStreetViewBtn.style.display = 'block';
    } else {
      // Nascondi il bottone quando esci da Street View
      exitStreetViewBtn.style.display = 'none';
    }
  });

  // Uscire da Street View quando si clicca sul bottone
  exitStreetViewBtn.addEventListener('click', function () {
    streetView.setVisible(false);
  });

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

  // Array per tenere traccia dei popup attivi
  let activeOverlays = [];

  // Array per tenere traccia dei marker
  let markers = [];

  // Popup custom con la classe CustomOverlay
  class CustomOverlay extends google.maps.OverlayView {
    constructor(position, content, map) {
      super();
      this.position = position;
      this.content = content;
      this.map = map;
      this.div = null;
      this.setMap(map);
      activeOverlays.push(this); // Aggiunge l'overlay attuale alla lista degli overlay attivi
    }

    onAdd() {
      const div = document.createElement('div');
      div.className = 'custom-overlay';
      div.innerHTML = this.content;
      this.div = div;

      const panes = this.getPanes();
      panes.overlayLayer.appendChild(div);
    }

    draw() {
      if (this.div) {
        const projection = this.getProjection();
        const position = projection.fromLatLngToDivPixel(this.position);
        this.div.style.left = position.x + 'px';
        this.div.style.top = position.y + 'px';
      }
    }

    onRemove() {
      if (this.div) {
        this.div.parentNode.removeChild(this.div);
        this.div = null;
      }
    }

    // Funzione per chiudere l'overlay
    close() {
      this.setMap(null); // Rimuove l'overlay dalla mappa
    }
  }

  function closeAllOverlays() {
    activeOverlays.forEach(overlay => overlay.close());
    activeOverlays = []; // Svuota l'array degli overlay attivi
  };

  // Tappe recuperate dal backend (Laravel)
  const stages = window.travelStages;

  // Crea i marker per ogni tappa e li aggiunge all'array markers
  stages.forEach(stage => {
    // console.log('Tappa:', stage);

    const latitude = parseFloat(stage.latitude);
    const longitude = parseFloat(stage.longitude);

    if (!isNaN(latitude) && !isNaN(longitude)) {

      // console.log('Aggiungo marker per la tappa con coordinate:', latitude, longitude);

      const marker = new google.maps.Marker({
        position: { lat: latitude, lng: longitude },
        map: map,
        title: stage.place,
        day: stage.day // Aggiungi l'attributo day per filtrare i marker
        // Nessuna icona personalizzata specificata, per ora uso il marker predefinito
      });

      markers.push(marker); // Aggiunge il marker all'array

      // Aggiungi un popup al marker
      marker.addListener('click', function () {
        closeAllOverlays(); // Chiudi tutti gli overlay aperti prima di aprirne uno nuovo
        new CustomOverlay(
          marker.getPosition(),
          `<div class="custom-overlay-content">${stage.place}</div>`,
          map
        );
      });
    }
  });

  // Chiude tutti gli overlay se si clicca sulla mappa (fuori dai marker)
  map.addListener('click', function () {
    closeAllOverlays();
  });

  // Funzione per filtrare i marker in base al giorno selezionato
  function filterMarkersByDay(selectedDay) {
    closeAllOverlays(); // Chiudi tutti gli overlay attivi quando si cambia giorno
    markers.forEach(marker => {
      if (marker.day === selectedDay) {
        marker.setMap(map); // Mostra il marker
      } else {
        marker.setMap(null); // Nasconde il marker
      }
    });
  }

  // Filtra i marker a seconda del giorno selezionato
  document.querySelectorAll('.day_badge').forEach(badge => {
    badge.addEventListener('click', function () {
      const selectedDay = badge.getAttribute('data_date');
      filterMarkersByDay(selectedDay);
    });
  });

  // Filtra i marker per il primo giorno di viaggio al caricamento della mappa
  const firstDayBadge = document.querySelector('.day_badge');
  if (firstDayBadge) {
    const firstDay = firstDayBadge.getAttribute('data_date');
    filterMarkersByDay(firstDay);
  }

  // Se non ci sono tappe, centra la mappa sulla destinazione del viaggio
  if (stages.length === 0 && window.destinationCoordinates) {
    map.setCenter({
      lat: window.destinationCoordinates.latitude,
      lng: window.destinationCoordinates.longitude,
    });
  }
});
