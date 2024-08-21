document.addEventListener('DOMContentLoaded', function () {
  const accordionItems = document.querySelectorAll('.accordion_item');

  /*   console.log(accordionItems);
  
    if (accordionItems.length === 0) {
      console.error('No accordion items found');
    } else {
      console.log('Accordion items found:', accordionItems.length);
    } */

  accordionItems.forEach(item => {
    const header = item.querySelector('.accordion_header');

    header.addEventListener('click', () => {

      // Chiudi tutti gli altri accordion aperti
      /*      accordionItems.forEach(i => {
             if (i !== item) {
               i.classList.remove('active');
             }
           }); */

      // Alterna l'apertura dell'accordion corrente
      item.classList.toggle('active');
    });
  });
});
