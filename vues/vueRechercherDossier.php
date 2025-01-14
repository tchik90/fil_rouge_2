
<div class="contourAdmin container d-flex justify-content-center align-items-center flex-column rounded-3">
    <?php
    if ($action === "rechercherDossier") {
    ?>

        <!-- RECHERCHE -->
        <div class="container my-3">
            <form class="form-inline" action="index.php">
                <div class="input-group col-auto maRecherche">
                    <input type="hidden" name="action" value="rechercherDossierMAJ">
                    <select name="optionRechercheDossier" class="rounded-5 me-1">
                        <option value="com">Numéro Commande</option>
                        <option value="dos">Numéro Dossier</option>
                        <option value="nom">Nom Client</option>
                    </select>
                    <input class="form-control form-control-sm espaceBouton rounded-5" type="search" name="search" placeholder="Rechercher" aria-label="Rechercher">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-primary bouton" type="submit">Rechercher</button>
                    </div>
                </div>
            </form>
        </div>

            <table class="container-fluid container-md table table-striped border alignTable rounded-3 maTableAdmin overflow-hidden">
                <thead>
                    <tr>
                        <th scope="col">Numero de dossier</th>
                        <th scope="col">Numéro de commande</th>
                        <th scope="col">Date de création du dossier</th>
                        <th scope="col">Nom du client</th>
                        <th scope="col">Type de dossier</th>
                        <th scope="col">Dossier géré par</th>
                        <th scope="col">Statut du dossier</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dossiers as $dossier) { ?>
                        <tr>
                            <th scope="row"><?= $dossier['numDossier']; ?></th>
                            <td><?= $dossier['numCommande']; ?></td>
                            <td><?= $dossier['dateDossier']; ?></td>
                            <td><?= $dossier['nomClient']; ?></td>
                            <td><?= afficherTypeDossier($dossier['typeDossier']); ?></td>
                            <td><?= $dossier['nomUtilisateur']; ?></td>
                            <td><?= afficherStatutDossier($dossier['statutDossier']); ?></td>
                            <td><a href="index.php?action=voirDossier&numDossier=<?= $dossier['numDossier']; ?>"><button class="btn bouton">Voir le dossier</button></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        <p class="d-flex justify-content-center text-white">Nombre de dossiers trouvés : <?= count($dossiers); ?></p>


    <?php
    }
    ?>
    <?php
    if ($action === 'rechercherDossierMAJ') {
        if ($_GET['optionRechercheDossier'] == 'nom') { ?>


<?php if (!is_null($recherche) && count($recherche) > 0) {
                //var_dump($recherche);
            ?>
                
                <!-- RECHERCHE -->
                <div class="container my-3">
                    <form class="form-inline" action="index.php">
                        <div class="input-group col-auto maRecherche">
                            <input type="hidden" name="action" value="rechercherDossierMAJ">
                            <select name="optionRechercheDossier" class="rounded-5 me-1">
                                <option value="com">Numéro Commande</option>
                                <option value="dos">Numéro Dossier</option>
                                <option value="nom">Nom Prénom</option>
                            </select>
                            <input class="form-control form-control-sm espaceBouton rounded-5" type="search" name="search" placeholder="Rechercher" aria-label="Rechercher">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-primary bouton" type="submit">Rechercher</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive w-100">

                    <table class="container table table-striped border alignTable rounded-3 maTableAdmin overflow-hidden">
                        <thead>
                            <tr>
                                <th scope="col">Numéro de dossier</th>
                                <th scope="col">Numéro de commande</th>
                                <th scope="col">Date de création du dossier</th>
                                <th scope="col">Nom du client</th>
                                <th scope="col">Type de dossier</th>
                                <th scope="col">Dossier géré par</th>
                                <th scope="col">Statut du dossier</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($recherche as $info) {
                                
                                $dateCommande = date('d-m-Y', strtotime($info['dateDossier']));
                                $typeDossier = afficherTypeDossier($info['typeDossier']);
                                $utilisateur = getUtilisateur($info['idUtilisateur']);
                                $statutDossier = afficherStatutDossier($info['statutDossier']);
                                ?>
                            <tr>
                                <td><?= $info['numDossier']; ?></td>
                                <td><?= $info['numCommande']; ?></td>
                                <td><?= $dateCommande; ?></td>
                                <th scope="row"><?= $info['nomClient']; ?></th>
                                <td><?= $typeDossier; ?></td>
                                <td><?= $utilisateur['nomUtilisateur']; ?></td>
                                <td><?= $statutDossier; ?></td>
                                <td><a href="index.php?action=voirDossier&numDossier=<?= $info['numDossier']; ?>"><button class="btn bouton">Voir le dossier</button></a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <a href=javascript:history.go(-1)><button class="btn bouton mb-3">Retour</button></a>
                </div>
            <?php } else { ?>
                <p class="d-flex justify-content-center text-white">Aucun résultat trouvé.</p>
            <?php } ?>
            <?php if ($recherche) { ?>
                <p class="d-flex justify-content-center text-white">Nombre de clients trouvés : <?= count($recherche); ?></p>
            <?php }  ?>

        <?php
        }

        if ($_GET['optionRechercheDossier'] == 'dos') { ?>


            <?php if (!is_null($recherche) && count($recherche) > 0) {
                //var_dump($recherche);
            ?>
                <?php
                $dateCommande = date('d-m-Y', strtotime($recherche[0]['dateDossier']));
                $typeDossier = afficherTypeDossier($recherche[0]['typeDossier']);
                $utilisateur = getUtilisateur($recherche[0]['idUtilisateur']);
                $statutDossier = afficherStatutDossier($recherche[0]['statutDossier']);
                ?>
                <!-- RECHERCHE -->
                <div class="container my-3">
                    <form class="form-inline" action="index.php">
                        <div class="input-group col-auto maRecherche">
                            <input type="hidden" name="action" value="rechercherDossierMAJ">
                            <select name="optionRechercheDossier" class="rounded-5 me-1">
                                <option value="com">Numéro Commande</option>
                                <option value="dos">Numéro Dossier</option>
                                <option value="nom">Nom Prénom</option>
                            </select>
                            <input class="form-control form-control-sm espaceBouton rounded-5" type="search" name="search" placeholder="Rechercher" aria-label="Rechercher">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-primary bouton" type="submit">Rechercher</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive w-100">

                    <table class="container table table-striped border alignTable rounded-3 maTableAdmin overflow-hidden">
                        <thead>
                            <tr>
                                <th scope="col">Numéro de dossier</th>
                                <th scope="col">Numéro de commande</th>
                                <th scope="col">Date de création du dossier</th>
                                <th scope="col">Nom du client</th>
                                <th scope="col">Type de dossier</th>
                                <th scope="col">Dossier géré par</th>
                                <th scope="col">Statut du dossier</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row"><?= $recherche[0]['numDossier']; ?></th>
                                <td><?= $recherche[0]['numCommande']; ?></td>
                                <td><?= $dateCommande; ?></td>
                                <td><?= $recherche[0]['nomClient']; ?></td>
                                <td><?= $typeDossier; ?></td>
                                <td><?= $utilisateur['nomUtilisateur']; ?></td>
                                <td><?= $statutDossier; ?></td>
                                <td><a href="index.php?action=voirDossier&numDossier=<?= $recherche[0]['numDossier']; ?>"><button class="btn bouton">Voir le dossier</button></a></td>
                            </tr>
                        </tbody>
                    </table>
                    <a href=javascript:history.go(-1)><button class="btn bouton mb-3">Retour</button></a>
                </div>
            <?php } else { ?>
                <p class="d-flex justify-content-center text-white">Aucun résultat trouvé.</p>
            <?php }
        }

        if ($_GET['optionRechercheDossier'] == 'com') {
            //var_dump($recherche);
            ?>


            <?php if (!is_null($recherche) && count($recherche) > 0) {
                //var_dump($recherche);
            ?>
                <?php
                $dateCommande = date('d-m-Y', strtotime($recherche[0]['dateDossier']));
                $typeDossier = afficherTypeDossier($recherche[0]['typeDossier']);
                $utilisateur = getUtilisateur($recherche[0]['idUtilisateur']);
                $statutDossier = afficherStatutDossier($recherche[0]['statutDossier']);
                ?>
                <!-- RECHERCHE -->
                <div class="container my-3">
                    <form class="form-inline" action="index.php">
                        <div class="input-group col-auto maRecherche">
                            <input type="hidden" name="action" value="rechercherDossierMAJ">
                            <select name="optionRechercheDossier" class="rounded-5 me-1">
                                <option value="com">Numéro Commande</option>
                                <option value="dos">Numéro Dossier</option>
                                <option value="nom">Nom Prénom</option>
                            </select>
                            <input class="form-control form-control-sm espaceBouton rounded-5" type="search" name="search" placeholder="Rechercher" aria-label="Rechercher">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-primary bouton" type="submit">Rechercher</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive w-100">

                    <table class="container table table-striped border alignTable rounded-3 maTableAdmin overflow-hidden">
                        <thead>
                            <tr>
                                <th scope="col">Numéro de dossier</th>
                                <th scope="col">Numéro de commande</th>
                                <th scope="col">Date de création du dossier</th>
                                <th scope="col">Nom du client</th>
                                <th scope="col">Type de dossier</th>
                                <th scope="col">Dossier géré par</th>
                                <th scope="col">Statut du dossier</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= $recherche[0]['numDossier']; ?></td>
                                <th scope="row"><?= $recherche[0]['numCommande']; ?></th>
                                <td><?= $dateCommande; ?></td>
                                <td><?= $recherche[0]['nomClient']; ?></td>
                                <td><?= $typeDossier; ?></td>
                                <td><?= $utilisateur['nomUtilisateur']; ?></td>
                                <td><?= $statutDossier; ?></td>
                                <td><a href="index.php?action=voirDossier&numDossier=<?= $recherche[0]['numDossier']; ?>"><button class="btn bouton">Voir le dossier</button></a></td>
                            </tr>
                        </tbody>
                    </table>
                    <a href=javascript:history.go(-1)><button class="btn bouton mb-3">Retour</button></a>
                </div>
            <?php } else { ?>
                <p class="d-flex justify-content-center text-white">Aucun résultat trouvé.</p>

    <?php }
        }
    } ?>

</div>