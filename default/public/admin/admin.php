<?php

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	header('Location: index.php');
}
include 'connect.php';

if (isset($_POST['submit'])) {

		$stmt = $pdo->prepare('SELECT * FROM admin WHERE username = :username AND password = :password');  

	    $criteria = [
	        'username' => $_POST['username'],
	        'password' => md5($_POST['password']),
	    ];

	    $stmt->execute($criteria);
	    $row = $stmt->fetch();

        //Check they entered the correct username/password
        if ($_POST['username'] === $row['username'] && $_POST['password'] === $row['password']) {
              $_SESSION['loggedin'] = true;
                header('Location: index.php');
        }
        //If they didn't, display an error message
        else { 
                echo "Wrong Password"; 
        }
}
else { //The submit button was not pressed, show the log-in form
?>
<h2>Log in</h2>
    <form action="admin.php" method="post" style="padding: 40px">

      <label>Enter Username</label>
      <input type="text" name="username" /> 
      <label>Enter Password</label>
      <input type="password" name="password" />

      <input type="submit" name="submit" value="Log In" />
    </form>
<?php
}