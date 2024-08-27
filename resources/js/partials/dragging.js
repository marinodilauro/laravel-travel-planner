document.addEventListener("DOMContentLoaded", function () {
  const detailsSection = document.querySelector('.travel_details');
  const dragHandle = document.getElementById('drag_handle');
  const map = document.getElementById('map');
  const headerImage = document.querySelector('.header_image');
  const chips = document.querySelector('.chips');

  let isDragging = false;
  let startY = 0;
  let startTop = 0;

  // Setta la posizione della mappa al caricamento della pagina
  map.style.top = '-28vh';
  headerImage.style.height = '38vh';

  // Avvia il trascinamento tenendo premuto sulla handle
  dragHandle.addEventListener('mousedown', function (event) {
    isDragging = true;
    startY = event.clientY;
    startTop = detailsSection.getBoundingClientRect().top;
  });

  // Modifica l'altezza della sezione trascinando la handle
  document.addEventListener('mousemove', function (event) {
    if (isDragging) {
      const deltaY = event.clientY - startY;
      let newTop = startTop + deltaY;

      // Limita il movimento tra il 38% e il 70% della viewport
      const minTop = window.innerHeight * 0.38;
      const maxTop = window.innerHeight * 0.7;
      newTop = Math.max(minTop, Math.min(maxTop, newTop));

      detailsSection.style.top = `${newTop}px`;

      // Aggiorna dinamicamente le dimensioni degli altri elementi
      const relativePosition = (newTop - minTop) / (maxTop - minTop);

      // Calcola e imposta la nuova altezza per headerImage
      const newHeight = 38 + (32 * relativePosition); // Tra 38vh e 70vh
      headerImage.style.height = `${newHeight}vh`;

      // Calcola e imposta la nuova posizione per la mappa
      const newMapTop = -28 + (18 * relativePosition); // Tra -28vh e -10vh
      map.style.top = `${newMapTop}vh`;

      // Calcola e imposta la nuova posizione per i chips
      const newChipsTop = 22 + (32 * relativePosition); // Tra 22% e 54%
      chips.style.top = `${newChipsTop}%`;
    }
  });

  // Concludi il trascinamento
  document.addEventListener('mouseup', function () {
    if (isDragging) {
      isDragging = false;
    }
  });

  // Al click sul bottone, alterna l'altezza tra 38vh e 70vh
  dragHandle.addEventListener('click', function () {

    const currentTop = detailsSection.style.top;

    if (currentTop === '38vh') {

      detailsSection.style.top = '70vh';
      headerImage.style.height = '70vh'; // Riduci l'altezza dell'immagine/mappa
      map.style.top = '-10vh'; // Riduci l'altezza dell'immagine/mappa
      chips.style.top = '54%';
    } else {

      detailsSection.style.top = '38vh';
      headerImage.style.height = '38vh'; // Aumenta l'altezza dell'immagine/mappa
      map.style.top = '-28vh'; // Aumenta l'altezza dell'immagine/mappa
      chips.style.top = '22%';

    }

  });
});
