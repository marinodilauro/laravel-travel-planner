document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById('modalId');
  const modalPlace = document.getElementById('modalPlace');
  const deleteForm = document.getElementById('deleteForm');

  document.querySelectorAll('.open_modal_btn').forEach(button => {
    button.addEventListener('click', function () {
      const stage = this.getAttribute('data-stage');
      const stageId = this.getAttribute('data-stage-id');
      const stagePlace = this.getAttribute('data-stage-place');
      console.log(stagePlace);
      modalPlace.textContent = stagePlace;

      // Modifica l'azione del form per includere l'ID della tappa da eliminare
      deleteForm.action = `/user/stages/${stageId}`;
    });
  });
});
