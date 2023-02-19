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
                <button onclick="history.back()" style="font-style: italic; color:white; bottom:640px; margin-left:0px; position:fixed; color:white;
                display: inline-block;  background: black; border-radius: .5rem; ">Previous</button>
                <?php
                    if($user_data['user_type'] == "Administrator"){

                        echo '<a href="#" class="logo"><i class="fas fa-utensils"></i>Script Kidoh Kitchen.</a>
                        <div style=" color: white; font-size:10px;">
                            <h2>orders made by customers</h2>
                        </div>
                        <nav class="navbar">
                            <a href="Home.php">Active Customers</a>
                            <a href="control.php">Control</a>
                            <a href="Customers_review.php">review</a>
                            <a class="active" href="#order">order</a>
                            <a href="ProfileView.php">Profile</a>
                            <a href="AddDriver.php">Drivers</a>  
                        </nav>';
                    }else if($user_data['user_type'] == "")
                    {

                        echo  '<div class="icons">
                        <a class="active" href="Cart.php" class="fas fa-shopping-cart"></a>
                        </div>
                        <a href="#" class="logo"><i class="fas fa-utensils"></i>Script Kidoh Kitchen.</a>
                        <div style=" color: white; font-size:30px;">
                            <h2>Orders</h2>
                        </div>
                        <nav class="navbar">
                            <a href="home.php">Home</a> 
                        </nav>';
                    }
                ?>
            </header>
            <?php
                if($user_data['user_type'] == ""){
                    ?>

                    <section class="dishes" id="dishes">


                        <h1 class="heading">Menu Control</h1>
    
                        <div class="box-container">
                            <div class="box">
                                <?php 
                                    $conn = mysqli_connect("localhost","root","","food_db");
                                    $who=$user_data['userid'];
                                    
                                    $query = "SELECT `order_id`,`id2`,`menu_id`,`qty`,`total_price`,`payment_mode`,`status`,`image`,`name`,`date` FROM `order` WHERE `userid`='$who' AND `status`!='Delivered'";
                                    $query_run = mysqli_query($conn,$query);
                  
                                ?>
                                <table class="table">
                                    <thread>
                                        <tr style="font-style: italic; color:darkblue;">
    
                                            <th>Order id</th>    
                    
                                            <th>Product  Image</th>
                    
                                            <th>Product &nbsp Name</th>
                    
                                            <th>Quantity</th>
                    
                                            <th>Total Price</th>
                    
                                            <th>Date Ordered</th>
                    
                                            <th>Payment Mode</th>
                                        </tr>
                                    </thread>
                                    <tbody>
                                        <?php
                                            if(mysqli_num_rows($query_run) > 0)
                                            {    
                                                foreach($query_run as $row)
                                                {?>
                                                    <tr>
                                                        <td><?php echo $row['order_id']; ?></td>
                                                        <td>
                                                          <img src="<?php echo $row['image']; ?>" style="border-radius: 50%;" width="100px" alt="Image">
                                                        </td>
                                                        <td><?php echo $row['name']; ?></td>
                                                        <td><?php echo '&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'. $row['qty']; ?></td>
                                                        <td><?php echo '&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'. $row['total_price']; ?></td>
                                                        <td><?php echo $row['date']; ?></td>
                                                        <td><?php echo '&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.$row['payment_mode']; ?></td>
                                                    </tr>
                                                    <?php
                                                }?>
                                                <?php
                                                    switch($row['status']){
                                                    case "InComplete":?><a href="DeliveryMethod.php" class="btn btn-info" style="bottom:0px; display:block; margin-left: 0px; position: relative;">Request Delivery</a><?php
                                                    break;  
                                                    case "Waiting":?><a href="<?php echo 'CheckStatus.php?order_id='.$row['order_id']; ?>" class="btn btn-info" style="bottom:0px; display:block; margin-left: 0px; position: relative;">Check Status</a><?php
                                                    break;
                                                    case "Driver Assigned":?><a href="<?php echo 'CheckStatus.php?order_id='.$row['order_id']; ?>" class="btn btn-info" style="bottom:0px; display:block; margin-left: 0px; position: relative;">Check Status</a><?php
                                                    break;
                                                    case "Driver Accepted":?><a href="<?php echo 'CheckStatus.php?order_id='.$row['order_id']; ?>" class="btn btn-info" style="bottom:0px; display:block; margin-left: 0px; position: relative;">Check Status</a><?php
                                                    break;
                                                    case "Out for Delivery":?><a href="<?php echo 'CheckStatus.php?order_id='.$row['order_id']; ?>"class="btn btn-info" style="bottom:0px; display:block; margin-left: 0px; position: relative;">Check Status</a><?php
                                                    break;
                                                    }
                                                ?>
                                                <a href="<?php echo 'generatePDF.php?userid='.$who.'&order_id='.$row['order_id'] ?>" style="bottom:0px; display:block; margin-left: 0px; position: relative;" class="btn btn-info">Download Invoice</a>
                                                <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                    <section class="dishes" id="dishes">


                        <h1 class="heading">Orders History</h1>

                        <div class="box-container">
                            <div class="box">
                                <?php 
                                    $conn = mysqli_connect("localhost","root","","food_db");
                                    $who=$user_data['userid'];
                                    
                                    $query = "SELECT `order_id`,`id2`,`menu_id`,`qty`,`total_price`,`payment_mode`,`status`,`image`,`name`,`date` FROM `order` WHERE `userid`='$who' AND `status`='Delivered' GROUP BY `order_id`";
                                    $query_run = mysqli_query($conn,$query);
              
                                ?>
                                <table class="table">
                                    <thread>
                                        <tr style="font-style: italic; color:darkblue;">

                                            <th>Order id</th>    

                                            <th>Date Ordered</th>

                                            <th>Payment Mode</th>
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
                                                        <td><?php echo $row['date']; ?></td>
                                                        <td><?php echo '&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.$row['payment_mode']; ?></td>
                                                
                                                        <?php
                                                        switch($row['status']){
                                                        case "Delivered":?><td><a href="<?php echo 'CheckStatus.php?order_id='.$row['order_id']; ?>" style="bottom:0px; display:block; margin-left: 0px; position: relative;">&nbsp &nbsp You Received</a><td><?php
                                                        break; }?>
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
                }else if($user_data['user_type'] == "Administrator"){
                    ?>
                    <section class="dishes" id="dishes"style="background-color:white;" >


                        <h1 class="heading">Menu Control</h1>

                        <div class="box-container">
                            <div class="box" style="background-color:white; border: .1rem solid rgba(0,0,0,.2);">
                                <?php 
                                    $conn = mysqli_connect("localhost","root","","food_db");
                                    $who=$user_data['userid'];
            
                                    $query = "SELECT `order_id`,`id2`,`menu_id`,`qty`,`total_price`,`payment_mode`,`status`,`image`,`name`,`date` FROM `order` GROUP BY `order_id`";
                                    $query_run = mysqli_query($conn,$query);
          
                                ?>
                                <table class="table"style="background-color:white; border: .1rem solid rgba(0,0,0,.2);" >
                                    <thread>
                                        <tr style="font-style: italic; color:darkblue;">

                                            <th>Order id</th>    

                                            <th>Date Ordered</th>

                                            <th>Payment Mode</th>

                                            <th>Status</th>
                                        </tr>
                                    </thread>
                                    <tbody>
                                        <?php
                                            if(mysqli_num_rows($query_run) > 0)
                                            {    
                                                foreach($query_run as $row)
                                                {?>
                                                    <tr>
                                                        <td><a href="<?php echo 'WhichOrder.php?order_id='.$row['order_id']; ?>" style="bottom:0px; display:block; margin-left: 0px; position: relative;"><?php echo $row['order_id']; ?></a></td>
                                                        <td><?php echo '&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.$row['date']; ?></td>
                                                        <td><?php echo '&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.$row['payment_mode']; ?></td>
                                                        <td><?php echo $row['status']; ?></td>
                                                        <?php
                                                            switch($row['status']){
                                                            case "Waiting":?> <td><a href="<?php echo 'AssignDriver.php?order_id='.$row['order_id']; ?>" class="btn btn-info">Assign Driver</a><td><?php
                                                            break;
                                                            case "InComplete":?><td><h1>must request<br>Delivery</h1><td><?php
                                                            break;
                                                            case "Driver Assigned":?><td><h1>Waiting for<br>Driver Approval</h1><td><?php
                                                            break;
                                                            case "Driver Accepted":?><td><h1>Driver has Approved</h1></td><?php
                                                            break;
                                                            case "Out for Delivery":?><td><h1>Driver out<br>for Delivery</h1></td><?php
                                                            break;
                                                            case "Delivered":?><td><h1>Customer Received</h1><?php
                                                            break;
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
        </body>
    </html>
</DOCTYPE>