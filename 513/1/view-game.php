<!DOCTYPE html>
<html>
<?php
session_start();
if(!isset($_SESSION['username'])){
	header("Location: login.php");
}
include("config.php");
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
				<a href="cart.php" style="font-size: 25px;">
		          <span class="glyphicon glyphicon-shopping-cart">Cart</span>
		        </a>
		        <div class="pull-right">
			  	<a href = "profile.php"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp; <strong><?php echo $_SESSION['username']?></strong></a>&nbsp;&nbsp;&nbsp;
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
			<h2>View Game</h2>
			   
			   <form class="form-horizontal" method="post" action="../../cgi-bin/513/1/updateGame.cgi">
				<input type="hidden" id="ISBN" name="ISBN" value="<?php echo $_GET['ISBN'] ?>">
			    <div class="form-group">
				    <label for="ISBN">ASIN(unique) </label>
				   <div id="name-asin"></div>
			 	 </div>
			 	  <div class="form-group">
				    <label for="title">Title</label>
				    <div id="name-title"></div>
			 	 </div>
			 	 <div class="form-group">
				    <label for="price">Price</label>
				    <div id="name-price"></div>
			 	 </div>
				<div class="form-group">
				    <label for="developers">Developers</label>
				    <div id="name-developer"></div>		   
			 	 </div>
				<input type="hidden" name="action" value="addDeveloper">
				<br><br><br>
				  <div class="row">
					<div class="col-sm-12 box">
					<h3> Add New Developer
						<div id="developer-select-list"></div>
						<div class="pull-right">
						<input type="submit" class="btn btn-primary " name="submit" value="Save new developer">	
						</div>				
					</div>
				  </div>
			 	</form> 
		    </div>
		  </div>
		   
		 </div>
</body>
<script>
   var ISBN = document.getElementById('ISBN').value;
   var xmlhttp = new XMLHttpRequest( );
   var url = "http://people.aero.und.edu/~spandey/cgi-bin/513/1/viewGame.cgi";
   var data = "action=view&ISBN="+ISBN;
   $.ajax({
           type: "GET",
           url: url,
           data:"action=view&ISBN="+ISBN,
           success: function(data)
           {    
		var arr = JSON.parse( data);
                document.getElementById('name-asin').innerHTML =arr[0].ASIN;
		document.getElementById('name-title').innerHTML=arr[0].title;
		document.getElementById('name-price').innerHTML=arr[0].price;
		document.getElementById('name-developer').innerHTML=arr[0].developer;
		}    
     });
    $('#developer-list').multiselect({
	includeSelectAllOption: true
    });

</script>

<script>
   var xmlhttp = new XMLHttpRequest( );
   var url = "http://people.aero.und.edu/~spandey/cgi-bin/513/1/developers.cgi";
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
    var out  = "<select id='developer-list' name='developers' multiple='multiple' class='form-control' required>";
    for ( i = 0; i < arr.length; i++){ out += "<option value='"  + arr[i].id +
		    "'> "+arr[i].name+"</option>";
    }
    out += "</select>"
    document.getElementById( "developer-select-list" ).innerHTML = out;
    $('#developer-list').multiselect({
	includeSelectAllOption: true
	});
   }

</script>
</html>
