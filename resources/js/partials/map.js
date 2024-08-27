tt.setProductInfo("travel-app", "0.1")

const mapOptions = {
  key: '7Ja8sBNIfLOZqGSKQ0JmEQeYrsKGdGsw',
  container: 'map',
  style: {
    map: '2/basic_street-light',
    poi: '2/poi_dynamic-light',
  },
  zoom: 10
}

// Se esistono le coordinate della prima tappa, centrare la mappa su di esse
if (window.firstStageCoordinates) {

  mapOptions.center = [window.firstStageCoordinates.longitude, window.firstStageCoordinates.latitude];

} else {

  // Altrimenti, centrare la mappa sulla destinazione del viaggio
  mapOptions.center = [window.destinationCoordinates.longitude, window.destinationCoordinates.latitude];
}

const map = tt.map(mapOptions);

// Toggle mappa/immagine di copertina del viaggio
document.addEventListener("DOMContentLoaded", function () {
  const mapBtn = document.querySelector('.map_btn');
  const travelImage = document.querySelector('.travel_image');
  const foreground = document.querySelector('.foreground');
  const mapDiv = document.getElementById('map');
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

    } else {

      // Mostra l'immagine del viaggio e nascondi la mappa
      travelImage.style.display = 'block';
      foreground.style.display = 'block';
      mapDiv.style.display = 'none';
      dragHandle.style.display = 'none';
      detailsSection.style.borderRadius = '0';
      detailsSection.style.top = '38vh';
      chips.style.top = '22%';
      headerImage.style.height = '38vh';
    }

  });
});

// Tappe recuperate dal backend (Laravel)
const stages = window.travelStages;

// Itera su ogni tappa per creare un marker sulla mappa
stages.forEach(stage => {

  if (stage.latitude && stage.longitude) {

    const marker = new tt.Marker({
      color: '#65558f',  // Cambia il colore del marker predefinito
      width: '25px',  // Cambia la larghezza del marker
      height: '30px'  // Cambia l'altezza del marker
      // element: createCustomMarkerElement()
    })
      .setLngLat([stage.longitude, stage.latitude])
      .addTo(map);

    // Funzione per creare un elemento personalizzato per il marker
    function createCustomMarkerElement() {
      const markerElement = document.createElement('div');
      markerElement.innerHTML = ""
      markerElement.className = 'custom_marker';

      const icon = document.createElement('img');
      icon.style.width = '30px';
      icon.style.height = '30px';

      markerElement.appendChild(icon);

      return markerElement;
    }

    // Evento al click del marker
    /*     marker.getElement().addEventListener('click', function () {
          alert('Marker clicked!');
        }); */

    // Aggiungi un popup al marker (opzionale)
    const markerHeight = 30, markerRadius = 10, linearOffset = 25;

    const popupOffsets = {
      'top': [0, 0],
      'top-left': [0, 0],
      'top-right': [0, 0],
      'bottom': [0, -markerHeight],
      'bottom-left': [linearOffset, (markerHeight - markerRadius + linearOffset) * -1],
      'bottom-right': [-linearOffset, (markerHeight - markerRadius + linearOffset) * -1],
      'left': [markerRadius, (markerHeight - markerRadius) * -1],
      'right': [-markerRadius, (markerHeight - markerRadius) * -1]
    };

    const popup = new tt.Popup({
      offset: popupOffsets,
      className: 'marker_popup',
      'closeButton': false,
      'closeOnClick': true,
    }).setText(stage.place);

    marker.setPopup(popup).togglePopup();

  }
});

