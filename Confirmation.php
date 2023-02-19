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
    <a href="Home.php" style="font-style: italic; color:white; bottom:640px; margin-left:0px; position:fixed; color:white;
    display: inline-block;  background: black; border-radius: .5rem; ">Home</a>

    <section class="dishes" id="dishes">

      <?php
        switch($_GET['success']){
        case "Thank you, <br> we have received your Delivery Request and it will be proccessed soon!":
      ?>
      <h1 class="heading">Request Received</h1>
      <?php
        break;
        case "Thank You, <br> your order was successful!":
      ?>
      <h1 class="heading">Payment Approved</h1>
      <?php
      }
      ?>
      <div class="box-container">
        <div class="box">
          <?php
            $success = $_GET['success'];
            if(!empty($success))
            {
              echo $success;
            }
            else if(empty($success))
            {
              header("location:Cart.php");
            }
          ?>
          <a href="Orders.php" class="btn btn-info">OK</a>
        <div>
      </div>
    </section>
  </html>
</html>
