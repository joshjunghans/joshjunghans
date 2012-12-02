<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
	<title>istruct Admin Login</title> 
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="content-language" content="en-US" />
	<link id="template-style" href="style.css" media="all" rel="stylesheet" />
	<script type="text/javascript" id="jquery" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/process-login.js"></script>
</head>
<body class="login">

	<div id="wrap">
		
		<div id="container">
			<div id="content">
			<!-- Start Content -->
				<img id="logo" src="images/istruct-logo_159x46.png" title="istruct Admin" alt="istruct" />
				<div class="errors"></div>
				<form method="post" action="func/process-login.php">
					<p>
						<label for="User_Email">Email:</label>
						<input type="text" id="User_Email" name="User_Email" />
					</p>
					<p>
						<label for="User_Pass">Password:</label>
						<input type="password" id="User_Pass" name="User_Pass" />
					</p>
					<hr style="float:none;clear:both;" />
					<p style="text-align:center;padding-bottom:15px;">
						<input type="submit" class="button large" value="Login" id="login" />
					</p>
				</form>

			<!-- End Content -->
			</div><!-- #content -->
		</div><!-- #container -->

	</div><!-- #wrap -->

</body>
</html>
