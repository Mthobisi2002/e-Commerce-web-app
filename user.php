
<div id="friends">

<?php
  if(isset($_GET['action'])) {
	  session_unset();
	  session_destroy();
	  header("Location:login.php");
  }

  $image = "images/user_male.jpg";
  if($FRIEND_ROW['gender'] == "Female")
  {
    $image = "images/user_female.jpg";
  }
  if(file_exists($FRIEND_ROW['profile_image']))
  {
    $image = $image_class->get_thumb_profile($FRIEND_ROW['profile_image']);
  }
?>

<style>
  #friends_img{
  width:300px;
  height:300px;
  position:relative;
  bottom:-100px;
  display: block;
  margin-left: 500px;
  }
</style>

<?php
  if($FRIEND_ROW['user_type'] !== "Driver")
  {?>
    <a href = "#?id=<?php echo $FRIEND_ROW['userid']; ?>">
    <div class="box" style="background-color:white; border: .1rem solid rgba(0,0,0,.2);"> 
      <img id="friends_img"   src="<?php echo $image ?>">
      <br>
      <div style="font-style: normal; color: black; font-size:10px; bottom:200px; display:block; margin-left: 1000px; position: relative;">
        <h2>Name & Surname :</h2>
      </div>
    <div style="font-style: italic; color: gold; bottom:225px; display:block; margin-left: 1150px; position: relative;">
      <h1><?php echo $FRIEND_ROW['first_name'] . " " . $FRIEND_ROW['last_name'] ?></h1>
    </div>
    <?php
      $userid = $FRIEND_ROW['userid'];
      $conn = mysqli_connect("localhost","root","","food_db");
      $query="SELECT `Street_Address` FROM `addresses` WHERE `userid`='$userid'";
      $query_run = mysqli_query($conn,$query);
      $rowData = mysqli_fetch_array($query_run);

      $query1="SELECT `Complex_Building` FROM `addresses` WHERE `userid`='$userid'";
      $query_run1 = mysqli_query($conn,$query1);
      $rowData1 = mysqli_fetch_array($query_run1);

      $query2="SELECT `City_Town` FROM `addresses` WHERE `userid`='$userid'";
      $query_run2 = mysqli_query($conn,$query2);
      $rowData2 = mysqli_fetch_array($query_run2);

      $query3="SELECT `Province` FROM `addresses` WHERE `userid`='$userid'";
      $query_run3 = mysqli_query($conn,$query3);
      $rowData3 = mysqli_fetch_array($query_run3);

      $query4="SELECT `Postal_Code` FROM `addresses` WHERE `userid`='$userid'";
      $query_run4 = mysqli_query($conn,$query4);
      $rowData4 = mysqli_fetch_array($query_run4);
    ?>
    <div style="font-style: normal; color: black; font-size:10px; bottom:210px; display:block; margin-left: 1000px; position: relative;">
      <h3>Street Address :</h3>
    </div>
    <?php 
      if(!empty($rowData))
      { ?>
        <div style="font-style: italic; color: blue; bottom:225px; display:block; margin-left: 1150px; position: relative;">
          <h4><?php echo $rowData[0] ?></h4>
        </div>
      <?php
      }
    ?>
    <div style="font-style: normal; color: black; font-size:10px; bottom:200px; display:block; margin-left: 1000px; position: relative;">
      <h3>Complex Building :</h3>
    </div>
    <?php 
    if(!empty($rowData1))
    {?>
      <div style="font-style: italic; color: blue; bottom:215px; display:block; margin-left: 1150px; position: relative;">
        <h4><?php echo $rowData1[0] ?></h4>
      </div>
      <?php 
    }    
    ?>
    <div style="font-style: normal; color: black; font-size:10px; bottom:190px; display:block; margin-left: 1000px; position: relative;">
      <h3>City/Town :</h3>
    </div>
    <?php
    if(!empty($rowData2))
    {?>
      <div style="font-style: italic; color: blue; bottom:205px; display:block; margin-left: 1150px; position: relative;">
        <h4><?php echo $rowData2[0] ?></h4>
      </div>
      <?php
    }?>
    <div style="font-style: normal; color: black; font-size:10px; bottom:180px; display:block; margin-left: 1000px; position: relative;">
      <h3>Province :</h3>
    </div>
    <?php
      if(!empty($rowData3))
      {?>
        <div style="font-style: italic; color: blue; bottom:195px; display:block; margin-left: 1150px; position: relative; ">
          <h4><?php echo $rowData3[0] ?></h4>
        </div>
        <?php
      }?>
      <div style="font-style: normal; color: black; font-size:10px; bottom:170px; display:block; margin-left: 1000px; position: relative;">
        <h3>Postal Code :</h3>
      </div>
      <?php
      if(!empty($rowData4))
      { ?>
        <div style="font-style: italic; color: blue; bottom:185px; display:block; margin-left: 1150px; position: relative;">
          <h4><?php echo $rowData4[0] ?></h4>
        </div>
        <?php 
      }?>
      <div style="font-style: normal; color: black; font-size:10px; bottom:160px; display:block; margin-left: 1000px; position: relative;">
        <h3>Money Spent :</h3>
      </div>
      <?php
      $query5 = "SELECT SUM(`total_price`) FROM `order` WHERE `userid`='$userid'";
      $query_run5 = mysqli_query($conn,$query5);
      mysqli_num_rows($query_run5);
      $rowData5 = mysqli_fetch_array($query_run5);
      if(!empty($rowData5)){?>
        <div style="font-style: italic; color: green; bottom:175px; display:block; margin-left: 1150px; position: relative;">
          <h4><?php echo "$ ".$rowData5[0] ?></h4>
        </div>
        <?php
      }

    ?>
    <?php
  }
?>