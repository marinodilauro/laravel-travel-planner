document.addEventListener('DOMContentLoaded', function () {
  const openFormBtn = document.querySelector('.btn_add_stage');
  const closeFormBtn = document.querySelector('.close_form_btn');
  const addStageForm = document.querySelector('.add_stage_form');
  const noStages = document.querySelector('.no_stages');
  const suggestionsList = document.getElementById('suggestions');

  openFormBtn.addEventListener('click', function () {
    addStageForm.classList.remove('d-none');
    noStages.classList.add('d-none');
    console.log('open form');
  })

  closeFormBtn.addEventListener('click', function () {
    addStageForm.classList.add('d-none');
    suggestionsList.innerHTML = '';
    if (travelStages.length === 0) {
      noStages.classList.remove('d-none');
    }

  })

});
