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

<DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
            <title>100% Mthobisi Khanyile</title>
     
            <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"
            />

            <!-- font awesome cdn link -->
            <link rel="stylesheet" href="https:cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

            <link rel="stylesheet" href="css/styles.css">
        </head>
        <button onclick="history.back()" style="font-style: italic; color:white; bottom:640px; margin-left:0px; position:fixed; color:white;
        display: inline-block;  background: black; border-radius: .5rem; ">Previous</button>
        <section class="dishes" id="dishes">

        <?php 
            $conn = mysqli_connect("localhost","root","","food_db");
            $who=$user_data['userid'];
            $order_id = $_GET['order_id'];
            $query = "SELECT `status` FROM `order` WHERE `userid`='$who' AND `order_id`='$order_id'";
            $query_run = mysqli_query($conn,$query);
            $rowData = mysqli_fetch_array($query_run);
            $status = $rowData[0];            
        ?>

        <h1 class="heading">Order Status:</h1>
        <?php
            switch($status){
            case "Waiting":?>
            <div style="font-size: 40px; text-align: center; color: red;">
            <?php echo $status ?></div><?php
            break;
            case "Driver Assigned":?><div style="font-size: 40px; text-align: center; color: yellow;"><?php echo $status ?></div><?php
            break;
            case "Driver Accepted":?><div style="font-size: 40px; text-align: center; color: orange;"><?php echo $status ?></div><?php
            break;
            case "Out for Delivery":?><div style="font-size: 40px; text-align: center; color: blue;"><?php echo $status ?></div><?php
            break;
            case "Delivered":?><div style="font-size: 40px; text-align: center; color: green;"><?php echo $status ?></div><?php
            break;
            }
        ?>
        <div class="box-container">
            <div class="box">
                <a href="Orders.php" class="btn btn-info">Ok</a>
            <div>
        </div>
    </html>
</section>
