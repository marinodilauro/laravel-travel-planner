document.addEventListener("DOMContentLoaded", function () {
  // Seleziona l'elemento del selettore delle settimane
  const badgesContainer = document.querySelector('.week_days'); // Seleziona il contenitore dei badge
  const badges = document.querySelectorAll('.day_badge');
  const dayLabel = document.getElementById('day_label');

  // Calcola il numero di settimane in base alla durata del viaggio
  const duration = parseInt(document.getElementById('duration').value, 10);
  console.log(duration)
  // Funzione per abilitare lo scorrimento orizzontale
  function enableHorizontalScroll(container) {
    let isDown = false;
    let startX;
    let scrollLeft;

    container.addEventListener('mousedown', (e) => {
      isDown = true;
      container.classList.add('active');
      startX = e.pageX - container.offsetLeft;
      scrollLeft = container.scrollLeft;
    });

    container.addEventListener('mouseleave', () => {
      isDown = false;
      container.classList.remove('active');
    });

    container.addEventListener('mouseup', () => {
      isDown = false;
      container.classList.remove('active');
    });

    container.addEventListener('mousemove', (e) => {
      if (!isDown) return;
      e.preventDefault();
      const x = e.pageX - container.offsetLeft;
      const walk = (x - startX) * 2; // Velocità dello scorrimento
      container.scrollLeft = scrollLeft - walk;
    });

    // Supporto per il tocco su dispositivi mobili
    container.addEventListener('touchstart', (e) => {
      startX = e.touches[0].pageX - container.offsetLeft;
      scrollLeft = container.scrollLeft;
    });

    container.addEventListener('touchmove', (e) => {
      const x = e.touches[0].pageX - container.offsetLeft;
      const walk = (x - startX) * 2; // Velocità dello scorrimento
      container.scrollLeft = scrollLeft - walk;
    });
  }

  // Abilita lo scorrimento orizzontale
  enableHorizontalScroll(badgesContainer);

  // Aggiorna il titolo con il primo giorno
  if (badges.length > 0) {
    const firstBadge = badges[0];
    const dayNumber = firstBadge.id.split('-')[1]; // Ottiene il numero dal badge
    dayLabel.textContent = `Giorno ${dayNumber}`; // Aggiorna il titolo
  }
});