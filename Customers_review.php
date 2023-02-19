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
        <body>
            <!--header section starts-->
            <header style="background-color:lightblue;">
                <a href="#" class="logo"><i class="fas fa-utensils"></i>Script Kidoh's Kitchen.</a>
                <div style=" color: white; font-size:30px;">
                    <h2>Reviews Section</h2>
                </div>
                <button onclick="history.back()" style="font-style: italic; color:white; bottom:640px; margin-left:0px; position:fixed; color:white;
                display: inline-block;  background: black; border-radius: .5rem; ">Previous</button>
                <nav class="navbar">
                <a class="active" href="Customers_review.php">review</a>
                <a href="Orders.php">order</a>
                <a href="ProfileView.php">Profile</a>
                <a href="AddDriver.php">Drivers</a>
                </nav>
            </header>

            <section class="dishes" id="dishes" style="background-color:lightyellow;">
                <h1 class="heading">Reviews section</h1>
        
                    <div class="box-container">
                        <div class="box" style="background-color:lightyellow; border: .1rem solid rgba(0,0,0,.2);">
                            <?php 
                                $conn = mysqli_connect("localhost","root","","food_db");
                                $query = "SELECT * FROM menu";
                                $query_run = mysqli_query($conn,$query);
                            ?>
                            <table class="table" style="background-color:yellow; border: .1rem solid rgba(0,0,0,.2);">
                                <thread>
                                    <tr style="font-style: italic; color:darkblue;">
                                        <th>food image|</th>
                 
                                        <th>food name|</th>
                 
                                        <th>food price</th>
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
                                                       <img src="<?php echo $row['image']; ?>" style="border-radius: 50%;" width="100px" alt="Image">
                                                    </td>
                                                    <td><?php echo '&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'. $row['name']; ?></td>
                                                    <td><?php echo '&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'$'.$row['price']; ?></td>
                                                    <td>
                                                    <a href="show_rating.php?menu_id=<?php echo $row['menu_id']; ?>" class="btn btn-info">Check Reviews</a>
                                                    </td>
                                                </tr>
                                             <?php
                                            }
                                        }
                                    ?>      
                                </tbody>
                            </table>
                        </div>
                    </div>
            </section>
        </body>
    </html>
</html>