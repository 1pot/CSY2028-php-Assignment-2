<?php 
$pageTittle = "Jo's Jobs - Contact";
include 'inc/header.php' ?> 

	<main class="home">
		
		<h2>Contact Page</h2>
		<section>
			<aside>
				<h3>Telephone Number</h3>
				<p>669966996699</p>
				<h3>Email Address</h3>
				<p>Jo@jobs.com</p>
			</aside>
		</section>
			
		<form action="" method="post" style="padding: 40px">
			<h2>Fill in the information</h2>
			<label>Name</label>
			<input type="text" name="name" />  
			<label>Email</label>	
			<input type="text" name="email" /> 
			<label>Phone Number</label>
			<input type="text" name="name" /> 
			<input type="submit" name="submit" value="send" />
		</form>
	</main>

<?php include 'inc/footer.php' ?>