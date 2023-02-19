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
  background-image: url("images/payment5.jpg");

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
        <a href="cart.php" style="font-style: italic; color:white; bottom:620px; margin-left:-50px; position:fixed; color:white;
        display: inline-block;  background: black; border-radius: .5rem; ">Previous</a>
        <a href="#" class="logo"><i class="fas fa-utensils"></i>Script Kidoh's Kitchen.</a>
        <div style=" color: white; font-size:30px;">
          <h2>Payment</h2>
        </div>
        <nav class="navbar">
          <a href="home.php">Home</a>
        </nav>
      </header>
      <section class="dishes" id="dishes">


        <h1 class="heading">Menu Control</h1>

        <div class="box-container">
          <div class="bg-img">
            <?php 
              $conn = mysqli_connect("localhost","root","","food_db");
              $who=$user_data['userid'];
              $query = "SELECT image,name,price,qty,id2,menu_id,total_price FROM cart WHERE userid='$who'";
              $query_run = mysqli_query($conn,$query); 
              if (isset($_GET['menu_id']))
              {
                $menu_id=$_GET['menu_id'];
                $checkqty =mysqli_query($conn,"SELECT qty FROM cart WHERE `userid`='$who' AND `menu_id`='$menu_id'");
                $rowData1 = mysqli_fetch_array($checkqty);
                $qty = $rowData1[0];
                if($qty > 1)
                {
                  $minus=mysqli_query($conn, "UPDATE `cart` SET `qty`=`qty`-1 WHERE `menu_id`='$menu_id'");
                  header("location:ProceedCart.php");
                  exit;
                }else if($qty=1)
                {
                  $delete=mysqli_query($conn, "DELETE FROM `cart` WHERE `menu_id`='$menu_id'");
                  header("location:ProceedCart.php");
                  die();
                }
              
              }  
            ?>
            <table class="table">
              <thread >
                <tr style="font-style: italic; color:darkblue;">
                  <th>Product Image | &nbsp</th>

                  <th>Product Name |  &nbsp</th>

                  <th>Product Price | &nbsp</th>

                  <th>Quantity | &nbsp</th>

                  <th>Total Price</th>
                </tr>
              </thread>
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
                        <td><?php echo '&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'$'.$row['price']; ?></td>
                        <td><?php echo '&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'*'.$row['qty']; ?></td>
                        <td><?php echo '&nbsp'.'&nbsp'.'&nbsp'.'$'.$row['total_price']; ?></td>
                        <td>
                          <a href="<?php echo 'proceedcart.php?menu_id=' .$row['menu_id'] ?>" class="btn btn-info">Minus 1</a>
                        </td>
                      </tr>
                      <?php 
                    }
                    $query_run3 = mysqli_query($conn,"SELECT `status` FROM `order` WHERE `userid`='$who' AND `status`!='Delivered'");
                    $rowData3 = mysqli_fetch_array($query_run3);
                    if(empty($rowData3) && mysqli_num_rows($query_run) > 0)
                    { ?>
                      <div id="paypal-button" style="bottom:15px; display:block; margin-left:1095px; position: fixed;"></div>
                      <?php 
                    }else if(!empty($rowData3) && mysqli_num_rows($query_run) > 0)
                    {?>
                      <h1 style="bottom:15px; display:block; margin-left:1095px; position: fixed;">You have an uncomplete order</h1>
                      <?php
                    }
                  }
                ?>
              </tbody>
            </table> 
          </div>
        </div>

     
        <?php
        
          $query2 = "SELECT SUM(total_price) FROM cart WHERE userid='$who'";
          $query_run2 = mysqli_query($conn,$query2);
          mysqli_num_rows($query_run2);
          $rowData2 = mysqli_fetch_array($query_run2);
        
        ?>
        
        <div class="col-lg-4">
          <!---configure paypal environment (script tags)--->
          <script src="https://www.paypalobjects.com/api/checkout.js"></script>
          <script>
            paypal.Button.render({
              //Configure environment
              env: 'sandbox',
              client: {
                sandbox: 'AV05X0ed6eZzG8wnshcUPwUog_inaNKvA_AhmYHh6wXWhTuLjpz3FP-TEbUjqcyYzVad5WFA7h9pnY9P',
              },
              //Custom button (optional)
              locale:'en_US',
              style: {
              size: 'small',
              color: 'gold',
              shape: 'pill',
              },
      
                
              //Enable Pay Now checkout flow (optional)
              commit: true,
      
              //set up a payment
              payment : function(data,actions){
                return actions.payment.create({
                  transactions: [{
                    amount: {
                      total: '<?= $rowData2[0] ?>',
                        currency: 'USD',
                    }
                  }]
                });
              },
              //Execute the payment
              onAuthorize: function(data, actions){
                return actions.payment.execute().then(function() {
                  window.location="process.php";
                });
              }
            }, '#paypal-button');
          </script>
        <div>
      
      </section>
    </body>
  </html>
</DOCTYPE>
      