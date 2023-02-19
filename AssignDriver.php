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

<style>

  .bg-img {
  /* The image used */
  background-image: url("images/background2.jpg");

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
      <!--header section starts-->
      <section class="bg-img">
        <button onclick="history.back()" style="font-style: italic; color:white; bottom:640px; margin-left:0px; position:fixed; color:white;
        display: inline-block;  background: black; border-radius: .5rem; ">Previous</button>
        <h1 class="heading" style="color: white; font-size:50px;" >Assign Driver</h1>

        <div class="box-container">
          <div class="box">
            <?php 
              $conn = mysqli_connect("localhost","root","","food_db");
              $who=$user_data['userid'];

              $query = "SELECT `first_name`,`userid` FROM `users` WHERE `user_type`='Driver'";
              $query_run = mysqli_query($conn,$query);
              $order_id = $_GET['order_id'];
            ?>
            <?php
                if(mysqli_num_rows($query_run) > 0)
                {    
                  ?>
                  <?php
                    foreach($query_run as $row)
                    {
                      ?>
                        <tr>
                          <td><a href="<?php echo 'ADProcess.php?order_id='.$order_id."&driver_name=".$row['first_name']; ?>" class="btn btn-info"><?php echo $row['first_name'];?></a></td>
                        </tr>
                      <?php
                    }
                  ?>  
                  <?php     
                }
            ?>
            </tbody>
          </div>
        </div>
      </section>
    </body>
  </html>
</html>
