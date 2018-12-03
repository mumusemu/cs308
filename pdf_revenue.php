<?php
session_start();
require('fpdf16/fpdf.php');
ob_start ();
//db connection
$con = mysqli_connect('localhost','root','');
mysqli_select_db($con,'team16');
$trx_id= $_GET['trans_id'];
//get invoices data
$sql = "SELECT * FROM orders , products WHERE orders.product_id=products.product_id";

$query = mysqli_query($con,$sql); //user_id = '$cm_user_id'"; //
$orders = mysqli_fetch_array($query);

//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm

$pdf = new FPDF('P','mm','A4');

$pdf->AddPage();

//set font to arial, bold, 14pt
$pdf->SetFont('Arial','B',16);

//Cell(width , height , text , border , end line , [align] )

$pdf->Cell(130	,5,'Team 16 Co',0,0);
$pdf->Cell(59	,5,'INVOICE',0,1);//end of line

//set font to arial, regular, 12pt
$pdf->SetFont('Arial','',12);

$pdf->Cell(130	,5,'Adress: Orta Mahallesi, Sabanci Unv. No:27, Tuzla',0,0);
$pdf->Cell(59	,5,'',0,1);//end of line

$pdf->Cell(130	,5,'34956 Istanbul, TURKEY',0,0);
$pdf->Cell(20	,5,'ID: ',0,0); //eol
$pdf->Cell(20	,5,$orders['user_id'],0,1);//end of line
$pdf->Cell(130	,5,'Phone (0216) 483 90 00',0,0);
$pdf->Cell(20	,5,'Invoice: ',0,0);
$pdf->Cell(20	,5,$orders['trx_id'],0,1);//end of line
$pdf->Cell(13	,5,'Fax: (0216) 483 94 98',0,0);


//make a dummy empty cell as a vertical spacer
$pdf->Cell(189	,10,'',0,1);//end of line

//billing address

$pdf->SetFont('Arial','B',14);
$pdf->Cell(100	,5,'Bill to',0,1);//end of line

//add dummy cell at beginning of each line for indentation
$pdf->SetFont('Arial','',12);
$pdf->Cell(10	,5,'First Name: ',0,0);
$pdf->Cell(30	,5,'',0,0);
$pdf->Cell(90	,5,$orders['first_name'],0,1);

$pdf->Cell(10	,5,'Last Name: ',0,0);
$pdf->Cell(30	,5,'',0,0);
$pdf->Cell(90	,5,$orders['last_name'],0,1);

$pdf->Cell(10	,5,'Adress: ',0,0);
$pdf->Cell(30	,5,'',0,0);
$pdf->Cell(90	,5,$orders['address1'],0,1);

$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(30	,5,'',0,0);
$pdf->Cell(90	,5,$orders['address2'],0,1);

$pdf->Cell(10	,5,'Mobile Phone',0,0);
$pdf->Cell(30	,5,'',0,0);
$pdf->Cell(90	,5,$orders['mobile'],0,1);

//make a dummy empty cell as a vertical spacer
$pdf->Cell(189	,10,'',0,1);//end of line

//invoice contents
$pdf->SetFont('Arial','B',12);

$pdf->Cell(85	,5,'Transaction ID',1,0);
$pdf->Cell(35	,5,'Product Price',1,0);
$pdf->Cell(35	,5,'Buying Price',1,0);
$pdf->Cell(34	,5,'Revenue',1,1);//end of line

$pdf->SetFont('Arial','',12);

//Numbers are right-aligned so we give 'R' after new line parameter

//items
$query = mysqli_query($con,$sql); //products.product_id = '".$orders['product_id']."'");
$sql = mysqli_query($con,$sql);

$tax = 0; //total tax
$amount = 0; //total amount

//display the items
while($products = mysqli_fetch_array($query)){
		while($item = mysqli_fetch_array($sql)){
	$pdf->Cell(85	,5,$item['trx_id'],1,0);
	//add thousand separator using number_format function
	$pdf->Cell(35	,5,$orders['product_price'],1,0); //$orders['qty']),1,0);
	$tax = intdiv( $products['product_price'],10 ) ;
	$pdf->Cell(35	,5,$tax,1,0); 
	
	
	$pdf->Cell(34	,5,number_format($products['product_price']),1,1,'R');//end of line
	//accumulate tax and amount
	$tax += $products['tax'];
	$amount += $products['product_price'];
	$subtotal = $amount * $orders['qty'];
		}
}

//summary
$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'Subtotal',0,0);
$pdf->Cell(4	,5,'$',1,0);
$pdf->Cell(30	,5,number_format($subtotal),1,1,'R');//end of line

$taxable = $orders['qty'] * $tax  ;
$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'Taxable',0,0);
$pdf->Cell(4	,5,'',1,0);
$pdf->Cell(30	,5,$taxable,1,1,'R');//end of line

$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'Tax Rate',0,0);
$pdf->Cell(4	,5,'$',1,0);
$pdf->Cell(30	,5,'10%',1,1,'R');//end of line

$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'Total Due',0,0);
$pdf->Cell(4	,5,'$',1,0);
$pdf->Cell(30	,5,number_format($amount + $tax),1,1,'R');//end of line

$pdf->SetFont('Arial','',8);
$message = "\n\n\nThank you for ordering at the CS308 online store. Our policy is to ship your materials within two business days of purchase. On all orders over $2000.00, we offer free 2-3 day shipping. If you haven't received your items in 3 busines days, let us know and we'll reimburse you 5%.\n\nWe hope you enjoy the items you have purchased. If you have any questions, you can email us at the following email address:"; 
$pdf->MultiCell(0, 5, $message);

$pdf->SetFont('Arial', 'U', 8); 
$pdf->SetTextColor(1, 162, 232); 
 
$pdf->Write(13, "team16@cs308store.com", "mailto:example@example.com");













ob_end_clean();

$pdf->Output();
?> 
