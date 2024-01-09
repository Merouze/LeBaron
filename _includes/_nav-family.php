<div class="navbar">
    <div class="contact-info">
        <div class="d-logo">
            <img class="logo" src="asset\img\Logo-LB.png" alt="">
        </div>
        <div class="nav-info">
            <p class="info-nav">Permanence téléphonique 7j/7 et 24h/24</p>
        </div>
        <div class="contact-info-cta">
            <p><a href="tel:+33231269175">📞 02 31 26 91 75</a></p>
            <p class="cta"><a href="tel:+33231269175">Nous contacter</a></p>
        </div>
        

    </div>
    </div>
    <div class="nav-links">
        <ul>
            <li><a href="./family.php">Espace famille</a></li>
            <ul class="dropdown">
                <li><a href="#">Avis de décès ▼</a></li>
                <div class="dropdown-content">
                <li><a href="avis-deces.php?idDefunt=<?= urlencode($resultat['id_defunt']) ?>">Voir l'Avis de Décès</a></li>
            <li><a href="see-message.php?idDefunt=<?= urlencode($resultat['id_defunt']) ?>">Voir les Condoléances</a></li>

                </div>
            </ul>
            <li><a href="contact.php">Se Déconnecter</a></li>
        </ul>
    </div>
    <div class="burger-menu" id="burger-icon">&#9776;</div>
</div>