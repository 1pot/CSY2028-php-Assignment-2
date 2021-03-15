<?php
session_start();
include 'connect.php';
$pageTittle = "Jo's Jobs - Edit Job";
include 'inc/admin_header.php'
?>

	<section class="left">
		<ul>
			<li><a href="jobs.php">Jobs</a></li>
			<li><a href="categories.php">Categories</a></li>
		</ul>
	</section>
	<section class="right">

	<?php


	if (isset($_POST['submit'])) {
		try {
			$stmt = $pdo->prepare('UPDATE job
								SET title = :title,
								    description = :description,
								    salary = :salary,
								    location = :location,
								    categoryId = :categoryId,
								    closingDate = :closingDate,
								    updated_by = :updated_by
								   WHERE id = :id
						');

			$criteria = [
				'title' 		=> $_POST['title'],
				'description'	=> $_POST['description'],
				'salary' 		=> $_POST['salary'],
				'location' 		=> $_POST['location'],
				'categoryId' 	=> $_POST['categoryId'],
				'closingDate' 	=> $_POST['closingDate'],
				'updated_by'	=> $_SESSION['user_id'],
				'id' 			=> $_POST['id']
			];

			$stmt->execute($criteria);
		} catch(PDOException $e) {
			echo '<div>'.$e->getMessage().'</div>';// stylish div exception
		}

		echo 'Job saved';
	}
	else {
		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
			try {
				$stmt = $pdo->prepare('SELECT * FROM job WHERE id = :id');
				$stmt->execute($_GET);
				$job = $stmt->fetch();
			} catch(PDOException $e) {
				echo '<div>'.$e->getMessage().'</div>'; 
			} catch(Error $e) {
				echo '<div>'.$e->getMessage().'</div>'; 
			} ?>

			<h2>Edit Job</h2>

			<form action="editjob.php" method="POST">

				<input type="hidden" name="id" value="<?php echo $job['id']; ?>" />
				<label>Title</label>
				<input type="text" name="title" value="<?php echo $job['title']; ?>" />

				<label>Description</label>
				<textarea name="description"><?php echo $job['description']; ?></textarea>

				<label>Location</label>
				<input type="text" name="location" value="<?php echo $job['location']; ?>" />


				<label>Salary</label>
				<input type="text" name="salary" value="<?php echo $job['salary']; ?>" />

				<label>Category</label>

				<select name="categoryId">
				<?php try {
					$stmt = $pdo->prepare('SELECT * FROM category');
					$stmt->execute();

					foreach ($stmt as $row) {
						if ($job['categoryId'] == $row['id']) {
							echo '<option selected="selected" value="' . $row['id'] . '">' . $row['name'] . '</option>';
						} else {
							echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
						}

					}
				} catch(PDOException $e) {
					echo '<div>'.$e->getMessage().'</div>'; 
				} catch(Error $e) {
					echo '<div>'.$e->getMessage().'</div>'; 
				}?>

				</select>

				<label>Closing Date</label>
				<input type="date" name="closingDate" value="<?php echo $job['closingDate']; ?>"  />

				<input type="submit" name="submit" value="Save" />

			</form>

		<?php
		}

		else {
			?>
			<h2>Log in</h2>

			<form action="index.php" method="post">

				<label>Password</label>
				<input type="password" name="password" />

				<input type="submit" name="submit" value="Log In" />
			</form>
		<?php
		}

	}
	?>

</section>
	</main>
<?php include 'inc/admin_footer.php' ?>
