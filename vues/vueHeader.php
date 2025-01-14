<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL' crossorigin='anonymous'></script>
    <link rel='stylesheet' href='style/style.css' defer>
    <title><?= $titre ?></title>

</head>

<body>

    <!-- Les alerts -->
    <!-- <div class="col-12 alert alert-danger d-block d-sm-none text-center" role="alert">Screen X-Small</div>
    <div class="col-sm-12 alert alert-info d-none d-sm-block d-md-none text-center" role="alert">Screen Small ≥576px</div>
    <div class="col-md-12 alert alert-success d-none d-md-block d-lg-none text-center" role="alert">Screen Medium ≥768px</div>
    <div class="col-lg-12 alert alert-warning d-none d-lg-block d-xl-none text-center" role="alert">Screen Large ≥992px</div>
    <div class="col-xl-12 alert alert-dark d-none d-xl-block d-xxl-none text-center" role="alert">Screen X-Large ≥1200px</div>
    <div class="col-xxl-12 alert alert-secondary d-none d-xxl-block text-center" role="alert">Screen XX-Large ≥1400px</div> -->

    <!-- Si connexion active -->
    <?php
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
        $role = $_SESSION['role'];

        if ($role == 1) $retourAccueil = "accueilAdmin";
        else if ($role == 2) $retourAccueil = "accueilTechnicienHOT";
        else if ($role == 3) $retourAccueil = "accueilTechnicienSAV";
    } else {
        $retourAccueil = "connexion";
    }
    ?>
    <!-- Nav Barre Admin-->
    <?php
    if ($roleHeader == 1) {
    ?>
        <!-- DEBUG -->
        <!-- <p>HEADER ADMIN</p> -->
        <nav class="navbar navbar-expand-lg maNav ">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php?action=<?=$retourAccueil?>">
                    <img src="Images/Menuiz Man.png" alt="Logo" class="logonav">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="d-flex flex-grow-1 justify-content-center mt-3 mt-lg-0 troisBouton">
                         <button type="button" class="btn btn-primary mx-2 boutonPopup bouton boxBouton" data-role="1" data-title="Ajouter un nouvel administrateur">Ajouter un nouvel administrateur</button>
                        <button type="button" class="btn btn-primary mx-2 boutonPopup bouton boxBouton" data-role="3" data-title="Ajouter un nouveau technicien SAV">Ajouter un nouveau technicien SAV</button>
                        <button type="button" class="btn btn-primary mx-2 boutonPopup bouton boxBouton" data-role="2" data-title="Ajouter un nouveau technicien Hotline">Ajouter un nouveau technicien Hotline</button>
                    </div>
                    <div class="navbar-nav">
                        <a class="nav-link btnDeconnexion d-block d-lg-none text-center" aria-current="page" href="index.php">
                            <h4 class="">Accueil</h4>
                        </a>
                        <!-- BOUTON DECONNEXION -->
                        <?php if (isset($_SESSION['id'])) { ?>
                            <a href="index.php?action=deconnexion" class="nav-link d-flex btnDeconnexion justify-content-center">
                                <h4 class="mt-1 me-1">Déconnexion</h4>
                                <img src="Images/se-deconnecter.png" alt="imgDeconnexion" class="imgDeconnexion mb-3 mb-lg-0">
                            </a>
                        <?php } ?>
                    </div>


                    <div class="modal fade" id="ajoutUtilisateurModal" tabindex="-1" aria-labelledby="ajoutUtilisateurModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered myModal">
                            <div class="modal-content modal-content-bg">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ajoutUtilisateurModalLabel">Ajouter un nouvel utilisateur</h5>
                                    <button type="button " class="btn-close" id="ajoutUtilisateurModal" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="ajoutUtilisateurForm" method="POST">
                                        <input type="hidden" name="action" value="accueilAdmin">
                                        <input type="hidden" name="id" value="<?= $id ?>">
                                        <input type="hidden" name="crud" value="ajouterUtilisateur">
                                        <div class="mb-3">
                                            <label for="pseudo" class="form-label">Pseudo</label>
                                            <input type="text" class="form-control" id="pseudo" name="pseudo">
                                            <span id="pseudoErreur" style="color: #8FC1E6;"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nom" class="form-label">Nom</label>
                                            <input type="text" class="form-control" id="nom" name="nom">
                                            <span id="nomErreur" style="color: #8FC1E6;"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="prenom" class="form-label">Prénom</label>
                                            <input type="text" class="form-control" id="prenom" name="prenom">
                                            <span id="prenomErreur" style="color: #8FC1E6;"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="mot_de_passe" class="form-label">Mot de passe</label>
                                            <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe">
                                            <span id="mdpErreur" style="color: #8FC1E6;"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="confirmer_mot_de_passe" class="form-label">Confirmer le mot de passe</label>
                                            <input type="password" class="form-control" id="confirmer_mot_de_passe" name="confirmer_mot_de_passe">
                                            <span id="confirmMdpErreur" style="color: #8FC1E6;"></span>
                                        </div>
                                        <!-- Champ caché pour stocker le rôle -->
                                        <input type="hidden" id="role_utilisateur" name="role_utilisateur">
                                        <div class="text-center">
                                            <button type="button" id="enregistrerBtn" class="btn btn-primary">Enregistrer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

    <?php
    } else {
    ?>
        <!-- DEBUG -->
        <!-- <p>HEADER AUTRE</p> -->
        <!-- Nav Barre Autre Utilisateurs et Accueil -->
        <nav class="navbar navbar-expand-lg maNav ">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php?action=<?=$retourAccueil?>">
                    <img src="Images/Menuiz Man.png" alt="Logo" class="logonav">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="d-flex flex-grow-1 justify-content-center mt-3 mt-lg-0"></div>
                    <div class="navbar-nav">
                        <a class="nav-link btnDeconnexion d-block d-lg-none text-center" aria-current="page" href="index.php">
                            <h4 class="">Accueil</h4>
                        </a>
                        <!-- BOUTON DECONNEXION -->
                        <?php if (isset($_SESSION['id'])) { ?>
                            <a href="index.php?action=deconnexion" class="nav-link d-flex btnDeconnexion justify-content-center">
                                <h4 class="mt-1 me-1">Déconnexion</h4>
                                <img src="Images/se-deconnecter.png" alt="imgDeconnexion" class="imgDeconnexion mb-3 mb-lg-0">
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </nav>
    <?php
    }
    ?>

    <h1 class="my-5 text-center"><?= $titre ?></h1>