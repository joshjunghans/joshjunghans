<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
	<title>istruct Admin</title> 
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="content-language" content="en-US" />
	<link id="template-style" href="style.css" media="all" rel="stylesheet" />
	<script type="text/javascript" id="jquery" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/check-installation-constants.js"></script>
</head>
<body class="install">

	<div id="wrap">
		
		<div id="header_wrap">
			<div id="header">
				<img id="logo" src="images/istruct-logo_86x25.png" title="istruct Admin" alt="istruct" />

				<ul class="menu">
					<li><a href="index.php" title="Admin Home" class="active">Admin Home</a></li>
					<li><a href="site.php" title="Manage Site Settings" class="inactive">Site</a></li>
					<li><a href="pages.php" title="Manage Pages" class="inactive">Pages</a></li>
					<li><a href="add-ons.php" title="Manage Add-ons" class="inactive">Add-ons</a></li>
					<li><a href="users.php" title="Manage Users" class="inactive">Users</a></li>
				</ul>

			</div><!-- #header -->
		</div><!-- #header_wrap -->

		
		<div id="container">
			<div id="content">
			<!-- Start Content -->

				<h1>Welcome To Your iStruct Interface!</h1>
				<p>Follow the instructions below to continue the installation process.</p>

				<hr />

				<div id="step1">
					<h2>Step 1: <small>Setup Database</small></h2>
					<p>We need to create a database that will hold all the fun stuff to run iStruct.  There are a number of ways to do this.  One of the easiest ways is to use <a href="http://www.phpmyadmin.net/" target="_blank">phpMyAdmin</a>, which is a database management tool.  Your web host may offer phpMyAdmin or cPanel.  Look into this before you try to install anything on your server.</p>
					<ol>
						<li>Create the database.  Name it whatever you would like, just remember what you named it.</li>
						<li>Create a new user.  Give them global permissions, meaning everything.  Write the username and password you just created.</li>
					</ol>
				</div>
				<div id="step2">
					<h2>Step 2: <small>Tell iStruct the database values</small></h2>
					<p>Navigate to <em>/[istruct location]/ws-framework/struct/</em> on your server and open up &quot;globals.php&quot; in a text editor.</p>
					<p>Edit lines 12-15.  What you are doing is defining constants that the iStruct system uses to connect to the database.  Enter in the necessary values.  See the comments next to each definition for further explanation.</p>
				</div>

				<div id="validate">
					<div id="response">
						<h3>Validating Database Credentials</h3>
						<ul>
							<li id="constants">Checking database constants</li>
							<li id="dbcon">Checking database connection</li>
						</ul>
					</div>
					<p style="text-align:center;padding-bottom:15px;">
						<a class="button large" id="validate_install">Validate Database Credentials</a>
					</p>
				</div>

			<!-- End Content -->
			</div><!-- #content -->
		</div><!-- #container -->

	</div><!-- #wrap -->

</body>
</html>
