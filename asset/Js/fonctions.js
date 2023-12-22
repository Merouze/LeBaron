// FOR GET TOKEN
function getToken() {
    // return document.querySelector('[data-token]').value
    return document.querySelector('body').getAttribute('data-token')
}
// ***************************************** */ Btn add member ************************************ 
function addFamilyMember() {
    let familyMembersContainer = document.getElementById('family-members-container');

    // Créer le conteneur pour le nom et le lien familial
    let container = document.createElement('div');

    // Ajouter le label et l'input text pour le nom
    container.innerHTML = `
    <div id="family-members-container">
    <label for="family-name">Nom et Prénom Famille et Proche :</label>
    <input type="text" class="family-name" name="family-name[]" required><br>
    <select name="family-link[]" class="family-name" required>
        <option value="Son epouse">Son épouse</option>
        <option value="Son epoux">Son époux</option>
        <hr>
        <option value="Sa fille">Sa fille</option>
        <option value="Ses filles">Ses filles</option>
        <option value="Son fils">Son fils</option>
        <option value="Ses fils">Ses fils</option>
        <option value="Ses enfants">Ses enfants</option>
        <option value="Son gendre">Son gendre</option>
        <hr>
        <option value="Sa soeur">Sa soeur</option>
        <option value="Ses soeurs">Ses soeurs</option>
        <option value="Son frere">Son frère</option>
        <option value="Ses freres">Ses frères</option>
        <option value="Ses freres et soeurs">Ses frères et soeurs</option>
        <hr>
        <option value="Son petit-fils">Son petit-fils</option>
        <option value="Sa petite-fille">Sa petite-fille</option>
        <option value="Ses petits-enfants">Ses petits-enfants</option>
        <option value="Ses arrière-petit-fils">Ses arrière-petit-fils</option>
        <option value="Ses arrière-petite-fille">Ses arrière-petite-fille</option>
        <option value="Ses arrières-petits-enfants">Ses arrières-petits-enfants</option>
        <hr>
        <option value="Son neveux">Son neuveux</option>
        <option value="Sa niece">Sa nièce</option>
        <option value="Ses neveux">Ses neveux</option>
        <hr>
        <option value="Son cousin">Son cousin</option>
        <option value="Ses cousins">Ses cousins</option>
        <option value="Sa cousine">Sa cousine</option>
        <option value="Ses cousines">Ses cousines</option>
        <hr>
        <option value="Sa tante">Sa tante</option>
        <option value="Ses tantes">Ses tantes</option>
        <option value="Son oncle">Son oncle</option>
        <option value="Ses oncles">Ses oncles</option>
        <option value="Ses oncles et tantes">Ses oncles et tantes</option>
        <hr>
        <option value="Son ami(e)">Son ami(e)</option>
        <option value="Ses ami(e)s">Ses ami(e)s</option>
    </select>
</div>
    `;

    // Ajouter le conteneur complet au conteneur principal
    familyMembersContainer.appendChild(container);
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

// ***************************************** */ Btn add member ************************************ 
    function confirmDelete(idDefunt) {
        // Utilisez la fonction confirm() pour afficher une boîte de dialogue avec les boutons OK et Annuler
        let confirmation = confirm("Êtes-vous sûr de vouloir supprimer cet avis de décès ?");

        // Si l'utilisateur clique sur OK, redirigez vers la page de suppression avec l'id du défunt
        if (confirmation) {
            window.location.href = `./admin.php`;
        }
    }



