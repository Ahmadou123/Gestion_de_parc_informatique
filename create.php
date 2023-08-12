
<?php
require_once "bd_conn.php";

$model = '';
$categorie = '';
$brand = '';
$qty = '';
$qty_lef = '';
$imagePath = ''; 
$status = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $model = $_POST['model'];
    $categorie = $_POST['categorie'];
    $brand = $_POST['brand'];
    $qty = $_POST['qty'];
    $qty_lef = $_POST['qty_lef'];
    $status = $_POST['status'];

    function randomString($n)
    {
        $characters = '0123456789wxcvbnqsdfghjklmazertyuiopAZERTYUIOPMLKJHGFDSQWXCVBN';
        $str = '';
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $str .= $characters[$index];
        }
        return $str;
    }

    if (!is_dir('images')) {
        mkdir('images');
    }

    if(empty($errors)){
        $image = $_FILES['image'] ?? null;
        $imagePath = '';
        if($image && $image['tmp_name']){
            $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
            mkdir(dirname($imagePath));
            move_uploaded_file($image["tmp_name"], $imagePath );
        }
    }


    if (empty($errors)) {
        $statement = $pdo->prepare("INSERT INTO materiel (image, model, categorie, brand, qty, qty_lef, status)
            VALUES (:imagePath, :model, :categorie, :brand, :qty, :qty_lef, :status)");

        $statement->bindValue(':imagePath', $imagePath);
        $statement->bindValue(':model', $model);
        $statement->bindValue(':categorie', $categorie); // Correction de la variable et ajout du lien
        $statement->bindValue(':brand', $brand);
        $statement->bindValue(':qty', $qty);
        $statement->bindValue(':qty_lef', $qty_lef);
        $statement->bindValue(':status', $status); // Correction de la variable

        $statement->execute();
         header('Location: index.php');
    }     
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <?php if (!empty($errors)): ?>
     <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
            <div><?php echo $error ?></div>
            <?php endforeach; ?>
     </div>
    <?php endif;?>

    <div class="container mt-5">
        <h1>Ajouter</h1>
        <div class="container d-flex">
        <form method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col mt-3">
                  <label>Image</label><br>
                  <input type="file" class="form-control" name="image">
                </div>
                <div class="col mt-3">
                  <label>Model</label>
                  <input type="text" name="model" class="form-control"  value="<?php echo $model ?>" required  >
                </div>
            </div>    
            <div class="row">
                <div class="col mt-3">
                <label>Catégorie</label>
                <input type="text"  name="categorie" class="form-control"  value="<?php echo $categorie ?>" required>
                </div>
                <div class="col mt-3">
                <label>brand</label>
                <input type="text"  name="brand" class="form-control"value="<?php echo $brand ?>" required>
                </div>
            </div>    
            <div class="row">
                <div class="col mt-3">
                <label>Qty</label>
                <input type="number"  name="qty" class="form-control" value="<?php echo $qty ?>" required>
                </div>
                <div class="col mt-3">
                <label>Qty lef</label>
                <input type="number"  name="qty_lef" class="form-control" value="<?php echo $qty_lef ?>" required>
                </div>
            </div>    
                    
            <div class="form-group md-3 mt-3">
                <label for="">Status</label>
                <input type="radio" class="form-check-input" name="status" id="nouveau" value="nouveau">
                <label for="nouveau" class="form-input-label">Nouveau</label>
                &nbsp;
                <input type="radio" class="form-check-input" name="status" id="ancien" value="ancien">
                <label for="ancien" class="form-input-label">Ancien</label>
            </div>
               <button type="submit" class="btn btn-primary mt-3">Enregistrer</button>
            </form>
        </div>  
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>






