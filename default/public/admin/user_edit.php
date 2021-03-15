<?php session_start(); include 'connect.php'; $pageTittle = "Users - Edit User"; include '../admin/inc/admin_header.php' ?>
<section class="left">
	<?php include '../admin/inc/left_bar.php'; ?>
</section>
<section class="right">
<?php if (isset($_POST['submit'])) {
    //adding try catch so our app does not crash and dont show bad looking messages
    try{
        $date 		= new DateTime();
        $date_time 	= $date->format('Y-m-d H:i:s');
        
        $stmt = $pdo->prepare('
            UPDATE users SET 
                    first_name 			= :first_name, 
                    last_name 			= :last_name, 
                    username 			= :username, 
                    contact_number 		= :contact_number, 
                    email_address 		= :email_address, 
                    login_password 		= :login_password, 
                    user_type_id 		= :user_type_id, 
                    record_status		= :record_status,
                    created_date_time 	= :created_date_time, 
                    updated_date_time 	= :updated_date_time 
            WHERE user_id = :user_id'
        );
        $criteria = [
                'first_name' 		=> $_POST['first_name'],
                'last_name' 		=> $_POST['last_name'],
                'username' 			=> $_POST['username'],
                'contact_number'	=> $_POST['contact_number'],
                'email_address' 	=> $_POST['email_address'],
                'login_password'	=> $_POST['login_password'],
                'user_type_id' 		=> $_POST['user_type_id'],
                'record_status'		=> '1',
                'created_date_time'	=> '2020-04-21 18:26:01',
                'updated_date_time'	=> '2020-04-21 18:26:01',
                'user_id'			=> $_POST['user_id']
        ];
        $stmt->execute($criteria);
    } catch(PDOException $e) {
        //add a div so it looks stylish 
        echo  '<div>'.$e->getMessage().'</div>';
    } catch(Error $e) {
        //add a div so it looks stylish 
        echo  '<div>'.$e->getMessage().'</div>';
    }
    header("Location: https://v.je/admin/index.php");
} else {
    if (((isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) && (isset($_SESSION['user_type_id']) && $_SESSION['user_type_id'] == 1)){
        try {
            $stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = :id');
            $stmt->execute($_GET);
            $user = $stmt->fetch();
        } catch(PDOException $e) {
            echo '<div>'.$e->getMessage().'</div>';
        } catch(Error $e) {
            echo '<div>'.$e->getMessage().'</div>';
        }?>
        <h2>Edit User</h2>
        <form action="user_edit.php" method="POST"">
            <label>First Name</label>
            <input type="text" name="first_name" value="<?php echo $user['first_name']; ?>" />
            <label>Last Name</label>
            <input type="text" name="last_name" value="<?php echo $user['last_name']; ?>"/>
            <label>UserName</label>
            <input type="text" name="username" value="<?php echo $user['username']; ?>"/>
            <label>Contact</label>
            <input type="text" name="contact_number" value="<?php echo $user['contact_number']; ?>"/>
            <label>Email</label>
            <input type="text" name="email_address" value="<?php echo $user['email_address']; ?>"/>
            <label>Password</label>
            <input type="password" name="login_password" value="<?php echo $user['first_name']; ?>"/>
            <label>User Role</label>
            <select name="user_type_id">
            <?php try {
                $stmt = $pdo->prepare('SELECT * FROM user_types WHERE record_status = 1');
                $stmt->execute();
                echo '<option value="">Please select user role</option>';
                foreach ($stmt as $row) {
                    $selected = '';
                    if ($user['user_type_id'] == $row['user_type_id']) {
                        $selected = 'selected="selected" ';
                    }
                    echo '<option value="' . $row['user_type_id'] . '" ' . $selected . '>' . $row['title'] . '</option>';
                }
            } catch(PDOException $e) {
                echo '<div>'.$e->getMessage().'</div>'; 
            } catch(Error $e) {
                echo '<div>'.$e->getMessage().'</div>'; 
            } ?>
            </select>
            <!-- always add hidden fields right before submit button -->
            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>" />
            <input type="submit" name="submit" value="Update" />
        </form>
<?php } else { ?>
        <h2>Log in</h2>
        <?php include 'login.php'; ?>
    <?php }
} ?>
</section>
</main>
<?php include 'inc/admin_footer.php' ?>
