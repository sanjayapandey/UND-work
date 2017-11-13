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
			<h2>View Game</h2>
			   <input type="hidden" id="ISBN" value="<?php echo $_GET['ISBN'] ?>">
			   <form class="form-horizontal" method="post" action="../../cgi-bin/513/1/game.cgi">
			    <div class="form-group">
				    <label for="ISBN">ISBN(unique) <strong>*</strong></label>
				   <div id="name-asin"></div>
			 	 </div>
			 	  <div class="form-group">
				    <label for="title">Title<strong>*</strong></label>
				    <div id="name-title"></div>
			 	 </div>
			 	 <div class="form-group">
				    <label for="price">Price<strong>*</strong></label>
				    <div id="name-price"></div>
			 	 </div>
				<div class="form-group">
				    <label for="developers">Select Developers<strong>*</strong></label>
				    <div id="developer-select-list">				   
			 	 </div>
				<input type="hidden" name="action" value="add">
				<div class="pull-right">
				    <a href="edit-game.php?<?php echo $_GET['ISBN'] ?>" class="btn btn-primary ">Edit Game </a>
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
		}    
     });
    $('#developer-list').multiselect({
	includeSelectAllOption: true
    });

</script>
</html>
