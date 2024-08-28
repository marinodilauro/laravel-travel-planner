document.addEventListener("DOMContentLoaded", function () {

  const dayBadges = document.querySelectorAll('.day_badge');  // Seleziona tutti i badge dei giorni
  const dayLabel = document.getElementById('day_label');
  const dayInput = document.getElementById('day_input'); // Input nascosto per il giorno
  const stageItems = document.querySelectorAll('.stage_card'); // Gli elementi della lista degli stage
  const badgesContainer = document.querySelector('.days'); // Contenitore dei badge

  // Mostra solo gli stage del giorno selezionato
  function filterStagesByDay(selectedDay) {
    stageItems.forEach(item => {
      item.style.display = item.getAttribute('data_day') === selectedDay ? 'flex' : 'none';
    });
  }

  // Seleziona il badge del primo giorno
  if (dayBadges.length > 0) {
    const firstDayBadge = dayBadges[0];
    firstDayBadge.classList.add('selected');
    dayLabel.textContent = `Giorno 1`;
    dayInput.value = firstDayBadge.getAttribute('data_date'); // Imposta il valore del campo nascosto alla prima data
    filterStagesByDay(firstDayBadge.getAttribute('data_date'));
  }


  // Aggiungi un event listener al click di ciascun badge
  dayBadges.forEach((badge, index) => {
    badge.addEventListener('click', () => {

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

  // Abilita lo scorrimento orizzontale tramite trascinamento
  let isDown = false;
  let startX;
  let scrollLeft;

  badgesContainer.addEventListener('mousedown', (e) => {
    isDown = true;
    badgesContainer.classList.add('active');
    startX = e.pageX - badgesContainer.offsetLeft;
    scrollLeft = badgesContainer.scrollLeft;
  });

  badgesContainer.addEventListener('mouseleave', () => {
    isDown = false;
    badgesContainer.classList.remove('active');
  });

  badgesContainer.addEventListener('mouseup', () => {
    isDown = false;
    badgesContainer.classList.remove('active');
  });

  badgesContainer.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - badgesContainer.offsetLeft;
    const speed = (x - startX) * 2; // Velocità dello scorrimento
    badgesContainer.scrollLeft = scrollLeft - speed;
  });

  // Supporto per il tocco su dispositivi mobili
  badgesContainer.addEventListener('touchstart', (e) => {
    startX = e.touches[0].pageX - badgesContainer.offsetLeft;
    scrollLeft = badgesContainer.scrollLeft;
  });

  badgesContainer.addEventListener('touchmove', (e) => {
    const x = e.touches[0].pageX - badgesContainer.offsetLeft;
    const speed = (x - startX) * 2; // Velocità dello scorrimento
    badgesContainer.scrollLeft = scrollLeft - speed;
  });
});