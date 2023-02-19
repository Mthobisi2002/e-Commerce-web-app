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

  //posting start here
  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
        
     $post = new Post();
     $id = $_SESSION['mybook_userid'];
     $result = $post->create_post($id, $_POST, $_FILES);

     if($result == "")
     {
          header("Location: Control.php");
          die;
     }else
     {

        echo "<div style='text-align:center; font-size:12px; color:white; background-color:grey;'>";
        echo "<br>The following errors occured:<br><br>";
        echo $result;
        echo "</div>";
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

<style>
   .bg-img {
   /* The image used */
   background-image: url("images/AddProduct.jpg");

   /* Control the height of the image */
   min-height: 380px;

   /* Center and scale the image nicely */
   background-position: center;
   background-repeat: no-repeat;
   background-size: cover;
   width: 100%;
   height: 100%;
   position: relative;
   }
</style>

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
        <body>
            <!--order section starts-->
            <div class="bg-img">

                <a href="Control.php" style="font-style: italic; color:white; bottom:640px; margin-left:0px; position:fixed; color:white;
                display: inline-block;  background: black; border-radius: .5rem; ">Previous</a>
                <h1 class="heading" style=" color: white; font-size:30px;" >Add Product</h1>
                <form method="post" enctype = "multipart/form-data" style="background-color:lightyellow; width:550px; height:100px; margin-left:500px; position:fixed;" >
                    <textarea name="post" placeholder="food name" required></textarea><br>
                    <textarea name="price" placeholder="food price" required></textarea>
                    <input type="file" name="file" required>
                    <input id="post_button" type="submit" value="ADD">
                    <br>
                </form>
            </div>
            <!--order section ends-->
        </body>
    </html>
</DOCTYPE>