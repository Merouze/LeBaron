// Mobile menu 

document.getElementById('burger-icon').addEventListener('click', function () {
  let navLinks = document.querySelector('.nav-links');
  navLinks.classList.toggle('active');
});

// Captcha form 

function onSubmit(token) {
  document.getElementById("demo-form").submit();
}

// Au chargement de la page, attachez la fonction de défilement
window.onscroll = function() {
  scrollFunction();
};

// ***************************************** */ Btn back-top************************************ 

// Au chargement de la page, attachez la fonction de défilement
window.onscroll = function() {
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

