<?php
$order_id = $_GET['order_id'];
$status = "Delivered";

$conn = mysqli_connect("localhost","root","","food_db");
$query =mysqli_query($conn, "UPDATE `order` SET `status`='$status' WHERE `order_id`='$order_id'");
header("location:DUpdate.php?order_id=".$order_id);
die;
?>