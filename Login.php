<?php

    session_start();
    
    include("classes/connect.php");
    include("classes/login.php");
    
    
    $email = "";
    $password= "";
    
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
    
       $login = new Login();
       $result = $login->evaluate($_POST);
    
       if($result != "")
       {
            echo "<div style='text-align:center; font-size:12px; color:white; background-color:grey;'>";
            echo "<br>The following errors occured:<br><br>";
            echo $result;
            echo "</div>";
       }else
       {
           header("Location:Home.php");
           die;
       }
    
       $email = $_POST['email'];
       $Password = $_POST['password'];
    }   

?>

<style>
    #bar{
        height:100px;
        background-color: lightgreen;
        color:d9dfeb;
        padding:4px;
        
    }
    #signup_button{
        background-color:darkblue ;
        width: 100px;
        color: white;
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
    #bar3{
        background-color: white;
        width: 200px;
        margin: left;
        margin-top: -350px;
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
        <div style="font-size: 40px; color:white;  ">Script Kidoh's Kitchen</div>
        <a href="Registration.php" id="signup_button">Sign Up</a>
        <div id="bar2">

            <form method="post">
                <div style="font-size: 40px; color:black;  ">Sign In</div>
                <br><br>

                <input name="email" value="<?php echo $email ?>" type="text" id="text" placeholder="Email"><br><br>
                <input name="password" value="<?php echo $password ?>" type="password" id="text" placeholder="Password"><br><br>
            
                <input type="submit" id="button" value="LogIn">
                <br><br>
            <form>
        </div>

        <div id="bar3">

            <form method="post">
                <div style="font-size: 35px; color:red; font-style: italic;">Login details(HELP)</div>
                <br>
                <div style="font-size: 30px; color:darkred; font-style: italic;">Administrator</div>
                <br>
                <div style="font-size: 30px; color:black; font-style: italic;">Email:</div>
                <div style="font-size: 15px; color:blue; font-style: bold;">Khanyile.x.za@gmail.com</div>
                <div style="font-size: 30px; color:black; font-style: italic;">Password:</div>
                <div style="font-size: 15px; color:blue; font-style: bold;">Mtho@Admin</div>
                <br>
                <div style="font-size: 30px; color:darkred; font-style: italic;">Driver</div>
                <br>
                <div style="font-size: 30px; color:black; font-style: italic;">Email:</div>
                <div style="font-size: 15px; color:blue; font-style: bold;">DriverOne@gmail.com</div>
                <div style="font-size: 30px; color:black; font-style: italic;">Password:</div>
                <div style="font-size: 15px; color:blue; font-style: bold;">1234</div>
                <br>
                <div style="font-size: 30px; color:darkred; font-style: italic;">Customer</div>
                <br>
                <div style="font-size: 15px; color:blue; font-style: bold;">Create account(Sign Up)<p>then login(Sign In)</div>
                <nav class="navbar">
                    <a href="About.php">About Me & web app</a>
                </nav>
            <form>
        </div>

    </body>
</html>
