<?php
if ($action === "dossierTermine") {
?>
<div class="contourAdmin container-fluid container-md d-flex justify-content-center align-items-center flex-column rounded-3">
            <div class="container my-3">
                <form class="form-inline" action="index.php">
                    <div class="input-group col-auto maRecherche">
                        <input type="hidden" name="action" value="dossierTermineMAJ">
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
                        <?php foreach ($dossiers as $dossier) { ?>
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
                <p class="d-flex justify-content-center text-white">Nombre de dossiers trouvés : <?= count($dossiers); ?></p>
                
        </div> 
<?php
}
?>