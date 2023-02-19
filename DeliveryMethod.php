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
      <a href="orders.php" style="font-style: italic; color:white; bottom:640px; margin-left:0px; position:fixed; color:white;
      display: inline-block;  background: black; border-radius: .5rem; ">Previous</a>
      <!--header section starts-->
      <section class="dishes" id="dishes">
        <h1 class="heading">Delivery Method</h1>
          <div class="box-container">
            <div class="box">
              <?php 
                $conn = mysqli_connect("localhost","root","","food_db");
                $who=$user_data['userid'];
      
                $query = "SELECT id2,id,Street_Address,Complex_Building,City_Town,Province,Postal_Code FROM Addresses WHERE userid='$who'";
                $query_run = mysqli_query($conn,$query);
                if (isset($_GET['id']))
                {
                  $id=$_GET['id'];
                  $delete=mysqli_query($conn, "DELETE FROM `addresses` WHERE `id`='$id'");
                  header("location:DeliveryMethod.php");
                  exit;
                } 
              ?>
            <table class="table">
              <thread>
                <tr style="font-style: italic; color:darkblue;">
                  <th>Street Address &nbsp &nbsp</th>

                  <th>Complex Building &nbsp &nbsp</th>

                  <th>City/Town &nbsp &nbsp</th>

                  <th>Province &nbsp &nbsp</th>

                  <th>Postal Code</th>
                </tr>
              </thread>
              <tbody>
                <?php
                  if(mysqli_num_rows($query_run) > 0)
                  {    
                    foreach($query_run as $row)
                    {?>
                      <tr>
                                         
                        <td><?php echo $row['Street_Address']; ?></td>
                        <td><?php echo '&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.$row['Complex_Building']; ?></td>
                        <td><?php echo $row['City_Town']; ?></td>
                        <td><?php echo '&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.$row['Province'];?></td>
                        <td><?php echo '&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.$row['Postal_Code'];?></td>
                        <td>
                         <a href="<?php echo 'DeliveryMethod.php?id=' .$row['id'] ?>" class="btn btn-info">Delete</a>
                        </td>
                        <td>
                         <a href="<?php echo 'EditAddress.php?id2=' .$row['id2'] ?>" class="btn btn-info">Edit</a>
                        </td>
                        <td>
                         <a href="RDProcess.php" class="btn btn-info">CONFIRM</a>
                        </td>
                                    
                      </tr>
                      <?php
                    }
                  }else
                  {
                  ?>
                  <tr>
                    <td><td>
                    <td><td>
                    <td><td>
                    <td><td>
                    <td><td>
                    <td>
                      <a href="AddAddress.php" class="btn btn-info">Add Address</a>
                    <td> 
                  </tr>
                  <?php
                  }
                ?>
              </tbody>
            </table>
            </div>
          </div>
        </div>
      </section>
    </body>
  </html>
</html>
