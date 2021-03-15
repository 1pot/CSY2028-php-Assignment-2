<?php
session_start();
include 'connect.php';
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	//UPDATE TABLE SET COLUMN = VALUE, COLUMN = VALUE,.... WHERE CONDITION;
	try {
		$stmt = $pdo->prepare('Update job SET record_status = 1 , updated_by = :updated_by WHERE id = :id');
		$stmt->execute(
			[
				'id' => $_POST['id'],
				'updated_by' => $_SESSION['user_id'],

			]
		);
	} catch(PDOException $e) {
		echo '<div>'.$e->getMessage().'</div>'; // stylish div exception
	} catch(Error $e) {
		echo '<div>'.$e->getMessage().'</div>'; // stylish div exception
	}
	header('location: job_restore_list.php');
}


