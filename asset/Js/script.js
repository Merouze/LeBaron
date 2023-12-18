
// ----------------------------------- //
// ----------- FOR DISPLAY ----------- //

// Mobile menu 

// const mobileButton = document.getElementById("mobile-button");
// const mainNav = document.getElementById("main-nav");
// const mobileIcon = document.getElementById("mobile-icon");


// mobileButton.addEventListener("click", toggleNav);

// mainNav.addEventListener("click", function(event) {
//     if (event.target.hasAttribute("href")) toggleNav();
// })

// window.addEventListener("resize", function(event) {
//     if (window.innerWidth >= 768) resetNav();
// })

// Modal services

// const cardsList = document.querySelectorAll("#cards-list a.card");
// cardsList.forEach(function(card) {
//     card.addEventListener("click", function(event) {
//         event.preventDefault();
//         const modal = createModal();
//         const classList = {
//             H3: "modal-ttl",
//             P: "modal-txt",
//             IMG: "modal-icon"
//         };
//         modal.firstElementChild.innerHTML = '<i class="fa fa-times modal-close" aria-hidden="true"></i>';
//         Object.values(this.children).forEach(function(element) {
//             const newElement = element.cloneNode(true);
//             newElement.className = classList[element.tagName];
//             modal.firstElementChild.appendChild(newElement);
//         });
//     })
// })


// Mobile menu 


document.getElementById('burger-icon').addEventListener('click', function () {
  console.log('salut');
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
