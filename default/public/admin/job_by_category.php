<?php $pageTittle = "Jo's Jobs -".(isset($_GET['Title'])? $_GET['Title'] : '')." Jobs";
include '../admin/inc/admin_header.php' 
//echo $_GET['category'];
?> 

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

		<div style="width: 100%">
			<div class="pull-left" style="width: 100%">
				<h1><?php echo (isset($_GET['Title'])? $_GET['Title'] : ''); ?> Jobs</h1>
			</div>
			<div class="pull-right" style="width: 50%">
				<form action="job_by_category.php" method="POST">
					<label class="locLbl">Location</label>
					<select name="location">
						<option class="optionSel">Please select location</option>
					<?php $stmt = $pdo->prepare('select distinct location from job Where record_status = 1');
						$stmt->execute();
						foreach ($stmt as $row) {
							//posted value of filter form to show jobs by category
							if ($_POST['location'] == $row['location']) {
								echo '<option selected="selected" value="' . $row['location'] . '">' . $row['location'] . '</option>';
							} else {
								echo '<option value="' . $row['location'] . '">' . $row['location'] . '</option>';
							}
						} ?>
					</select>
					<input type="submit" name="submit" value="FILTER" />
				</form>
			</div>
		</div>
		<div style="width: 100%">
			<ul class="listing">
				<?php
				// To create listing of jobs by category 
				// dynamicall pass get parameter
				// named as category s
				$pdo = new PDO('mysql:dbname=job;host=127.0.0.1', 'student', 'student');
				// to select job by location lets create if to concate in query
				$quer_concat_string = '';
				if(isset($_POST['location'])){
					$quer_concat_string .= " AND location = '".$_POST['location']."'" ;
				}else if (isset($_GET['category'])) {
					$quer_concat_string .= ' AND categoryId = '.$_GET['category'];
				}
		
				$stmt = $pdo->prepare('SELECT * FROM job WHERE closingDate > :date AND record_status = 1 '. $quer_concat_string.' ORDER BY closingDate DESC LIMIT 10 ');
				$date = new DateTime();
				$values = ['date' => $date->format('Y-m-d')];
				$stmt->execute($values);
				foreach ($stmt as $job) {
					
					echo '<li>';
					echo '<div class="details">';
					echo '<h2>' . $job['title'] . '</h2>';
					echo '<h3>' . $job['salary'] . '</h3>';
					echo '<p>' . nl2br($job['description']) . '</p>';

					echo '<a class="more" href="/apply.php?id=' . $job['id'] . '">Apply for this job</a>';

					echo '</div>';
					echo '</li>';
				}?>
			</ul>
		</div>
	</section>
</main>	
<?php include '../admin/inc/admin_footer.php' ?>

