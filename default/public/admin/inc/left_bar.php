<ul>
	<?php if(isset($_SESSION['user_type_id']) &&  $_SESSION['user_type_id'] == 1){ ?>
		<li><a href="index.php">Users</a></li>
	<?php } ?>
	<li><a href="jobs.php">Jobs</a></li>
	<?php if( isset($_SESSION['user_type_id']) && ( $_SESSION['user_type_id'] == 1 || $_SESSION['user_type_id'] == 2)){ ?>
		<li style="margin-left: 10px;"><a href="job_restore_list.php">Restore Jobs</a></li>
	<?php } ?>
	<li><a href="categories.php">Categories</a></li>
	<li >
		<ul style="margin-left: 10px;">
			<?php include '../admin/inc/category_menu_li.php'; ?>
		</ul>
	</li>
</ul>
