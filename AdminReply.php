<?php

   include("classes/connect.php");
   include("classes/AdminReply.php");

   $replying = "";
   $ratingId = "";

   if($_SERVER['REQUEST_METHOD'] == 'POST')
   {

      $Reply = new Reply();
      $result = $Reply->evaluate($_POST);
      $replying = $_POST['replying'];
      $ratingId = $_POST['ratingId'];
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
      <section class="dishes" id="dishes">
         <h1 class="heading" style="color: white; font-size:30px;" >Reply</h1>
         <button onclick="history.back()" style="font-style: italic; color:white; bottom:640px; margin-left:0px; position:fixed; color:white;
         display: inline-block;  background: black; border-radius: .5rem; ">Previous</button>
         <div class="box-container">
            <div class="box">
				   <form method="POST" action="" style="background-color:lightblue;">
					   <div class="form-group">
                     <input type="hidden" class="form-control" id="ratingId" name="ratingId" value="<?php echo $_GET['ratingId']; ?>">
					   </div>
                  <?php
                     $conn = mysqli_connect("localhost","root","","food_db");
                     $ratingId2=$_GET['ratingId'];
                     $query="SELECT `reply` FROM `item_rating` WHERE `ratingId`='$ratingId2' ";
                     $query_run = mysqli_query($conn,$query);
                     if(mysqli_num_rows($query_run) < 0)
                     {?>
						      <input name="replying" class="form-control" rows="5" id="replying" type="text" style="height:200px; width:1000px;" >
                     <?php
                     }else if(mysqli_num_rows($query_run) > 0)
                     {
                        $rowData = mysqli_fetch_array($query_run);
                        $reply = $rowData[0]; ?>
						      <input name="replying" class="form-control" rows="5" id="replying" type="text" style="height:200px; width:1000px;" value="<?php echo $reply ?>">
                     <?php
                     }
                  ?>
					   <div class="form-group">
						   <button type="submit" class="btn btn-info"  id="saveReply">post</button>
					   </div>			  
				   </form>
            </div>
         </div>
      </section>
   </html>
</html>
