<?php session_start(); $pageTittle = "Jo's Jobs - Admin Home"; include 'inc/admin_header.php' ?>
	<!-- check user login -->
	<?php if (isset($_POST['submit'])) {
		try {
			$stmt = $pdo->prepare('SELECT username, login_password, user_type_id, user_id  FROM users WHERE username = :username AND login_password = :login_password');
			$criteria = [
				'username' => $_POST['username'],
				'login_password' => $_POST['login_password'],
			];
			$stmt->execute($criteria);
			$row = $stmt->fetch();
			//Check they entered the correct username/password
			if ($_POST['username'] === $row['username'] && $_POST['login_password'] === $row['login_password']) {
				$_SESSION['user_id'] = $row['user_id'];
				$_SESSION['user_type_id'] = $row['user_type_id'];
				$_SESSION['loggedin'] = true;
				header("Location: https://v.je/admin/index.php");
			} else {
				//If they didn't, display an error message
				echo "Wrong Username or Passowrd";
			}
		} catch(PDOException $e) {
			echo '<div>'.$e->getMessage().'</div>'; // stylish div exception
		} catch(Error $e) {
			echo '<div>'.$e->getMessage().'</div>'; // stylish div exception
		}
	}
	// Login user with admin / 1 as user type
	if ((isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) { ?>
		<section class="left">
			<?php include '../admin/inc/left_bar.php'; ?>
		</section>
		<!-- Closing left bar -->
		<?php if((isset($_SESSION['user_type_id']) && $_SESSION['user_type_id'] == 1)){ ?>
			<section class="right">
				<?php include '../admin/users.php'; ?>
			</section>
		<?php } else if ( isset($_SESSION['user_type_id']) && $_SESSION['user_type_id'] == 2 ) { 
			header('Location: https://v.je/admin/jobs.php');
		} else{ 
			header('Location: https://v.je/admin/jobs.php');
		} ?>
	<?php } else { ?>
		<h2>Log in</h2>
		<?php include '../admin/login.php'; ?>
	<?php } ?>
	</section>
	</main>

<?php include 'inc/admin_footer.php' ?>

