
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
<body>
    <h1>Ajouter</h1>
       
   <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
            <div><?php echo $error ?></div>
        <?php endforeach; ?>
    </div>
<?php endif;?>

    <form method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label>Image</label><br>
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label>Model</label>
        <input type="text" name="model" class="form-control"  value="<?php echo $model ?>" required  >
    </div>
   
    <div class="form-group">
        <label>Catégorie</label>
        <input type="text"  name="categorie" class="form-control"  value="<?php echo $categorie ?>" required>
    </div>

    <div class="form-group">
        <label>brand</label>
        <input type="text"  name="brand" class="form-control"value="<?php echo $brand ?>" required>
    </div>

    <div class="form-group">
        <label>Qty</label>
        <input type="number"  name="qty" class="form-control" value="<?php echo $qty ?>" required>
    </div>
    <div class="form-group">
        <label>Qty lef</label>
        <input type="number"  name="qty_lef" class="form-control" value="<?php echo $qty_lef ?>" required>
    </div>
    <div class="form-group">
        <label>Status</label>
        <input type="text"  name="status" class="form-control" value="<?php echo $status ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>
</body>
</html>






