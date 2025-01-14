<?php if($action === 'accueilAdminMAJ')  { ?>

        <div class="contourAdmin container-fluid container-md d-flex justify-content-center align-items-center flex-column rounded-3">
            <div class="container my-3">
                <form class="form-inline" action="index.php">
                    <div class="input-group col-auto maRecherche">
                        <input type="hidden" name="action" value="accueilAdminMAJ">
                        <input class="form-control form-control-sm espaceBouton rounded-5" type="search" name="search" placeholder="Rechercher" aria-label="Rechercher">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-primary bouton" type="submit">Rechercher</button>
                        </div>
                    </div>
                </form>
            </div>
                <?php if (!is_null($resultats_recherche) && count($resultats_recherche) > 0) { ?>
                <table class="container-fluid container-md table table-striped border maTableAdmin rounded-3 overflow-hidden alignTable">
                    <thead>
                        <tr>
                            <th scope="col">Identifiant</th>
                            <th scope="col">Pseudo</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Rôle</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultats_recherche as $utilisateur) { ?>
                            <tr>
                        <th scope="row"><?= $utilisateur['idUtilisateur']; ?></th>
                        <td><?= $utilisateur['pseudoUtilisateur']; ?></td>
                        <td><?= $utilisateur['nomUtilisateur']; ?></td>
                        <td><?= $utilisateur['prenomUtilisateur']; ?></td>
                        <?php $role = $utilisateur['roleUtilisateur']; ?>
                        <td><?= afficheRoleUtilisateur($role); ?></td>
                        <td><button class="btn bouton modifierBtn" id="<?= $utilisateur['idUtilisateur']; ?>" data-id="<?= $utilisateur['idUtilisateur']; ?>" data-bs-toggle="modal" data-bs-target="#modifUtilisateurModal<?= $utilisateur['idUtilisateur']; ?>">Modifier</button>
                        <a href="#" onclick="confirmerSuppression(<?= $utilisateur['idUtilisateur']; ?>);"><button class="btn bouton">Supprimer</button></a></td>
                    </tr>
                
                        <div class="modal fade" id="modifUtilisateurModal<?= $utilisateur['idUtilisateur']; ?>" tabindex="-1" aria-labelledby="modifUtilisateurModalLabel<?= $utilisateur['idUtilisateur']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered myModal">
                                <div class="modal-content modal-content-bg">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modifUtilisateurModalLabel<?= $utilisateur['idUtilisateur']; ?>">Modifier un utilisateur</h5>
                                        <button type="button" class="btn-close" id="btnCloseModal<?= $utilisateur['idUtilisateur']; ?>" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="modifUtilisateurForm<?= $utilisateur['idUtilisateur']; ?>" method="POST">
                                            <input type="hidden" name="action" value="accueilAdmin">
                                            <input type="hidden" name="id" value="<?=$utilisateur['idUtilisateur'];?>">
                                            <input type="hidden" name="crud" value="modifierUtilisateur">
                                            
                                            <div class="text-center">
                                                <span id="alertChangement<?= $utilisateur['idUtilisateur']; ?>" class="text-center" style="color: #8FC1E6;"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="pseudoModif<?= $utilisateur['idUtilisateur']; ?>" class="form-label">Pseudo</label>
                                                <input type="text" class="form-control" id="pseudoModif<?= $utilisateur['idUtilisateur']; ?>" name="pseudoModif">
                                                <span data-id="<?= $utilisateur['idUtilisateur']; ?>" id="pseudoModifErreur<?= $utilisateur['idUtilisateur']; ?>" style="color: #8FC1E6;"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nomModif<?= $utilisateur['idUtilisateur']; ?>" class="form-label">Nom</label>
                                                <input type="text" class="form-control" id="nomModif<?= $utilisateur['idUtilisateur']; ?>" name="nomModif">
                                                <span data-id="<?= $utilisateur['idUtilisateur']; ?>" id="nomModifErreur<?= $utilisateur['idUtilisateur']; ?>" style="color: #8FC1E6;"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="prenomModif<?= $utilisateur['idUtilisateur']; ?>" class="form-label">Prénom</label>
                                                <input type="text" class="form-control" id="prenomModif<?= $utilisateur['idUtilisateur']; ?>" name="prenomModif">
                                                <span data-id="<?= $utilisateur['idUtilisateur']; ?>" id="prenomModifErreur<?= $utilisateur['idUtilisateur']; ?>" style="color: #8FC1E6;"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="new_mot_de_passe<?= $utilisateur['idUtilisateur']; ?>" class="form-label">Nouveau mot de passe</label>
                                                <input type="password" class="form-control" id="new_mot_de_passe<?= $utilisateur['idUtilisateur']; ?>" name="new_mot_de_passe">
                                                <span data-id="<?= $utilisateur['idUtilisateur']; ?>" id="newMdpErreur<?= $utilisateur['idUtilisateur']; ?>" style="color: #8FC1E6;"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="confirmer_new_mot_de_passe<?= $utilisateur['idUtilisateur']; ?>" class="form-label">Confirmer le nouveau mot de passe</label>
                                                <input type="password" class="form-control" id="confirmer_new_mot_de_passe<?= $utilisateur['idUtilisateur']; ?>" name="confirmer_new_mot_de_passe">
                                                <span data-id="<?= $utilisateur['idUtilisateur']; ?>" id="confirmNewMdpErreur<?= $utilisateur['idUtilisateur']; ?>" style="color: #8FC1E6;"></span>
                                            </div>
                                            <div class="text-center">
                                                <button type="button" class="btn btn-primary modifBtn" data-id="<?= $utilisateur['idUtilisateur']; ?>">Valider</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php } ?>
                    </tbody>
                </table>
                <?php } else { ?>
                    <p class="d-flex justify-content-center text-white">Aucun résultat trouvé.</p>
                <?php } ?>
                <?php if($resultats_recherche) { ?>      
                <p class="d-flex justify-content-center text-white">Nombre d'utilisateurs trouvés : <?= count($resultats_recherche); ?></p>
                <?php }  ?>  
        </div> 

