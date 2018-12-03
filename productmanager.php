<?php
session_start();


?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Product Manager</title>
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<script src="js/jquery2.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="main.js"></script>
		<link rel="stylesheet" type="text/css" href="style.css">
		<style></style>
	</head>
<body>
<div class="wait overlay">
	<div class="loader"></div>
</div>
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">	
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse" aria-expanded="false">
					<span class="sr-only">navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="#" class="navbar-brand" style="color:white">Online Store</a>
			</div>
		<div class="collapse navbar-collapse" id="collapse">
			<ul class="nav navbar-nav">
				<li><a href="index.php" style="color:white"><span class="glyphicon glyphicon-home"></span> Home</a></li>
			</ul>
			<form class="navbar-form navbar-left">
		        <div class="form-group">
		          <input type="text" class="form-control" placeholder="Search" id="search">
		        </div>
		        <button type="submit" class="btn btn-default" id="search_btn"><span class="glyphicon glyphicon-search"></span></button>
		     </form>
			<ul class="nav navbar-nav navbar-right">



				<li><a href="#" style="color:white" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-shopping-cart"></span> Add Brand or Category </a>
					<div class="dropdown-menu" style="width:250px;">
						<div class="panel panel-success">
							<div class="panel-body">
								<div class="row">
									 <form method = "post" enctype="multipart/form-data" >
                  <table width = "200" border =" 0" cellspacing = "1" 
                     cellpadding = "2">
                
                     <tr>
                        <td width = "100">Brand</td>
                        <td><input name = "brand_title" type = "text" 
                           id = "brand_title"></td>
                     </tr>
                     <tr>
                        <td width = "100">Category</td>
                        <td><input name = "cat_title" type = "text" 
                           id = "cat_title"></td>
                     </tr>
                     <tr>
                        <td width = "100"> </td>
                        <td>
                            <input name = "addbc" type = "submit" 
                              id = "addbc" value = "Add">
                        </td>
                     </tr>
                  </table>
               </form>
				</div>
			</div>
		</div>
	</div>
				</li>





				<li><a href="#" style="color:white" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-shopping-cart"></span> Invoice </a>
					<div class="dropdown-menu" style="width:250px;">
						<div class="panel panel-success">
							<div class="panel-body">
								<div class="row">
									<form method='get' action='invoice-db.php'>
		
			<select name='trx_id'>

				<?php
				$con = mysqli_connect("localhost", "root", "", "team16");
				$sql = "SELECT trx_id FROM orders";
		    $result = mysqli_query($con,$sql);
		    
		    $row = mysqli_fetch_assoc($result);
		    $trx_id=$row['trx_id'];
		    
            

					//show invoices list as options
					$query = mysqli_query($con,"select * from orders  GROUP BY trx_id ");
					while($orders = mysqli_fetch_array($query)){
						echo "<option value='".$orders['trx_id']."'>".$orders['trx_id']."</option>";

					}
					$query1 = mysqli_query($con,"select * from products");
					while($invoice = mysqli_fetch_array($query)){
						echo "<option value='".$invoice['trx_id']."'>".$invoice['trx_id']."</option>";
					}
				?>
			</select>
			<input type='submit' value='Generate'  >
			                          
			
		</form>

				 <form method = "post" enctype="multipart/form-data" >
                  <table width = "200" border =" 0" cellspacing = "1" 
                     cellpadding = "2">
                
                     <tr>
                        <td width = "100">Trx ID</td>
                        <td><input name = "trx_id" type = "text" 
                           value="<?php echo $trx_id; ?>" id = "trx_id"></td>
                     </tr>
                     
                     <tr>
                        <td width = "100"> </td>
                        <td>
                            <input name='approve' type = "submit" value='Deliver' id = "approve" >
                        </td>
                     </tr>
                  </table>
               </form>
				</div>
			</div>
		</div>
	</div>
				</li>






				<li><a href="#" style="color:white" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-shopping-cart"></span> Browse Image to Upload </a>
					<div class="dropdown-menu" style="width:250px;">
						<div class="panel panel-success">
							<div class="panel-heading">
								<div class="row">




									 <form method = "post" enctype="multipart/form-data" >
                 <td> This area for uploading image into database...</td>
                 <table width = "200" border =" 0" cellspacing = "1" 
                     cellpadding = "2">
                     <tr>
                        <td width = "150"> Image</td>
                        <td><input type="file" name="fileToUpload" id="fileToUpload">
                        <input name = "upload" type = "submit" id = "upload" value = "Upload"></td>
                     </tr>
                  </table>
               </form>
				</div>
			</div>
		</div>
	</div>
				</li>
				
				<li><a href="#" style="color:white" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-shopping-cart"></span> Update Item </a>
					<div class="dropdown-menu" style="width:230px;">
						<div class="panel panel-success">
							<div class="panel-body">
								<div class="row">
									 <form method = "post" enctype="multipart/form-data" >
                  <table width = "200" border =" 0" cellspacing = "1" 
                     cellpadding = "2">
                
                     <tr>
                        <td width = "100">ID</td>
                        <td><input name = "product_id" type = "text" 
                           id = "product_id"></td>
                     </tr>

                  	<tr>
                        <td width = "100">Stock</td>
                        <td><input name = "stock" type = "text" 
                           id = "stock"></td>
                     </tr>
                     
                     <tr>
                        <td width = "100">Price</td>
                        <td><input name = "product_price" type = "text" 
                           id = "product_price"></td>
                     </tr>
                     <tr>
                        <td width = "100"> </td>
                        <td>
                            <input name = "update" type = "submit" id = "update" value = "Update">
                            
                        </td>
                     </tr>
                  </table>
               </form>
				</div>
			</div>
		</div>
	</div>
				</li>

				<li><a href="#" style="color:white" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-shopping-cart"></span> Add New Item </a>
					<div class="dropdown-menu" style="width:260px;">
						<div class="panel panel-success">
							<div class="panel-body">
								<div class="row">
									 <form method = "post" enctype="multipart/form-data" >
                  <table width = "330" border ="0" cellspacing = "1" 
                     cellpadding = "2">
                
                     <tr>
                        <td width = "100">ID</td>
                        <td><input name = "product_id" type = "text" 
                           id = "product_id"></td>
                     </tr>

                  	<tr>
                        <td width = "100">Stock</td>
                        <td><input name = "stock" type = "text" 
                           id = "stock"></td>
                     </tr>
                     <tr>
                        <td width = "100">Categories</td>
                        <td><input name = "product_cat" type = "text" 
                           id = "product_cat"></td>
                     </tr>
                     <tr>
                        <td width = "100">Brand</td>
                        <td><input name = "product_brand" type = "text" 
                           id = "product_brand"></td>
                     </tr>
                     <tr>
                        <td width = "100">Title</td>
                        <td><input name = "product_title" type = "text" 
                           id = "product_title"></td>
                     </tr>
                     <tr>
                        <td width = "100">Price</td>
                        <td><input name = "product_price" type = "text" 
                           id = "product_price"></td>
                     </tr>
                     <tr>
                        <td width = "100"> Desc</td>
                        <td><input name = "product_desc" type = "text" 
                           id = "product_desc"></td>
                     </tr>
                     
                     <tr>
                        <td width = "100"> Keywords</td>
                        <td><input name = "product_keywords" type = "text" 
                           id = "product_keywords"></td>
                     </tr>
                  	<tr>
                        <td width = "100"> Image</td>
                        <td><input type="file" name="fileToUpload" id="fileToUpload">
                        </td>
                     </tr>
                     <tr>
                        <td width = "100"> </td>
                        <td>
                           	  <input name = "addnew" type = "submit" 
                              id = "addnew" value = "Add New Item">
                        </td>
                     </tr>
                     
                  </table>
               </form>
				</div>
			</div>

		</div>
	</div>
				</li>

				<li><a href="#" style="color:white" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-shopping-cart"></span> Delete Item </a>
					<div class="dropdown-menu" style="width:210px;">
						<div class="panel panel-success">
							<div class="panel-body">
								<div class="row">
									 <form method = "post" enctype="multipart/form-data" >
                  <table width = "200" border =" 0" cellspacing = "1" 
                     cellpadding = "2">
                
                     <tr>
                        <td width = "100">ID</td>
                        <td><input name = "product_id" type = "text" 
                           id = "product_id"></td>
                     </tr>
                     <tr>
                        <td width = "100"> </td>
                        <td>
                            <input name = "delete" type = "submit" 
                              id = "delete" value = "Delete">
                        </td>
                     </tr>
                  </table>
               </form>
				</div>
			</div>
		</div>
	</div>
				</li>
				

			<ul class="nav navbar-nav navbar-right" id = "hide">
                <li><a href="#" style="color:white" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span><?php echo "Hi,".$_SESSION["name"]; ?></a>
                    <ul class="dropdown-menu">
                        <li><a href="cart.php" style="text-decoration:none; color:black;"><span class="glyphicon glyphicon-shopping-cart"> Cart</a></li>
                        <li class="divider"></li>
                        <li><a href="customer_order.php" style="text-decoration:none; color:black;"><span class="glyphicon glyphicon-ok"> Orders</a></li>
                        <li class="divider"></li>
                        <li><a href="" style="text-decoration:none; color:black;"><span class="glyphicon glyphicon-edit"> Change Password</a></li>
                        <li class="divider"></li>
                        <li><a href="logout.php" style="text-decoration:none; color:black;"><span class="glyphicon glyphicon-log-out"> Logout</a></li>
                    </ul>
                </li>
                
			</ul>
		</div>
	</div>
