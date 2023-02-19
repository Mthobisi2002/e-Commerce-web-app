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
<?php
$who = $user_data['userid'];
$order_id = $_GET['order_id'];
$status = "Waiting";
$conn = mysqli_connect("localhost","root","","food_db");
$query =mysqli_query($conn, "UPDATE `order` SET `status`='$status' WHERE `userid`='$who' AND `status`='InComplete'");
$AfterRequest = "Thank you, <br> we have received your Delivery Request and it will be proccessed soon!";
header("location:Confirmation.php?success=".$AfterRequest);
die;

?>