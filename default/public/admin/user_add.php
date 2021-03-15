<?php session_start(); include 'connect.php'; $pageTittle = "Users - Add User"; include '../admin/inc/admin_header.php' ?>
<section class="left">
	<?php include '../admin/inc/left_bar.php'; ?>
</section>
<section class="right">
    <!--	Login user with admin / as user type 1 -->
	<?php if (((isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) && (isset($_SESSION['user_type_id']) && $_SESSION['user_type_id'] == 1)) {
		if (isset($_POST['submit'])) {
			try {
				$date 		= new DateTime();
				$date_time 	= $date->format('Y-m-d H:i:s');
				$stmt = $pdo->prepare('INSERT INTO users (first_name, last_name, username, contact_number, email_address, login_password, user_type_id, record_status, created_date_time, updated_date_time) 
				VALUES (:first_name, :last_name, :username, :contact_number, :email_address, :login_password, :user_type_id,
				:record_status, :created_date_time, :updated_date_time)');
				$date = new DateTime();
				$date_time= $date->format('Y-m-d H:i:s');
				$criteria = [
					'first_name' 		=> $_POST['first_name'],
					'last_name' 		=> $_POST['last_name'],
					'username' 			=> $_POST['username'],
					'contact_number'	=> $_POST['contact_number'],
					'email_address' 	=> $_POST['email_address'],
					'login_password'	=> $_POST['login_password'],
					'user_type_id' 		=> $_POST['user_type_id'],
					'record_status'		=> '1',
					'created_date_time'	=> "'".$date_time."'",
					'updated_date_time'	=> "'".$date_time."'",
				];
				$stmt->execute($criteria);
			} catch(PDOException $e) {
      			echo '<div>'.$e->getMessage().'</div>'; 
  			} catch(Error $e) {
                echo '<div>'.$e->getMessage().'</div>';
            }
			    header("Location: https://v.je/admin/index.php");
        } else { ?>
		
		<h2>Add Job</h2>
		<form action="user_add.php" method="POST"">
			<label>First Name</label>
			<input type="text" name="first_name" />
			<label>Last Name</label>
			<input type="text" name="last_name" />
			<label>UserName</label>
			<input type="text" name="username" />
			<label>Contact</label>
			<input type="text" name="contact_number" />
			<label>Email</label>
			<input type="text" name="email_address" />
			<label>Password</label>
			<input type="password" name="login_password" />
			<label>User Role</label>
			<select name="user_type_id">
			<?php try {
                $stmt = $pdo->prepare('SELECT * FROM user_types WHERE record_status = 1');
                $stmt->execute();
                echo '<option value="">Please select user role</option>';
                foreach ($stmt as $row) {
                    echo '<option value="' . $row['user_type_id'] . '">' . $row['title'] . '</option>';
                }
            } catch(PDOException $e) {
                echo '<div>'.$e->getMessage().'</div>';
            } catch(Error $e) {
                echo '<div>'.$e->getMessage().'</div>';
            } ?>
			</select>
			<input type="submit" name="submit" value="Add" />
		</form>
        <?php }
	} else { ?>
		<h2>Log in</h2>
		<?php include 'login.php'; ?>
	<?php } ?>
</section>
	</main>
<?php include '../admin/inc/admin_footer.php'; ?>


