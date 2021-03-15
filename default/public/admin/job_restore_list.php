<?php
session_start();
include 'connect.php';
$pageTittle = "Jo's Jobs - Job list";
include 'inc/admin_header.php'
?>

<section class="left">
	<?php include '../admin/inc/left_bar.php'; ?>
</section>

	<section class="right">

	<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
		<h2>Restore Jobs</h2>
        <!--	Adding try catch block so we can render any exception in our custom way  hence it does not look bad to end user.Also we can maintain our interface the way we like it to be.	-->
        <?php try {
			echo '<table>';
			echo '<thead>';
			echo '<tr>';
			echo '<th>Title</th>';
			echo '<th style="width: 15%">Salary</th>';
			echo '<th style="width: 10%">&nbsp;</th>';
			echo '<th style="width: 15%">&nbsp;</th>';
			echo '<th style="width: 5%">&nbsp;</th>';
			echo '<th style="width: 5%">&nbsp;</th>';
			echo '</tr>';
			$stmt = $pdo->query('SELECT * FROM job WHERE record_status = 2  ORDER BY closingDate DESC LIMIT 10 ');

			foreach ($stmt as $job) {
				$applicants = $pdo->prepare('SELECT count(*) as count FROM applicants WHERE jobId = :jobId');

				$applicants->execute(['jobId' => $job['id']]);

				$applicantCount = $applicants->fetch();

				echo '<tr>';
				echo '<td>' . $job['title'] . '</td>';
				echo '<td>' . $job['salary'] . '</td>';
				echo '<td><a style="float: right" href="editjob.php?id=' . $job['id'] . '">Edit</a></td>';
				echo '<td><a style="float: right" href="applicants.php?id=' . $job['id'] . '">View applicants (' . $applicantCount['count'] . ')</a></td>';
				echo '<td><form method="post" action="job_restore.php">
				<input type="hidden" name="id" value="' . $job['id'] . '" />
				<input type="submit" name="submit" value="Restore" />
				</form></td>';
				echo '</tr>';
			}

			echo '</thead>';
			echo '</table>';
		} catch(PDOException $e) {
			echo '<div>'.$e->getMessage().'</div>'; // stylish div exception
		} catch(Error $e) {
			echo '<div>'.$e->getMessage().'</div>'; // stylish div exception
		}
	}
		else {
			?>
			<h2>Please Log in</h2>

			<form action="index.php" method="post">
				<label>Enter Username</label>
				<input type="text" name="username" />
				<label>Password</label>
				<input type="password" name="login_password" />

				<input type="submit" name="submit" value="Log In" />
			</form>

		<?php
		}
	?>

</section>
	</main>

<?php include 'inc/admin_footer.php' ?>
