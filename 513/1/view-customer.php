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
			   <input type="hidden" id="id" name="id" value="<?php echo $_GET['id'] ?>">
			   <div class="row">
					<div class="panel panel-default">
						<h3>Customer Information</h3>
						<div class="panel-body">
							<label for="ISBN">Customer Id </label>
				  			<div id="name-id"></div>
							<label for="title">First Name</label>
				    			<div id="name-fname"></div>
							 <label for="price">Last Name</label>
				   			<div id="name-lname"></div><hr>
							<label for="price">Total Spend Amount</label>
				   			<div id="total-amount"></div>
							<label for="games">Purchase History</label>
				   			<div id="name-games"></div>
						</div>
					</div>
				</div>
		    </div>
		  </div>
		   
		 </div>
</body>
<script>
   var id = document.getElementById('id').value;
   var xmlhttp = new XMLHttpRequest( );
   var url = "http://people.aero.und.edu/~spandey/cgi-bin/513/1/viewCustomer.cgi";

   $.ajax({
           type: "GET",
           url: url,
           data:"action=view&id="+id,
           success: function(data)
           {    
		                
		var arr = JSON.parse( data);
		
                document.getElementById('name-id').innerHTML =arr[0].id;
		document.getElementById('name-fname').innerHTML=arr[0].fname;
		document.getElementById('name-lname').innerHTML=arr[0].lname;
		document.getElementById('total-amount').innerHTML=arr[0].amount;
		var arr1 = JSON.parse( JSON.stringify(arr[0].games));
		var i;
		var out  = "<table class='table table-bordered'><tr><th>S.N</th><th>Game Title</th> <th>Quantity</th></tr>";
		for ( i = 0; i < arr1.length; i++){
			var counter = i+1;
			out+= "<tr><td>"  + counter +
            		"</td><td> <a href='view-game.php?ISBN="+arr1[i].ASIN+"'>"+arr1[i].Title+"</a></td><td>"+arr1[i].Quantity+"</td></tr>";
		}
		 out+= "</table>";
		document.getElementById('name-games').innerHTML=out;
		}    
     });

</script>
</html>
