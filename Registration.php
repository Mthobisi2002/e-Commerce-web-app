<?php
   
   include("classes/connect.php");
   include("classes/Registration.php");

   $first_name = "";
   $last_name = "";
   $gender = "";
   $email = "";

   if($_SERVER['REQUEST_METHOD'] == 'POST')
   {
        $Registration = new Registration();
        $result = $Registration->evaluate($_POST);

        if($result != "")
        {
            echo "<div style='text-align:center; font-size:12px; color:white; background-color:grey;'>";
            echo "<br>The following errors occured:<br><br>";
            echo $result;
            echo "</div>";
        }else
        {
            header("Location: login.php");
            die;
        }

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
    }   

?>

<style>
    #bar{
        height:100px;
        background-color: rgb(59,89,152);
        color:d9dfeb;
        padding:4px;
        
    }
    #Login_button{
        background-color: darkblue;
        color:white;
        width: 100px;
        text-align: center;
        padding: 4px;
        border-radius: 4px;
        float: right;
    }
    #bar2{
        background-color: white;
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
    background-image: url("images/login.jpeg");

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

        <div style="font-size: 40px; color:white;">Script Kidoh's Kitchen</div>
        <a href="Login.php" id="Login_button">Sign In</a>


        <div id="bar2">

            <div style="font-size: 40px; color:black;  ">Sign Up</div>

            <br><br>

            <form method="post" action="Registration.php">

                <input value="<?php echo $first_name ?>" name="first_name" type="text" id="text" placeholder="First name"><br><br>
                <input value="<?php echo $last_name ?>" name="last_name" type="text" id="text" placeholder="Last name"><br><br>

                <span style="font-weight: normal;"> Gender: </span><br>
                <select id="text" name="gender">

                    <options><?php echo $gender ?></options>
                    <option>Male</option>
                    <option>Female</option>

                </select>
                <br><br>

                <input name="email" type="text" id="text" placeholder="Email"><br><br>

                <input name="password" type="password" id="text" placeholder="Password"><br><br>
                <input name="password2" type="password" id="text" placeholder="Retype Password"><br><br>

                <input type="submit" id="button" value="SignUp"><br><br><br>

            </form>

        </div>

    </body>

</html>
