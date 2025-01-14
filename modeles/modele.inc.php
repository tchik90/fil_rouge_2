<?php
    require("ModeleException.php");

    // Sert a établir une connexion avec la base de données avec un fichier .ini et PDO
    function getConnexion() {
        if(file_exists("param.ini")) {
            $tParam = parse_ini_file("param.ini", true);
            extract($tParam['BDD']);
        } else {
            throw new ModeleException("Fichier param.ini absent");
        }
            
        $dsn = "mysql:host=$host;dbname=$bdd;";
        return new PDO($dsn, $login, $password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }

    // Récupère les informations des utilisateurs et retourne un tableau associatif
    function getUtilisateurs() : array {

        $connexion = getConnexion();

        $sql = "SELECT idUtilisateur, pseudoUtilisateur, nomUtilisateur, prenomUtilisateur, mdpUtilisateur, roleUtilisateur FROM utilisateurs";

        $resultat = $connexion->query($sql);

        return $resultat->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère des informations sur les dossiers de réclamation 
    function getRechercherDossier() : array{

        $connexion = getConnexion();

        $sql = "SELECT dr.*, c.nomClient, u.nomUtilisateur,c.prenomClient,cmd.dateCommande
        FROM dossier_reclamation dr 
        INNER JOIN commande cmd ON dr.numCommande = cmd.numCommande 
        INNER JOIN client c ON cmd.idClient = c.idClient
        INNER JOIN utilisateurs u ON dr.idUtilisateur = u.idUtilisateur";

        $resultat = $connexion->query($sql);

        return $resultat->fetchAll(PDO::FETCH_ASSOC);
    }

    // Sert à récupérer les informations d'un dossier de réclamation en fonction de son numéro de dossier
    function getDossier($numDossier) {
        $connexion = getConnexion();
    
        $sql = "SELECT dr.*, cmd.* , c.*, u.*, concerner.* ,article.*
        FROM dossier_reclamation dr 
        INNER JOIN commande cmd ON dr.numCommande = cmd.numCommande 
        INNER JOIN client c ON cmd.idClient = c.idClient
        INNER JOIN utilisateurs u ON dr.idUtilisateur = u.idUtilisateur
        INNER JOIN concerner ON dr.numDossier = concerner.numDossier
        INNER JOIN article ON concerner.codeArticle = article.codeArticle
        WHERE dr.numDossier = :numDossier";
    
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':numDossier', $numDossier, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Récupére les utilisateurs associé à des dossiers 
    function getUtilisateurOnDossier() {

        $connexion = getConnexion();

        $sql = "SELECT dr.numDossier, dr.idUtilisateur, u.nomUtilisateur, u.prenomUtilisateur
        FROM dossier_reclamation dr 
        INNER JOIN utilisateurs u ON dr.idUtilisateur = u.idUtilisateur";

        $curseur = $connexion->prepare($sql);

        $curseur->execute();

        $resultat = $curseur->fetchAll(PDO::FETCH_ASSOC);

        return $resultat;

    }

    // Modifie le statut d'un dossier en cours
    function modifierStatut($statutDossier, $numDossier){
    
        $connexion = getConnexion();

        $sql ="UPDATE dossier_reclamation SET statutDossier = $statutDossier WHERE numDossier = $numDossier";

        $connexion->query($sql);

    }

    // Recherche des dossiers en fonction d'un terme de recherche dans plusieurs colonnes
    function rechercheDossier($recherche)  {
        
        $connexion = getConnexion();

        $sql = "SELECT *
        FROM dossier_reclamation dr 
        INNER JOIN commande cmd ON dr.numCommande = cmd.numCommande 
        INNER JOIN client c ON cmd.idClient = c.idClient
        INNER JOIN utilisateurs u ON dr.idUtilisateur = u.idUtilisateur
        WHERE dr.numDossier LIKE :search_term OR dr.dateDossier LIKE :search_term OR dr.typeDossier LIKE :search_term OR dr.dateClotureDossier LIKE :search_term
        OR c.nomClient LIKE :search_term OR dr.idUtilisateur LIKE :search_term OR dr.statutDossier LIKE :search_term";

        $curseur = $connexion->prepare($sql);

        $curseur->execute(['search_term' => "%$recherche%"]);

        $resultats = $curseur->fetchAll(PDO::FETCH_ASSOC);

        return $resultats;
    }
    
    // Recherche des utilisateurs en fonction d'un terme de recherche dans plusieurs colonnes
    function rechercheUtilisateur($recherche)  {
   
        $connexion = getConnexion();

        $sql = "SELECT * FROM utilisateurs WHERE nomUtilisateur LIKE :search_term OR prenomUtilisateur LIKE :search_term OR idUtilisateur LIKE :search_term OR roleUtilisateur LIKE :search_term OR pseudoUtilisateur LIKE :search_term";

        $curseur = $connexion->prepare($sql);

        $curseur->execute(['search_term' => "%$recherche%"]);

        $resultats = $curseur->fetchAll(PDO::FETCH_ASSOC);

        return $resultats;
        
    }

    // Permet de retourner le role (int) en chaine de caractères
    function afficheRoleUtilisateur($role) {
        if ($role == 1) return "Administrateur";
        else if ($role == 2)  return "Technicien Hotline";
        else return "Technicien SAV";
    }
    
    // Affiche le header en fonction du role donc admin ou technicien
    function afficheHeader () {
        $role = 0;
        if (isset($_SESSION['id'])) {
            $id = $_SESSION['id'];
            $user = getUtilisateur($id);
            $role = $user['roleUtilisateur'];
//var_dump("fonction role : " . $role);
        }
        return $role;
    }

    // Permet de retourner le type de dossier (int) en chaine de caractères
    function afficherTypeDossier($typeDossier){
        if($typeDossier == 1)return "NPAI";
        else if($typeDossier == 2)return "NP";
        else if ($typeDossier == 3)return "EC";
        else if ($typeDossier == 4)return "EP";
        else if ($typeDossier == 5)return "SAV";
    }

    // Permet de retourner le statut du dossier (int) en chaine de caractères
    function afficherStatutDossier($statutDossier){
        if($statutDossier == 1) return "En cours de diagnostics";
        else if ($statutDossier == 2) return "En cours de réexpedition";
        else if($statutDossier == 3) return "Terminer";

    }
    
    // Sert à vérifier les informations de connexion d'un utilisateur 
    function controleConnexion($pseudoUtilisateur, $mdpUtilisateur, $users) {
        $idUser = 0;

        foreach ($users as $utilisateur) {
            if ($utilisateur['pseudoUtilisateur'] == $pseudoUtilisateur) { // si pseudo correct
                if ($utilisateur['mdpUtilisateur'] == $mdpUtilisateur) { // si mot de passe correct
                    $idUser = $utilisateur['idUtilisateur']; 
                    return $idUser; // retourne l'id utilisateur
                } else {
                    $idUser = -1; // mot de passe incorrect
                    return $idUser;
                }
            } 
        }
        return $idUser; //idUser = 0 -> Utilisateur introuvable
    }

    // Récupère les informations d'un utilisateur à partir de son ID
    function getUtilisateur($id) {
        $bdd = getConnexion();


        $sql = "SELECT * FROM utilisateurs WHERE idUtilisateur = :id";


        $requete = $bdd->prepare($sql);


        $requete->bindParam(':id', $id);


        $requete->execute();

        $result = $requete->fetch(PDO::FETCH_ASSOC);

        return $result;
    }


    // Permet d'ajouter un utilisateur à la base de données avec les informations en paramètres
    function ajoutUtilisateur(string $pseudoUtilisateur, string $nom, string $prenom, string $mdpUtilisateur, int $role) {
        try {
            
            $connexion = getConnexion();
    

            $sql = "INSERT INTO utilisateurs (pseudoUtilisateur, nomUtilisateur, prenomUtilisateur, mdpUtilisateur, roleUtilisateur) 
                    VALUES (:pseudo, :nom, :prenom, :motDePasse, :role)";
    
            $requete = $connexion->prepare($sql);
    
            
            $requete->bindParam(':pseudo', $pseudoUtilisateur);
            $requete->bindParam(':nom', $nom);
            $requete->bindParam(':prenom', $prenom);
            $requete->bindParam(':motDePasse', $mdpUtilisateur);
            $requete->bindParam(':role', $role);
    
            $requete->execute();
    
            
            return $connexion->lastInsertId();

        } catch (PDOException $e) {
            
            throw new ModeleException("Erreur lors de l'insertion de l'utilisateur : " . $e->getMessage());
        }
    }

    // Récupère le nombre d'administrateur dans la BDD
    function getAdmins() {

        $connexion = getConnexion();
    
        $sql = "SELECT COUNT(*) AS count FROM utilisateurs WHERE roleUtilisateur = 1";

        $curseur = $connexion->prepare($sql);
    
        $curseur->execute();
    
        $resultat = $curseur->fetch(PDO::FETCH_ASSOC);
    
        return $resultat['count'];
    
    }

    // Récupère le rôle de tous les utilisateurs dans la BDD
    function getRoleUtilisateur() {

        $connexion = getConnexion();

        $sql = "SELECT idUtilisateur, roleUtilisateur FROM utilisateurs";

        $curseur = $connexion->prepare($sql);

        $curseur->execute();

        $resultat = $curseur->fetchAll(PDO::FETCH_ASSOC);

        return $resultat;
    }

    // Supprime un utilisateur en fonction de son ID
    function supprimerUtilisateur(int $id_utilisateur) {

        $connexion = getConnexion();

        $sql = "DELETE FROM utilisateurs WHERE idUtilisateur = :idUti";

        $curseur = $connexion->prepare($sql);

        $curseur->execute([':idUti' => $id_utilisateur]);

        $nbSuppr = $curseur->rowCount();

        return $nbSuppr;
    }

    // Permet de mettre à jour les infos d'un utilisateur
    function modifierUtilisateur(int $idUtilisateur,string $pseudo ,string $nom, string $prenom, string $mdp) {

        $connexion = getConnexion();

        $sql = "UPDATE utilisateurs set pseudoUtilisateur = :pseudo,  nomUtilisateur = :nom, prenomUtilisateur = :prenom, mdpUtilisateur  = :mdp where idUtilisateur = :id";

        $curseur = $connexion->prepare($sql);

        $curseur->execute([':pseudo' => $pseudo, ':nom' => $nom, ':prenom' => $prenom , ':mdp' => $mdp, ':id' => $idUtilisateur]);

        $nbContacts = $curseur->rowCount();

        return $nbContacts;
    }

    // Mettre à jour les infos d'un utilisateur sans le mot de passe
    function modifierUtilisateurSansMdp(int $idUtilisateur,string $pseudo ,string $nom, string $prenom) {

        $connexion = getConnexion();

        $sql = "UPDATE utilisateurs set pseudoUtilisateur = :pseudo,  nomUtilisateur = :nom, prenomUtilisateur = :prenom where idUtilisateur = :id";

        $curseur = $connexion->prepare($sql);

        $curseur->execute([':pseudo' => $pseudo, ':nom' => $nom, ':prenom' => $prenom , ':id' => $idUtilisateur]);

        $nbContacts = $curseur->rowCount();

        return $nbContacts;
    }

    // Récupère tous les clients dans la BDD
    function getClients() : array {

        $connexion = getConnexion();

        $sql = "SELECT * FROM client";

        $resultat = $connexion->query($sql);

        return $resultat->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère les infos d'un client en fonction de son ID
    function getClient($idClient) {

        $connexion = getConnexion();

        $sql = "SELECT * FROM client WHERE idClient = :search_term";

        $curseur = $connexion->prepare($sql);

        $curseur->execute(['search_term' => $idClient]);

        $resultats = $curseur->fetchAll(PDO::FETCH_ASSOC);

        return $resultats;
    }

    // Récupère toutes les commandes dans la BDD
    function getCommandes() {
        $connexion = getConnexion();

        $sql = "SELECT * FROM commande";

        $resultat = $connexion->query($sql);

        return $resultat->fetchAll(PDO::FETCH_ASSOC);
    }


    // Récupère les infos d'une commande en fonction de son numéro de commande
    function getCommande($recherche) {
        $connexion = getConnexion();

        //$sql = "SELECT com.numCommande, DATE_FORMAT(com.dateCommande, '%d/%m/%Y') AS 'dateCommande', cont.codeArticle, libelleArticle, garantieArticle, idDiag, com.idClient, nomClient, prenomClient, codePostalClient, villeClient 
        $sql = "SELECT com.numCommande, com.dateCommande, cont.codeArticle, libelleArticle, art.prixUnitaire, garantieArticle, idDiag, com.idClient, nomClient, prenomClient, codePostalClient, villeClient 
        FROM commande com 
        JOIN client c ON c.idClient = com.idClient 
        JOIN contenir cont ON cont.numCommande = com.numCommande 
        JOIN article art ON art.codeArticle = cont.codeArticle 
        WHERE com.numCommande = :search_term";

        $curseur = $connexion->prepare($sql);

        $curseur->execute(['search_term' => $recherche]);

        $resultats = $curseur->fetchAll(PDO::FETCH_ASSOC);
//var_dump($resultats);
        return $resultats;
    }

    // Rechercher des clients dans la BDD en fonction de leur nom et prénom
    function rechercheClient($recherche)  {

        $resultats = [];
        
        $connexion = getConnexion();

        $sql = "SELECT * FROM client WHERE nomClient LIKE :search_term OR prenomClient LIKE :search_term";

        $curseur = $connexion->prepare($sql);

        $curseur->execute(['search_term' => "%$recherche%"]);

        $resultats = $curseur->fetchAll(PDO::FETCH_ASSOC);

        return $resultats;

    }

    // Rechercher des commandes en fonction de leur numéro de commande
    function rechercheCommande($recherche)  {

        $resultats = [];
        
        $connexion = getConnexion();

        $sql = "SELECT * FROM commande WHERE numcommande LIKE :search_term";

        $curseur = $connexion->prepare($sql);

        $curseur->execute(['search_term' => "%$recherche%"]);

        $resultats = $curseur->fetchAll(PDO::FETCH_ASSOC);

        return $resultats;

    }
    

    // Rechercher des commandes en fonction de leur numéro de commande mais en incluant les info du client associé à chaque commande
    function rechercheClientCommande($recherche)  {
        
        $connexion = getConnexion();

        $sql = "SELECT * FROM commande com JOIN client c ON c.idClient = com.idClient WHERE com.numCommande = :search_term";

        $curseur = $connexion->prepare($sql);

        $curseur->execute(['search_term' => $recherche]);

        $resultats = $curseur->fetchAll(PDO::FETCH_ASSOC);

        return $resultats;

    }

    // Permet de rechercher des dossiers de réclamation dans la BDD en fonction du numéro de commande en incluant les infos de la commande et du client associé à chaque dossier.
    function rechercheDossierCommande($recherche)  {
        
        $connexion = getConnexion();

        $sql = "SELECT * FROM dossier_reclamation dos 
        JOIN commande com ON dos.numCommande = com.numCommande
        JOIN client cli ON cli.idClient = com.idClient 
        WHERE dos.numCommande = :search_term";

        $curseur = $connexion->prepare($sql);

        $curseur->execute(['search_term' => $recherche]);

        $resultats = $curseur->fetchAll(PDO::FETCH_ASSOC);

        return $resultats;

    }

    // Rechercher des dossiers dans la BDD en fonction du nom ou prénom du client associé à chaque dossier
    function rechercheDossierNom($recherche)  {
        
        $connexion = getConnexion();

        $sql = "SELECT * FROM dossier_reclamation dos 
        JOIN commande com ON dos.numCommande = com.numCommande
        JOIN client cli ON cli.idClient = com.idClient 
        WHERE cli.nomClient LIKE :search_term OR cli.prenomClient LIKE :search_term";

        $curseur = $connexion->prepare($sql);

        $curseur->execute(['search_term' => "%$recherche%"]);

        $resultats = $curseur->fetchAll(PDO::FETCH_ASSOC);

        return $resultats;

    }

    function rechercheClientDossier($recherche)  {
        
        $connexion = getConnexion();

        $sql = "SELECT * FROM dossier_reclamation dos 
        JOIN commande com ON dos.numCommande = com.numCommande
        JOIN client cli ON cli.idClient = com.idClient 
        WHERE dos.numDossier = :search_term";

        $curseur = $connexion->prepare($sql);

        $curseur->execute(['search_term' => $recherche]);

        $resultats = $curseur->fetchAll(PDO::FETCH_ASSOC);

        return $resultats;

    }

    // Permet de rechercher les commandes dans la BDD en fonction de l'id du client associé à la commande
    function rechercheCommandesClient($idClient) {
        $connexion = getConnexion();

        $sql = "SELECT * FROM commande WHERE idClient = :search_term";

        $curseur = $connexion->prepare($sql);

        $curseur->execute(['search_term' => $idClient]);

        $resultats = $curseur->fetchAll(PDO::FETCH_ASSOC);

        return $resultats;
    }


    // Récupère tous les pseudos des utilisateurs dans la BDD
    function getPseudos() {
        $connexion = getConnexion();

        $sql = "SELECT pseudoUtilisateur FROM utilisateurs";

        $curseur = $connexion->prepare($sql);

        $curseur->execute();

        $resultat = $curseur->fetchAll(PDO::FETCH_ASSOC);
        
        return $resultat;
    }

    // Permet de récupérer tous les dossiers qui sont terminés dans la BDD
    function dossierTermine() {

        $connexion = getConnexion();

        $sql = "SELECT *
        FROM dossier_reclamation dr 
        INNER JOIN commande cmd ON dr.numCommande = cmd.numCommande 
        INNER JOIN client c ON cmd.idClient = c.idClient
        INNER JOIN utilisateurs u ON dr.idUtilisateur = u.idUtilisateur
        WHERE statutDossier = 3";

        $resultat = $connexion->query($sql);

        return $resultat->fetchAll(PDO::FETCH_ASSOC);
    }

    // Permet de rechercher les dossiers terminés en fonction de plusieurs critères de recherche
    function rechercheDossierTerm($recherche)  {
                
        $connexion = getConnexion();

        $sql = "SELECT *
        FROM dossier_reclamation dr 
        INNER JOIN commande cmd ON dr.numCommande = cmd.numCommande 
        INNER JOIN client c ON cmd.idClient = c.idClient
        INNER JOIN utilisateurs u ON dr.idUtilisateur = u.idUtilisateur
        WHERE dr.statutDossier = 3 AND (dr.numDossier LIKE :search_term OR dr.dateDossier LIKE :search_term OR dr.typeDossier LIKE :search_term 
        OR c.nomClient LIKE :search_term OR dr.idUtilisateur LIKE :search_term)";

        $curseur = $connexion->prepare($sql);

        $curseur->execute(['search_term' => "%$recherche%"]);

        $resultats = $curseur->fetchAll(PDO::FETCH_ASSOC);

        return $resultats;
    }

    // Permet de récupérer tous les dossiers qui sont en cours de diagnostics dans la BDD
    function dossierDiagnostic() {

        $connexion = getConnexion();

        $sql = "SELECT *
        FROM dossier_reclamation dr 
        INNER JOIN commande cmd ON dr.numCommande = cmd.numCommande 
        INNER JOIN client c ON cmd.idClient = c.idClient
        INNER JOIN utilisateurs u ON dr.idUtilisateur = u.idUtilisateur
        WHERE statutDossier = 1";

        $resultat = $connexion->query($sql);

        return $resultat->fetchAll(PDO::FETCH_ASSOC);
    }

    // Permet de rechercher les dossiers en cours de diagnostics en fonction de plusieurs critères de recherche
    function rechercheDossierDiag($recherche)  {
                
        $connexion = getConnexion();

        $sql = "SELECT *
        FROM dossier_reclamation dr 
        INNER JOIN commande cmd ON dr.numCommande = cmd.numCommande 
        INNER JOIN client c ON cmd.idClient = c.idClient
        INNER JOIN utilisateurs u ON dr.idUtilisateur = u.idUtilisateur
        WHERE dr.statutDossier = 1 AND (dr.numDossier LIKE :search_term OR dr.dateDossier LIKE :search_term OR dr.typeDossier LIKE :search_term 
        OR c.nomClient LIKE :search_term OR dr.idUtilisateur LIKE :search_term)";

        $curseur = $connexion->prepare($sql);

        $curseur->execute(['search_term' => "%$recherche%"]);

        $resultats = $curseur->fetchAll(PDO::FETCH_ASSOC);

        return $resultats;
    }

    // Permet de récupérer tous les dossiers qui sont en cours d'expédition dans la BDD
    function dossierExpedition() {
        $connexion = getConnexion();

        $sql = "SELECT *
        FROM dossier_reclamation dr 
        INNER JOIN commande cmd ON dr.numCommande = cmd.numCommande 
        INNER JOIN client c ON cmd.idClient = c.idClient
        INNER JOIN utilisateurs u ON dr.idUtilisateur = u.idUtilisateur
        WHERE statutDossier = 2";

        $resultat = $connexion->query($sql);

        return $resultat->fetchAll(PDO::FETCH_ASSOC);
    }

    // permet de rechercher les dossiers en cours d'expédition en fonction de plusieurs critères de recherche
    function rechercheDossierExpe($recherche)  {
                
        $connexion = getConnexion();

        $sql = "SELECT *
        FROM dossier_reclamation dr 
        INNER JOIN commande cmd ON dr.numCommande = cmd.numCommande 
        INNER JOIN client c ON cmd.idClient = c.idClient
        INNER JOIN utilisateurs u ON dr.idUtilisateur = u.idUtilisateur
        WHERE dr.statutDossier = 2 AND (dr.numDossier LIKE :search_term OR dr.dateDossier LIKE :search_term OR dr.typeDossier LIKE :search_term 
        OR c.nomClient LIKE :search_term OR dr.idUtilisateur LIKE :search_term)";

        $curseur = $connexion->prepare($sql);

        $curseur->execute(['search_term' => "%$recherche%"]);

        $resultats = $curseur->fetchAll(PDO::FETCH_ASSOC);

        return $resultats;
    }

    // Permet d'ajouter un nouveau dossier dans la BDD avec les paramètres fournis
    function ajoutDossier($typeDossier, $statutDossier, $numCom, $idUtilisateur, $commentaire) {

        try {
            $connexion = getConnexion();

            $sql = "INSERT INTO dossier_reclamation
            (dateDossier, typeDossier, statutDossier, numCommande, idUtilisateur, commentaireDossier) 
            VALUES (CURRENT_DATE(), :typeDossier, :statutDossier, :numCommande, :idUtilisateur, :commentaireDossier)";

            $requete = $connexion->prepare($sql);


            $requete->bindParam(':statutDossier', $statutDossier);
            $requete->bindParam(':typeDossier', $typeDossier);
            $requete->bindParam(':numCommande', $numCom);
            $requete->bindParam(':idUtilisateur', $idUtilisateur);
            $requete->bindParam(':commentaireDossier', $commentaire);

            $requete->execute();
            
        } catch (PDOException $e) {
            throw new ModeleException("Erreur lors de l'insertion de l'utilisateur : " . $e->getMessage());
        }

        return $connexion->lastInsertId();
    }   
        
    // Permet d'associer un article à un dossier dans la BDD en insérant une nouvelle ligne dans la table "Concerner"
    function ajoutDossierArticle($codeArticle, $numDossier) {

        try {
            $connexion = getConnexion();

            $sql = "INSERT INTO concerner(codeArticle, numDossier) 
            VALUES (:codeArticle, :numDossier)";

            $requete = $connexion->prepare($sql);


            $requete->bindParam(':codeArticle', $codeArticle);
            $requete->bindParam(':numDossier', $numDossier);

            $requete->execute();
            
        } catch (PDOException $e) {
            throw new ModeleException("Erreur lors de l'insertion de l'utilisateur : " . $e->getMessage());
        }
    }

    // Récupére les dossiers associés à une commande spécifique dans la BDD
    function getCommandeReclamation($idCommande) {
        $connexion = getConnexion();

        $sql = "SELECT * FROM dossier_reclamation WHERE numCommande = :search_term";

        $curseur = $connexion->prepare($sql);

        $curseur->execute(['search_term' => $idCommande]);

        $resultats = $curseur->fetchAll(PDO::FETCH_ASSOC);

        return $resultats;
    }

?>