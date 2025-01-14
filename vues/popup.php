<!-- Passer les tableaux php en JSON -->
<?php
$tableau = getPseudos(); 
$tableau_json = json_encode($tableau);

$tableau_role = getRoleUtilisateur();
$tableau_json2 =json_encode($tableau_role);

$tableau_dossier = getUtilisateurOnDossier();
$tableau_json3 = json_encode($tableau_dossier);

$tableau_utilisateur = getUtilisateurs();
$tableau_json4 = json_encode($tableau_utilisateur);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.4/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.4/sweetalert2.min.js"></script>
<script>

    // Alert SUPPRESSION
    function confirmerSuppression(idUtilisateur) {
    // Effectuer une requête AJAX pour obtenir le nombre d'administrateurs restants
    $.ajax({
        url: 'index.php?action=accueilAdmin',
        type: 'GET',
        success: function(response) {
            var tableauRole = <?php print $tableau_json2; ?>;            
            var nbAdmins = <?=getAdmins()?>;
            var tableauDossier = <?php print $tableau_json3; ?>;  

            var roleUtilisateur = tableauRole.find(user => user.idUtilisateur === idUtilisateur).roleUtilisateur;
            var dossierUtilisateur = tableauDossier.find(function(utilisateur) {
                return utilisateur.idUtilisateur === idUtilisateur;
            });


            if (nbAdmins === 1 && roleUtilisateur === 1) {
                // Il ne reste qu'un seul administrateur, afficher un message d'erreur
                Swal.fire('Erreur', 'Impossible de supprimer l\'utilisateur. Il ne peut pas rester moins d\'un administrateur.', 'error');
                
            } else if (dossierUtilisateur) {
                Swal.fire('Erreur', 'Impossible de supprimer l\'utilisateur. Il est associé à un dossier.', 'error');
            } else {

                    // Il y a plus d'un administrateur, demander confirmation pour la suppression
                    Swal.fire({
                        title: 'Êtes-vous sûr ?',
                        text: "Vous ne pourrez pas revenir en arrière !",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui, supprimer !'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Effectuer la suppression de l'utilisateur
                            $.ajax({
                                url: 'index.php?action=accueilAdmin',
                                type: 'GET',
                                data: {id: idUtilisateur},
                                success: function(response) {
                                    // Afficher un message de succès
                                    Swal.fire({
                                        title: 'Supprimé !',
                                        text: 'L\'utilisateur a été supprimé.',
                                        icon: 'success',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Ok'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Actualiser la page
                                            location.reload();
                                        }
                                    });
                                },
                                error: function(xhr, status, error) {
                                    // Gérer les erreurs
                                    Swal.fire('Erreur', 'Une erreur s\'est produite lors de la suppression de l\'utilisateur.', 'error');
                                }
                            });
                        } else {
                            // L'utilisateur a annulé la suppression
                            Swal.fire('Annulé', 'L\'utilisateur n\'a pas été supprimé.', 'info');
                        }
                    });
                
            }
        },
        error: function(xhr, status, error) {
            // Gérer les erreurs
            Swal.fire('Erreur', 'Une erreur s\'est produite lors de la récupération du nombre d\'administrateurs.', 'error');
        }
    });
}





    // Partie AJOUT

    // Récupérer les boutons les titre et les roles pour lier à chaque bouton
    const boutons = document.querySelectorAll('.boutonPopup');
    const modalTitle = document.querySelector('#ajoutUtilisateurModalLabel');
    const tableauJS = <?php print $tableau_json; ?>;


    boutons.forEach(bouton => {
        bouton.addEventListener('click', () => {
            const title = bouton.dataset.title;
            const role = bouton.dataset.role;

            modalTitle.textContent = title;
            document.getElementById('role_utilisateur').value = role;
            const modal = new bootstrap.Modal(document.getElementById('ajoutUtilisateurModal'));
            modal.show();       
        });
    });




    const erreurPseudo = document.getElementById('pseudoErreur');
    const erreurNom = document.getElementById('nomErreur');
    const erreurPrenom = document.getElementById('prenomErreur');
    const erreurMdp = document.getElementById('mdpErreur');
    const erreurConfirmMdp = document.getElementById('confirmMdpErreur');

    const inputPseudo = document.getElementById('pseudo');
    const inputNom = document.getElementById('nom');
    const inputPrenom = document.getElementById('prenom');
    const inputMdp = document.getElementById('mot_de_passe');
    const inputConfirmMdp = document.getElementById('confirmer_mot_de_passe');

    const regex = /^[A-Za-z éè'-]*$/;

    const enregistrerBtn = document.getElementById('enregistrerBtn');
    enregistrerBtn.addEventListener('click', function() {

        var pseudo = inputPseudo.value.trim();
        var nom = inputNom.value.trim();
        var prenom = inputPrenom.value.trim();
        var mdp = inputMdp.value.trim();
        var confirmMdp = inputConfirmMdp.value.trim();
        
        var valid = false;
        // Trouvé dans le tableau de données si le pseudo est déja existant
        for (i = 0; i < tableauJS.length; i++) {
            var maValue = tableauJS[i].pseudoUtilisateur;

            if (maValue == inputPseudo.value) {
                valid = false;
                erreurPseudo.textContent = "Pseudo déjà pris ! Veuillez en choisir un autre."
                break;
            } else {
                erreurPseudo.textContent = ""
                valid = true; 
            }
        }
        // Regex Nom Vérif
        if (!regex.test(inputNom.value)) {
            valid = false;
            erreurNom.textContent = "Le nom n'est pas valide !";
        } else {
            erreurNom.textContent = "";
        }
        // Regex Prénom Vérif
        if (!regex.test(inputPrenom.value)) {
            valid = false;
            erreurPrenom.textContent = "Le prénom n'est pas valide !";
        } else {
            erreurPrenom.textContent = "";
        }
        
        // Egalité du MDP
        var mdp1 = inputMdp.value;
        var mdp2 = inputConfirmMdp.value;
        if (mdp1 !== mdp2) {
            valid = false;
            erreurConfirmMdp.textContent = "Les mots de passe ne correspondent pas !";
        } else {
            erreurConfirmMdp.textContent = ""; 
        }


        // Vérification du pseudo
        if (pseudo === '') {
            valid = false;
            erreurPseudo.textContent = "Veuillez saisir un pseudo.";
        }

        // Vérification du nom
        if (nom === '') {
            valid = false;
            erreurNom.textContent = "Veuillez saisir un nom.";
        }

        // Vérification du prénom
        if (prenom === '') {
            valid = false;
            erreurPrenom.textContent = "Veuillez saisir un prénom.";
        }

        // Vérification du mot de passe
        if (mdp === '') {
            valid = false;
            erreurMdp.textContent = "Veuillez saisir un mot de passe.";
        } else {
            erreurMdp.textContent = "";
        }

        // Vérification de la confirmation du mot de passe
        if (confirmMdp === '') {
            valid = false;
            erreurConfirmMdp.textContent = "Veuillez confirmer le mot de passe.";
        }
        
        if (valid) {
        myForm = document.getElementById('ajoutUtilisateurForm');
        myForm.submit();
        }

    });   
    
    // Vidé les champs si on quitte le popup
    $('#ajoutUtilisateurModal').on('hide.bs.modal', function (e) {
    inputPseudo.value = "";
    inputNom.value = "";
    inputPrenom.value = "";
    inputMdp.value = "";
    inputConfirmMdp.value = "";
    erreurPseudo.textContent = "";
    erreurNom.textContent = "";
    erreurPrenom.textContent = "";
    erreurMdp.textContent = "";
    erreurConfirmMdp.textContent = "";
    })
    // CSS du modal Popup
    $(document).ready(function() {
        $('.modal-content').css('background', '#3C4FA0');
        $('.modal-content').css('color', 'white');
        $('#enregistrerBtn').css('background', '#4488C5');
        $('#enregistrerBtn').css('color', 'white');
        $('#enregistrerBtn').css('border', 'solid 3px white');

        $('#enregistrerBtn').hover(
        function() {
            // Au survol
            $(this).css('background', '#8FC1E6');
        },
        function() {
            // Lorsque le survol se termine
            $(this).css('background', '#4488C5');
        }
    );  
    });


    //Partie Modif

    

        
    var tableauUtilisateur = <?php print $tableau_json4; ?>;

    // Préremplir les champs et afficher les modals qui sont générés en fonction des ids pour chacun des utilisateurs
    $('.modifierBtn').click(function(e) {
        e.preventDefault();

        var idUtilisateur = $(this).data('id');

        var utilisateur = tableauUtilisateur.find(function(user) {
            return user.idUtilisateur === idUtilisateur;
        });

        if (utilisateur) {
            $('#pseudoModif' + idUtilisateur).val(utilisateur.pseudoUtilisateur);
            $('#nomModif' + idUtilisateur).val(utilisateur.nomUtilisateur);
            $('#prenomModif' + idUtilisateur).val(utilisateur.prenomUtilisateur);
            $('#modifUtilisateurModal' + idUtilisateur).modal('show');
        } else {
            console.error('Utilisateur non trouvé.');
        }
    });

  
    const modifierBtns = document.querySelectorAll('.modifBtn');
    
    modifierBtns.forEach(function(modifierBtn) {
        modifierBtn.addEventListener('click', function() {
            var idUtilisateur = $(this).data('id');
            var modal = document.querySelector('#modifUtilisateurModal' + idUtilisateur);
            var pseudoModif = modal.querySelector('#pseudoModif' + idUtilisateur).value.trim();
            var nomModif = modal.querySelector('#nomModif' + idUtilisateur).value.trim();
            var prenomModif = modal.querySelector('#prenomModif' + idUtilisateur).value.trim();
            var newMdp = modal.querySelector('#new_mot_de_passe' + idUtilisateur).value.trim();
            var confirmNewMdp = modal.querySelector('#confirmer_new_mot_de_passe' + idUtilisateur).value.trim();

            // Span d'erreur récupéré
            const aucunChangement = document.getElementById('alertChangement' + idUtilisateur);
            const erreurModifPseudo = document.getElementById('pseudoModifErreur' + idUtilisateur);
            const erreurModifNom = document.getElementById('nomModifErreur' + idUtilisateur);
            const erreurModifPrenom = document.getElementById('prenomModifErreur' + idUtilisateur);
            const erreurModifMdp = document.getElementById('newMdpErreur' + idUtilisateur);
            const erreurModifConfirmMdp = document.getElementById('confirmNewMdpErreur' + idUtilisateur);

            // Effacer les msg d'erreur en fermant et réouvrant le modal
            modal.addEventListener('hide.bs.modal', function (e) {

                $('#new_mot_de_passe' + idUtilisateur).val("");
                $('#confirmer_new_mot_de_passe' + idUtilisateur).val("");

                $('#alertChangement' + idUtilisateur).text("");
                $('#pseudoModifErreur' + idUtilisateur).text("");
                $('#nomModifErreur' + idUtilisateur).text("");
                $('#prenomModifErreur' + idUtilisateur).text("");
                $('#newMdpErreur' + idUtilisateur).text("");
                $('#confirmNewMdpErreur' + idUtilisateur).text("");
            });

            var utilisateur = tableauUtilisateur.find(function(user) {
                return user.idUtilisateur === idUtilisateur;
            });

            // console.log(utilisateur);
            var valid = false;

            var pseudoPris = false; 


            if (pseudoModif !== utilisateur.pseudoUtilisateur ) {
                // Le pseudo est différent de celui de l'utilisateur actuel
                valid = true;
                aucunChangement.textContent = "";
                erreurModifPseudo.textContent = "";
                erreurModifNom.textContent = "";
                erreurModifPrenom.textContent = "";

                // Vérifier si le pseudo est déjà pris
                for (var i = 0; i < tableauUtilisateur.length; i++) {
                    var monPseudoModif = tableauUtilisateur[i].pseudoUtilisateur;
                    if (monPseudoModif === pseudoModif && utilisateur.pseudoUtilisateur !== pseudoModif) {
                        pseudoPris = true;
                    }
                }
                if (pseudoPris) {
                    valid = false;
                    erreurModifPseudo.textContent = "Pseudo déjà pris ! Veuillez en choisir un autre."; 

                    aucunChangement.textContent = "";
                } else {
                    erreurModifPseudo.textContent = ""; 
                }

            } else if ((nomModif !== utilisateur.nomUtilisateur || prenomModif !== utilisateur.prenomUtilisateur)) {
                // Vérifier si le nom ou le prénom est modifié, en excluant les chaînes vides
                valid = true;
                aucunChangement.textContent = "";
                erreurModifPseudo.textContent = "";
                erreurModifNom.textContent = "";
                erreurModifPrenom.textContent = "";
            } else if (newMdp !== '' && newMdp !== utilisateur.motDePasse) {
                // Vérifier si le mot de passe est modifié
                valid = true;
                aucunChangement.textContent = "";
                erreurModifPseudo.textContent = "";
                erreurModifNom.textContent = "";
                erreurModifPrenom.textContent = "";
            } else {
                // Aucun changement
                aucunChangement.textContent = "Aucun changement !";
                erreurModifPseudo.textContent = "";
            }

            // Champs vide ou non valide
            if (pseudoModif === '') {
                valid = false;
                erreurModifPseudo.textContent = "Le pseudo ne peut pas être vide !";
            }

            if (!regex.test(nomModif) || nomModif === '') {
                valid = false;
                erreurModifNom.textContent = "Le nom n'est pas valide !";
            } else {
                erreurModifNom.textContent = "";
            }

            if (!regex.test(prenomModif) || prenomModif === '') {
                valid = false;
                erreurModifPrenom.textContent = "Le prénom n'est pas valide !";
            } else {
                erreurModifPrenom.textContent = "";
            }
            
            // Egalité MDP
            var mdp1 = newMdp;
            var mdp2 = confirmNewMdp;
            if (mdp1 !== mdp2) {
                valid = false;
                erreurModifConfirmMdp.textContent = "Les mots de passe ne correspondent pas !";
            } else {
                erreurModifConfirmMdp.textContent = ""; 
            }

            if (valid) {
                // Créer un objet FormData pour envoyer uniquement les champs modifiés
                $('#modifUtilisateurModal' + idUtilisateur).modal('hide');

                var formData = new FormData();
                formData.append('idUtilisateur', idUtilisateur);
                formData.append('pseudoModif', pseudoModif);
                formData.append('nomModif', nomModif);
                formData.append('prenomModif', prenomModif);
                
                // Ajouter le nouveau mot de passe seulement s'il est modifié et non vide
                if (newMdp !== '') {
                    formData.append('newMdp', newMdp);
                }

                fetch('index.php?action=accueilAdmin', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur lors de la requête');
                    }
                    // Afficher l'alerte SweetAlert après le succès de la requête
                    return Swal.fire({
                        icon: 'success',
                        title: 'Succès',
                        text: 'La modification a été réussie !'
                    });
                })
                .then((result) => {
                    // Si l'alerte SweetAlert se ferme, soumettre le formulaire
                    if (result.isConfirmed) {
                        var modifForm = document.getElementById('modifUtilisateurForm' + idUtilisateur);
                        modifForm.submit();
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    // Gérer les erreurs de requête
                });

            //     var modifForm = document.getElementById('modifUtilisateurForm' + idUtilisateur);
            //     modifForm.submit();   
            }
            
            
        });
    }); 
    // CSS Pop up
    $(document).ready(function() {
        $('.modifBtn').css('background', '#4488C5');
        $('.modifBtn').css('color', 'white');
        $('.modifBtn').css('border', 'solid 3px white');

        $('.modifBtn').hover(
            function() {
                // Au survol
                $(this).css('background', '#8FC1E6');
            },
            function() {
                // Lorsque le survol se termine
                $(this).css('background', '#4488C5');
            }
        );
    });


</script>