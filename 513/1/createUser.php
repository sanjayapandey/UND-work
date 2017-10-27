<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Game Store</title>
<meta
	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
	name="viewport">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bookstore.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/ionicons.min.css">
<link rel="stylesheet" href="css/skins/_all-skins.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="login-logo">
			<b>Game</b>Store
		</div>
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-lg-9">
				<div class="box">
					<div class="box-header">
						<?php
						include("config.php");

						//collect data
						$firstName=$_POST['firstName'];
						$lastName=$_POST['lastName'];
						$userName=$_POST['userName'];
						$password=$_POST['password'];
						$role=$_POST['role'];
						if($firstName != '' && $lastName != '' && $userName != '' && $password != '' && $role != ''){
					  // Compose the query.
					  $query  = "INSERT INTO customer (first_name, middle_name,last_name, user_name, password,phone_number) VALUES('$firstName','$middleName','$lastName','$userName','$password','$phoneNumber')";
					
					 if (mysql_query($query)) {?>
						<h1>Success!!!</h1>
						<br> Welcome
						<strong><?php echo $_POST["firstName"]; ?></strong>
						Your account is successfully created, you can login to application
						by clicking following button.      <a href="login.php"
							class="btn btn-primary"> Login </a><br>
						<?php
						} else {
						    echo "Error: " . $query . "<br>" . mysql_error($conn);
						}
						
						// Close the database.
						mysql_close( );
						}else{
						echo "Name or username or password can't be empty. Try again! ";
						?>
												<br><a href="signup.html" class="btn btn-primary"> Back to
													Signup </a>
												<?php
						}
						?>

						<br /> <br />
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
