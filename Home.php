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
  $conn = mysqli_connect("localhost","root","","food_db");
  $userid = $user_data['userid'];
  $sql = "SELECT SUM(qty) FROM cart WHERE userid='$userid'";
  $query_run10 = mysqli_query($conn,$sql);
  mysqli_num_rows($query_run10);
  $rowData10 = mysqli_fetch_array($query_run10);

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
                <?php
                    if($user_data['user_type'] == "Administrator"){
                        echo '<a href="#" class="logo"><i class="fas fa-utensils"></i>Script Kidoh Kitchen.</a>
                        <div style=" color: white; font-size:10px;">
                            <h2>know your customers</h2>
                        </div>
                        <div style=" color: white; font-size:15px;">
                            <a href="Home.php?action=logout">Logout</a>
                        </div>
                        <nav class="navbar">
                            <a class="active" href="Home.php">Active Customers</a>
                            <a href="control.php">Control</a>
                            <a href="Customers_review.php">review</a>
                            <a href="Orders.php">order</a>
                            <a href="ProfileView.php">Profile</a>
                            <a href="AddDriver.php">Drivers</a>
                         </nav>';
                    }if($user_data['user_type'] == "")
                    {?>
                        <a href="#" class="logo"><i class="fas fa-utensils"></i>Script Kidoh Kitchen.</a>
                        <div style=" color: white; font-size:15px; margin-left:-50px; position:fixed;">
                            <a href="Home.php?action=logout">Logout</a>
                        </div>
                        <div style=" color: white; font-size:10px; margin-left:600px; position:fixed; ">
                            <h2>Our Menu To You</h2>
                        </div>
                        <nav class="navbar">
                            <a class="active" href="Home.php">menu</a>
                            <a href="orders.php">order</a>
                            <a href="ProfileView.php">Profile</a>
                        </nav>
                        <div class="icons">
                            <a href="cart.php" style="font-style: italic; color:gold; font-size:27px;" class="fas fa-shopping-cart">&nbsp &nbsp<?php echo $rowData10[0]; ?></a>
                        </div>
                        <?php
                    }if($user_data['user_type'] == "Driver")
                    {
                        echo '<a href="#" class="logo"><i class="fas fa-utensils"></i>Script Kidoh Kitchen.</a>
                        <div style=" color: white; font-size:10px;">
                            <h2>Deliveries Assigned To You</h2>
                        </div>
                        <div style=" color: white; font-size:15px;">
                            <a href="Home.php?action=logout">Logout</a>
                        </div>
                        <nav class="navbar">
                            <a class="active" href="#Home">Assigned Deliveries</a>
                        </nav>';
                    }
                ?>
            </header>

            <!--header section ends-->


            <!-- Active Customers -->

            <div style="display: flex;">

                <div style="min-height: 400px; flex: 1;">
             
                    <div id="friends_bar">

                        <?php
                            if($user_data['user_type'] == "Administrator"){
                                if($friends)
                                {
                                    foreach ($friends as $FRIEND_ROW) {
                                    # code...
                                    include("user.php");
                                     }
                                }?>
                                <?php
                            }if($user_data['user_type'] == ""){
                                $conn = mysqli_connect("localhost","root","","food_db");
                                $who=$user_data['userid'];  
                                if(isset($_GET['id']))
                                {
                                    $id=$_GET['id'];
                                    $qty=1;
                                    $query_run11=mysqli_query($conn, "SELECT `menu_id` FROM `menu` WHERE `id`='$id'");
                                    $rowData11 = mysqli_fetch_array($query_run11);
                                    $menu_id = $rowData11[0];
                                    $query_run12 = mysqli_query($conn, "SELECT * FROM `cart` WHERE `menu_id`='$menu_id'");
                                    if(mysqli_num_rows($query_run12) > 0)
                                    {
                                        $updateqty=mysqli_query($conn,"UPDATE `cart` SET `qty`=`qty`+'$qty',`total_price`=`price`*`qty` WHERE `menu_id`='$menu_id'");
                                        header("location:Home.php?menu_id=".$menu_id);
                                    }else{
                                        $addcart=mysqli_query($conn, "INSERT INTO `cart` (`id2`,`menu_id`,`price`,`image`,`name`,`userid`,`qty`,`total_price`)
                                        SELECT `id2`,`menu_id`,`price`,`image`,`name`,$who,$qty,price FROM `menu` WHERE `id`='$id'");
                                        header("location:Home.php?menu_id=".$menu_id);
                                    }
                                }
                                if(isset($_GET['action'])) {
                                    session_unset();
                                    session_destroy();
                                    header("Location:Login.php");
                                }
                                include('index.php');
                                ?>
                                <?php
                            }if($user_data['user_type']=="Driver")
                            {?>
                                <section class="dishes" id="dishes">
                                    <h1 class="heading">Our Menu to You</h1>
                    
                                        <div class="box-container">
                                            <div class="box">
                                                <?php 
                                                    $conn = mysqli_connect("localhost","root","","food_db");
                                                    $who=$user_data['userid'];
                                                    $query1="SELECT `first_name` FROM `users` WHERE `userid`='$who'";
                                                    $query_run1 = mysqli_query($conn,$query1);
                                                    $rowData1 = mysqli_fetch_array($query_run1);
                                                    $driver_name = $rowData1[0];
                                                    $query = "SELECT `order_id`,`image`,`name`,`qty`,`total_price`,`status` FROM `order` WHERE `driver_name`='$driver_name' GROUP BY `order_id`";
                                                    $query_run = mysqli_query($conn,$query);
                                                    if(isset($_GET['action'])) {
                                                     session_unset();
                                                     session_destroy();
                                                     header("Location:login.php");
                                                     }
                                                ?>
                                                <table class="table">
                                                    <thread>
                                                        <tr style="font-style: italic; color:darkblue;">
                                                            <th>Order Id</th>
                                                        </tr>
                                                    </thread>
                                                    <tbody>
                                                        <?php
                                                            if(mysqli_num_rows($query_run) > 0)
                                                            {
                                                                foreach($query_run as $row)
                                                                {?>
                                                                    <tr>
                                                                        <td><a href="<?php echo 'WhichOrder.php?order_id='.$row['order_id']; ?>"><?php echo $row['order_id']; ?></a></td>
                                                                        <?php
                                                                            switch($row['status']){
                                                                            case "Driver Assigned":?> <td><a href="<?php echo 'DAProcess.php?order_id=' .$row['order_id'] ?>" class="btn btn-info">Accept</a><td><?php
                                                                            break;
                                                                            case "Driver Accepted":?><td><a href="<?php echo 'DUpdate.php?order_id=' .$row['order_id'] ?>" class="btn btn-info">Update Status</a><td><?php
                                                                            break;
                                                                            case "Out for Delivery":?><td><a href="<?php echo 'DUpdate.php?order_id=' .$row['order_id'] ?>" class="btn btn-info">Update Status</a><td><?php
                                                                            break;
                                                                            default:?><td><h1>All Done</h1><td><?php
                                                                            }
                                                                        ?>
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
                              <?php
                            }
                            ?>  
                        </div>
                    </div>
                </div>
            </div>
        </body>
    </html>
</DOCTYPE>