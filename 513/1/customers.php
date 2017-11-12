<!DOCTYPE html>
<html>
<?php
session_start();
if(!isset($_SESSION['username'])){
	header("Location: login.php");
}
?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Game Store- Games</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="css/bootstrap.min.css">  
  <link rel="stylesheet" href="css/bookstore.css">
  <link rel="stylesheet" href="css/my-css.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/ionicons.min.css">
  <link rel="stylesheet" href="css/skins/_all-skins.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
</head>

<script>
   var xmlhttp = new XMLHttpRequest( );
   var url = "../../cgi-bin/513/1/customers.cgi";
   xmlhttp.onreadystatechange = function( ) {
    if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) {
     myFunction( xmlhttp.responseText );
    }
   }
   xmlhttp.open( "GET", url, true );
   xmlhttp.send( );

  function myFunction( response ) {
    var arr = JSON.parse( response );
    var i;
    var out  = "<table class='table table-bordered'><tr><th>Customer Id</th>" +
               "<th>Customer Name</th></tr>";
    for ( i = 0; i < arr.length; i++ ) {
     out += "<tr><td>"  + arr[i].id +
            "</td><td> <a href='view-customer.php?id="+ arr[i].id +"'>" + arr[i].name + "</a>"+
            "</td></tr>";
    }
    out += "</table>"
    document.getElementById( "customer-table" ).innerHTML = out;
   }

</script>

<body>
<div id="wrapper">
 <!-- Sidebar -->
        
</div>
<div class="container">
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-7">
				<div class="login-logo">
					<b>Game </b>Store
				</div>
			</div>
			<div class="col-sm-3">
		        <div class="pull-right">
			  	<a href = "view-customer.php?id=<?php echo $_SESSION['userid']?>"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp; <strong><?php echo $_SESSION['username']?></strong></a>&nbsp;&nbsp;&nbsp;
			  	 <a href="logout.php" class="btn btn-danger btn-flat"> Logout </a>
			  	</div>
			  </div>
		</div>
		<!-- Small boxes (Stat box) -->
		  <div class="row">
			<div class="col-sm-2">
				<div id="sidebar-wrapper">
					<ul class="sidebar-nav">
						<li><a href="dashboard.php">Dashboard</a>
						</li>
						 <?php if($_SESSION['username'] == 'admin'){?>
						<li><a href="game-list.php">Games</a>
						</li>
						<li><a href="customers.php">Customer</a>
						</li>
						<li><a href="developer.php">Developer</a>
						</li>
						<?php }?>
					</ul>
				</div>
			</div>
			<div class="col-sm-8">
			<h2>List Customers</h2>
			<div class="row">
				<div id="customer-table">
			</div>
			   
		    </div>
		  </div>
		   
		 </div>
</body>
</html>
