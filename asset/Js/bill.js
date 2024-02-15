

document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.getElementById('devisBody');
  
    // Ajout d'une nouvelle ligne
    function addRow() {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td><input type="text" name="designation[]"></td>
            <td><input type="text" name="frais_avances[]"></td>
            <td><input type="text" name="prix_ht_10[]"></td>
            <td><input type="text" name="prix_ht_20[]"></td>
            <td>
                <ul class="icon-estimate">
                    <li><img class="addRow" src="../asset/img/icons8-add-30.png" alt="logo-add"></li>
                    <li><img class="moveUp" src="../asset/img/icons8-up-30.png" alt="icons-up"></li>
                    <li><img class="moveDown" src="../asset/img/icons8-down-30.png" alt="icons-down"></li>
                    <li><img class="removeRow" src="../asset/img/icons8-delete-30.png" alt="logo-delete"></li>
                </ul>
            </td>
        `;
        addEventListenersToRow(newRow);
        tableBody.appendChild(newRow);
  
 
    }
  
    // Suppression d'une ligne
    function removeRow(row) {
        if (tableBody.rows.length > 1) {
            tableBody.removeChild(row);
        } else {
            alert("Vous ne pouvez pas supprimer la dernière ligne.");
        }
    }
  
    // Déplacement d'une ligne vers le haut
    function moveRowUp(row) {
        const previousRow = row.previousElementSibling;
        if (previousRow) {
            tableBody.insertBefore(row, previousRow);
        }
    }
  
    // Déplacement d'une ligne vers le bas
    function moveRowDown(row) {
        const nextRow = row.nextElementSibling;
        if (nextRow) {
            tableBody.insertBefore(nextRow, row);
        }
    }
  
    // Ajout des écouteurs d'événements à une ligne
    function addEventListenersToRow(row) {
        row.querySelector('.addRow').addEventListener('click', addRow);
        row.querySelector('.moveUp').addEventListener('click', function () { moveRowUp(row); });
        row.querySelector('.moveDown').addEventListener('click', function () { moveRowDown(row); });
        row.querySelector('.removeRow').addEventListener('click', function () { removeRow(row); });

        // Ajout d'un écouteur d'événement à chaque champ d'entrée de la ligne
        row.querySelectorAll('[name^="designation["], [name^="frais_avances["], [name^="prix_ht_10["], [name^="prix_ht_20["]').forEach(function (input) {
            input.addEventListener('input', updateTotals);
        });
    }

    // Ajout des écouteurs d'événements aux lignes existantes
    tableBody.querySelectorAll('tr').forEach(addEventListenersToRow);
   
  // // // ***************************************** */ calc For estimate ************************************ 
  
      function updateTotals() {
          // Récupérer tous les champs dynamiques à nouveau après modification
          const dynamicFieldsUpdated = document.querySelectorAll('[name^="designation["]');
  
          // Initialiser les totaux
          let totalHt = 0;
          let tva10 = 0;
          let tva20 = 0;
          let totalAdvance = 0;
          let ttc = 0;
  
          // Calculer les totaux en parcourant tous les champs dynamiques
          dynamicFieldsUpdated.forEach(function (field) {
              const row = field.closest('tr');
              const designation = row.querySelector('[name^="designation["]').value.trim();
              const fraisAvances = parseFloat(row.querySelector('[name^="frais_avances["]').value) || 0;
              const prixHT10 = parseFloat(row.querySelector('[name^="prix_ht_10["]').value) || 0;
              const prixHT20 = parseFloat(row.querySelector('[name^="prix_ht_20["]').value) || 0;
  
              console.log('Row:', row);
              console.log('Designation:', designation);
              console.log('Frais Avances:', fraisAvances);
              console.log('Prix HT 10:', prixHT10);
              console.log('Prix HT 20:', prixHT20);
  
              totalHt += isNaN(prixHT10) ? 0 : prixHT10;
              totalHt += isNaN(prixHT20) ? 0 : prixHT20;
              tva10 += isNaN(prixHT10) ? 0 : (prixHT10 * 0.1);
              tva20 += isNaN(prixHT20) ? 0 : (prixHT20 * 0.2);
              totalAdvance += isNaN(fraisAvances) ? 0 : fraisAvances;
  
              console.log('Total HT:', totalHt);
              console.log('TVA 10%:', tva10);
              console.log('TVA 20%:', tva20);
              console.log('Total Advance:', totalAdvance);
          });
  
          // Calculer le TTC une fois tous les totaux mis à jour
          ttc = totalHt + tva10 + tva20 + totalAdvance;
  
          console.log('TTC:', ttc);
  
          // Mettre à jour les champs totaux dans le tableau
          document.getElementById('total_ht').value = totalHt.toFixed(2);
          document.getElementById('tva_10').value = tva10.toFixed(2);
          document.getElementById('tva_20').value = tva20.toFixed(2);
          document.getElementById('total_frais_avances').value = totalAdvance.toFixed(2);
          document.getElementById('ttc').value = ttc.toFixed(2);
      }
    }
);