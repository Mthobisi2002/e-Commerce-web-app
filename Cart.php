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
  background-image: url("images/cart.jpg");

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

            <header style="background-color:lightblue;">
                <div class="icons">
                    <a class="active" href="Cart.php" class="fas fa-shopping-cart"></a>
                    </div>
                    <a href="Home.php" style="font-style: italic; color:white; bottom:620px; margin-left:-50px; position:fixed; color:white;
                    display: inline-block;  background: black; border-radius: .5rem; ">Previous</a>
                    <a href="#" class="logo"><i class="fas fa-utensils"></i>Script Kidoh's Kitchen.</a>
                    <div style=" color: white; font-size:30px;">
                        <h2>Cart</h2>
                    </div>

                    <nav class="navbar">
                        <a href="home.php">Home</a>
                    </nav>
                </div>
            </header>

            <section class="dishes" id="dishes" >


                <h1 class="heading">Cart</h1>

                    <div class="box-container">
                        <div class="bg-img">
                            <?php 
                                $conn = mysqli_connect("localhost","root","","food_db");
                                $who=$user_data['userid'];
              
                                $query = "SELECT distinct menu_id,id2,image,name  FROM cart WHERE userid='$who'";
                                $query_run = mysqli_query($conn,$query);

                                if (isset($_GET['menu_id']))
                                {
                                    $menu_id=$_GET['menu_id'];
                                    $delete=mysqli_query($conn, "DELETE FROM `cart` WHERE `menu_id`='$menu_id'");
                                    header("location:cart.php");
                                    die();
                                }
              
                            ?>
                            <table class="table">
                                <thread>
                                    <tr style="font-style: italic; color:darkblue;">
                                        <th>Product Image |</th>

                                        <th>Product Name</th>
                                    </tr>
                                <thread>
                                <tbody>
                                    <?php
                                        if(mysqli_num_rows($query_run) > 0)
                                        {    
                                            foreach($query_run as $row)
                                            {?>
                                                <tr>
                                                    <td>
                                                        <img src="<?php echo $row['image']; ?>" style="border-radius: 50%;" width="100px" height="200px" alt="Image">
                                                    </td>
                                                    <td><?php echo $row['name']; ?></td>
                                                    <td>
                                                        <a href="<?php echo 'cart.php?menu_id=' .$row['menu_id'] ?>" class="btn btn-info">CANCEL</a>
                                                    </td>
                                                </tr>
                                             <?php
                                            }
                                        }?>   
                                </tbody>
                            </table>
                                <a href="proceedcart.php" class="btn btn-info" style="bottom:5px; display:block; margin-left: 1254px; position: fixed;">Proceed</a>
                        </div>
                    </div>
            </section>
        </body>
    </html>
</html>