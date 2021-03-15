<ul>
	<li><a href="index.php">Home</a></li>
	<li>
		Jobs
		<ul>
			<?php include 'inc/category_menu_li.php'; ?>
		</ul>
	</li>

	<li><a href="../../about.php">About us</a></li>
	<li><a href="../../faqs.php">FAQs</a></li>
	<li>
        <?php if(isset($_SESSION['loggedin'])){?>
            <a href="../admin/logout.php">Logout</a>
        <?php } else{ ?>
            <a href="../admin/login_main.php">Login</a>
        <?php } ?>

    </li>
</ul>