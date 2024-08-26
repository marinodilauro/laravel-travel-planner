document.addEventListener('DOMContentLoaded', function () {
  const openFormBtn = document.querySelector('.btn_add_stage');
  const closeFormBtn = document.querySelector('.close_form_btn');
  const addStageForm = document.querySelector('.add_stage_form');

  openFormBtn.addEventListener('click', function () {
    addStageForm.classList.remove('d-none');
    console.log('open form');
  })

  closeFormBtn.addEventListener('click', function () {
    addStageForm.classList.add('d-none');
  })

});
