<?php if ($action == "voirDossier") { ?>

<?php $dateCommande = date('d-m-Y', strtotime($dossiers [0]['dateCommande'])); ?>

<div class="contourAdmin container-fluid container-md d-flex justify-content-center align-items-center flex-column rounded-3">
    <div class="container my-3">

    <!-- entête -->
    <table class="container-fluid container-md table table-striped border alignTable rounded-3 maTableAdmin overflow-hidden">
        <thead>
            <div class="container d-flex justify-content-center my-3" style="color: white">
                <h2>Informations du dossier du client</h2>
            </div>    
            <tr>
            <th scope="col">Numero de dossier</th>
            <th scope="col">Numéro de commande</th>
            <th scope="col">Date de création du dossier</th>
            <th scope="col">Nom du client</th>
            <th scope="col">Type de dossier</th>
            <th scope="col">Dossier géré par</th>
            <th scope="col">Statut du dossier</th>

            </tr>
        </thead>
        <tbody>
            
                <tr>
                    <th scope="row"><?= $dossiers[0]['numDossier']; ?></th>
                    <td><?= $dossiers[0]['numCommande']; ?></td>
                    <td><?= $dossiers[0]['dateDossier']; ?></td>
                    <td><?= $dossiers[0]['nomClient']; ?></td>
                    <td><?= afficherTypeDossier ($dossiers[0]['typeDossier']); ?></td>
                    <td><?= $dossiers[0]['nomUtilisateur']; ?></td>
                    <td><?= afficherStatutDossier($dossiers[0]['statutDossier']); ?></td>
                    
                </tr>
            
        </tbody>
    </table>


        <div class="table-responsive w-100">
            <table class="container-fluid container-md table table-striped border alignTable rounded-3 maTableAdmin overflow-hidden">
                <thead>
                <div class="container d-flex justify-content-center my-3" style="color: white">
                    <h2>Informations des articles posant problème</h2>
                </div> 
                    <tr>
                        <th scope="col">Article</th>
                        <th scope="col">Nom de l'article</th>
                        <th scope="col">Durée de garantie</th>
                        <th scope="col">Date fin de garantie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dossiers as $dossier) {
                        
                        $dureeGarantie = $dossier['garantieArticle'];
                        $finGarantie = date('d-m-Y', strtotime($dossier['dateCommande'] . " + $dureeGarantie year"))
                    ?>
                        <tr>
                            <td scope="row"><?= $dossier['codeArticle'];?></td>
                            <td><?= $dossier['libelleArticle']; ?></td>
                            <td><?= $dossier['garantieArticle']; ?></td>
                            <td><?= $finGarantie; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="container my-3 d-flex">       
                <h4 style="color: white;">Commentaire : <?= $dossiers [0]['commentaireDossier']; ?></h4>
            </div>

            <?php if ($dossiers[0]['statutDossier'] == 1) {?>
                    <div class="text-center">
                        <a href="index.php?action=voirDossierMAJ&dossierExpe=1&numDossier=<?=$numDossier?>">
                            <button type="button" class="btn bouton">Passer le dossier en expédition</button>
                        </a>
                    </div>
            <?php } ?>  
            <?php if ($dossiers[0]['statutDossier'] == 2) {?>
                    <div class="text-center">
                    <a href="index.php?action=voirDossierMAJ&dossierTerm=1&numDossier=<?=$numDossier?>">
                            <button type="button" class="btn bouton">Passer le dossier en Terminer</button>
                        </a>
                    </div>
            <?php } ?>    

            <a href=javascript:history.go(-1)><button class="btn bouton">Retour</button></a>
        </div>
    </div>
</div>
<?php } ?>   



