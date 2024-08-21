// Seleziona l'elemento del selettore delle settimane
const weekSelector = document.getElementById('week-selector');

// Calcola il numero di settimane in base alla durata del viaggio
const duration = document.getElementById('duration').value;
console.log(duration)
const numWeeks = Math.ceil(duration / 7);

// Genera le opzioni per il selettore delle settimane
for (let i = 1; i <= numWeeks; i++) {
  const option = document.createElement('option');
  option.value = i;
  option.text = `Settimana ${i}`;
  weekSelector.add(option);
}