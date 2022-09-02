<?php 

require_once 'db.php';

if(isset($_POST['updatebtn']))
{
        $userid = intval ($_GET['id']);
        $code_article = $_POST['code_article'];
        $nom_article = $_POST['nom_article'];
        $quantite = $_POST['quantite'];

        $sql= " UPDATE `produit` SET `code_article`=:code_art,`nom_article`=:nomart,`quantite`=:quant WHERE id=:nouvelleid ";

        $query = $pdo->prepare($sql);
        $query ->bindParam(':code_art', $code_article, PDO::PARAM_STR);
        $query ->bindParam(':nomart', $nom_article, PDO::PARAM_STR);
        $query ->bindParam(':quant', $quantite, PDO::PARAM_STR);
        $query ->bindParam(':nouvelleid', $userid, PDO::PARAM_STR);

        $query->execute();

        echo "<script>alert('Vous avez modifier un produit');</script>";
        echo "<script> window.location.href='produit.php'</script>";

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Metre a jour Produit</title>
</head>
<body>
<?php require_once 'navbar.php'; ?>
                <h1>Metre a jour ce Produit </h1>
       
       <div class="container">
        <div class="row">
        <div class="col-8">

        <?php 

        $userid = intval ($_GET['id']);
        $sql ="SELECT  `code_article`, `nom_article`,`quantite` FROM `produit` WHERE id=:nouvelleid";

        $query = $pdo->prepare($sql);
        $query->bindParam(':nouvelleid', $userid , PDO::PARAM_STR);
        $query->execute();

        $resultat= $query->fetchAll(PDO::FETCH_OBJ);

        foreach ($resultat as $row)
        {
?>
        

                <form action="" method="POST" class="form-group">
                        Code Produit :
                        <input type="text" name="code_article" id="" class="form-control" value="<?php echo $row->code_article; ?>">
                        Nom Produit : 
                        <input type="text" name="nom_article" id="" class="form-control" value="<?php echo $row->nom_article; ?>">
                        Quantite Produit : 
                        <input type="text" name="quantite" id="" class="form-control" value="<?php echo $row->quantite; ?>">

                        <input type="submit" name="updatebtn" id="" value="Metre a jours" class="btn btn-primary mt-3">
                        <?php } ?>
                </form>
        </div>
        </div>
       </div>
        
</body>
</html>