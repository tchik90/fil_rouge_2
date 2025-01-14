<?php

$action = "accueil";

if (isset ($_GET['action']))
    $action = $_GET['action'];
if (!isset ($_GET['action']))
    $action = "connexion";

require ("./modeles/modele.inc.php");


//var_dump("action -> " . $action);

// switch sur si pas de connexion trouvé -> formulaire connexion
switch ($action) {
    case "connexion":
        session_start();
        $titre = "Connexion";
        $roleHeader = afficheHeader();
        require "./vues/vueHeader.php";
        require "./vues/vueConnexion.php";
        break;
    case "accueilTechnicienSAV":
        // récupération ID et ROLE
        session_start();
        if (isset ($_SESSION['id'])) {
            // récupération ID et ROLE
            $id = $_SESSION['id'];
            $roleUser = $_SESSION['role'];

            // récupération des infos utilisateurs
            $utilisateur = getUtilisateur($id);
            $nom = $utilisateur['nomUtilisateur'];
            $prenom = $utilisateur['prenomUtilisateur'];
            $role = afficheRoleUtilisateur($utilisateur['roleUtilisateur']);

            $titre = "Bonjour $nom $prenom, vous êtes connecté en tant que $role";
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";
            require "./vues/vueAccueil.php";
        } else {
            $roleHeader = 0;
            $titre = "Erreur";
            $action = "erreur";
            require "./vues/vueHeader.php";
            require "vues/vueErreur.php";
        }
        break;
    case "accueilTechnicienHOT":
        session_start();
        if (isset ($_SESSION['id'])) {
            // récupération ID et ROLE
            $id = $_SESSION['id'];
            $roleUser = $_SESSION['role'];

            // récupération des infos utilisateurs
            $utilisateur = getUtilisateur($id);
            $nom = $utilisateur['nomUtilisateur'];
            $prenom = $utilisateur['prenomUtilisateur'];
            $role = afficheRoleUtilisateur($utilisateur['roleUtilisateur']);

            $titre = "Bonjour $nom $prenom, vous êtes connecté en tant que $role";
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";
            require "./vues/vueAccueil.php";
        } else {
            $roleHeader = 0;
            $titre = "Erreur";
            $action = "erreur";
            require "./vues/vueHeader.php";
            require "vues/vueErreur.php";
        }
        break;
    case "nouveauDossier":
        session_start();
        if (isset ($_SESSION['id'])) {
            // récupération ID et ROLE
            $id = $_SESSION['id'];
            $roleUser = $_SESSION['role'];

            $titre = "Créer un dossier de réclamation<br>\nRechercher une commande"; // à modifier par une recherche client
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";
            $clients = getClients();
            require "./vues/vueCreerDossier.php";
        } else {
            $roleHeader = 0;
            $titre = "Erreur";
            $action = "erreur";
            require "./vues/vueHeader.php";
            require "vues/vueErreur.php";
        }
        break;
    case "nouveauDossierRechercheClient":
        session_start();
        if (isset ($_SESSION['id'])) {
            // récupération ID et ROLE
            $id = $_SESSION['id'];
            $roleUser = $_SESSION['role'];

            $titre = "Créer un dossier de réclamation"; // à modifier par une recherche client
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";

            if ($_GET['optionRechercheNouveauDossier'] == 'nom') {
                $clients = getClients();
                if (isset ($_GET['search'])) {
                    $search = $_GET['search'];
                    $recherche = rechercheClient($search);
                }
            } else if ($_GET['optionRechercheNouveauDossier'] == 'com') {
                $commandes = getCommandes();
                if (isset ($_GET['search'])) {
                    $search = $_GET['search'];
                    //$recherche = rechercheCommande($search);
                    $recherche = rechercheClientCommande($search);
                }
            }
            require "./vues/vueCreerDossier.php";
            break;
        } else {
            $roleHeader = 0;
            $titre = "Erreur";
            $action = "erreur";
            require "./vues/vueHeader.php";
            require "vues/vueErreur.php";
        }
    case "rechercherDossier":
        session_start();
        if (isset ($_SESSION['id'])) {
            // récupération ID et ROLE
            $id = $_SESSION['id'];
            $roleUser = $_SESSION['role'];

            $titre = "Rechercher un dossier";
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";
            $dossiers = getRechercherDossier();
            require "./vues/vueRechercherDossier.php";
            if (isset ($_GET['search'])) {
                $resultats_recherche = rechercheDossier($recherche);
            }

           
        } else {
            $roleHeader = 0;
            $titre = "Erreur";
            $action = "erreur";
            require "./vues/vueHeader.php";
            require "vues/vueErreur.php";
        }
        break;
    case "rechercherDossierMAJ":     
        session_start();
        if (isset ($_SESSION['id'])) {

            // récupération ID et ROLE
            $id = $_SESSION['id'];
            $roleUser = $_SESSION['role'];

            $titre = "Rechercher un dossier";
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";

            if ($_GET['optionRechercheDossier'] == 'nom') {
                $clients = getClients();
                if (isset ($_GET['search'])) {
                    $search = $_GET['search'];
                    $recherche = rechercheDossierNom($search);
                }
            // a modifier
            } else if ($_GET['optionRechercheDossier'] == 'dos') {
                $commandes = getCommandes();
                if (isset ($_GET['search'])) {
                    $search = $_GET['search'];
                    //$recherche = rechercheCommande($search);
                    $recherche = rechercheClientDossier($search);
                }
            } else if ($_GET['optionRechercheDossier'] == 'com') {
                $commandes = getCommandes();
                //var_dump($commandes);
                if (isset ($_GET['search'])) {
                    $search = $_GET['search'];
                    //var_dump($search);
                    //$recherche = rechercheCommande($search);
                    $recherche = rechercheDossierCommande($search);
                    //var_dump($recherche);
                }
            }
            
            require "./vues/vueRechercherDossier.php";

            // if (isset ($_GET['search'])) {
            //     $recherche = $_GET['search'];
            //     $resultats_recherche = rechercheDossier($recherche);
            // }
        } else {
            $roleHeader = 0;
            $titre = "Erreur";
            $action = "erreur";
            require "./vues/vueHeader.php";
            require "vues/vueErreur.php";
        }
        break;
    case "voirDossier":
        session_start();
        if (isset ($_SESSION['id'])) {
            // récupération ID et ROLE
            $id = $_SESSION['id'];
            $roleUser = $_SESSION['role'];

            $titre = "Dossier";
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";
            
            if (isset($_GET['numDossier'])) {
                $numDossier = $_GET['numDossier'];
                $dossiers = getDossier($numDossier);
            }

            $dossiers = getDossier($numDossier);
            
            require "vues/vueDossier.php";
        } else {
            $roleHeader = 0;
            $titre = "Erreur";
            $action = "erreur";
            require "./vues/vueHeader.php";
            require "vues/vueErreur.php";
        }
    break;
    case "voirDossierMAJ":
        session_start();
        if (isset ($_SESSION['id'])) {
            // récupération ID et ROLE
            $id = $_SESSION['id'];
            $roleUser = $_SESSION['role'];

            $titre = "Dossier";
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";
            
            if (isset($_GET['numDossier'])) {
                $numDossier = $_GET['numDossier'];
                $dossiers = getDossier($numDossier);
            }

            $dossiers = getDossier($numDossier);


            if(isset($_GET["dossierExpe"])) {
                modifierStatut(2, $numDossier);
                header("Location: index.php?action=voirDossier&numDossier=$numDossier");
            } 
            if(isset($_GET["dossierTerm"])) {
                modifierStatut(3, $numDossier);
                header("Location: index.php?action=voirDossier&numDossier=$numDossier");
            }
            
            require "vues/vueDossier.php";
        } else {
            $roleHeader = 0;
            $titre = "Erreur";
            $action = "erreur";
            require "./vues/vueHeader.php";
            require "vues/vueErreur.php";
        }
        break;  
    case "dossierTermine":
        session_start();
        if (isset ($_SESSION['id'])) {
            // récupération ID et ROLE
            $id = $_SESSION['id'];
            $roleUser = $_SESSION['role'];

            $titre = "Dossiers terminés";
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";

            $dossiers = dossierTermine();

            if (isset ($_GET['search'])) {
                $resultats_recherche = rechercheDossierTerm($recherche);
            }

            require "./vues/vueDossierTermine.php";

        } else {
            $roleHeader = 0;
            $titre = "Erreur";
            $action = "erreur";
            require "./vues/vueHeader.php";
            require "vues/vueErreur.php";
        }
        break;

    case "dossierTermineMAJ":
        session_start();
        if (isset ($_SESSION['id'])) {
            // récupération ID et ROLE
            $id = $_SESSION['id'];
            $roleUser = $_SESSION['role'];

            $titre = "Dossiers terminés";
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";

            if (isset ($_GET['search'])) {
                $recherche = $_GET['search'];
                $resultats_recherche = rechercheDossierTerm($recherche);
            }

            require "./vues/vueResultat.php";

        } else {
            $roleHeader = 0;
            $titre = "Erreur";
            $action = "erreur";
            require "./vues/vueHeader.php";
            require "vues/vueErreur.php";
        }
        break;

    case "diagnostics":
        session_start();
        if (isset ($_SESSION['id'])) {
            // récupération ID et ROLE
            $id = $_SESSION['id'];
            $roleUser = $_SESSION['role'];

            $titre = "Dossiers en cours de diagnostics";
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";

            $dossiers = dossierDiagnostic();
            
            if (isset ($_GET['search'])) {
                $resultats_recherche = rechercheDossierDiag($recherche);
            }
            require "./vues/vueDiagnostics.php";
        } else {
            $roleHeader = 0;
            $titre = "Erreur";
            $action = "erreur";
            require "./vues/vueHeader.php";
            require "vues/vueErreur.php";
        }
        break;
    case "diagnosticsMAJ":
        session_start();
        if (isset ($_SESSION['id'])) {
            // récupération ID et ROLE
            $id = $_SESSION['id'];
            $roleUser = $_SESSION['role'];

            $titre = "Dossiers en cours de diagnostics";
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";

            if (isset ($_GET['search'])) {
                $recherche = $_GET['search'];
                $resultats_recherche = rechercheDossierDiag($recherche);
            }
            require "./vues/vueResultat.php";

        } else {
            $roleHeader = 0;
            $titre = "Erreur";
            $action = "erreur";
            require "./vues/vueHeader.php";
            require "vues/vueErreur.php";
        }
        break;
    case "expedition":
        session_start();
        if (isset ($_SESSION['id'])) {
            // récupération ID et ROLE
            $id = $_SESSION['id'];
            $roleUser = $_SESSION['role'];

            $titre = "Dossiers en cours d'expédition";
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";

            $dossiers = dossierExpedition();
            
            if (isset ($_GET['search'])) {
                $resultats_recherche = rechercheDossierExpe($recherche);
            }
            require "./vues/vueExpedition.php";
        } else {
            $roleHeader = 0;
            $titre = "Erreur";
            $action = "erreur";
            require "./vues/vueHeader.php";
            require "vues/vueErreur.php";
        }
        break;
    case "expeditionMAJ":
        session_start();
        if (isset ($_SESSION['id'])) {
            // récupération ID et ROLE
            $id = $_SESSION['id'];
            $roleUser = $_SESSION['role'];

            $titre = "Dossiers en cours d'expédition";
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";

            if (isset ($_GET['search'])) {
                $recherche = $_GET['search'];
                $resultats_recherche = rechercheDossierExpe($recherche);
            }
            require "./vues/vueResultat.php";

        } else {
            $roleHeader = 0;
            $titre = "Erreur";
            $action = "erreur";
            require "./vues/vueHeader.php";
            require "vues/vueErreur.php";
        }
        break;
    case "connexionMaj":
        $pseudoUtilisateur = $_GET['user'];
        $mdpUtilisateur = $_GET['pass'];

        $users = getUtilisateurs(); // liste des utilisateurs

        $id = controleConnexion($pseudoUtilisateur, $mdpUtilisateur, $users);

        if ($id == 0) { // utilisateur introuvable
            $titre = "Connexion<br><h2 class='text-center'>Pseudo ou Mot de passe incorrect</h2>";
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";
            require "./vues/vueConnexion.php";
        } else if ($id == -1) { // mot de passe incorrect
            $titre = "Connexion<br><h2 class='text-center'>Pseudo ou Mot de passe incorrect</h2>";
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";
            require "./vues/vueConnexion.php";
        } else { // connexion validée
            $role = getUtilisateur($id);
            $role = $role['roleUtilisateur'];

            // stocker en session
            session_start();
            $_SESSION['id'] = $id;
            $_SESSION['role'] = $role;

            if ($role == 1) {
                $action = "accueilAdmin";
            } else if ($role == 2) {
                $action = "accueilTechnicienHOT";
            } else {
                $action = "accueilTechnicienSAV";
            }

            header("Location: index.php?action=$action");
        }
        break;
    case "accueilAdmin":
        session_start();
        
        if (isset ($_SESSION['id'])) {

            // récupération ID et ROLE
            $id = $_SESSION['id'];
            $roleUser = $_SESSION['role'];

            // infos utilisateur
            $utilisateur = getUtilisateur($id);
            $nom = $utilisateur['nomUtilisateur'];
            $prenom = $utilisateur['prenomUtilisateur'];
            $role = afficheRoleUtilisateur($utilisateur['roleUtilisateur']);

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                
                if ($_POST["crud"] == 'ajouterUtilisateur') {
                    $pseudo = $_POST["pseudo"];
                    $nomForm = $_POST["nom"];
                    $prenomForm = $_POST["prenom"];
                    $mot_de_passe = $_POST["mot_de_passe"];
                    $confirmer_mot_de_passe = $_POST["confirmer_mot_de_passe"];
                    $role_utilisateur = $_POST["role_utilisateur"];

                    try {
                        $id_utilisateur = ajoutUtilisateur($pseudo, ucfirst(strtolower($nomForm)), ucfirst(strtolower($prenomForm)), $mot_de_passe, $role_utilisateur);
                        header("Location: index.php?action=accueilAdmin");
                    } catch (ModeleException $e) {
                        echo "Erreur : " . $e->getMessage();
                    }

                } else if ($_POST["crud"] == 'modifierUtilisateur') {
                    // var_dump($_POST);

                    $idUtilisateur = $_POST['id'];
                    $nouveauPseudo = $_POST['pseudoModif'];
                    $nouveauNom = $_POST['nomModif'];
                    $nouveauPrenom = $_POST['prenomModif'];
                    $nouveauMdp = $_POST['new_mot_de_passe'];

                    if ($nouveauMdp !== '') {
                        // Mettre à jour le mot de passe
                        try {
                            modifierUtilisateur($idUtilisateur, $nouveauPseudo, ucfirst(strtolower($nouveauNom)), ucfirst(strtolower($nouveauPrenom)), $nouveauMdp);
                            header("Location: index.php?action=accueilAdmin");
                        } catch (ModeleException $e) {
                            echo "Erreur : " . $e->getMessage();
                        }
                    } else {
                        // Ne mettre à jour que les autres champs (pseudo, nom, prénom)
                        try {
                            modifierUtilisateurSansMdp($idUtilisateur, $nouveauPseudo, ucfirst(strtolower($nouveauNom)), ucfirst(strtolower($nouveauPrenom)));
                            header("Location: index.php?action=accueilAdmin");
                        } catch (ModeleException $e) {
                            echo "Erreur : " . $e->getMessage();
                        }
                    }
                }
            };

             
        
            if(isset($_GET['id'])) {
                $id_utilisateur = $_GET['id'];
                
                try {
                    getAdmins();
                    getRoleUtilisateur();
                    getUtilisateurOnDossier();
                    supprimerUtilisateur($id_utilisateur); // Supprimer l'utilisateur
                } 

                 catch (ModeleException $e) {
                    echo "Erreur : " . $e->getMessage();
                }
            }


            $titre = "Bonjour $nom $prenom, vous êtes connecté en tant que $role";
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";
            $utilisateurs = getUtilisateurs();
            require "./vues/vueAccueil.php";
            require "./vues/popup.php";


            } else {
                $roleHeader = 0;
                $titre = "Erreur";
                $action = "erreur";
                require "./vues/vueHeader.php";
                require "vues/vueErreur.php";
            }
        
        break;

    case "accueilAdminMAJ":
        session_start();
        if (isset ($_SESSION['id'])) {

            // récupération ID et ROLE
            $id = $_SESSION['id'];
            $roleUser = $_SESSION['role'];

            $utilisateur = getUtilisateur($id);
            $nom = $utilisateur['nomUtilisateur'];
            $prenom = $utilisateur['prenomUtilisateur'];
            $role = afficheRoleUtilisateur($utilisateur['roleUtilisateur']);


            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                
                if ($_POST["crud"] == 'ajouterUtilisateur') {
                    $pseudo = $_POST["pseudo"];
                    $nomForm = $_POST["nom"];
                    $prenomForm = $_POST["prenom"];
                    $mot_de_passe = $_POST["mot_de_passe"];
                    $confirmer_mot_de_passe = $_POST["confirmer_mot_de_passe"];
                    $role_utilisateur = $_POST["role_utilisateur"];

                    try {
                        $id_utilisateur = ajoutUtilisateur($pseudo, ucfirst(strtolower($nomForm)), ucfirst(strtolower($prenomForm)), $mot_de_passe, $role_utilisateur);
                        header("Location: index.php?action=accueilAdmin");
                    } catch (ModeleException $e) {
                        echo "Erreur : " . $e->getMessage();
                    }

                } else if ($_POST["crud"] == 'modifierUtilisateur') {
                    // var_dump($_POST);

                    $idUtilisateur = $_POST['id'];
                    $nouveauPseudo = $_POST['pseudoModif'];
                    $nouveauNom = $_POST['nomModif'];
                    $nouveauPrenom = $_POST['prenomModif'];
                    $nouveauMdp = $_POST['new_mot_de_passe'];

                    if ($nouveauMdp !== '') {
                        // Mettre à jour le mot de passe
                        try {
                            modifierUtilisateur($idUtilisateur, $nouveauPseudo, ucfirst(strtolower($nouveauNom)), ucfirst(strtolower($nouveauPrenom)), $nouveauMdp);
                            header("Location: index.php?action=accueilAdmin");
                        } catch (ModeleException $e) {
                            echo "Erreur : " . $e->getMessage();
                        }
                    } else {
                        // Mettre à jour que les autres champs (pseudo, nom, prénom)
                        try {
                            modifierUtilisateurSansMdp($idUtilisateur, $nouveauPseudo, ucfirst(strtolower($nouveauNom)), ucfirst(strtolower($nouveauPrenom)));
                            header("Location: index.php?action=accueilAdmin");
                        } catch (ModeleException $e) {
                            echo "Erreur : " . $e->getMessage();
                        }
                    }
                }
            };

             
        
            if(isset($_GET['id'])) {
                $id_utilisateur = $_GET['id'];
                
                try {
                    getAdmins();
                    getRoleUtilisateur();
                    getUtilisateurOnDossier();
                    supprimerUtilisateur($id_utilisateur); // Supprimer l'utilisateur
                } 

                 catch (ModeleException $e) {
                    echo "Erreur : " . $e->getMessage();
                }
            }

            $titre = "Résultat de votre recherche";
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";
            $utilisateurs = getUtilisateurs();
            if (isset ($_GET['search'])) {
                $recherche = $_GET['search'];
                $resultats_recherche = rechercheUtilisateur($recherche);
            }
            require "./vues/vueResultat.php";
            require "./vues/popup.php";



        } else {
            $roleHeader = 0;
            $titre = "Erreur";
            $action = "erreur";
            require "./vues/vueHeader.php";
            require "vues/vueErreur.php";
        }
        break;
    case "voirCommande":
        session_start();
        if (isset ($_SESSION['id'])) {
            // récupération ID et ROLE
            $id = $_SESSION['id'];
            $roleUser = $_SESSION['role'];

            $titre = "Vue de la commande";
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";

            $numCom = $_GET['commande'];
            $commande = getCommande($numCom);

            require "vues/vueCommande.php";
        } else {
            $roleHeader = 0;
            $titre = "Erreur";
            $action = "erreur";
            require "./vues/vueHeader.php";
            require "vues/vueErreur.php";
        }
        break;

    case "creerNouveauDossier":
        session_start();
        if (isset ($_SESSION['id'])) {
            // récupération ID et ROLE
            $id = $_SESSION['id'];
            $roleUser = $_SESSION['role'];

            $titre = "Créer un dossier de réclamation";
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";

            //affichage
            $numCom = $_GET['commande'];
            $commande = getCommande($numCom);
            require "./vues/vueCreerDossier.php";
        } else {
            $roleHeader = 0;
            $titre = "Erreur";
            $action = "erreur";
            require "./vues/vueHeader.php";
            require "vues/vueErreur.php";
        }
        break;

    case "creerNouveauDossierMAJ":
        session_start();
        if (isset ($_SESSION['id'])) {
            // récupération ID et ROLE
            $id = $_SESSION['id'];
            $roleUser = $_SESSION['role'];

            $titre = "Créer un dossier de réclamation";
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";

            //affichage
            if(isset($_GET['typeSAV'])) $typeSAV = $_GET['typeSAV'];
            
            $numCom = $_GET['commande'];
            $commande = getCommande($numCom);
            require "./vues/vueCreerDossier.php";
        } else {
            $roleHeader = 0;
            $titre = "Erreur";
            $action = "erreur";
            require "./vues/vueHeader.php";
            require "vues/vueErreur.php";
        }
        break;

    case "nouveauDossierValide":
        session_start();
        if (isset ($_SESSION['id'])) {
            // récupération ID et ROLE
            $id = $_SESSION['id'];
            $roleUser = $_SESSION['role'];

            $titre = "Nouveau dossier de réclamation créé";
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";

            //affichage
            $typeDossier = $_GET['typeDossier'];
            if($typeDossier == 'NPAI') $typeDossier = 1;
            if($typeDossier == 'NP') $typeDossier = 2;
            if($typeDossier == 'EC') $typeDossier = 3;
            if($typeDossier == 'EP') $typeDossier = 4;
            if($typeDossier == 'SAV') $typeDossier = 5;

            $numCom = $_GET['commande'];
            $commentaire = $_GET['commentaire'];
            $commande = getCommande($numCom);
            
            //require "./vues/vueCreerDossier.php";

            $idUtilisateur = $id;

            if($typeDossier == 1 || $typeDossier == 2) {
                $statutDossier = 2;
            } else {
                $statutDossier = 1;
            }

            $numDossier = ajoutDossier($typeDossier, $statutDossier, $numCom, $idUtilisateur, $commentaire);
            require "./vues/vueCreerDossier.php";
            $tArticles = [];
            foreach ($_GET['checkArticle'] as $checkArticle) {
                array_push($tArticles, $checkArticle);
            }

            foreach ($tArticles as $article) {
                //var_dump($article);
                $codeArticle = $article;
                ajoutDossierArticle($codeArticle, $numDossier);
            }

        } else {
            $roleHeader = 0;
            $titre = "Erreur";
            $action = "erreur";
            require "./vues/vueHeader.php";
            require "vues/vueErreur.php";
        }
        break;
    
    case "voirCommandesClient":
        session_start();
        if (isset ($_SESSION['id'])) {
            // récupération ID et ROLE
            $id = $_SESSION['id'];
            $roleUser = $_SESSION['role'];

            $idClient = $_GET['idClient'];
            $client = getClient($idClient);
            //var_dump($client);
            $nomClient = $client[0]['nomClient'];
            $prenomClient = $client[0]['prenomClient'];

            $titre = "Liste de commandes de $prenomClient $nomClient";
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";

            //affichage
            $idClient = $_GET['idClient'];
            $commandes = rechercheCommandesClient($idClient);
            require "./vues/vueListeCommandesClient.php";

        } else {
            $roleHeader = 0;
            $titre = "Erreur";
            $action = "erreur";
            require "./vues/vueHeader.php";
            require "vues/vueErreur.php";
        }
        break;

    case "deconnexion":
        session_start();
        session_destroy();
        header("Location: index.php");
        break;


    // Exemple a copier pour les actions
    case "EXEMPLE BASE ACTION":
        session_start();
        if (isset ($_SESSION['id'])) {
            // récupération ID et ROLE
            $id = $_SESSION['id'];
            $roleUser = $_SESSION['role'];

            $titre = "A MODIFIER";
            $roleHeader = afficheHeader();
            require "./vues/vueHeader.php";

            //affichage

        } else {
            $roleHeader = 0;
            $titre = "Erreur";
            $action = "erreur";
            require "./vues/vueHeader.php";
            require "vues/vueErreur.php";
        }
        break;
}

require "./vues/vueFooter.php";
