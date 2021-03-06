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
   var url = "../../cgi-bin/513/1/games.cgi";
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
    var out  = "<table class='table table-bordered'><tr><th>ASIN</th>" +
               "<th>Title</th>" +
	       "<th>Developers</th>" +
	       "<th>Price</th>" +
               "<th>Update Price</th></tr>";
    for ( i = 0; i < arr.length; i++ ) {
     out += "<tr><td>"  + arr[i].ASIN +
            "</td><td> <a href='view-game.php?ISBN="+ arr[i].ASIN +"'>" + arr[i].title + "</a>"+
	     "</td><td>" + arr[i].developer +
            "</td><td>" + arr[i].price +
	    "</td><td><input type='hidden' name='keys'  value='"+arr[i].ASIN+"'><input type=number name='prices' value="+arr[i].price+">"+ 
            "</td></tr>";
    }
    out += "</table>"
    document.getElementById( "game-table" ).innerHTML = out;
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
			<a href="add-game.php" class="btn btn-primary btn-flat pull-right" style="border-radius: 50%;"> Add New Game </a>
			<h3>List Games</h3>
			<div class="row">
				<div id="purchaseSuccess" class="alert alert-success" style="display:none"> Price updated successfully. </div>
			  	<div id="purchaseError" class="alert alert-danger" style="display:none"> Something went wrong, try again ! </div>
				<form id="updatePrice" class="form-horizontal" method="post">
				<div id="game-table"></div>
				 	<div class="row">
					<div class="col-sm-12 box">
						<div class="pull-right">
						<input type="hidden" name="action" value="updatePrice">
						<input type="submit" class="btn btn-primary " name="submit" value="Update game price">	
						</div>				
					  </div>
					</div>
				</form>
			</div>

			</div>
			   
		    </div>
		  </div>
		   
		 </div>
</body>
<script type="text/javascript">
$("#updatePrice").submit(function(e) {
    var url = "../../cgi-bin/513/1/updatePrice.cgi";
	
    $.ajax({
           type: "POST",
           url: url,
           data: $("#updatePrice").serialize(), // serializes the form's elements.
           success: function(data)
           {	
		var arr = JSON.parse( data);		
		if(arr[0].success === "true"){
			
			$("#purchaseSuccess").show();
		}else{
			$("#purchaseError").show();
		}
				
	    }
         });
    e.preventDefault(); // avoid to execute the actual submit of the form.
});
</script>
</html>
