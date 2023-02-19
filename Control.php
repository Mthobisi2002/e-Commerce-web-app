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

            <header  style="background-color:lightblue;">
            <a href="#" class="logo"><i class="fas fa-utensils"></i>Script Kidoh's Kitchen</a>
            <a href="Home.php" style="font-style: italic; color:white; bottom:640px; margin-left:0px; position:fixed; color:white;
            display: inline-block;  background: black; border-radius: .5rem; ">Home</a>

            <div style=" color: white; font-size:30px;">
                <h2>Control Section</h2>
            </div>

            <nav class="navbar">
                <a href="AddProduct.php">Add Product</a>  
            </nav>

            </header>

                <section class="dishes" id="dishes" style="background-color:lightyellow;">


                    <h1 class="heading">Menu Control</h1>

                    <div class="box-container" >
                        <div class="box" style="background-color:lightyellow; border: .1rem solid rgba(0,0,0,.2);">
                            <?php 
                                $conn = mysqli_connect("localhost","root","","food_db");

                                $query = "SELECT * FROM menu";
                                $query_run = mysqli_query($conn,$query);

                                if (isset($_GET['id']))
                                {
                                    $id=$_GET['id'];
                                    $delete=mysqli_query($conn, "DELETE FROM `menu` WHERE `id`='$id'");
                                    header("location:control.php");
                                    die();
                                }
                            ?>
                            <table class="table" style="background-color:yellow; border: .1rem solid rgba(0,0,0,.2);">
                                <thread>
                                    <tr style="font-style: italic; color:darkblue;">
                                        <th>Product Image|&nbsp &nbsp</th>

                                        <th>Product Name|&nbsp &nbsp</th>

                                        <th>Product Price</th>
                                    </tr>
                                </thread>
                                <tbody >
                                    <?php
                                        if(mysqli_num_rows($query_run) > 0)
                                        {
                                            foreach($query_run as $row)
                                            {?>
                                                <tr>
                                                    <td>
                                                        <img src="<?php echo $row['image']; ?>" style="border-radius: 50%;" width="100px" alt="Image">
                                                    </td>
                                                    <td><?php echo '&nbsp'. $row['name']; ?></td>
                                                    <td><?php echo '&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'$'.$row['price']; ?></td>
                                                    <td>
                                                        <a href="<?php echo 'control.php?id=' .$row['id'] ?>" class="btn btn-info">DELETE</a>
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
