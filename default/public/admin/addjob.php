<?php session_start(); include 'connect.php'; $pageTittle = "Jo's Jobs - Add Job"; include 'inc/admin_header.php' ?>
<section class="left">
    <ul>
        <li><a href="jobs.php">Jobs</a></li>
        <li><a href="categories.php">Categories</a></li>
    </ul>
</section>
<section class="right">
<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    if (isset($_POST['submit'])) {
        try {
            $stmt = $pdo->prepare('INSERT INTO job (title, description, salary, location, closingDate, categoryId, created_by, updated_by)
                           VALUES (:title, :description, :salary, :location, :closingDate, :categoryId, :created_by, :updated_by)');
            $criteria = [
                'title' 		=> $_POST['title'],
                'description' 	=> $_POST['description'],
                'salary' 		=> $_POST['salary'],
                'location' 		=> $_POST['location'],
                'categoryId' 	=> $_POST['categoryId'],
                'closingDate' 	=> $_POST['closingDate'],
                'created_by' 	=> $_SESSION['user_id'],
                'updated_by' 	=> $_SESSION['user_id'],
            ];
            $stmt->execute($criteria);
            
        } catch(PDOException $e) {
            echo  $e->getMessage(); 

        }
        header("Location: https://v.je/admin/jobs.php");
	}
	else { ?>
			<h2>Add Job</h2>
			<form action="addjob.php" method="POST"">
				<label>Title</label>
				<input type="text" name="title" />
				<label>Description</label>
				<textarea name="description"></textarea>
				<label>Salary</label>
				<input type="text" name="salary" />
				<label>Location</label>
				<input type="text" name="location" />
				<label>Category</label>
				<select name="categoryId">
				<?php try {
					$stmt = $pdo->prepare('SELECT * FROM category');
					$stmt->execute();

					foreach ($stmt as $row) {
						echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
					}
				} catch(PDOException $e) {
					echo '<div>'.$e->getMessage().'</div>'; // stylish div exception
				} catch(Error $e) {
					echo '<div>'.$e->getMessage().'</div>'; // stylish div exception
				}?>
				</select>
				<label>Closing Date</label>
				<input type="date" name="closingDate" />
				<input type="submit" name="submit" value="Add" />
			</form>
		<?php
		}
	} else {?>
        <h2>Log in</h2>
        <?php include 'login.php'; ?>
<?php } ?>
</section>
</main>
<?php include 'inc/admin_footer.php'; ?>


