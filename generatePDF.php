<?php

    require("pdf/fpdf.php");
    
    $pdf = new FPDF('P','mm','A4');
    
    $userid = $_GET['userid'];
    $order_id = $_GET['order_id'];
    
    $conn = mysqli_connect("localhost","root","","food_db");
    $query="SELECT `menu_id` FROM `order` WHERE `order_id`='$order_id'";
    $query_run = mysqli_query($conn,$query);
    $rowData = mysqli_fetch_array($query_run);
    $menu_id = $rowData[0];
    
    $query1="SELECT `first_name` FROM `users` WHERE `userid`='$userid'";
    $query_run1 = mysqli_query($conn,$query1);
    $rowData1 = mysqli_fetch_array($query_run1);
    $first_name = $rowData1[0];
    
    $query2="SELECT `last_name` FROM `users` WHERE `userid`='$userid'";
    $query_run2 = mysqli_query($conn,$query2);
    $rowData2 = mysqli_fetch_array($query_run2);
    $last_name = $rowData2[0];
    
    $query3="SELECT `image` FROM `order` WHERE `order_id`='$order_id'";
    $query_run3 = mysqli_query($conn,$query3);
    $rowData3 = mysqli_fetch_array($query_run3);
    $image = $rowData3[0];
    
    $query4="SELECT `date` FROM `order` WHERE `order_id`='$order_id'";
    $query_run4 = mysqli_query($conn,$query4);
    $rowData4 = mysqli_fetch_array($query_run4);
    $date = $rowData4[0];
    
    $query5="SELECT `qty` FROM `order` WHERE `order_id`='$order_id'";
    $query_run5 = mysqli_query($conn,$query5);
    $rowData5 = mysqli_fetch_array($query_run5);
    $qty = $rowData5[0];
    
    $query6="SELECT `name` FROM `order` WHERE `order_id`='$order_id'";
    $query_run6 = mysqli_query($conn,$query6);
    $rowData6 = mysqli_fetch_array($query_run6);
    $name = $rowData6[0];
    
    $query7="SELECT `total_price` FROM `order` WHERE `order_id`='$order_id'";
    $query_run7 = mysqli_query($conn,$query7);
    $rowData7 = mysqli_fetch_array($query_run7);
    $total_price = $rowData7[0];
    
    $query8="SELECT `status` FROM `order` WHERE `order_id`='$order_id'";
    $query_run8 = mysqli_query($conn,$query8);
    $rowData8 = mysqli_fetch_array($query_run8);
    $status = $rowData8[0];
    
    $query9="SELECT `payment_mode` FROM `order` WHERE `order_id`='$order_id'";
    $query_run9 = mysqli_query($conn,$query9);
    $rowData9 = mysqli_fetch_array($query_run9);
    $payment_mode = $rowData9[0];
    
    $query_run10 = mysqli_query($conn,"SELECT `menu_id`,`image`,`date`,`qty`,`name`,`total_price`,`status`,`payment_mode` FROM `order` WHERE `order_id`='$order_id'");
    
    
    $pdf = new FPDF(); 
    $pdf->AddPage();
    
    $width_cell=array(10,40,30,1,1);
    $pdf->SetFont('Arial','B',16);
    
    //Background color of header//
    $pdf->SetFillColor(193,229,252);
    
    // Header starts /// 
    //First header column //
    $pdf->Cell($width_cell[0],10,'QTY',1,0,'C',true);
    //Second header column//
    $pdf->Cell($width_cell[1],10,'ITEM',1,0,'C',true);
    //Third header column//
    $pdf->Cell($width_cell[2],10,'PRICE',1,0,'C',true); 
    //Fourth header column//
    $pdf->Cell($width_cell[3],10,'',1,0,'C',true);
    //Third header column//
    $pdf->Cell($width_cell[4],10,'',1,1,'C',true); 
    //// header ends ///////
    
    $pdf->SetFont('Arial','',14);
    //Background color of header//
    $pdf->SetFillColor(235,236,236); 
    //to give alternate background fill color to rows// 
    $fill=false;
    
    /// each record is one row  ///
    foreach ($query_run10 as $row) {
    $pdf->Cell($width_cell[0],10,$row['qty'],1,0,'C',$fill);
    $pdf->Cell($width_cell[1],10,$row['name'],1,0,'L',$fill);
    $pdf->Cell($width_cell[2],10,$row['total_price'],1,0,'C',$fill);
    $pdf->Cell($width_cell[3],10,'',1,0,'C',$fill);
    $pdf->Cell($width_cell[4],10,'',1,1,'C',$fill);
    //to give alternate background fill  color to rows//
    $fill = !$fill;
    }
    /// end of records /// 
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Helvetica','',25);
    $order = "order :";
    $pdf->Text(100,60,$order);
    
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Courier','',25);
    $pdf->Text(130,60,$order_id);
    
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Helvetica','',10);
    $customer = "Customer :";
    $pdf->Text(100,65,$customer);
    
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Courier','',10);
    $pdf->Text(120,65,$first_name);
    
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Courier','',10);
    $pdf->Text(135,65,$last_name);
    
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Helvetica','',10);
    $DateTime = "date & time :";
    $pdf->Text(100,70,$DateTime);
    
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Courier','',10);
    $pdf->Text(122,70,$date);
    
    $pdf->SetTextColor(0,255,0);
    $pdf->SetFont('Times','',25);
    $restaurant = "Script Kidoh's Kitchen";
    $pdf->Text(100,10,$restaurant);
    
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Helvetica','',25);
    $receipt = "Receipt";
    $pdf->Text(126,30,$receipt);
    
    $pdf->Line(50, 80, 190-50, 80);
    $pdf->Line(50, 80, 190-0, 80);
    
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Helvetica','',10);
    $payment_modetxt = "payment mode :";
    $pdf->Text(100,75,$payment_modetxt);
    
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Courier','',10);
    $pdf->Text(127,75,$payment_mode);
    
    $pdf->SetTextColor(193,229,252);
    $pdf->SetFont('Helvetica','',30);
    $ThankYou = "THANK YOU";
    $pdf->Text(130,90,$ThankYou);
    
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Helvetica','',10);
    $statustxt = "status :";
    $pdf->Text(100,80,$statustxt);
    
    switch($status)
    {
        case "InComplete":
            $pdf->SetTextColor(194,8,8);
            $pdf->SetFont('Courier','',15);
            $pdf->Text(120,80,$status);
        break;
        case "Delivered":
            $pdf->SetTextColor(0,255,0);
            $pdf->SetFont('Courier','',10);
            $pdf->Text(120,80,$status);
        break;
        default:
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Courier','',10);
        $pdf->Text(120,80,$status);
    }
    $pdf->Output();
?>
