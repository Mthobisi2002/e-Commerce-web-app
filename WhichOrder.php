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
            </header>
            <section class="dishes" id="dishes">
                <h1 class="heading">Order number : <?php echo $_GET['order_id'];?></h1>
                <div class="box-container">
                    <div class="box">
                        <?php 
                            $conn = mysqli_connect("localhost","root","","food_db");
                            $who=$user_data['userid'];
                            $order_id = $_GET['order_id'];
                            $query = "SELECT `order_id`,`qty`,`total_price`,`image`,`name`,`date` FROM `order` WHERE `order_id`='$order_id'";
                            $query_run = mysqli_query($conn,$query);
              
                        ?>
                        <table class="table">
                            <thread>
                                <tr style="font-style: italic; color:darkblue;">
    
                                    <th>Order id &nbsp</th>    
        
                                    <th>Product  Image &nbsp</th>
        
                                    <th>Product Name &nbsp</th>
            
                                    <th>Quantity &nbsp</th>
            
                                    <th>Total Price</th>
            
                                    <th>Date Ordered</th>

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
                                                  <img src="<?php echo $row['image']; ?>" style="border-radius: 50%;" width="100px" height="200px" alt="Image">
                                                </td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo '&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'. $row['qty']; ?></td>
                                                <td><?php echo '&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'. $row['total_price']; ?></td>
                                                <td><?php echo $row['date']; ?></td>      
                                            </tr>
                                            <?php
                                        }
                                        if($user_data['user_type'] == "")
                                        {?>
                                            <a href="<?php echo 'generatePDF.php?userid='.$who.'&order_id='.$order_id ?>" style="bottom:0px; display:block; margin-left: 0px; position: relative;" class="btn btn-info">Download Invoice</a>
                                            <?php
                                        }
                                    };
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </body>
    </html>
</DOCTYPE>