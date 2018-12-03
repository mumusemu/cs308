

<?php

include "db.php";
session_start();
if(isset($_GET["pid"])) {

    $uid = $_SESSION["uid"];
    $pid = $_GET["pid"];

    $sql_count = "SELECT COUNT(*) FROM comments WHERE product_id = '$pid'";
    $result = mysqli_query($con,$sql_count);
    $count = mysqli_fetch_array($result);
    $many = $count['COUNT(*)'];

    $sql = "SELECT * FROM products WHERE product_id = '$pid'";
    $run = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($run);

    $pro_id = $row['product_id'];
    $pro_stock = $row['stock'];
    $pro_cat = $row['product_cat'];
    $pro_brand = $row['product_brand'];
    $pro_title = $row['product_title'];
    $pro_price = $row['product_price'];
    $pro_image = $row['product_image'];
    $pro_desc = $row['product_desc'];

    //// Can be more efficent !!!
    $cat_sql = "SELECT DISTINCT c.cat_title,b.brand_title FROM categories c, products p, brands b WHERE c.cat_id='$pro_cat' && b.brand_id='$pro_brand'";
    $runner = mysqli_query($con,$cat_sql);
    $row_cat = mysqli_fetch_array($runner);

    $pro_cat_string = $row_cat['cat_title'];
    $pro_brand_string = $row_cat['brand_title'];
    ////
    ///
    if (!isset($_SESSION["uid"])) {
        header("location:index.php");
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>CS308 Store</title>
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
        <script src="js/jquery2.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <!-- Bootstrap -->
        <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

        <!-- Slick -->
        <link type="text/css" rel="stylesheet" href="css/slick.css"/>
        <link type="text/css" rel="stylesheet" href="css/slick-theme.css"/>

        <!-- nouislider -->
        <link type="text/css" rel="stylesheet" href="css/nouislider.min.css"/>

        <!-- Font Awesome Icon -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="style.css" type="text/css">
        <!-- Custom stlylesheet -->
        <link type="text/css" rel="stylesheet" href="css/style.css"/>
        <style>
            @media screen and (max-width: 480px) {
                #search {
                    width: 80%;
                }

                #search_btn {
                    width: 30%;
                    float: right;
                    margin-top: -32px;
                    margin-right: 10px;
                }
            }
            .dropbtn {
                background-color: #4CAF50;
                color: white;
                padding: 16px;
                font-size: 12px;
                border: none;
            }

            /* The container <div> - needed to position the dropdown content */
            .dropdown {
                position: relative;
                display: inline-block;
            }

            /* Dropdown Content (Hidden by Default) */
            .dropdown-content {
                display: none;
                position: absolute;
                background-color: #f1f1f1;
                min-width: 140px;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                z-index: 1;
            }

            /* Links inside the dropdown */
            .dropdown-content a {
                color: black;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
            }

            /* Change color of dropdown links on hover */
            .dropdown-content a:hover {background-color: #ddd}

            /* Show the dropdown menu on hover */
            .dropdown:hover .dropdown-content {
                display: block;
            }

            /* Change the background color of the dropdown button when the dropdown content is shown */
            .dropdown:hover .dropbtn {
                background-color: #3e8e41;
            }
        </style>
    </head>
<body>
<!-- TOP HEADER -->

<!-- /TOP HEADER -->

<div class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse" aria-expanded="false">
                <span class="sr-only"> navigation toggle</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="./profile.php" style="color:white" class="navbar-brand">Online Store</a>
        </div>
        <div class="collapse navbar-collapse" id="collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php" style="color:white"><span class="glyphicon glyphicon-home"></span>Home</a></li>
                <li><a href="index.php" style="color:white"><span class="glyphicon glyphicon-modal-window"></span>Product</a></li>
                <li style="width:300px;left:10px;top:10px;"><input type="text" class="form-control" id="search"></li>
                <li style="top:10px;left:20px;"><button class="btn btn-default" id="search_btn">Search</button></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="#" style="color:white" id="cart_container" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-shopping-cart"></span>Cart<span class="badge">0</span></a>
                    <div class="dropdown-menu" style="width:400px;">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-3 col-xs-3">Sl.No</div>
                                    <div class="col-md-3 col-xs-3">Product Image</div>
                                    <div class="col-md-3 col-xs-3">Product Name</div>
                                    <div class="col-md-3 col-xs-3">Price in $.</div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="cart_product">
                                    <!--<div class="row">
                                        <div class="col-md-3">Sl.No</div>
                                        <div class="col-md-3">Product Image</div>
                                        <div class="col-md-3">Product Name</div>
                                        <div class="col-md-3">Price in $.</div>
                                    </div>-->
                                </div>
                            </div>
                            <!--div class="panel-footer"></div-->
                        </div>
                    </div>
                </li>
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

<nav id="navigation">
    <!-- container -->
    <div class="container" style="padding-left: 100px;">
        <!-- responsive-nav -->
        <div id="responsive-nav">
            <!-- NAV -->
            <ul class="main-nav nav navbar-nav">

                <div class="dropdown">
                    <div class="dropdown-content">

                        <?php
                        $sql_category = "SELECT DISTINCT (cat_title) FROM categories;";
                        $m = mysqli_query($con,$sql_category);
                        while($cat_name = mysqli_fetch_array($m)){
                            echo"
                                <a href='profile.php' class=''>$cat_name[0]</a>
                            ";
                        }
                        ?>

                    </div>
                </div>
                <div class="dropdown">
                        <div class="dropdown-content">
                            <?php
                            $sql_brand = "SELECT DISTINCT (brand_title) FROM brands;";
                            $br = mysqli_query($con,$sql_brand);
                            while($brand_name = mysqli_fetch_array($br)){
                                echo"
                                    <a href='#'>$brand_name[0]</a>
                                ";
                            }
                            ?>
                        </div>
                </div>
            </ul>
            <!-- /NAV -->
        </div>
        <!-- /responsive-nav -->
    </div>
    <!-- /container -->
</nav>
<!-- /NAVIGATION -->

    <?php
    echo"
    <div class='container' style='margin-top: 10px;'>
        <!-- row -->
        <div class='row'>
            <!-- Product main img -->
            <div class='col-md-5 col-md-push-2'>
                
            </div>
            <!-- /Product main img -->

            <!-- Product thumb imgs -->
            <div class='col-md-2  col-md-pull-5'>
                <div id='product-imgs'>
                    <div class='product-preview2'>
                        <img src='./product_images/$pro_image'>
                    </div>
                </div>
            </div>
            <!-- /Product thumb imgs -->

            <!-- Product details -->
            <div class='col-md-5'>
                <div class='product-details'>
                    <h2 class='product-name'>$pro_title</h2>
                    <div>
                        <div class='product-rating'>";

    $rating_avg_sql = "SELECT rating FROM products WHERE product_id='$pro_id'";

    $rating_array = mysqli_query($con,$rating_avg_sql);
    $rating_avg = mysqli_fetch_array($rating_array);
    $rating_nf = sprintf("%0.2f",$rating_avg[0]);


    if($rating_nf == 4  ){
        echo "
<i class='fa fa-star'></i>
<i class='fa fa-star'></i>
<i class='fa fa-star'></i>
<i class='fa fa-star'></i>
<i class='fa fa-star-o'></i>
";
    }
    else if($rating_nf == 5  ){
        echo "
<i class='fa fa-star'></i>
<i class='fa fa-star'></i>
<i class='fa fa-star'></i>
<i class='fa fa-star'></i>
<i class='fa fa-star'></i>
";
    }
    else if($rating_nf > 3 && $rating_nf < 4){
        echo "
<i class='fa fa-star'></i>
<i class='fa fa-star'></i>
<i class='fa fa-star'></i>
<i class='fa fa-star-half-o'></i>
<i class='fa fa-star-o'></i>
";
    }
    else if($rating_nf == 3){
        echo "
<i class='fa fa-star'></i>
<i class='fa fa-star'></i>
<i class='fa fa-star'></i>
<i class='fa fa-star-o'></i>
<i class='fa fa-star-o'></i>
";
    }
    else if($rating_nf == 2){
        echo "
<i class='fa fa-star'></i>
<i class='fa fa-star'></i>
<i class='fa fa-star-o'></i>
<i class='fa fa-star-o'></i>
<i class='fa fa-star-o'></i>
";
    }

    else if($rating_nf > 2 && $rating_nf < 3){
        echo "
<i class='fa fa-star'></i>
<i class='fa fa-star'></i>
<i class='fa fa-star-half-o'></i>
<i class='fa fa-star-o'></i>
<i class='fa fa-star-o'></i>
";
    }
    else if($rating_nf > 1 && $rating_nf < 2){
        echo "
<i class='fa fa-star'></i>
<i class='fa fa-star-half-o'></i>
<i class='fa fa-star-o'></i>
<i class='fa fa-star-o'></i>
<i class='fa fa-star-o'></i>
";
    }
    else if($rating_nf < 1){
       echo "
<i class='fa fa-star-half-o'></i>
<i class='fa fa-star-o'></i>
<i class='fa fa-star-o'></i>
<i class='fa fa-star-o'></i>
<i class='fa fa-star-o'></i>
";
   }  else if($rating_nf == 1){
        echo "
<i class='fa fa-star'></i>
<i class='fa fa-star-o'></i>
<i class='fa fa-star-o'></i>
<i class='fa fa-star-o'></i>
<i class='fa fa-star-o'></i>
";
    }
	$pro_id_1 = $_GET["pid"];
	$five_star = "SELECT COUNT(*) FROM comments c WHERE c.rating = 5  AND c.product_id='$pro_id_1'";
   $four_star = "SELECT COUNT(*) FROM comments c WHERE c.rating = 4  AND c.product_id='$pro_id_1'";
   $three_star = "SELECT COUNT(*) FROM comments c WHERE c.rating = 3  AND c.product_id='$pro_id_1'";
   $two_star = "SELECT COUNT(*) FROM comments c WHERE c.rating = 2  AND c.product_id='$pro_id_1'";
   $one_star = "SELECT COUNT(*) FROM comments c WHERE c.rating = 1  AND c.product_id='$pro_id_1'";
   $oo= mysqli_query($con,$one_star);
   $one = mysqli_fetch_array($oo);
   $tt = mysqli_query($con,$two_star);
   $two = mysqli_fetch_array($tt);
   $th = mysqli_query($con,$three_star);
   $three = mysqli_fetch_array($th);
   $ff = mysqli_query($con,$four_star);
   $four = mysqli_fetch_array($ff);
   $fi = mysqli_query($con,$five_star);
   $five = mysqli_fetch_array($fi);
   $gui_o = $one['COUNT(*)'];
   $gui_t = $two['COUNT(*)'];
   $gui_th = $three['COUNT(*)'];
   $gui_f = $four['COUNT(*)'];
   $gui_fi = $five['COUNT(*)'];


    echo"
                            <!--Product rating average is calculated-->
                        </div>
                        <a class='review-link' href='#'>$many Review(s) | Add your review</a>
                    </div>
                    <div>
                        <h3 class='product-price'>$$pro_price.00</h3>
                        <span class='product-available'>In Stock</span>
                    </div>
                    <p>Brand: $pro_brand_string</p>

                    <div class='product-options'>
                        <label>
                            Color
                            <select class='input-select'>
                                <option value='0'>Red</option>
                            </select>
                        </label>
                    </div>

                    <div class='add-to-cart'>
                        <div class='qty-label'>
                            Qty
                            <div class='input-number'>
                                <input type='number' placeholder='1'>
                                <span class='qty-up'>+</span>
                                <span class='qty-down'>-</span>
                            </div>
                        </div>
                        <button class='add-to-cart-btn' id='product' ><i class='fa fa-shopping-cart'></i> add to cart</button>
                    </div>
                    

                    <ul class='product-links'>
                        <li>Category: $pro_cat_string</li>
                        <li><a href='#'></a></li>
                    </ul>

                    <ul class='product-links'>
                        <li>Share:</li>
                        <li><a href='#'><i class='fa fa-facebook'></i></a></li>
                        <li><a href='#'><i class='fa fa-twitter'></i></a></li>
                        <li><a href='#'><i class='fa fa-google-plus'></i></a></li>
                        <li><a href='#'><i class='fa fa-envelope'></i></a></li>
                    </ul>

                </div>
            </div>";
$sql_com_rat = "SELECT DISTINCT u.first_name,co.rating,co.comments FROM comments co,products p, user_info u WHERE u.user_id = co.user_id AND  co.product_id = '$pro_id'";
$runn = mysqli_query($con,$sql_com_rat);

    echo "
<div class='col-md-12'>
    <div id='product-tab'>
        <ul class='tab-nav'>
            <li class='active'><a data-toggle='tab' href='#tab1'>Description</a></li>
            <li><a data-toggle='tab' href='#tab3'>Review($many)</a></li>
        </ul>

        <div class='tab-content'>
            <div id='tab1' class='tab-pane fade in active'>
                <p>$pro_desc</p>
            </div>
            <div id='tab2' class='tab-pane fade'>
            <!-- product -->
					<div class=\"col-md-3\">
						<div class=\"product\">
							<div class=\"product-img\">
								<img src='./product_images/$pro_image'>
							</div>
							<div class=\"product-body\">
								<p class=\"product-category\">$pro_cat_string</p>
								<h3 class=\"product-name\"><a href=\"#\">$pro_title</a></h3>
								<h4 class=\"product-price\">$$pro_price.00</h4>
								    <div class=\"product-rating\">
								    </div>
								    <div class='add-to-cart'>
								        <button class=\"add-to-cart-btn\"><i class=\"fa fa-shopping-cart\"></i> add to cart</button>
			                        </div>
							</div>
							
						</div>
					</div>
					<!-- /product -->

            </div>
            <div id='tab3' class='tab-pane fade'>
                <div clas='row'>
                    <div class='col-md-3'>
                        <div class='rating'>
                            <div class='rating-avg'>
                                <span>$rating_nf</span>
                                <div class='rating-stars'>";
    ?>
<?php

if($rating_nf == 4  ){
    echo "
<i class='fa fa-star'></i>
<i class='fa fa-star'></i>
<i class='fa fa-star'></i>
<i class='fa fa-star'></i>
<i class='fa fa-star-o'></i>
";
}
else if($rating_nf == 5  ){
    echo "
<i class='fa fa-star'></i>
<i class='fa fa-star'></i>
<i class='fa fa-star'></i>
<i class='fa fa-star'></i>
<i class='fa fa-star'></i>
";
}

else if($rating_nf == 3){
    echo "
<i class='fa fa-star'></i>
<i class='fa fa-star'></i>
<i class='fa fa-star'></i>
<i class='fa fa-star-o'></i>
<i class='fa fa-star-o'></i>
";
}
else if($rating_nf == 2){
    echo "
<i class='fa fa-star'></i>
<i class='fa fa-star'></i>
<i class='fa fa-star-o'></i>
<i class='fa fa-star-o'></i>
<i class='fa fa-star-o'></i>
";
}


else if($rating_nf == 1){
    echo "
<i class='fa fa-star'></i>
<i class='fa fa-star-o'></i>
<i class='fa fa-star-o'></i>
<i class='fa fa-star-o'></i>
<i class='fa fa-star-o'></i>
";
}
echo"
                                </div>
                            </div> 
                        </div>
                        
                                 <ul class='rating'>
                                        <li>
                                            <div class='rating-stars'>
                                            	<i class='fa fa-star'></i>
												<i class='fa fa-star'></i>
	    										<i class='fa fa-star'></i>
											    <i class='fa fa-star'></i>
												<i class='fa fa-star'></i>
											</div>
											<div class='rating-progress'>
				    							<div style='width: 80%;'></div>
											</div>
											<span class='sum'>$gui_fi</span>
										</li>
										<li>
											<div class='rating-stars'>
							    				<i class='fa fa-star'></i>
								    			<i class='fa fa-star'></i>
									    		<i class='fa fa-star'></i>
										    	<i class='fa fa-star'></i>
						    				    <i class='fa fa-star-o'></i>
											</div>
											<div class='rating-progress'>
											    <div style='width: 60%;'></div>
												</div>
												<span class='sum'>$gui_f</span>
										</li>
										<li>
			    							<div class='rating-stars'>
    											<i class='fa fa-star'></i>
												<i class='fa fa-star'></i>
								    			<i class='fa fa-star'></i>
					    						<i class='fa fa-star-o'></i>
		    									<i class='fa fa-star-o'></i>
											</div>
				    							<div class='rating-progress'>
					    						<div></div>
											</div>
											<span class='sum'>$gui_th</span>
										</li>
										<li>
			    							<div class='rating-stars'>
											    <i class='fa fa-star'></i>
								    			<i class='fa fa-star'></i>
					    						<i class='fa fa-star-o'></i>
												<i class='fa fa-star-o'></i>
						    					<i class='fa fa-star-o'></i>
											</div>
			    							<div class='rating-progress'>
		    	    						<div></div>
		    		    					</div>
					    					<span class='sum'>$gui_t</span>
										</li>
										<li>
											<div class='rating-stars'>
												<i class='fa fa-star'></i>
												<i class='fa fa-star-o'></i>
												<i class='fa fa-star-o'></i>
												<i class='fa fa-star-o'></i>
												<i class='fa fa-star-o'></i>
											</div>
											<div class='rating-progress'>
												<div></div>
											</div>
											<span class='sum'>$gui_o</span>
										</li>
                                    </ul>    
                                </div>
                            </div>
                            <div class='col-md-5'>
                                <div id='reviews'>
                                    <ul class='reviews'>";
?>
<?php

while($comments = mysqli_fetch_array($runn)){
    $f_name = $comments['first_name'];
    $rating = $comments['rating'];
    $comment = $comments['comments'];
    echo "
                                        <li>
                                            <div class=\"review-heading\">
                                                <h5 class=\"name\">$f_name</h5>
	                                                <p class='rating'>$rating</p>
	                                                <div class=\"review-rating\">
	                                                     <i class=\"fa fa-star\"></i>
	                                                     <i class=\"fa fa-star\"></i>
	                                                     <i class=\"fa fa-star\"></i>
	                                                     <i class=\"fa fa-star\"></i>
	                                                     <i class=\"fa fa-star-o empty\"></i>
	                                                 </div>
	                                        </div>
	                                        <div class=\"review-body\">
	                                            <p>$comment</p>
	                                        </div>
	                                    </li>
                                            ";
}

echo"
                                    </ul>
                                </div>
                            </div>
                            <div class='col-md-4'>
                                <div id='review-form'>
								    <form class='review-form' method='post'>
								    	<textarea class='input' name='comment' placeholder='Your Review'></textarea>
								    	<div class='input-rating'>
								    		<span>Your Rating: </span>
								    		<div class='stars'>
								    			<input id='star5' name='rating' value='5' type='radio'><label for='star5'></label>
								    			<input id='star4' name='rating' value='4' type='radio'><label for='star4'></label>
								    			<input id='star3' name='rating' value='3' type='radio'><label for='star3'></label>
								    			<input id='star2' name='rating' value='2' type='radio'><label for='star2'></label>
								    			<input id='star1' name='rating' value='1' type='radio'><label for='star1'></label>
								    		</div>
								    	</div>
								    	<button class='primary-btn'>Submit</button>
								    </form>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>";
if(isset($_SESSION["uid"]) && isset($_POST["rating"]) && isset($_POST["comment"])){
	$c_rating = $_POST["rating"];
    $c_comment = $_POST["comment"];
    $sql_insert = "INSERT INTO comments(product_id,user_id,rating,comments) 
                    VALUES ('$pro_id','$uid','$c_rating','$c_comment')";
    $try_insert = mysqli_query($con,$sql_insert);
}
            ?>
            <!-- /Product details -->
    <?php
       /*
       echo "
<div class='container' style='margin-top: 100px;'>
    <div class='panel panel-default'>
        <div class='panel-heading' style='font-size: xx-large'>
            <div class='row'>
                <div class='col-md-12'>
                    $pro_title
                </div>
            </div>
        </div>

        <div class='panel-body'>
        <table>
            <tr>
                <td style='padding-left: 90px'>
                    <img src='product_images/$pro_image' alt='product image' height='400' width='400'>
                </td>
                <td style='padding-left: 150px;'>
                    <div class='design'>
                    Product ID:
                    </div>
                    $pro_id

                    <div class='design'>
                    Product Description:
                    </div>
                    $pro_desc

                     <div class='design'>
                    Product Category:
                    </div>
                    $pro_cat_string

                    <div class='design'>
                    Product Brand:
                    </div>
                    $pro_brand_string

                    <div class='design'>
                    Product Price:
                    </div>
                    <p style='font-size: x-large; color: #2e6da4'>$$pro_price</p>

                </td>
                
                
            </tr>
        </table>
        <button pid='$pro_id' style='float: right; font-size: 24px; width: 98%; margin-top: 4px;'  id='product' class='btn btn-success btn-xl'>AddToCart</button>
        </div>
        
    </div>     
    <div class='col-md-4'>
        <a href=./profile.php style='font-size: 18px;'>Return to products</a>
    </div>
    <div class='col-md-8'>
         <div class='col-md-3'>
                    <a href='product.php?pid=$prev_pid&pressed=$pid' style='font-size: 24px;'>Previous <span class='glyphicon glyphicon-arrow-left'></span></a>
                </div>
                <div class='col-md-3'>
                    <a href='product.php?pid=$next_pid&pressed=$pid' style='font-size: 24px;'><span class='glyphicon glyphicon-arrow-right'></span>Next</a>
                </div>
    </div>    
</div>
		";
       */

}
?>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/nouislider.min.js"></script>
<script src="js/jquery.zoom.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>

