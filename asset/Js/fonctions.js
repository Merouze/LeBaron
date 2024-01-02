// FOR GET TOKEN
function getToken() {
    // return document.querySelector('[data-token]').value
    return document.querySelector('body').getAttribute('data-token')
}


function removeFamilyMember() {
    let familyMembersContainer = document.getElementById('family-members-container');

    // Récupérer tous les conteneurs enfants
    let containers = familyMembersContainer.getElementsByTagName('div');

    // Vérifier s'il y a plus d'un conteneur avant de supprimer
    if (containers.length > 1) {
        familyMembersContainer.removeChild(containers[containers.length - 1]);
    } else {
        // S'il ne reste qu'un conteneur, effacer le contenu à la place de le supprimer
        containers[0].innerHTML = '';
    }
}

// *****************************************  ************************************ 
   



