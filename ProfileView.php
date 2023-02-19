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
    //posting start here
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        
        $post = new Post();
        $id = $_SESSION['mybook_userid'];
        $result = $post->create_post($id, $_POST, $_FILES);

        if($result == "")
        {
            header("Location: profileView.php");
            die;
        }else
        {
            echo "<div style='text-align:center; font-size:12px; color:white; background-color:grey;'>";
            echo "<br>The following errors occured:<br><br>";
            echo $result;
            echo "</div>";
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
<html>
    <head>
        <title>100% Mthobisi Khanyile</title>
    </head>  
    <a href="Home.php" style="font-style: italic; color:white; bottom:640px; margin-left:0px; position:fixed; color:white;
    display: inline-block;  background: black; border-radius: .5rem; ">Home</a>
    <!--cover area-->
    <div style="width: 800px; margin: auto; min-height: 400px">
    <div style="background-color: white; text-align: center; color: #405d9b">

    <?php
        
        $image = "images/user_male.jpg";
        if($user_data['gender'] == "Female")
        {
            $image = "images/user_female.jpg";
        }
        if(file_exists($user_data['profile_image']))
        {

            $image = $image_class->get_thumb_profile($user_data['profile_image']);
        }
    ?>
    <img id="profile_pic" src="<?php echo $image ?>"><br/>
        <a style="text-decoration: none; color: #f0f;" href="change_profile_image.php? change=profile">Change Profile Image</a> |
    </span>
    <br>
    <div style="font-size: 20px; color: black;"><?php echo $user_data['first_name'] . " " . $user_data['last_name'] ?></div>
    <br>
</html>
