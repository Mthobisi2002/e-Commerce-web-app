<?php
$order_id = $_GET['order_id'];
$status = "Driver Accepted";

$conn = mysqli_connect("localhost","root","","food_db");
$query =mysqli_query($conn, "UPDATE `order` SET `status`='$status' WHERE `order_id`='$order_id'");
header("location:Home.php");
die;
?>