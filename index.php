
<?php
require_once "bd_conn.php";

$search = $_GET['search'] ?? '';
if ($search){
  $statement = $pdo->prepare('SELECT * FROM materiel WHERE model LIKE :model ORDER BY id DESC');
  $statement ->bindValue(':model',"%$search%");

}else{
  $statement = $pdo->prepare('SELECT * FROM materiel ');
}
$statement->execute();
$materiel = $statement->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1f1c7c4ddf.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="index.css">
    <title>PHP CRUD Application</title>
</head>
<body>
<div class="container mt-5">
        <h3 class="mb-4">Liste des materiels</h3>
        <form action="">
 <div class="input-group mb-3">
  <input type="text" class="form-control" placeholder="Rechercher un materiel" name="search" value="<?php echo $search ?>">
  <button class="btn btn-outline-success" type="submit">Rechercher</button>
</div>
 </form>
        <a href="create.php" class="btn btn-success mb-3">Add new</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Model</th>
                    <th>Categorie</th>
                    <th>Marque</th>
                    <th>Quantité</th>
                    <th>Quantité Restante</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
        <tbody>

            <?php foreach ($materiel as $id => $materiel): ?>
            <tr>
                <th scope="row"><?php echo $id + 1  ?></th>
                <td>
                <img src="<?php echo $materiel['image'] ?>" alt="image produits" class="thumb-image" width="50px" height="35px">
                </td>
                <td> <?php echo $materiel['model'] ?> </td>
                <td> <?php echo $materiel['categorie'] ?> </td>
                <td> <?php echo $materiel['brand'] ?> </td>
                <td> <?php echo $materiel['qty'] ?> </td>
                <td> <?php echo $materiel['qty_lef'] ?> </td>
                <td> <?php echo $materiel['status'] ?> </td>
                <td>
            <div style="display: flex;">
               <a href="update.php?id=<?php echo $materiel['id']; ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
              <a href="delete.php?id=<?php echo $materiel['id']; ?>" class="link-dark"><i class="fa-solid fa-trash fs-5 me-3"></i></a>
        </div>
       </td>
       </tr>
      <?php endforeach; ?>
       </tbody>
    </table>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>