<?php
include("classes/autoload.php");


    $login = new Login();
    $user_data = $login->check_login($_SESSION['mybook_userid']);

    $USER = $user_data;
    if(isset($_GET['id']) && is_numeric($_GET['id']))
    {
        $profile = new Profile();
        $profile_data = $profile->get_profile($_GET['id']);
        if(is_array($profile_data))
        {
            $user_data = $profile_data[0];
        }    
    }

    //collect posts
  $post = new Post();
  $id = $user_data['userid'];

  $posts = $post->get_posts($id);

  //collect friends
  $user = new User();

  $friends = $user->get_friends($id);

  $image_class = new Image();

?>

<?php 
  $conn = mysqli_connect("localhost","root","","food_db");
  function create_orderid()
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
  //defining variables
  $Order_id = create_orderid();

  $who=$user_data['userid'];

  $payment_mode = "paypal";

  $status = "InComplete";
  $query = mysqli_query($conn,"SELECT qty,id2,menu_id,image,name,total_price FROM cart WHERE userid='$who'");
  foreach($query as $row)
  {
    $qty = $row['qty'];
    $id2 = $row['id2'];
    $menu_id = $row['menu_id'];
    $image = $row['image'];
    $name = $row['name'];
    $total_price = $row['total_price'];
    $Pquery = "INSERT INTO `order` (`order_id`,`userid`,`status`,`payment_mode`,`qty`,`id2`,`menu_id`,`image`,`name`,`total_price`)  VALUES  ('$Order_id','$who','$status','$payment_mode','$qty','$id2','$menu_id','$image','$name','$total_price')";
    $DB = new Database();
    $DB->save($Pquery);
    $delete=mysqli_query($conn, "DELETE FROM `cart`");
    $AfterPayment="Thank You, <br> your order was successful!";
    header("location:confirmation.php?success=".$AfterPayment);
  }
              
?>

