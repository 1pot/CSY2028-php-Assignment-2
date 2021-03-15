<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="css/styles.css"/>
		<title> <?php echo $pageTittle; ?> </title>
	</head>
	<body>
<header>
		<section>
			<aside>
				<h3>Office Hours:</h3>
				<p>Mon-Fri: 09:00-17:30</p>
				<p>Sat: 09:00-17:00</p>
				<p>Sun: Closed</p>
			</aside>
			<h1>Jo's Jobs</h1>
		</section>
	</header>
	<nav>
		<ul>
			<li><a href="index.php">Home</a></li>
			<li>Jobs
				<ul>
					<?php include 'category_menu_li.php'; ?>
				</ul>
			</li>
			<li><a href="about.php">About Us</a></li>
			<li><a href="faqs.php">FAQS</a></li>
			<li><a href="admin/index.php">Restricted Area</a></li>
		</ul>
	</nav>
	<img src="images/randombanner.php"/>