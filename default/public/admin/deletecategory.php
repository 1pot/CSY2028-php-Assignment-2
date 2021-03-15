<?php
session_start();
include 'connect.php';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	// deleting category by id
	$stmt = $pdo->prepare('DELETE FROM category WHERE id = :id');
	$stmt->execute(['id' => $_POST['id']]);


	header('location: categories.php');
}


