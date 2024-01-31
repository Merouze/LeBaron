// Mobile menu 

document.getElementById('burger-icon').addEventListener('click', function () {
  let navLinks = document.querySelector('.nav-links');
  navLinks.classList.toggle('active');
});
// ***************************************** */ Btn back-top************************************ 

// Au chargement de la page, attachez la fonction de défilement
window.onscroll = function () {
  scrollFunction();
};

function scrollFunction() {
  // Si le défilement est supérieur à 20 pixels, affichez le bouton
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    document.getElementById("myBtn").style.display = "block";
  } else {
    // Sinon, masquez le bouton
    document.getElementById("myBtn").style.display = "none";
  }
}

// Lorsque le bouton est cliqué, remontez en haut de la page avec un effet en douceur
function topFunction() {
  document.body.scrollTop = 0; // Pour Safari
  document.documentElement.scrollTop = 0; // Pour les autres navigateurs
}

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
// ***************************************** */ addRow For estimate ************************************ 





















