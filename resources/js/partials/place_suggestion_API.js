document.addEventListener('DOMContentLoaded', function () {
  const placeInput = document.getElementById('place');
  const suggestionsList = document.getElementById('suggestions');
  const apiKey = '7Ja8sBNIfLOZqGSKQ0JmEQeYrsKGdGsw';

  placeInput.addEventListener('input', function () {
    const query = placeInput.value;

    if (query.length > 1) { // Inizia la ricerca dopo 2 caratteri

      fetch(`https://api.tomtom.com/search/2/search/${query}.json?key=${apiKey}&limit=5`)
        .then(response => response.json())
        .then(data => {

          // Svuota la lista di suggerimenti
          suggestionsList.innerHTML = '';

          // Aggiungi nuovi suggerimenti
          data.results.forEach(result => {
            const suggestionItem = document.createElement('li');
            suggestionItem.textContent = result.poi ? result.poi.name : result.address.freeformAddress;
            suggestionItem.classList.add('list-group-item');

            // Associa le coordinate solo se disponibili
            if (result.position) {
              suggestionItem.dataset.lat = result.position.lat;
              suggestionItem.dataset.lon = result.position.lon;
            }

            // Aggiungi evento di click per selezionare il suggerimento
            suggestionItem.addEventListener('click', function () {
              placeInput.value = result.poi ? result.poi.name : result.address.freeformAddress;

              // Verifica se le coordinate sono state associate e aggiungile al campo di input
              if (suggestionItem.dataset.lat && suggestionItem.dataset.lon) {
                placeInput.dataset.lat = suggestionItem.dataset.lat;
                placeInput.dataset.lon = suggestionItem.dataset.lon;
              } else {
                // Rimuovi eventuali coordinate se il suggerimento selezionato non le ha
                delete placeInput.dataset.lat;
                delete placeInput.dataset.lon;
              }

              suggestionsList.innerHTML = ''; // Svuota la lista dopo la selezione
            });

            suggestionsList.appendChild(suggestionItem);

          });
        })
        .catch(error => console.error('Errore nella ricerca dei suggerimenti:', error));

    } else {

      suggestionsList.innerHTML = ''; // Svuota la lista se l'input è troppo corto

    }
  });
});