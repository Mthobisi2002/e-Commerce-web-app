<?php

$userid = $_GET['userid'];
$Street_Address = $_GET['streetaddress'];
$Complex_Building = $_GET['complexbuilding'];
$City_Town = $_GET['citytown'];
$Province = $_GET['province'];
$Postal_Code = $_GET['postalcode'];

$data = array($Street_Address,$Postal_Code,$City_Town);

    $conn = mysqli_connect("localhost","root","","food_db");
    $query =mysqli_query($conn, "UPDATE `addresses` SET `Street_Address`='$Street_Address',`Complex_Building`='$Complex_Building',`City_Town`='$City_Town',`Province`='$Province',`Postal_Code`='$Postal_Code' WHERE `userid`='$userid'");
    header("location:Orders.php");
    die;

?>