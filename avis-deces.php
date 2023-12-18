<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes./_nav.php' ?>
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Avis de décès et&nbsp;<span class="blue">Condoléances</span></h1>
<!-- section obituary -->
<section class="obituary mt50 mt100">
    <div class="obituary-text ad">
        <form class="recherche-ad" action="">
            <h3 class="text-align white">Recherche par Nom ou Prénom</h3>
            <label for="recherche"></label>
            <input class="input-ad" type="text">
            <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
            <button type="submit" class="cta-ad ">Rechercher</button>
        </form>
    </div>
</section>

<section class="display-ad">
    <h3 class="mb50 text-align grey">Nos derniers avis de <span class="blue">décès publiés</span></h3>
    <ul>
        <li>
            <ul>
                <div class="display-mtb20">
                    <div>
                        <li>JEANNINE ROMBEAUX (14)</li>
                        <li class="blue">11/12/23</li>
                    </div>
                    <div>
                        <p class="obituary-cta"><a class="cta-obituary" href="">Consulter +</a></p>
                    </div>
                </div>
            </ul>
        <li>
            <ul>
                <div class="display-mtb20">
                    <div>
                        <li>JEANNINE ROMBEAUX (14)</li>
                        <li class="blue">11/12/23</li>
                    </div>
                    <div>
                        <p class="obituary-cta"><a class="cta-obituary" href="">Consulter +</a></p>
                    </div>
                </div>
            </ul>
        </li>
        <li>
            <ul>
                <div class="display-mtb20">
                    <div>
                        <li>JEANNINE ROMBEAUX (14)</li>
                        <li class="blue">11/12/23</li>
                    </div>
                    <div>
                        <p class="obituary-cta"><a class="cta-obituary" href="">Consulter +</a></p>
                    </div>
                </div>
            </ul>
        </li>
        <li>
            <ul>
                <div class="display-mtb20">
                    <div>
                        <li>JEANNINE ROMBEAUX (14)</li>
                        <li class="blue">11/12/23</li>
                    </div>
                    <div>
                        <p class="obituary-cta"><a class="cta-obituary" href="">Consulter +</a></p>
                    </div>
                </div>
            </ul>
        </li>
    </ul>


</section>
<!-- // ----- # FORM # ----- // -->
<?php include './_includes./_form.php' ?>
<!-- // ----- # MAP # ----- // -->
<?php include './_includes./_location.php' ?>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes./_footer.php' ?>