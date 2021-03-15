<?php session_start(); include 'connect.php';
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	// UPDATE TABLE SET COLUMN = VALUE, COLUMN = VALUE,.... WHERE CONDITION;
	try {
		$date 		= new DateTime();
		$date_time 	= $date->format('Y-m-d H:i:s');
		// use proper indentation so code look clean
		$stmt = $pdo->prepare('
				UPDATE users SET 
						record_status		= :record_status,
						updated_date_time 	= :updated_date_time 
				WHERE user_id = :user_id'
		);
		$criteria = [
			'user_id'		    => $_POST['id'],
			'record_status'		=> '2',
			'updated_date_time'	=> "'".$date_time."'",
		];
		$stmt->execute($criteria);

		$stmt = $pdo->prepare('Update job SET record_status = 2 WHERE id = :id');
		$stmt->execute(['id' => $_POST['id']]);
	} catch(PDOException $e) {
		echo '<div>'.$e->getMessage().'</div>';
	} catch(Error $e) {
        echo '<div>'.$e->getMessage().'</div>';
    }
	header('location: index.php');
}


