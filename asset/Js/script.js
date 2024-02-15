// Mobile menu 
document.getElementById('burger-icon').addEventListener('click', function () {
  let navLinks = document.querySelector('.nav-links');
  navLinks.classList.toggle('active');
});
// ***************************************** */ Btn back-top************************************ 
window.onscroll = function () {
  scrollFunction();
};
// ***************************************** */ check all checkbox ************************************ 
document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("checkAll").addEventListener("change", function () {
    const checkboxes = document.getElementsByClassName("condolence-checkbox");
    for (let i = 0; i < checkboxes.length; i++) {
      checkboxes[i].checked = this.checked;
    }
  });

  const form = document.querySelector(".form-check");

  form.addEventListener("submit", function (event) {
    const checkboxes = document.getElementsByClassName("condolence-checkbox");
    for (let i = 0; i < checkboxes.length; i++) {
      checkboxes[i].value = checkboxes[i].checked ? checkboxes[i].value : 0;
    }
  });
});
// *****************************************add row estimate and billing************************************

document.addEventListener('DOMContentLoaded', function () {
  // Ajouter un écouteur d'événement au bouton d'ajout initial
  document.querySelector('.addRow').addEventListener('click', function () {
    addRow();
  });

  function addRow() {
    // Créez un nouvel élément de ligne
    let newRow = document.createElement('tr');

    // Ajoutez des cellules avec des champs d'entrée uniques
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

    // Ajoutez la nouvelle ligne à la fin du corps du tableau
    document.getElementById('devisBody').appendChild(newRow);

    // Ajoutez un écouteur d'événement au nouveau bouton d'ajout de la ligne actuelle
    newRow.querySelector('.addRow').addEventListener('click', function () {
      addRow();
    });

    // Ajoutez un écouteur d'événement au nouveau bouton de suppression de la ligne actuelle
    newRow.querySelector('.removeRow').addEventListener('click', function () {
      removeRow(newRow);
    });

    // Ajoutez des écouteurs d'événements aux boutons de déplacement
    newRow.querySelector('.moveUp').addEventListener('click', function () {
      moveRowUp(newRow);
    });

    newRow.querySelector('.moveDown').addEventListener('click', function () {
      moveRowDown(newRow);
    });

    // Ajoutez des écouteurs d'événements aux champs d'entrée de la nouvelle ligne
    addEventListenersToDynamicFields();
  }

  function removeRow(row) {
    // Vérifiez s'il y a plus d'une ligne avant de supprimer
    if (document.querySelectorAll('#devisBody tr').length > 1) {
      // Supprimez la ligne spécifiée
      document.getElementById('devisBody').removeChild(row);
    } else {
      alert("Vous ne pouvez pas supprimer la dernière ligne.");
    }
  }

  function moveRowUp(row) {
    const previousRow = row.previousElementSibling;
    if (previousRow) {
      document.getElementById('devisBody').insertBefore(row, previousRow);
      updateTotals(); // Mise à jour des totaux après le déplacement
    } else {
      console.log('Avertissement : Impossible de déplacer vers le haut');
    }
  }
  
  function moveRowDown(row) {
    const nextRow = row.nextElementSibling;
    if (nextRow) {
      document.getElementById('devisBody').insertBefore(nextRow, row);
      updateTotals(); // Mise à jour des totaux après le déplacement
    } else {
      console.log('Avertissement : Impossible de déplacer vers le bas');
    }
  }

  // Ajoutez des écouteurs d'événements aux champs d'entrée existants
  addEventListenersToDynamicFields();

  function addEventListenersToDynamicFields() {
    const dynamicFields = document.querySelectorAll('[name^="designation["], [name^="frais_avances["], [name^="prix_ht_10["], [name^="prix_ht_20["]');

    dynamicFields.forEach(function (field) {
      field.addEventListener('input', updateTotals);
    });
  }
});

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

















