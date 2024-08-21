// Seleziona tutti i badge dei giorni
const dayBadges = document.querySelectorAll('.day_badge');
const dayLabel = document.getElementById('day_label');

// Seleziona il primo badge del giorno
const firstDayBadge = dayBadges[0];
firstDayBadge.classList.add('selected')
dayLabel.textContent = 'Giorno 1';

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

  });

});