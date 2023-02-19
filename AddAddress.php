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


   if($_SERVER['REQUEST_METHOD'] == 'POST')
   {
      $who=$user_data['userid'];
      $Street_Address =$_POST['Street_Address'];
      $Complex_Building = $_POST['Complex_Building'];
      $City_Town = $_POST['City_Town'];
      $Province = $_POST['Province'];
      $Postal_Code = $_POST['Postal_Code'];
      header("Location:AAProcess.php?streetaddress=".$Street_Address."&complexbuilding=".$Complex_Building."&citytown=".$City_Town."&province=".$Province."&postalcode=".$Postal_Code."&userid=".$who);
   }   

?>
<style>
    #BackButton{
    background-color: black ;
    color:white;
    width: 70px;
    text-align: center;
    padding: 4px;
    border-radius: 4px;
    float: left;
    }
    #bar2{
    background-color: lightyellow;
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
    background-color: green;
    color: white;
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
            <header>
                <nav class="navbar">
                    <a href="home.php">Home</a>
                </nav>
            </header>
            <section class="dishes" id="dishes">
                <h1 class="heading"></h1>
                <div class="box-container">
                    <div class="box">
                    <head>
                        <title>Delivery Address</title>
                    </head>
                    <body style="font-family: tahoma;background-color: lightyellow;">
                        <div id= "bar">
                            <div style="font-size: 30px; font-style:normal; color:darkblue; ">
                                <h1>add your address</h1>
                            </div>
                            <button onclick="history.back()"  id="BackButton"></i>Back</button>
                        </div>
                        <div id="bar2">
                            <form method="post" action="AddAddress.php" >
                                <input name="Street_Address" type="text" id="text" placeholder="Street Address" required><br><br>
                                <input name="Complex_Building" type="text"  id="text" placeholder="Complex/Building(Optional)"><br><br>
                                <span style="font-weight: normal; color: darkblue;"> Town : </span><br>
                                <select id="text" name="City_Town">
                                    <option>Ntuzuma</option>
                                    <option>KwaMashu</option>
                                    <option>NewLands</option>
                                    <option>Nanda</option>
                                    <option>Mlazi</option>
                                    <option>Phoniex</option>
                                    <option>uMhlanga</option>
                                    <option>Durban North</option>
                                    <option>La Lucia</option>
                                </select>
                                <br><br>
                                <span style="font-weight:normal; color: darkblue;"> Province : </span><br>
                                <select id="text" name="Province">
                                    <option>KwaZulu-Natal</option>
                                </select>
                                <br><br>
                                <input name="Postal_Code" type="text" id="text" placeholder="Postal Code" required><br><br>
                                <input type="submit" id="button" value="SAVE"><br><br><br>
                            </form>
                        </div>
                    </body>
                <div>
            </section>
        </body>
    </html>
</html>





