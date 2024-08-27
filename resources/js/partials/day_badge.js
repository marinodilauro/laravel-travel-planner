// Seleziona tutti i badge dei giorni
const dayBadges = document.querySelectorAll('.day_badge');
const dayLabel = document.getElementById('day_label');
const dayInput = document.getElementById('day_input'); // Input nascosto per il giorno
const stageItems = document.querySelectorAll('.stage_card'); // Gli elementi della lista degli stage

// Seleziona il primo badge del giorno
const firstDayBadge = dayBadges[0];
firstDayBadge.classList.add('selected')
dayLabel.textContent = 'Giorno 1';
dayInput.value = firstDayBadge.getAttribute('data_date'); // Imposta il valore del campo nascosto alla prima data

// Mostra solo gli stage del giorno selezionato
function filterStagesByDay(selectedDay) {
  stageItems.forEach(item => {
    if (item.getAttribute('data_day') === selectedDay) {
      item.style.display = 'flex'; // Mostra l'elemento
    } else {
      item.style.display = 'none'; // Nasconde l'elemento
    }
  });
}

// Filtra inizialmente gli stage per il primo giorno
filterStagesByDay(firstDayBadge.getAttribute('data_date'));

// Aggiungi un event listener al click di ciascun badge
dayBadges.forEach((badge, index) => {

  badge.addEventListener('click', () => {

    // Elimina classe "active" dagli altri badge
    /*     dayBadges.forEach(i => {
          if (i !== badge) {
            i.classList.remove('active');
          }
        }); */

    // Rimuovi la classe 'selected' da tutti i badge
    dayBadges.forEach(b => b.classList.remove('selected'));

    // Aggiungi la classe 'selected' al badge cliccato
    badge.classList.add('selected');

    // Aggiorna il testo del giorno selezionato
    dayLabel.textContent = `Giorno ${index + 1}`;

    const selectedDate = badge.getAttribute('data_date');

    // Aggiorna il valore del campo nascosto
    dayInput.value = selectedDate;


    // Filtra gli stage in base al giorno selezionato
    filterStagesByDay(selectedDate);
  });

});