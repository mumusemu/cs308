
<!DOCTYPE html>
<html>
<head>
		<meta charset="UTF-8">
		<title>CS308 Store</title>
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<script src="js/jquery2.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="main.js"></script>
		<style>
			@media screen and (max-width:480px){
				#search{width:80%;}
				#search_btn{width:30%;float:right;margin-top:-32px;margin-right:10px;}
			}
			table, th, td {
   			 border: 1px solid black;
			}
			table{
				margin-top: 60px;
				margin-left: auto;
				margin-right: auto;
			}
		</style>

</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">	
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse" aria-expanded="false">
					<span class="sr-only"> navigation toggle</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="profile.php" style="color:white" class="navbar-brand">Online Store</a>
			</div>
		<div class="collapse navbar-collapse" id="collapse">
			<ul class="nav navbar-nav">
				<li><a href="salem.php" style="color:white"><span class="glyphicon glyphicon-home"></span> Home</a></li>
				
			</ul>
			
			<ul class="nav navbar-nav navbar-right">
				
			</ul>
		</div>
	</div>
	</div>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "team16";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "SELECT * FROM orders , products WHERE orders.product_id=products.product_id";

$result = $conn->query($sql);
while($row = mysqli_fetch_array($result)){

if ($result->num_rows > 0) {
    echo "<table><tr><th> Order id </th><th> Transaction id </th><th> Product price </th><th> Buying price </th><th> Revenue </th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
		
$revenue = $row['product_price']-$row['buying_price'];
        echo "<tr><td>" . $row["order_id"]. "</td><td>" . $row["trx_id"]."</td><td>" . $row["product_price"]."</td><td>" . $row["buying_price"]. " </td><td>" . $revenue . "</td></tr>";

    }
    echo "</table>";
} else {
    echo "0 results";
}
}
$conn->close();
?> 

</body>
</html>