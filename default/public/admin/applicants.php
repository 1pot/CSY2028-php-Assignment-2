<?php
session_start();
include 'connect.php';
$pageTittle = "Jo's Jobs - Applicants";
include 'inc/admin_header.php'
?>
	
	<main class="sidebar">

	<section class="left">
		<ul>
			<li><a href="jobs.php">Jobs</a></li>
			<li><a href="categories.php">Categories</a></li>
		</ul>
	</section>
	<section class="right">

	<?php

		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

			$stmt = $pdo->prepare('SELECT * FROM job WHERE id = :id');

			$stmt->execute(['id' => $_GET['id']]);

			$job = $stmt->fetch();
		?>


			<h2>Applicants for <?=$job['title'];?></h2>

			<?php
			echo '<table>';
			echo '<thead>';
			echo '<tr>';
			echo '<th style="width: 10%">Name</th>';
			echo '<th style="width: 10%">Email</th>';
			echo '<th style="width: 65%">Details</th>';
			echo '<th style="width: 15%">CV</th>';
			echo '</tr>';

			$stmt = $pdo->prepare('SELECT * FROM applicants WHERE jobId = :id');

			$stmt->execute(['id' => $_GET['id']]);

			foreach ($stmt as $applicant) {
				echo '<tr>';
				echo '<td>' . $applicant['name'] . '</td>';
				echo '<td>' . $applicant['email'] . '</td>';
				echo '<td>' . $applicant['details'] . '</td>';
				echo '<td><a href="/cvs/' . $applicant['cv'] . '">Download CV</a></td>';
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


