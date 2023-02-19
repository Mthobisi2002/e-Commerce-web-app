<?php
   
   include("classes/connect.php");
   include("classes/AddDriver.php");

   $driver_name = "";
   $email = "";
   $user_type = "";

   if($_SERVER['REQUEST_METHOD'] == 'POST')
   {

      $AddDriver = new AddDriver();
      $result = $AddDriver->evaluate($_POST);

      if($result != "")
      {
      echo "<div style='text-align:center; font-size:12px; color:white; background-color:grey;'>";
      echo "<br>The following errors occured:<br><br>";
      echo $result;
      echo "</div>";
      }else
      {
          header("Location: Home.php");
          die;
      }

      $driver_name = $_POST['driver_name'];
      $email = $_POST['email'];
      $user_type = $_POST['user_type'];
   }   

?>
<style>
    #bar{
    height:100px;
    background-color: lightgreen;
    color:d9dfeb;
    padding:4px;   
    }
    #HomeButton{
    background-color: black ;
    width: 70px;
    text-align: center;
    padding: 4px;
    border-radius: 4px;
    float: right;
    color: white;
    font-weight: bold;
    }
    #bar2{
    background-color: yellow;
    width: 800px;
    margin: auto;
    margin-top: 50px;
    padding: 10px;
    text-align: center;
    font-weight: bold;
    }
     #text{
    height:40px;
    width:300px;
    border-radius:4px;
    border:solid 1px #ccc;
    padding:4px;
    font-size:14px;
    }
    #button{
    width: 300px;
    height: 40px;
    border-radius: 4px;
    font-weight: bold;
    border: none;
    background-color: lightgreen;
    color: white;
    }
    .bg-img {
    /* The image used */
    background-image: url("images/AddDriver.png");
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
<html>
    <head>
        <title>100% Mthobisi Khanyile</title>
    </head>

    <body class="bg-img">
        <div style="font-size: 50px; text-align: center; color: white;">Add Driver</div>
        <a href="Home.php" id="HomeButton"></i>Home</a>
        <button onclick="history.back()" style="font-style: italic; color:white; bottom:640px; margin-left:0px; position:fixed; color:white;
        display: inline-block;  background: black; border-radius: .5rem; ">Previous</button>
        <div id="bar4">
            <form method="post" action="AddDriver.php">
                <input value="<?php echo $driver_name ?>" name="driver_name" type="text" id="text" placeholder="Driver's Name"><br><br>
                <select id="text" name="user_type">
                    <options><?php echo $user_type ?></options>
                    <option>Driver</option>
                </select>
                <br><br>
                <input name="email" type="text" id="text" placeholder="Email"><br><br>
                <input name="password" type="password" id="text" placeholder="Password"><br><br>
                <input name="password2" type="password" id="text" placeholder="Retype Password"><br><br>
                <input type="submit" id="button" value="Add"><br><br><br>
            </form>
        </div>
    </body>
</html>
