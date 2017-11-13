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
  <title>Dashboard</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="css/bootstrap.min.css">  
  <link rel="stylesheet" href="css/bookstore.css">
  <link rel="stylesheet" href="css/my-css.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/ionicons.min.css">
  <link rel="stylesheet" href="css/skins/_all-skins.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
    var out  = "<table class='table table-bordered'><tr><th>Select</th> <th>Purchase quantity</th>" +
               "<th>Title</th>" +
		"<th>Developer</th>" +
               "</tr>";
    for ( i = 0; i < arr.length; i++ ) {
     out += "<tr><td>"  +
	    "<tr><td><input type='checkbox' class='checkbox'  name='asins' value='"+ arr[i].ASIN +"'>" +
	     "</td><td><input type='number' class='field' disabled  name='quantities' min=0 value=0 >"+
            "</td><td> <a href='view-game.php?ISBN="+ arr[i].ASIN +"'>" + arr[i].title + "</a>"+
            "</td><td>" + arr[i].developer +
           
            "</td></tr>";
    }
    out += "</table>";
    document.getElementById( "game-table" ).innerHTML = out;
	$('.checkbox').change(function() {
		  $(this).parent().next().find('.field').prop('disabled', !$(this).is(':checked'))
	});
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
				<div id="custom-search-input">
					<div class="input-group col-md-12">
						<form id="searchGame" method="post" action="#">
							<div class="col-sm-10">
							<input type="text" class="form-control input-lg pull-left" name="searchTitle"
								placeholder="Search by game name" value= "<?php if (isset($_POST['searchTitle'])) {
									echo $_POST['searchTitle'];
								}?>"/>
							</div>
							<div class="col-sm-2">
							<button type="submit" name="search" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-search"></span>&nbsp &nbsp Search</button>
							</div> 
						</form>
						<br> <br> <br>
					</div>
				</div>
				<div class="row">
					<h4>List of Games</h4>
				</div>
				<div id="purchaseSuccess" class="alert alert-success" style="display:none"> Purchase is successfull. </div>
				<div id="purchaseError" class="alert alert-danger" style="display:none"> Something went wrong while purchasing, try again ! </div>		
				<form id="purchaseGame" method="POST">
				<input type='hidden' name='userId' value="<?php echo $_SESSION['userid']?>">
				<div id="game-table"></div>
				<div class="row">
					<div class="col-sm-12">
						<input type="submit" class="btn btn-primary btn-sm pull-right" name="purchase" value="Purchase selected items">
					</div>
				</div>
				</form>
				
			</div>
		  </div>
		  <?php if($_SESSION['username'] == 'admin'){?>
		  <div class="row"><br><br><br>
		  	<div class="col-sm-2"></div>
		  	<div class="col-sm-8">
		  	<div class="panel panel-default">
						<div class="panel-body">
							<a href="../../cgi-bin/513/1/reset.cgi" class="btn btn-warning btn-flat pull-left"> Clear System </a>
			  				<form action="#" method="POST">
			  					<input type="hidden" name="fileName" value="dashboard.php">
								<a href="https://github.com/sanjayapandey/UND-work/tree/dev" target="_blank" class="btn btn-info btn-flat pull-right"> Github Source </a>
								<input type="submit" class="btn btn-primary btn-flat pull-right" name="source" value="source">
			  				</form>
						</div>
				</div>
				<div class="panel panel-default">
						<h3>Page Source Code</h3>
					<div class="panel-body">
						<?php 
							if(isset($_POST['source']) && $_POST['source'] != ''){
								
								$file = fopen( $_POST['fileName'], "r" ) or	exit( "Unable to open file!" );
								while ( !feof( $file ) )
									highlight_string(fgets( $file ));
								fclose( $file );
							}
						?>
					</div>
				</div>
			</div>
			<div class="col-sm-2"></div>
		  </div>
		  <?php }?>
		 </div>
</body>
<script type="text/javascript">

$("#searchGame").submit(function(e) {
    var url = "http://people.aero.und.edu/~spandey/cgi-bin/513/1/searchGame.cgi";
	
    $.ajax({
           type: "POST",
           url: url,
           data: $("#searchGame").serialize(), // serializes the form's elements.
           success: function(data)
           {	
		myFunction(data);		
	    }
         });
    e.preventDefault(); // avoid to execute the actual submit of the form.
});

$("#purchaseGame").submit(function(e) {
    var url = "../../cgi-bin/513/1/purchaseGame.cgi";
	
    $.ajax({
           type: "POST",
           url: url,
           data: $("#purchaseGame").serialize(), // serializes the form's elements.
           success: function(data)
           {	
		var arr = JSON.parse( data);		
		if(arr[0].success === "true"){
			$("#purchaseGame")[0].reset();
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
