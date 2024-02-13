<!-- // ----- # HEAD # ----- // -->
<?php include '../back-office/_includes/_head.php' ?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes/_nav-admin.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login.php' ?>
<!-- section header title -->
<section class="header-pages">
</section>
<div class="display-flex">

    <h1 class="mb50 display grey text-align padding-title">Espace&nbsp;<span class="blue">facturation</span></h1>
    <?php
    // Affichage des notifications ou erreurs
    if (isset($_SESSION['notif']) && is_array($_SESSION['notif'])) {
        echo '<span class="mb50 display-flex-center ' . $_SESSION['notif']['type'] . '">' . $_SESSION['notif']['message'] . '</span>';
        unset($_SESSION['notif']);
    } elseif (isset($_SESSION['error'])) {
        echo '<span class="mb50 display-flex-center error">' . $_SESSION['error'] . '</span>';
        unset($_SESSION['error']);
    }
    ?>
</div>

<section class="infos-estimate">

    <div>
        <form class="form-estimate" method="post" action="_treatment/_treatment-check-bill.php">
            <div>
                <label class="bold" for="Name">Nom et Prénom :</label>
                <input type="text" id="name" name="name" required>

                <label class="bold" for="adress">Adresse :</label>
                <input type="text" id="adress" name="adress" required>

                <label class="bold" for="cP">Code Postal :</label>
                <input type="text" id="cP" name="cP" required>

                <label class="bold" for="city">Ville :</label>
                <input type="text" id="city" name="city" required>

                <label class="bold" for="email">E-mail :</label>
                <input type="email" id="email" name="email" required>
                <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
                <div>
                    <table id="devisTable">
                        <thead>
                            <tr>
                                <th>Désignation</th>
                                <th>Frais avancés</th>
                                <th>Prix H.T. à 10%</th>
                                <th>Prix H.T. à 20%</th>
                                <th>Ajouter une ligne</th>
                            </tr>
                        </thead>
                        <tbody id="devisBody">
                            <tr id="row1">
                                <td><input type="text" name="designation[]"></td>
                                <td><input type="text" name="frais_avances[]"></td>
                                <td><input type="text" name="prix_ht_10[]"></td>
                                <td><input type="text" name="prix_ht_20[]"></td>
                                <td>
                                    <ul class="icon-estimate">
                                        <li>
                                            <img class="addRow" src="../asset/img/icons8-add-30.png" alt="logo-add">
                                        </li>
                                        <li>
                                            <img class="moveUp" src="../asset/img/icons8-up-30.png" alt="icons-up">

                                        </li>
                                        <li>
                                            <img class="moveDown" src="../asset/img/icons8-down-30.png" alt="icons-down">

                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                        <tr>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td>Total HT</td>
                            <td><input type="text" id="total_ht" name="total_ht"></td>
                            <td style="visibility: hidden;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td>TVA à 10%</td>
                            <td><input type="text" id="tva_10" name="tva_10"></td>
                            <td style="visibility: hidden;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td>TVA à 20%</td>
                            <td><input type="text" id="tva_20" name="tva_20"></td>
                            <td style="visibility: hidden;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td>Frais avancés</td>
                            <td><input type="text" id="total_frais_avances" name="total_frais_avances"></td>
                            <td style="visibility: hidden;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td>TTC</td>
                            <td><input type="text" id="ttc" name="ttc"></td>
                            <td style="visibility: hidden;">&nbsp;</td>
                        </tr>
                    </table>
                </div>
                <br>
                <br>
                <label class="bold" for="commentaire">Commentaire :</label>
                <textarea rows="6" id="commentaire" name="commentaire"></textarea>
            </div>
            <!-- <button type="submit" formtarget="_blank" name="submitPDF">Générer PDF</button> -->
            <br>
            <button type="submit" name="submitAddBill">Enregistrer</button>
            <br>
            <!-- <button type="submit" name="submitSendBill">Enregistrer et envoyer par mail</button> -->

        </form>
        <form class="form-estimate" method="post" action="_treatment/_treatment-billing.php">
            <div>
                <button type="submit" formtarget="_blank" name="submitPDF">Générer PDF</button>

                <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
            </div>
        </form>
        <form class="form-estimate" method="post" action="_treatment/_treatment-billing.php">
            <div>
                <button type="submit" formaction="" name="_treatment/_treatment_add_bill.php">Enregistrer sans envoyer par mail</button>
                <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
            </div>
        </form>
    </div>
</section>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>

<script src=".././asset/Js/script.js"></script>
<script src=".././asset/Js/fonctions.js"></script>
</body>

</html>