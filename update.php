<?php
require_once "bd_conn.php";
$id = $_GET['id']; 

$statement=$pdo->prepare('SELECT * FROM materiel WHERE id = :id');
$statement->bindValue(':id',$id);
$statement->execute();
$materiel=$statement->fetch(PDO::FETCH_ASSOC);

$errors = [];

$model = $materiel['model'];
$categorie = $materiel['categorie'];
$brand = $materiel['brand'];
$qty = $materiel['qty'];
$qty_lef = $materiel['qty_lef'];
$status = $materiel['status'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
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

    $model = $_POST['model'];
    $categorie = $_POST['categorie'];
    $brand = $_POST['brand'];
    $qty = $_POST['qty'];
    $qty_lef = $_POST['qty_lef'];
    $status = $_POST['status'];

    if (!$categorie) {
        $errors[] = 'categorie is required';
    }

    if (!$brand) {
        $errors[] = 'brand is required';
    }


    if (!is_dir('images')) {
        mkdir('images');
    }

    if(empty($errors)){
        $image = $_FILES['image'] ?? null;
        $imagePath = $materiel['image'];
       
        if($image && $image['tmp_name']){
            if ($materiel['image']){
                unlink($materiel['image']);
            }
            $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
            mkdir(dirname($imagePath));
            move_uploaded_file($image["tmp_name"], $imagePath );
        }
    }


        if (empty($errors)) {
            $statement = $pdo->prepare(" UPDATE `materiel` SET image = :image ,model= :model, categorie = :categorie, brand = :brand, qty = :qty, qty_lef= :qty_lef, status= :status WHERE id  = :id ");
            $statement->bindValue(':image', $imagePath);
            $statement->bindValue(':model', $model);
            $statement->bindValue(':categorie', $categorie); 
            $statement->bindValue(':brand', $brand);
            $statement->bindValue(':qty', $qty);
            $statement->bindValue(':qty_lef', $qty_lef);
            $statement->bindValue(':status', $status); 
            $statement->bindValue(':id', $id);
            $statement->execute();
            header('Location: index.php');
    }     
    
}
?>

<!DOCTYPE html>
<<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Modifier</title>
</head>
<body>
<div class="container mt-5">
    <h1>Modifier material</h1>
    <div class="container d-flex">
    <form method="post" enctype="multipart/form-data">
    <?php if (isset($materiel['image'])):  ?>
        <img src="<?php  echo $materiel['image'] ?>" alt="image elment" width="50px" height="35px">
    <?php endif; ?>

       
                <div class="row">
                <div class="col mt-3">
                  <label>Image</label><br>
                  <input type="file" class="form-control" name="image">
                </div>
                <div class="col mt-3">
                  <label>Model</label>
                  <input type="text" name="model" class="form-control"  value="<?php echo  $materiel['model']  ?>" required  >
                </div>
            </div>    
            <div class="row">
                <div class="col mt-3">
                <label>Catégorie</label>
                <input type="text"  name="categorie" class="form-control"  value="<?php echo  $materiel['categorie']  ?>" required>
                </div>
                <div class="col mt-3">
                <label>brand</label>
                <input type="text"  name="brand" class="form-control" value="<?php echo $materiel['brand'] ?>" required>
                </div>
            </div>    
            <div class="row">
                <div class="col mt-3">
                <label>Qty</label>
                <input type="number"  name="qty" class="form-control" value="<?php echo $materiel['qty']  ?>" required>
                </div>
                <div class="col mt-3">
                <label>Qty lef</label>
                <input type="number"  name="qty_lef" class="form-control" value="<?php echo  $materiel['qty_lef'] ?>" required>
                </div>
            </div>    
                    
            <div class="form-group md-3 mt-3">
                <label for="">Status</label>
                <input type="text" class="form-control" name="status" id="status" value="<?php echo  $materiel['status'] ?>" >
            </div>
               <button type="submit" class="btn btn-primary mt-3">Enregistrer</button>
            </form>
        </div>  
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