</div>	
	<p><br/></p>
	<p><br/></p>
	<p><br/></p>
	<div class="container-fluid">

		<div class="row">



			<div class="col-md-2 col-xs-12">
				

				<div id="get_brand1">

					<?php
      if(isset($_POST['update'])){
      	ob_start();
         // Create connection
         $conn = mysqli_connect("localhost", "root", "", "team16");
         // Check connection
         if (!$conn) {
             die("Connection failed: " . mysqli_connect_error());
         }

        $product_id = $_POST['product_id'];
        $product_price = $_POST['product_price'];
        $stock = $_POST['stock'];
        if(empty($product_price)){
			$sql = "UPDATE products SET stock='$stock' WHERE product_id=$product_id";
        }
        else if(empty($stock)){
        	$sql = "UPDATE products SET product_price='$product_price' WHERE product_id=$product_id";
        }
        else
        	$sql = "UPDATE products SET product_price='$product_price' , stock='$stock' WHERE product_id=$product_id";
         


        mysqli_query($conn, $sql);






      }

//-------------------------------------
if(isset($_POST["upload"])) {
	$slash="/";
	$target_dir = "product_images/";
	$target_file = $target_dir. basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

	// Check if file already exists
	if (file_exists($target_file)) {
	    echo "Sorry, file already exists.";
	    $uploadOk = 0;
	}
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000) {
	    echo "Sorry, your file is too large.";
	    $uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    $uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	    } else {
	        echo "Sorry, there was an error uploading your file.";
	    }
	}
}


      //asd


      if(isset($_POST['addnew'])){
         // Create connection
         $conn = mysqli_connect("localhost", "root", "", "team16");
         // Check connection
         if (!$conn) {
             die("Connection failed: " . mysqli_connect_error());
         }

        $product_id = $_POST['product_id'];
        $stock = $_POST['stock'];
        $product_cat = $_POST['product_cat'];
        $product_brand = $_POST['product_brand'];
        $product_title = $_POST['product_title'];
        $product_price = $_POST['product_price'];
        $product_desc = $_POST['product_desc'];

        $product_image = basename($_FILES["fileToUpload"]["name"]);
        $product_keywords = $_POST['product_keywords'];
        
        if(empty($product_id) or empty($stock) or empty($product_cat) or empty($product_brand) or empty($product_title) or empty($product_price) or empty($product_desc) or empty($product_keywords)){

			echo "All areas must be filled.";
        }
        else{
        $sql = "INSERT INTO products (product_id, stock, product_cat, product_brand, product_title, product_price, product_desc, product_image, product_keywords) VALUES ('$product_id', '$stock', '$product_cat', '$product_brand', '$product_title', '$product_price', '$product_desc', '$product_image','$product_keywords')";
        mysqli_query($conn, $sql);
   		 }
    
   }


   if(isset($_POST['addbc'])){
         // Create connection
         $conn = mysqli_connect("localhost", "root", "", "team16");
         // Check connection
         if (!$conn) {
             die("Connection failed: " . mysqli_connect_error());
         }

        $brand_title = $_POST['brand_title'];
        $cat_title = $_POST['cat_title'];
        
        
        if(empty($brand_title)){
			$sql = "INSERT INTO categories (cat_title) VALUES ('$cat_title')";
			
        }
        else if(empty($cat_title)){
        	$sql = "INSERT INTO brands (brand_title) VALUES ('$brand_title')";
        }
        else
        	echo "asd";
        
mysqli_query($conn, $sql);
    
    
   }

      if(isset($_POST['delete'])){
         // Create connection
         $conn = mysqli_connect("localhost", "root", "", "team16");
         // Check connection
         if (!$conn) {
             die("Connection failed: " . mysqli_connect_error());
         }

        $product_id = $_POST['product_id'];
        
        
		$sql = "DELETE FROM products WHERE product_id=$product_id";


         mysqli_query($conn, $sql);
      }
      

     

         ?>

                     
				</div>
			</div>
			<div class="col-md-8 col-xs-12">
				<div class="row">
					<div class="col-md-12 col-xs-12" id="product_msg">
					</div>
				</div>





