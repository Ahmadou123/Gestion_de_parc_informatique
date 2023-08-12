<?php
require_once "bd_conn.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $statement = $pdo->prepare('DELETE FROM materiel WHERE id = :id');
    $statement->bindValue(':id', $_GET['id']);
    $statement->execute();

    header('Location: index.php');
}



?>
