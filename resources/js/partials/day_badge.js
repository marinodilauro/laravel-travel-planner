document.addEventListener("DOMContentLoaded", function () {

  const dayBadges = document.querySelectorAll('.day_badge');  // Seleziona tutti i badge dei giorni
  const dayLabel = document.getElementById('day_label');
  const dayInput = document.getElementById('day_input'); // Input nascosto per il giorno
  const stageItems = document.querySelectorAll('.stage_card'); // Gli elementi della lista degli stage
  const badgesContainer = document.querySelector('.days'); // Contenitore dei badge
  const stageContainer = document.getElementById('stage_container');

  const stages = window.travelStages;  // Qui recuperiamo i dati passati dal Blade

  // Mostra solo gli stage del giorno selezionato
  function filterStagesByDay(selectedDay) {

    // RSvuota lo stage_container
    stageContainer.innerHTML = '';

    // Filtra e aggiungi solo gli stage del giorno selezionato
    const filteredStages = stages.filter(stage => stage.day === selectedDay);

    filteredStages.forEach(stage => {
      const stageElement = document.createElement('div');
      stageElement.classList.add('col');
      stageElement.innerHTML = `

            <div class="stage_card" data_day="${stage.day}" data-stage-id="${stage.id}">

              <a class="d-flex text-decoration-none text-dark p-0 flex-fill"
                href="/user/stages/${stage.slug}">

                <!-- Card image -->
                <div class="card_image">
                    ${stage.photo ?

          (stage.photo.startsWith(stage.photo, 'http') ?
            `<img class="img-fluid" loading="lazy" src="${stage.photo}" alt="${stage.place}">` :
            `<img class="img-fluid" loading="lazy" src="/storage/${stage.photo}" alt="${stage.place}">`
          ) :
          `<img class="img-fluid" loading="lazy" src="/storage/img/placeholder_image.png" alt="${stage.place}">`
        }
                </div>

                <!-- Card body -->
                <div class="card_body d-flex flex-column py-2 px-3">
                  <span class="travel_name pb-2">
                    ${stage.place}
                  </span>

                  <div class="d-flex flex-column gap-1">
                    <div class="roboto-regular d-flex justify-content-start align-items-center">
                      <span class="destination_icon material-symbols-outlined me-1">today</span>
                      <span class="text-secondary">${stage.day}</span>
                    </div>

                    ${stage.note ?
          `<div class="roboto-regular d-flex justify-content-start align-items-center">
                          <p>${stage.note}</p>
                        </div>` :
          ''
        }
                  </div>

                </div>
              </a>

              <!-- Card actions -->
              <div class="card_actions align-self-start mt-4">
                <div class="dropdown d-flex  align-items-center justify-content-start gap-2 ps-2 p-1">

                  <span data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    class="actions_icon material-symbols-outlined">
                    more_vert
                  </span>

                  <ul class="dropdown-menu">

                    <!-- Edit action -->
                    <li class="d-flex align-items-center ms-3">
                      <span class="material-symbols-outlined">
                        edit
                      </span>
                      <a class="dropdown-item"  href="/user/stages/${stage.slug}/edit">Modifica</a>
                    </li>

                    <!-- Delete actions -->

                    <li class="d-flex align-items-center ms-3">

                      <!-- Modal trigger button -->
                      <span class="material-symbols-outlined">
                        delete
                      </span>
                      <a class="dropdown-item open_modal_btn" data-bs-toggle="modal" data-bs-target="#modalId"
                        data-stage="${stage}" data-stage-id="${stage.id}"
                        data-stage-place="${stage.place}">
                        Elimina
                      </a>

                    </li>

                  </ul>

                </div>
              </div>

            </div>

      `;

      stageContainer.appendChild(stageElement);

    });
    // console.log('Filtered Stages:', filteredStages); // Per debugging, mostra gli stage filtrati in console
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
      console.log('badge clicked!');
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