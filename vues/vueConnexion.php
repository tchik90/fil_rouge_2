<?php if(!isset($_SESSION['id'])) { ?>

<form action="index.php" class="container p-5 formConnexion text-start">
    <input type="hidden" name="action" value="connexionMaj">
    <div class="row">
        <label for="user">Nom d'utilisateur :</label>
        <input type="text" name="user" class="inputText">
    </div>
    <div class="row mt-3">
        <label for="pass">Mot de passe :</label>
        <input type="password" name="pass"  class="inputText">
    </div>
    <div class="text-center mt-5">
        <input type="submit" value="Valider" class="btn bouton">
    </div>
</form>

<?php } else { 
    ?>
    <h4 class="text-center">Vous êtes déjà connecté</h4>
    <?php
    $role = $_SESSION['role'];

        if ($role == 1) $retourAccueil = "accueilAdmin";
        else if ($role == 2) $retourAccueil = "accueilTechnicienHOT";
        else if ($role == 3) $retourAccueil = "accueilTechnicienSAV";

?>
        <footer class="text-center">
            <br><br>
            <a href="index.php?action=<?= $retourAccueil ?>"><button class="btn bouton">Retour à l'accueil</button></a>
        </footer>
<?php }  ?>  