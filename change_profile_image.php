<?php
    session_start();
    include("classes/connect.php");
    include("classes/login.php");
    include("classes/user.php");
    include("classes/post.php");
    include("classes/image.php");

    $login = new Login();
    $user_data = $login->check_login($_SESSION['mybook_userid']);

    //posting starts here
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {

        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "")
        {

            if($_FILES['file']['type'] == "image/jpeg")
            {
                $allowed_size = (1024 * 1024) * 3;
                if($_FILES['file']['size'] < $allowed_size)
                {
                    //everything is fine
                    $folder = "uploads/" . $user_data['userid'] . "/";

                    //create folder
                    if(!file_exists($folder))
                    {
                        mkdir($folder,0777,true);
                    }
                    $image = new Image();

                    $filename = $folder . $image->generate_filename(15) . ".jpg";
                    move_uploaded_file($_FILES['file']['tmp_name'], $filename);

                    $change = "profile";

                    //check for mode
                    if(isset($_GET['change']))
                    {

                     $change = $_GET['change'];
                    }
                  
                    if(file_exists($user_data['profile_image']))
                    {
                         unlink($user_data['profile_image']);
                    }
                    $image->resize_image($filename,$filename,1500,1500);
                  
                    if(file_exists($filename))
                    {

                        $userid = $user_data['userid'];
                        $query = "update users set profile_image = '$filename' where userid = '$userid' limit 1";
                        $_POST['is_profile_image'] = 1;
                        $DB = new Database();
                        $DB->save($query);
                        header(("Location: profileView.php"));
                        die;
                    }
                
                }else
                {
                    echo "<div style='text-align:center; font-size:12px; color:white; background-color:grey;'>";
                    echo "<br>The following errors occured:<br><br>";
                    echo "only images of size 3mb or lower are allowed!";
                    echo "</div>";
                }

            }else
            {
                echo "<div style='text-align:center; font-size:12px; color:white; background-color:grey;'>";
                echo "<br>The following errors occured:<br><br>";
                echo "only images of jpeg type are allowed!";
                echo "</div>";
            }
        
        }else
        {
            echo "<div style='text-align:center; font-size:12px; color:white; background-color:grey;'>";
            echo "<br>The following errors occured:<br><br>";
            echo "please add a valid image!";
            echo "</div>";
        }

    }
    

?>

<style type="text/css">
    #blue_bar{

        height: 50px;
        background-color: #405d9b;
        color: #d9dfeb;
    }
    #search_box{

        width: 400px;
        height: 26px;
        border-radius: 5px;
        border: none;
        padding: 4px;
        font-size: 14px;
        background-image: url(search.png);
        background-repeat: no-repeat;
        background-position: right;

    }
    #post_button{

        float: right;
        background-color: #405d9b;
        border: none;
        color: white;
        padding: 4px;
        font-size: 14px;
        border-radius: 2px;
        width: 100px;

    }
    #post_bar{

        margin-top: 20px;
        background-color: white;
        padding: 10px;
    }
    #post{

        padding: 4px;
        font-size: 13px;
        display: flex;
        margin-bottom: 20px;
    }   
</style>

<html>
    <head>
      <title>100% Mthobisi Khanyile</title>
    </head>
    <button onclick="history.back()" style="font-style: italic; color:white; bottom:640px; margin-left:0px; position:fixed; color:white;
    display: inline-block;  background: black; border-radius: .5rem; ">Previous</button>
    <div style="width: 800px; margin: auto; min-height: 400px">
        <!--below cover area-->
        <div style="display: flex;">
            <!--posts area-->
            <div style="min-height: 400px; flex: 2.5; padding: 20px; padding-right: 0px;">
                <form method="post" enctype="multipart/form-data">
                    <div style="border: solid thin #aaa; padding: 10px; background-color: white;">
                        <input type="file" name="file">
                        <input id="post_button" type="submit" value="Change">
                        <br>
                        <div style = "text-align: center;">
                        <br><br>
                        <?php
                            //check for mode
                            echo "<img src= '$user_data[profile_image]' style = 'max-width: 500px;' >";
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
 </html>
