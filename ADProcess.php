<?php
$order_id = $_GET['order_id'];
$driver_name = $_GET['driver_name'];
$status = "Driver Assigned";

$conn = mysqli_connect("localhost","root","","food_db");
$query =mysqli_query($conn, "UPDATE `order` SET `driver_name`='$driver_name',`status`='$status' WHERE `order_id`='$order_id'");
header("location:Orders.php");
die;
?>