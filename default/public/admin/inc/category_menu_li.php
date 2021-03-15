<?php $categories = $pdo->query('SELECT * FROM category');
		foreach ($categories as $category) {
				echo '<li><a href="../admin/job_by_category.php?category='.$category['id'].'&Title='.$category['name'].'">'.$category['name'].'</a></li>';
} ?>