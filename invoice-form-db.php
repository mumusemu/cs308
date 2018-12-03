<?php
//db connection
$con = mysqli_connect('localhost','root','');
mysqli_select_db($con,'team16');
?>
<html>
	<head>
		<title>Invoice generator</title>
	</head>
	<body>
		select orders:
		<form method='get' action='invoice-db.php'>
			<select name='trx_id'>
				<?php
					//show invoices list as options
					$query = mysqli_query($con,"select * from orders GROUP BY trx_id");
					while($orders = mysqli_fetch_array($query)){
						echo "<option value='".$orders['trx_id']."'>".$orders['trx_id']."</option>";
					}
//					$query1 = mysqli_query($con,"select * from products");
//					while($invoice = mysqli_fetch_array($query)){
//						echo "<option value='".$invoice['trx_id']."'>".$invoice['trx_id']."</option>";
//					}
				?>
			</select>
			<input type='submit' value='Generate'>
		</form>
	</body>
</html>
