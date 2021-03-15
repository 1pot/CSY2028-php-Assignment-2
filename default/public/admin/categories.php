<?php session_start();
include 'connect.php';
$pageTittle = "Jo's Jobs - Categories";
include 'inc/admin_header.php' ?>
	<section class="left">
		<ul>
			<li><a href="jobs.php">Jobs</a></li>
			<li><a href="categories.php">Categories</a></li>
			<li >
				<ul style="margin-left: 10px;">
					<?php include '../admin/inc/category_menu_li.php'; ?>
				</ul>
			</li>
		</ul>
	</section>
	<section class="right">

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {?>
			<h2>Categories</h2>
			<?php echo (((isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) && 
						(isset($_SESSION['user_type_id']) && ($_SESSION['user_type_id'] == 1 || $_SESSION['user_type_id'] == 2)) ? 
						'<a class="new" href="addcategory.php">Add new category</a>': '' ); ?>
			<?php
			echo '<table>';
			echo '<thead>';
			echo '<tr>';
			echo '<th>Name</th>';
			echo '<th style="width: 5%">&nbsp;</th>';
			echo '<th style="width: 5%">&nbsp;</th>';
			echo '</tr>';

			$categories = $pdo->query('SELECT * FROM category');

			foreach ($categories as $category) {
				echo '<tr>';
				echo '<td>' . $category['name'] . '</td>';
				// Role base button permission
				echo (
						((isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) && 
						(isset($_SESSION['user_type_id']) && ($_SESSION['user_type_id'] == 1 || $_SESSION['user_type_id'] == 2)) ? 
						'<td><a style="float: right" href="editcategory.php?id=' . $category['id'] . '">Edit</a></td>': '' );
				echo '<td><form method="post" action="deletecategory.php">';
				echo '<input type="hidden" name="id" value="' . $category['id'] . '" />';
				// Role base button permission
				echo (
						((isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) && 
						(isset($_SESSION['user_type_id']) && ($_SESSION['user_type_id'] == 1 || $_SESSION['user_type_id'] == 2)) ? 
						'<input type="submit" name="submit" value="Delete" />': '');
				echo '</form></td>';
				echo '</tr>';
			}

			echo '</thead>';
			echo '</table>';

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
	?>

</section>
	</main>

<?php include 'inc/admin_footer.php' ?>

