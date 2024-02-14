// FOR GET TOKEN
function getToken() {
    // return document.querySelector('[data-token]').value
    return document.querySelector('body').getAttribute('data-token')
}
// add and delete member family
function addFamilyMember() {
    // Sélectionner le conteneur des membres de la famille
    let familyMembersContainer = document.querySelector('#family-members-container');

    // Créer un nouvel élément div pour le membre de la famille
    let newFamilyMember = document.createElement('div');

    // Créer l'élément input
    let inputElement = document.createElement('input');
    inputElement.type = 'text';
    inputElement.id = 'family-name';
    inputElement.name = 'family-name[]';
    inputElement.required = true;

    // Créer l'élément select
    let selectElement = document.createElement('select');
    selectElement.name = 'family-link[]';
    selectElement.className = 'family-name';
    selectElement.required = true;

    // Ajouter les options au select
    let options = [
        "Sa fille", "Ses filles", "Son fils", "Ses fils", "Ses enfants", "Sa belle fille", "Son gendre",

        "Sa soeur", "Ses soeurs", "Son frere", "Ses freres", "Ses freres et soeurs",
        "Son petit-fils", "Sa petite-fille", "Ses petits-enfants", "Ses arrière-petit-fils",
        "Ses arrière-petite-fille", "Ses arrières-petits-enfants", "Son neveux", "Sa niece",
        "Ses neveux", "Son cousin", "Ses cousins", "Sa cousine", "Ses cousines",
        "Sa tante", "Ses tantes", "Son oncle", "Ses oncles", "Ses oncles et tantes",
        "Son ami(e)", "Ses ami(e)s"
    ];

    options.forEach(optionText => {
        let option = document.createElement('option');
        option.value = optionText;
        option.text = optionText;
        selectElement.appendChild(option);
    });

    // Ajouter l'input et le select à la div
    newFamilyMember.appendChild(inputElement);
    newFamilyMember.appendChild(selectElement);

    // Ajouter le nouveau membre de la famille au conteneur
    familyMembersContainer.appendChild(newFamilyMember);
}
function removeFamilyMember() {
    let familyMembersContainer = document.getElementById('family-members-container');

    // Récupérer tous les conteneurs enfants
    let containers = familyMembersContainer.getElementsByTagName('div');

    // Vérifier s'il y a plus d'un conteneur avant de supprimer
    if (containers.length > 1) {
        // Supprimer effectivement le dernier conteneur
        familyMembersContainer.removeChild(containers[containers.length - 1]);
    } else {
        // S'il ne reste qu'un conteneur, effacer le contenu
        containers[0].querySelector('input').value = '';
        containers[0].querySelector('select').value = '';
    }
}
// delete condolence 
function confirmDeleteMessage(idCondolence) {
    // Utilisez la fonction confirm() pour afficher une boîte de dialogue avec les boutons OK et Annuler
    const confirmation = confirm("Êtes-vous sûr de vouloir supprimer ce message de condoléance ?");

    // Si l'utilisateur clique sur OK, redirigez vers la page de suppression avec l'id du défunt
    if (confirmation) {
        window.location.href = `./_treatment/_treatment_message.php?idCondolence=${idCondolence}&idDefunt=<?= $idDefunt ?>`;
    }
}
// delete obituary 
function confirmDelete(idDefunt) {
    // Utilisez la fonction confirm() pour afficher une boîte de dialogue avec les boutons OK et Annuler
    var confirmation = confirm("Êtes-vous sûr de vouloir supprimer cet avis de décès ?");

    // Si l'utilisateur clique sur OK, redirigez vers la page de suppression avec l'id du défunt
    if (confirmation) {
        window.location.href = `./_treatment/_delete.php?idDefunt=${idDefunt}`;
    }
}
// delete all account users
function confirmDeleteAll(idDefunt) {
    var confirmation = confirm("Êtes-vous sûr de vouloir supprimer les données familiales ?");
    if (confirmation) {
        // Si l'utilisateur clique sur OK dans la boîte de dialogue, redirigez vers la page de suppression
        window.location.href = "_treatment/_delete_family_data.php?idDefunt=" + idDefunt;
    }
}
// delete bill
function confirmDeleteBill(idBill) {
    var confirmation = confirm("Êtes-vous sûr de vouloir supprimer les données de cette factures ?");
    if (confirmation) {
        // Si l'utilisateur clique sur OK dans la boîte de dialogue, redirigez vers la page de suppression
        window.location.href = "_treatment/_delete_bill.php?idBill=" + idBill;
    }
    // Si l'utilisateur clique sur Annuler, ne faites rien
}
// scroll btn 
function scrollFunction() {
    // Si le défilement est supérieur à 20 pixels, affichez le bouton
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myBtn").style.display = "block";
    } else {
      // Sinon, masquez le bouton
      document.getElementById("myBtn").style.display = "none";
    }
}
// scroll btn  
function topFunction() {
      document.body.scrollTop = 0;
      document.documentElement.scrollTop = 0;
}




      
