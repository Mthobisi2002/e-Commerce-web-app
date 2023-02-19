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
include 'classes/Rating.php';
$rating = new Rating();
if(!empty($_POST['action']) && $_POST['action'] == 'saveRating' 
	&& !empty($_POST['rating']) 
	&& !empty($_POST['itemId'])) {
		$userID = $user_data['userid'];	
		$rating->saveRating($_POST, $userID);	
		$data = array(
			"success"	=> 1,	
		);
		echo json_encode($data);		
}
if(!empty($_GET['action']) && $_GET['action'] == 'logout') {
	session_unset();
	session_destroy();
	header("Location:index.php");
}
?>