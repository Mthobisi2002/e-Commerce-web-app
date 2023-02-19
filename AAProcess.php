
<?php
function create_DA2()
{
    $length = rand(4,19);
    $number = "";
    for ($i=0; $i < $length; $i++) {
        # code...
        $new_rand = rand(0,9);

        $number = $number . $new_rand;
    }

    return $number;
}
$DA2 = create_DA2();
$who = $_GET['userid'];
$Street_Address = $_GET['streetaddress'];
$Complex_Building = $_GET['complexbuilding'];
$City_Town = $_GET['citytown'];
$Province = $_GET['province'];
$Postal_Code = $_GET['postalcode'];

$data = array($Street_Address,$Postal_Code);

if(empty($data[0]) || empty($data[1]))
{
    $ERROR1="ERROR";
    header("location:AddAddress.php?ERROR1=".$ERROR1);
}
else if(!empty($data[0]) || !empty($data[1])){
    $conn = mysqli_connect("localhost","root","","food_db");
    $query =mysqli_query($conn, "INSERT INTO `Addresses` (`Street_Address`,`Complex_Building`,`City_Town`,`Province`,`Postal_Code`,`userid`,`id2`)  VALUES  ('$Street_Address','$Complex_Building','$City_Town','$Province','$Postal_Code','$who','$DA2')");
    header("location:orders.php");
    die;
}
    
    

                
    






?>