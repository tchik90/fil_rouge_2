<?php ob_start() ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL' crossorigin='anonymous'></script>
    <link rel='stylesheet' href='style/style.css'>
    <title><?= $titre ?></title>
</head>

<body class="container text-center">
    <h1 class="my-5"><?= $titre ?></h1>


<!-- Les alerts -->
    <div class="col-12 alert alert-danger d-block d-sm-none text-center" role="alert">Screen X-Small</div>
    <div class="col-sm-12 alert alert-info d-none d-sm-block d-md-none text-center" role="alert">Screen Small ≥576px</div>
    <div class="col-md-12 alert alert-success d-none d-md-block d-lg-none text-center" role="alert">Screen Medium ≥768px</div>
    <div class="col-lg-12 alert alert-warning d-none d-lg-block d-xl-none text-center" role="alert">Screen Large ≥992px</div>
    <div class="col-xl-12 alert alert-dark d-none d-xl-block d-xxl-none text-center" role="alert">Screen X-Large ≥1200px</div>
    <div class="col-xxl-12 alert alert-secondary d-none d-xxl-block text-center" role="alert">Screen XX-Large ≥1400px</div>

    <div><?= $contenu ?></div>

    <?php if($action != 'accueil' && $action != 'connexion') { ?>
    <footer>
        <br><br>
        <a href="index.php"><button class="btn btn-secondary">Retour à l'accueil</button></a>
    </footer>
<?php } ?>

<!-- TEST -->
<p>VUE FOOTER</p>

</body>
</html>

<?php 
$output = ob_get_clean();
echo $output;
 ?>