<?php   } else if ($action === 'rechercherDossierMAJ')  {?>

    <div class="contourAdmin container-fluid container-md d-flex justify-content-center align-items-center flex-column rounded-3">
            <div class="container my-3">
                <form class="form-inline" action="index.php">
                    <div class="input-group col-auto maRecherche">
                        <input type="hidden" name="action" value="rechercherDossierMAJ">
                        <input type="hidden" name="id" value="<?=$id?>">
                        <input class="form-control form-control-sm espaceBouton rounded-5" type="search" name="search" placeholder="Rechercher" aria-label="Rechercher">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-primary bouton" type="submit">Rechercher</button>
                        </div>
                    </div>
                </form>
            </div>
        <?php if (!is_null($resultats_recherche) && count($resultats_recherche) > 0) { ?>    
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
                    <?php foreach ($resultats_recherche as $dossier) { ?>
                        <tr>
                            <th scope="row"><?= $dossier['numDossier']; ?></th>
                            <td><?= $dossier['numCommande']; ?></td>
                            <td><?= $dossier['dateDossier']; ?></td>
                            <td><?= $dossier['nomClient']; ?></td>
                            <td><?= afficherTypeDossier ($dossier['typeDossier']); ?></td>
                            <td><?= $dossier['nomUtilisateur']; ?></td>
                            <td><?= afficherStatutDossier($dossier['statutDossier']); ?></td>
                            <td><a href="index.php?action=voirDossier&numDossier=<?= $dossier['numDossier']; ?>"><button class="btn bouton">Voir le dossier</button></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        <?php } else { ?>
                <p class="d-flex justify-content-center text-white">Aucun résultat trouvé.</p>
            <?php } ?>
            <?php if ($resultats_recherche) { ?>
                <p class="d-flex justify-content-center text-white">Nombre de dossiers trouvés : <?= count($resultats_recherche); ?></p>
            <?php }  ?>
        </div> 

<?php   } else if ($action === 'diagnosticsMAJ')  {?>

    <div class="contourAdmin container-fluid container-md d-flex justify-content-center align-items-center flex-column rounded-3">
            <div class="container my-3">
                <form class="form-inline" action="index.php">
                    <div class="input-group col-auto maRecherche">
                        <input type="hidden" name="action" value="diagnosticsMAJ">
                        <input type="hidden" name="id" value="<?=$id?>">
                        <input class="form-control form-control-sm espaceBouton rounded-5" type="search" name="search" placeholder="Rechercher" aria-label="Rechercher">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-primary bouton" type="submit">Rechercher</button>
                        </div>
                    </div>
                </form>
            </div>
        <?php if (!is_null($resultats_recherche) && count($resultats_recherche) > 0) { ?>    
            <table class="container-fluid container-md table table-striped border alignTable rounded-3 maTableAdmin overflow-hidden">
                <thead>
                    <tr>
                    <th scope="col">Numero de dossier</th>
                    <th scope="col">Numéro de commande</th>
                    <th scope="col">Date de création du dossier</th>
                    <th scope="col">Nom du client</th>
                    <th scope="col">Type de dossier</th>
                    <th scope="col">Dossier géré par</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultats_recherche as $dossier) { ?>
                        <tr>
                            <th scope="row"><?= $dossier['numDossier']; ?></th>
                            <td><?= $dossier['numCommande']; ?></td>
                            <td><?= $dossier['dateDossier']; ?></td>
                            <td><?= $dossier['nomClient']; ?></td>
                            <td><?= afficherTypeDossier ($dossier['typeDossier']); ?></td>
                            <td><?= $dossier['nomUtilisateur']; ?></td>
                            <td><a href="index.php?action=voirDossier&numDossier=<?= $dossier['numDossier']; ?>"><button class="btn bouton">Voir le dossier</button></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        <?php } else { ?>
                <p class="d-flex justify-content-center text-white">Aucun résultat trouvé.</p>
            <?php } ?>
            <?php if ($resultats_recherche) { ?>
                <p class="d-flex justify-content-center text-white">Nombre de dossiers trouvés : <?= count($resultats_recherche); ?></p>
            <?php }  ?>
        </div> 

<?php   } else if ($action === 'dossierTermineMAJ')  {?>

<div class="contourAdmin container-fluid container-md d-flex justify-content-center align-items-center flex-column rounded-3">
        <div class="container my-3">
            <form class="form-inline" action="index.php">
                <div class="input-group col-auto maRecherche">
                    <input type="hidden" name="action" value="dossierTermineMAJ">
                    <input type="hidden" name="id" value="<?=$id?>">
                    <input class="form-control form-control-sm espaceBouton rounded-5" type="search" name="search" placeholder="Rechercher" aria-label="Rechercher">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-primary bouton" type="submit">Rechercher</button>
                    </div>
                </div>
            </form>
        </div>
    <?php if (!is_null($resultats_recherche) && count($resultats_recherche) > 0) { ?>    
        <table class="container-fluid container-md table table-striped border alignTable rounded-3 maTableAdmin overflow-hidden">
            <thead>
                <tr>
                <th scope="col">Numéro de dossier</th>
                <th scope="col">Numéro de commande</th>
                <th scope="col">Date de création du dossier</th>
                <th scope="col">Date de clôture du dossier</th>
                <th scope="col">Nom du client</th>
                <th scope="col">Type de dossier</th>
                <th scope="col">Dossier géré par</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultats_recherche as $dossier) { ?>
                    <tr>
                        <th scope="row"><?= $dossier['numDossier']; ?></th>
                        <td><?= $dossier['numCommande']; ?></td>
                        <td><?= $dossier['dateDossier']; ?></td>
                        <td><?= $dossier['dateClotureDossier']; ?></td>
                        <td><?= $dossier['nomClient']; ?></td>
                        <td><?= afficherTypeDossier ($dossier['typeDossier']); ?></td>
                        <td><?= $dossier['nomUtilisateur']; ?></td>
                        <td><a href="index.php?action=voirDossier&numDossier=<?= $dossier['numDossier']; ?>"><button class="btn bouton">Voir le dossier</button></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    <?php } else { ?>
            <p class="d-flex justify-content-center text-white">Aucun résultat trouvé.</p>
        <?php } ?>
        <?php if ($resultats_recherche) { ?>
            <p class="d-flex justify-content-center text-white">Nombre de dossiers trouvés : <?= count($resultats_recherche); ?></p>
        <?php }  ?>
    </div> 

<?php   } else if ($action === 'expeditionMAJ')  {?>

<div class="contourAdmin container-fluid container-md d-flex justify-content-center align-items-center flex-column rounded-3">
        <div class="container my-3">
            <form class="form-inline" action="index.php">
                <div class="input-group col-auto maRecherche">
                    <input type="hidden" name="action" value="expeditionMAJ">
                    <input type="hidden" name="id" value="<?=$id?>">
                    <input class="form-control form-control-sm espaceBouton rounded-5" type="search" name="search" placeholder="Rechercher" aria-label="Rechercher">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-primary bouton" type="submit">Rechercher</button>
                    </div>
                </div>
            </form>
        </div>
    <?php if (!is_null($resultats_recherche) && count($resultats_recherche) > 0) { ?>    
        <table class="container-fluid container-md table table-striped border alignTable rounded-3 maTableAdmin overflow-hidden">
            <thead>
            <tr>
                <th scope="col">Numéro de dossier</th>
                <th scope="col">Numéro de commande</th>
                <th scope="col">Date de création du dossier</th>
                <th scope="col">Nom du client</th>
                <th scope="col">Type de dossier</th>
                <th scope="col">Dossier géré par</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($resultats_recherche as $dossier) { ?>
                <tr>
                    <th scope="row"><?= $dossier['numDossier']; ?></th>
                    <td><?= $dossier['numCommande']; ?></td>
                    <td><?= $dossier['dateDossier']; ?></td>
                    <td><?= $dossier['nomClient']; ?></td>
                    <td><?= afficherTypeDossier ($dossier['typeDossier']); ?></td>
                    <td><?= $dossier['nomUtilisateur']; ?></td>
                    <td><a href="index.php?action=voirDossier&numDossier=<?= $dossier['numDossier']; ?>"><button class="btn bouton">Voir le dossier</button></a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

    <?php } else { ?>
            <p class="d-flex justify-content-center text-white">Aucun résultat trouvé.</p>
        <?php } ?>
        <?php if ($resultats_recherche) { ?>
            <p class="d-flex justify-content-center text-white">Nombre de dossiers trouvés : <?= count($resultats_recherche); ?></p>
        <?php }  ?>
    </div> 
<?php }  ?>

        

