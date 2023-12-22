<?php
// Vérifiez si un ID de défunt est fourni pour la modification
if (isset($_POST['defunt_id']) && !empty($_POST['defunt_id'])) {
    $defuntId = $_POST['defunt_id'];

    $sqlUpdateDefunt = $dtLb->prepare("UPDATE defunt SET nom_prenom_defunt = :name, date_deces = :deathDate, age = :ageDeath WHERE id_defunt = :defuntId");
    $sqlUpdateDefunt->execute([
        'name' => $name,
        'deathDate' => $deathDate,
        'ageDeath' => $ageDeath,
        'defuntId' => $defuntId,
    ]);

    // Continuez avec le reste du code pour les autres tables...
} else {
    // Si aucun ID de défunt n'est fourni, il s'agit d'une nouvelle insertion
    $sqlDefunt = $dtLb->prepare("INSERT INTO defunt (nom_prenom_defunt, date_deces, age) VALUES (:name, :deathDate, :ageDeath)");
    $sqlDefunt->execute([
        'name' => $name,
        'deathDate' => $deathDate,
        'ageDeath' => $ageDeath,
    ]);

    // Récupérez l'ID du défunt inséré
    $defuntId = $dtLb->lastInsertId();
}

// Vérifiez si un ID de proche principal est fourni pour la modification
if (isset($_POST['proche_principal_id']) && !empty($_POST['proche_principal_id'])) {
    $prochePrincipalId = $_POST['proche_principal_id'];

    $sqlUpdateProchePrincipal = $dtLb->prepare("UPDATE proche SET nom_prenom_proche = :mainName, lien_familial = :mainLink WHERE id_proche = :prochePrincipalId");
    $sqlUpdateProchePrincipal->execute([
        'mainName' => $mainName,
        'mainLink' => $mainLink,
        'prochePrincipalId' => $prochePrincipalId,
    ]);

    // Continuez avec le reste du code pour les autres tables...
} else {
    // Si aucun ID de proche principal n'est fourni, il s'agit d'une nouvelle insertion
    $sqlProchePrincipal = $dtLb->prepare("INSERT INTO proche (nom_prenom_proche, lien_familial, id_defunt) VALUES (:mainName, :mainLink, :defuntId)");
    $sqlProchePrincipal->execute([
        'mainName' => $mainName,
        'mainLink' => $mainLink,
        'defuntId' => $defuntId,
    ]);
}
// Vérifiez si des membres de la famille existent pour la modification
if (!empty($familyNames)) {
    foreach ($familyNames as $familyIndex => $familyName) {
        // Vérifiez si un ID de membre de la famille est fourni pour la modification
        if (isset($_POST['family_ids'][$familyIndex]) && !empty($_POST['family_ids'][$familyIndex])) {
            $familyId = $_POST['family_ids'][$familyIndex];

            $sqlUpdateFamilyMember = $dtLb->prepare("UPDATE proche SET nom_prenom_proche = :familyName, lien_familial = :familyLink WHERE id_proche = :familyId");
            $sqlUpdateFamilyMember->execute([
                'familyName' => $familyName,
                'familyLink' => $familyLink[$familyIndex],
                'familyId' => $familyId,
            ]);

            // Continuez avec le reste du code pour les autres tables...
        } else {
            // Si aucun ID de membre de la famille n'est fourni, il s'agit d'une nouvelle insertion
            $sqlFamilyMember = $dtLb->prepare("INSERT INTO proche (nom_prenom_proche, lien_familial, id_defunt) VALUES (:familyName, :familyLink, :defuntId)");
            $sqlFamilyMember->execute([
                'familyName' => $familyName,
                'familyLink' => $familyLink[$familyIndex],
                'defuntId' => $defuntId,
            ]);
        }
    }
}


?>