<?php 
 


if(isset($_POST['approve'])){
		ob_start();
         // Create connection
         $conn = mysqli_connect("localhost", "root", "", "team16");
         // Check connection
         if (!$conn) {
             die("Connection failed: " . mysqli_connect_error());
         }

        
        $baba = "Delivered";
        $trx_id = $_POST['trx_id'];
        $sql = "UPDATE orders SET p_status='$baba' WHERE trx_id = '$trx_id'";

         mysqli_query($conn, $sql);
      }	
      ?>



				<div class="panel panel-info">
					<div class="panel-heading">All Products</div>
					<div class="panel-body">
						<div id="get_product1">
							<?php
				$con=mysqli_connect("localhost", "root", "");
              if(!$con){
                  echo 'not connected';
              }

              if(!mysqli_select_db($con,'team16'))
              {
                echo 'database not selected';
              }

							
	 $result = mysqli_query($con,"SELECT * FROM products");
	 $z = 0;
		while($row = mysqli_fetch_array($result)){
			$pro_id    	= $row['product_id'];
			$pro_cat   	= $row['product_cat'];
			$pro_brand 	= $row['product_brand'];
			$pro_title 	= $row['product_title'];
			$pro_price 	= $row['product_price'];
			$pro_image 	= $row['product_image'];
			$pro_id 	= $row['product_id'];
			$stock 		= $row['stock'];
			
			$z 			= $z + $pro_price;
			echo "
				<div class='col-md-4'>
							<div class='panel panel-default'>
								<div class='panel-heading'>$pro_title // Product Id:$pro_id</div>
								<div class='panel-body'>
									<img src='product_images/$pro_image' style='width:220px; height:200px;'/>
								</div>
								<div class='panel-heading'>$$pro_price 
									stock:$stock 
								</div>
							</div>
						</div>

			";
		}
		$y=125000;
		$z=$z-$y;
		echo"
	<div>
		Total Profit:$$z
	</div>	"
	?>

	
						</div>
						
					</div>
					<div class="panel-footer">&copy; 2018</div>
				</div>
			</div>
			<div class="col-md-1"></div>
		</div>

	</div>
</body>
</html>