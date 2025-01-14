<?php if ($action == "nouveauDossier" || $action == "nouveauDossierRechercheClient") { ?>
    <div class="contourAdmin container-fluid container-md d-flex justify-content-center align-items-center flex-column rounded-3">
        <div class="container my-3">
            <form class="form-inline" action="index.php">
                <div class="input-group col-auto maRecherche">
                    <input type="hidden" name="action" value="nouveauDossierRechercheClient">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <select name="optionRechercheNouveauDossier" class="rounded-5 me-1">
                        <option value="com">Numéro Commande</option>
                        <option value="nom">Nom Prénom</option>
                    </select>
                    <input class="form-control form-control-sm espaceBouton rounded-5" type="search" name="search" placeholder="Rechercher" aria-label="Rechercher">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-primary bouton" type="submit">Rechercher</button>
                    </div>
                </div>
            </form>
        </div>

        <?php
        if ($action === 'nouveauDossier') {
        ?>
            <div class="table-responsive w-100">

                <table class="container-fluid container-md table table-striped border alignTable rounded-3 maTableAdmin overflow-hidden">
                    <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Code Postal</th>
                            <th scope="col">Ville</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nombreClient = 0;
                        foreach ($clients as $client) { 
                            $nombreClient = $nombreClient+1?>
                            <tr>
                                <th scope="row"><?= $client['nomClient']; ?></th>
                                <td><?= $client['prenomClient']; ?></td>
                                <td><?= $client['codePostalClient']; ?></td>
                                <td><?= $client['villeClient']; ?></td>
                                <td>
                                    <a href="index.php?action=voirCommandesClient&idClient=<?= $client['idClient'] ?>">
                                        <button class="btn bouton">Voir les commandes</button>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
        
                    <p class="d-flex justify-content-center text-white">Nombre de clients trouvés : <?= $nombreClient; ?></p>
               
            </div>
            <?php
            
        }

        if ($action === 'nouveauDossierRechercheClient') {
            if ($_GET['optionRechercheNouveauDossier'] == 'nom') { ?>


                <?php if (!is_null($recherche) && count($recherche) > 0) { ?>
                    <div class="table-responsive w-100">

                        <table class="container-fluid container-md table table-striped border alignTable rounded-3 maTableAdmin overflow-hidden">
                            <thead>
                                <tr>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prénom</th>
                                    <th scope="col">Code Postal</th>
                                    <th scope="col">Ville</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recherche as $client) { ?>
                                    <tr>
                                        <th scope="row"><?= $client['nomClient']; ?></th>
                                        <td><?= $client['prenomClient']; ?></td>
                                        <td><?= $client['codePostalClient']; ?></td>
                                        <td><?= $client['villeClient']; ?></td>
                                        <td><a href="index.php?action=voirCommandesClient&idClient=<?= $client['idClient'] ?>"><button class="btn bouton">Voir les commandes</button></a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <p class="d-flex justify-content-center text-white">Aucun résultat trouvé.</p>
                <?php } ?>
                <?php if ($recherche) { ?>
                    <p class="d-flex justify-content-center text-white">Nombre de clients trouvés : <?= count($recherche); ?></p>
                <?php }  ?>

            <?php
            }
            if ($_GET['optionRechercheNouveauDossier'] == 'com') { ?>


                <?php if (!is_null($recherche) && count($recherche) > 0) { ?>
                    <?php $dateCommande = date('d-m-Y', strtotime($recherche[0]['dateCommande'])); ?>
                    <div class="table-responsive w-100">

                        <table class="container-fluid container-md table table-striped border alignTable rounded-3 maTableAdmin overflow-hidden">
                            <thead>
                                <tr>
                                    <th scope="col">Numéro</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prénom</th>
                                    <th scope="col">Code Postal</th>
                                    <th scope="col">Ville</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row"><?= $recherche[0]['numCommande']; ?></th>
                                    <td><?= $dateCommande; ?></td>
                                    <td><?= $recherche[0]['nomClient']; ?></td>
                                    <td><?= $recherche[0]['prenomClient']; ?></td>
                                    <td><?= $recherche[0]['codePostalClient']; ?></td>
                                    <td><?= $recherche[0]['villeClient']; ?></td>
                                    <td><a href="index.php?action=voirCommande&commande=<?= $recherche[0]['numCommande']; ?>"><button class="btn bouton">Voir la commande</button></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <p class="d-flex justify-content-center text-white">Aucun résultat trouvé.</p>
                <?php } ?>


    <?php
            }
        }
    } ?>

    </div>

    <?php if ($action == "creerNouveauDossier") { ?>

        <?php $dateCommande = date('d-m-Y', strtotime($commande[0]['dateCommande'])); ?>

        <div class="contourAdmin container-fluid container-md d-flex justify-content-center align-items-center flex-column rounded-3">
            <div class="container my-3">

                <h4 style="color: white;">Client : <?= $commande[0]['prenomClient'] . " " . $commande[0]['nomClient']; ?></h4>
                <h4 style="color: white;">Numéro de commande : <?= $commande[0]['numCommande']; ?></h4>
                <h4 style="color: white;">Date de commande : <?= $dateCommande; ?></h4>
                <div class="table-responsive w-100">

                    <form action="">
                        <input type="hidden" name="action" value="creerNouveauDossierMAJ">
                        <input type="hidden" name="commande" value="<?= $commande[0]['numCommande']; ?>">

                        <div class="d-flex justify-content-evenly container">
                            <div class="d-flex align-items-center my-1">
                                <input type="radio" name="typeSAV" class="me-1 btnOption" value="npai" id="npai">
                                <label for="npai" style="color: white;">NPAI</label>
                            </div>
                            <div class="d-flex align-items-center my-1">
                                <input type="radio" name="typeSAV" class="me-1 btnOption" value="np" id="np">
                                <label for="np" style="color: white;">NP</label>
                            </div>
                            <div class="d-flex align-items-center my-1">
                                <input type="radio" name="typeSAV" class="me-1 btnOption" value="ec" id="ec">
                                <label for="ec" style="color: white;">EC</label>
                            </div>
                            <div class="d-flex align-items-center my-1">
                                <input type="radio" name="typeSAV" class="me-1 btnOption" value="ep" id="ep">
                                <label for="ep" style="color: white;">EP</label>
                            </div>
                            <div class="d-flex align-items-center my-1">
                                <input type="radio" name="typeSAV" class="me-1 btnOption" value="sav" id="sav" checked>
                                <label for="sav" style="color: white;">SAV</label>
                            </div>
                        </div>

                        <table class="container-fluid container-md table table-striped border alignTable rounded-3 maTableAdmin overflow-hidden">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th scope="col">Article</th>
                                    <th scope="col">Nom de l'article</th>
                                    <th scope="col">Durée de garantie</th>
                                    <th scope="col">Date fin de garantie</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($commande as $article) {
                                    $codeArticle = $article['codeArticle'];
                                    $dureeGarantie = $article['garantieArticle'];
                                    $finGarantie = date('d-m-Y', strtotime($article['dateCommande'] . " + $dureeGarantie year")) // $article['dateCommande'] + $article['dateCommande']
                                ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="checkArticle[]" value="<?= $codeArticle; ?>">
                                        </td>
                                        <td scope="row"><?= $codeArticle; ?></td>
                                        <td><?= $article['libelleArticle']; ?></td>
                                        <td><?= $article['garantieArticle']; ?></td>
                                        <td><?= $finGarantie; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <div class="text-center">
                            <button type="submit" class="btn bouton">Créer un nouveau dossier</button>
                        </div>

                    </form>
                    <a href=javascript:history.go(-1)><button class="btn bouton">Retour</button></a>
                </div>
            </div>
        </div>


    <?php } ?>

    <?php if ($action == "creerNouveauDossierMAJ") { ?>
        <?php $dateCommande = date('d-m-Y', strtotime($commande[0]['dateCommande']));
        ?>

        <div class="contourAdmin container-fluid container-md d-flex justify-content-center align-items-center flex-column rounded-3">
            <div class="container my-3">

                <h4 style="color: white;">Client : <?= $commande[0]['prenomClient'] . " " . $commande[0]['nomClient']; ?></h4>
                <h4 style="color: white;">Numéro de commande : <?= $commande[0]['numCommande']; ?></h4>
                <h4 style="color: white;">Date de commande : <?= $dateCommande; ?></h4>
                <?php $typeDossier = strtoupper($_GET['typeSAV']) ?>
                <h4 style="color: white;">Type de dossier : <?= $typeDossier; ?></h4>
                <div class="table-responsive w-100">

                    <form action="">
                        <input type="hidden" name="action" value="nouveauDossierValide">
                        <input type="hidden" name="commande" value="<?= $commande[0]['numCommande']; ?>">

                        <table class="container-fluid container-md table table-striped border alignTable rounded-3 maTableAdmin overflow-hidden">
                            <thead>
                                <tr>
                                    <th scope="col">Article</th>
                                    <th scope="col">Nom de l'article</th>
                                    <th scope="col">Durée de garantie</th>
                                    <th scope="col">Date fin de garantie</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($commande as $article) {
                                    foreach ($_GET['checkArticle'] as $checkArticle) {

                                        if ($article['codeArticle'] == $checkArticle) {

                                            $codeArticle = $article['codeArticle'];
                                            $dureeGarantie = $article['garantieArticle'];
                                            $finGarantie = date('d-m-Y', strtotime($article['dateCommande'] . " + $dureeGarantie year")) // $article['dateCommande'] + $article['dateCommande']
                                ?>
                                            <input type="hidden" name="checkArticle[]" value="<?= $article['codeArticle'] ?>">
                                            <tr>
                                                <td scope="row"><?= $codeArticle; ?></td>
                                                <td><?= $article['libelleArticle']; ?></td>
                                                <td><?= $article['garantieArticle']; ?></td>
                                                <td><?= $finGarantie; ?></td>
                                            </tr>

                                <?php
                                        }
                                    }
                                } ?>
                            </tbody>
                        </table>
                        <div class="my-4">
                            <h4 style="color: white;">Description du problème rencontré</h4>
                            <div class="text-center ">
                                <div class="form-floating container w-75">
                                    <textarea class="form-control" name="commentaire" style="height: 100px"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- INFOS POUR LE INSERT -->
                        <input type="hidden" name="typeDossier" value="<?= $typeDossier ?>">
                        <input type="hidden" name="numCommande" value="<?= $commande[0]['numCommande']; ?>">
                        <input type="hidden" name="idUtilisateur" value="<?= $id ?>">

                        <div class="text-center">
                            <button type="submit" class="btn bouton">Créer un nouveau dossier</button>
                        </div>

                    </form>
                    <a href=javascript:history.go(-1)><button class="btn bouton">Retour</button></a>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if ($action == "nouveauDossierValide") { ?>
        <a style="text-decoration: none;" href="index.php?action=voirDossier&numDossier=<?= $numDossier ?>">
            <div class="container text-center w-25 maCarte">
                <h4 class="p-5">Dossier numéro : <?= $numDossier ?><br><br> Commande numéro : <?= $numCom ?></h4>
                <div class="text-center mb-5">
                    <button type="submit" class="btn bouton">Voir le dossier</button>
                </div>
            </div>
        </a>

    <?php } ?>

    <script>
        npai = document.getElementById('npai');
        np = document.getElementById('np');
        ec = document.getElementById('ec');
        ep = document.getElementById('ep');
        sav = document.getElementById('sav');

        npai.onclick = function() {
            checkbox = document.querySelectorAll('input[type=checkbox]')

            checkbox.forEach(element => {
                element.checked = true
            });
        }

        np.onclick = function() {
            checkbox = document.querySelectorAll('input[type=checkbox]')

            checkbox.forEach(element => {
                element.checked = true
            });
        }
        ec.onclick = function() {
            checkbox = document.querySelectorAll('input[type=checkbox]')

            checkbox.forEach(element => {
                element.checked = false
            });
        }
        ep.onclick = function() {
            checkbox = document.querySelectorAll('input[type=checkbox]')

            checkbox.forEach(element => {
                element.checked = false
            });
        }
        sav.onclick = function() {
            checkbox = document.querySelectorAll('input[type=checkbox]')

            checkbox.forEach(element => {
                element.checked = false
            });
        }
    </script>