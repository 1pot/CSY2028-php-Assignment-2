<?php
try{
$pdo = new PDO('mysql:dbname=job;host=127.0.0.1', 'student', 'student', [PDO::ATTR_ERRMODE =>  PDO::ERRMODE_EXCEPTION ]);
} 
	catch (Exception $e){
		echo 'could not connect..';
		exit;
	}

?>