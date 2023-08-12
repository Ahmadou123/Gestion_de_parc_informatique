<?php
require_once "bd_conn.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $statement = $pdo->prepare('DELETE FROM stock WHERE id = :id');
    $statement->bindValue(':id', $_GET['id']);
    $statement->execute();

    header('Location: index.php');
}



?>
