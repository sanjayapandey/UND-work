<!DOCTYPE html>
<?php
	session_start();
	if(isset($_SESSION['username'])){
		header("Location: dashboard.php");
	}
?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Game Store</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="css/bootstrap.min.css">  
  <link rel="stylesheet" href="css/bookstore.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/ionicons.min.css">
  <link rel="stylesheet" href="css/skins/_all-skins.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>Game</b>Store
  </div>
  <div class="login-box-body">
    <p class="login-box-msg"><strong>Sign In</strong></p>

    <form id="loginForm" method="post">
	<div id="loginError" class="alert alert-danger" style="display:none"> Username or password incorrect, try again! </div>	  	
	
      <div class="form-group has-feedback">
        <input type="text" name="username" class="form-control" placeholder="User Name">
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-4">
          <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
	<div class="col-xs-4">
		<a href="signup.html" class="btn btn-block btn-flat"> Create new account </a> 
        </div>
      </div>
	<div class="row">
        <div class="col-xs-4">
        </div>
	<div class="col-xs-4">
		<a href="signup-developer.html" class="btn btn-block btn-flat"> Developer signup </a> 
        </div>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript">

$("#loginForm").submit(function(e) {

    var url = "http://people.aero.und.edu/~spandey/cgi-bin/513/1/login.cgi";
	
    $.ajax({
           type: "POST",
           url: url,
           data: $("#loginForm").serialize(), // serializes the form's elements.
           success: function(data)
           {	
		var arr = JSON.parse( data);
		if(arr[0].loggedIn=='true'){
			var userId = arr[0].userId;
			var userName = arr[0].userName;
			location.href = 'loginService.php?userId=' + userId + '&userName='+userName;		
		}else{
			$('#loginError').show();		
		}
	        }
         });
    e.preventDefault(); // avoid to execute the actual submit of the form.
});
</script>		
		  
</body>
</html>
