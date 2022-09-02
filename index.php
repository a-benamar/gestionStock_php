<?php
        // faire appel a la base de donnees

        require_once 'db.php';
   
        // ajouter un produit depuis le formulaire 

if(isset($_POST['ajouter']) && !empty($_POST['code_article'])
                            && !empty($_POST['nom_article'])
                            && !empty($_POST['quantite'])

)
{   
    $code_article = $_POST['code_article'];
    $nom_article = $_POST['nom_article'];
    $quantite = $_POST['quantite'];

    // pour l'image ya bouceaup de chose a jouter 
    // je laisse le code dans un lien dans la descreption 

        $images=$_FILES['profile']['name'];
		$tmp_dir=$_FILES['profile']['tmp_name'];
		$imageSize=$_FILES['profile']['size'];
            // creer un dossier nommer le uplods 
            // pour stocker nos images
		$upload_dir='uploads/';
		$imgExt=strtolower(pathinfo($images,PATHINFO_EXTENSION));
		$valid_extensions=array('jpeg', 'jpg', 'png', 'gif', 'pdf');
		$picProfile=rand(1000, 1000000).".".$imgExt;
		move_uploaded_file($tmp_dir, $upload_dir.$picProfile);

        $sql ="INSERT INTO produit(code_article, nom_article, image_produit, quantite)
         VALUES (:code_article, :nom_article, :pic, :quantite)";
         $stmt = $pdo->prepare($sql);

         $stmt->bindParam(':code_article', $code_article);
         $stmt->bindParam(':nom_article', $nom_article);
         $stmt->bindParam(':pic', $picProfile);
         $stmt->bindParam(':quantite', $quantite);

         $stmt->execute();
         header('Location:index.php');
}
            $stmt = $pdo->query('SELECT * FROM produit');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>Gestion de Stock</title>
</head>
<body>
<?php require_once 'navbar.php'; ?>
   
    <div class="container">
        <div class="row">
            <div class="col-2 mt-3">
               <form action="index.php" class="form-group mt-3" method="POST" enctype="multipart/form-data" >
                <label for="">Image du Produit :</label>
                     <input type="file" class="form-control mt-3" name="profile" accept="*/image">
                   <label for="">Code Article :</label>
                   <input type="text" class="form-control mt-3" name="code_article" required>
                   <label for="">Designation du Produit :</label>
                   <input type="text" class="form-control mt-3" name="nom_article" required>
                   <label for="">Quantite :</label>
                   <input type="text" class="form-control mt-3" name="quantite" required>
                   <button type="submit" class="btn btn-primary mt-3" name="ajouter">Enregistrer</button>
               </form>
            </div>
            <div class="col-10 mt-3">
                <table class="table table-striped display" id="example">
                    <thead>
                        <th>Image</th>
                        <th>Code Article</th>
                        <th>Designation</th>
                        <th>Quantite</th>
                    </thead>
                    <tbody>
                    <?php 
                    while ( $row =  $stmt->fetch())
                    {
                        ?>
                    
                        <tr>
                            <td><img src="./uploads/<?php echo $row-> image_produit; ?>" alt=" "  class="image_product "></td>
                            <td><?php echo $row-> code_article; ?> </td>
                            <td><?php echo $row-> nom_article; ?> </td>
                            <td><?php echo $row-> quantite; ?> </td>
                        </tr>
                       <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
                $(document).ready(function() {
                    $('#example').DataTable( {
                        "scrollY":        "500px",
                        "scrollCollapse": true,
                        "paging":         false
                        } );
                    } );
            </script>
</body>
</html>