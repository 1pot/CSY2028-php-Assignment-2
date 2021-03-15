<?php
session_start();
include 'connect.php';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

	//UPDATE TABLE SET COLUMN = VALUE, COLUMN = VALUE,.... WHERE CONDITION;
	$stmt = $pdo->prepare('Update job SET record_status = 2 WHERE id = :id');
	$stmt->execute(['id' => $_POST['id']]);


	header('location: jobs.php');
}


