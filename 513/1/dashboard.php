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
    var out  = "<table class='table table-bordered'><tr><th>Select</th>" +
               "<th>Title</th>" +
		"<th>Developer</th>" +
               "<th>Purchase quantity</th></tr>";
    for ( i = 0; i < arr.length; i++ ) {
     out += "<tr><td>"  +
	    "<tr><td><input type='checkbox' name='asins' value='"+ arr[i].ASIN +"'>" +
            "</td><td> <a href='view-game.php?ISBN="+ arr[i].ASIN +"'>" + arr[i].title + "</a>"+
            "</td><td>" + arr[i].developer +
            "</td><td><input type='number' name='quantities' min=0 value=0 >"+
            "</td></tr>";
    }
    out += "</table>"
    document.getElementById( "game-table" ).innerHTML = out;
   }

$('input[name="asins"]').on('click', function() {
   if ($(this).is(':checked')) {
      $(this).siblings("input[type=number]").attr('quantities').removeProp("disabled");
   }
   else {
      $(this).siblings("input[type=number]").attr('quantities').prop("disabled", "disabled");
   }
});

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
				<div id="custom-search-input">
					<div class="input-group col-md-12">
						<form method="post" action="#">
							<input type="text" class="form-control input-lg" name="searchTitle"
								placeholder="Search by game name" value= "<?php if (isset($_POST['searchTitle'])) {
									echo $_POST['searchTitle'];
								}?>"/> 
						</form>
						<br> <br> <br>
					</div>
				</div>
				<div class="row">
					<h2>List of Games</h2>
				</div>
				<form action="../../cgi-bin/513/1/purchaseGame.cgi" method="POST">
				<div id="game-table"></div>
				<div class="row">
					<div class="col-sm-12">
						<input type="submit" class="btn btn-primary btn-sm pull-right" name="addToCart" value="Purchase selected items">
					</div>
				</div>
				</form>
				<?php   
				//if cart has already list, no need to initialize again
				if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
					$_SESSION['cart']= array();
				}
				if(isset($_POST['addToCart'])){ //check if cart form was submitted
					if(isset($_POST['asins']) && is_array($_POST['asins'])){
						foreach($_POST['asins'] as $checkbox){
							array_push($_SESSION['cart'],$checkbox);
						}
					}
				}
				?>
			</div>
		  </div>
		  <?php if($_SESSION['username'] == 'adminadmin'){?>
		  <div class="row">
		  	<div class="col-sm-2"></div>
		  	<div class="col-sm-8">
		  	<div class="panel panel-default">
						<div class="panel-body">
							<a href="reset.php" class="btn btn-primary btn-flat pull-left"> Clear System </a>
			  				<form action="#" method="POST">
			  					<input type="hidden" name="fileName" value="dashboard.php">
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
		 <?php 
		 /*
		  * Algorithm to find Longest Common Subsequence
		  * 
		  * function LCSLength(X[1..m], Y[1..n])
		    C = array(0..m, 0..n)
		    for i := 0..m
		       C[i,0] = 0
		    for j := 0..n
		       C[0,j] = 0
		    for i := 1..m
		        for j := 1..n
		            if X[i] = Y[j]
		                C[i,j] := C[i-1,j-1] + 1
		            else
		                C[i,j] := max(C[i,j-1], C[i-1,j])
		    return C[m,n]
		  */
		 function LCSLength ($array1, $array2){
		 	$temp = array();
		 	for ($i=0;$i<=sizeof($array1);$i++){
		 		$temp[$i][0]=0;
		 	}
		 	for($j=0;$j<=sizeof($array2);$j++){
		 		$temp[0][$j]=0;
		 	}
		 	for ($i=0;$i<sizeof($array1);$i++){
				$posX=$i+1;
				for ($j=0;$j<sizeof($array2);$j++){
					$posY=$j+1;
					if (strcasecmp($array1[$i], $array2[$j]) == 0) {
						$temp[$posX][$posY] = $temp[$posX-1][$posY-1]+1;
					}else {
						$temp[$posX][$posY] = max($temp[$posX][$posY-1], $temp[$posX-1][$posY]);
					}
				}
			}
			return $temp[sizeof($array1)][sizeof($array2)];
		 }
		 
		 ?>
</body>
</html>
