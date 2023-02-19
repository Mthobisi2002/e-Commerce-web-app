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
     
      $Street_Address =$_POST['Street_Address'];
      $Complex_Building = $_POST['Complex_Building'];
      $City_Town = $_POST['City_Town'];
      $Province = $_POST['Province'];
      $Postal_Code = $_POST['Postal_Code'];
      header("Location:EAProcess.php?streetaddress=".$Street_Address."&complexbuilding=".$Complex_Building."&citytown=".$City_Town."&province=".$Province."&userid=".$id."&postalcode=".$Postal_Code);
   }   

   $ID2 = $_GET['id2'];
   $conn= mysqli_connect("localhost","root","","food_db");   
   $query="SELECT `Street_Address` FROM `Addresses` WHERE `id2`='$ID2'";
   $query_run = mysqli_query($conn,$query);
   $rowData = mysqli_fetch_array($query_run);
   
   
   $query1="SELECT `Complex_Building` FROM `Addresses` WHERE `id2`='$ID2'";
   $query_run1 = mysqli_query($conn,$query1);
   $rowData1 = mysqli_fetch_array($query_run1);
   
   
   $query2="SELECT `City_Town` FROM `Addresses` WHERE `id2`='$ID2'";
   $query_run2 = mysqli_query($conn,$query2);
   $rowData2 = mysqli_fetch_array($query_run2);
   
   
   $query3="SELECT `Province` FROM `Addresses` WHERE `id2`='$ID2'";
   $query_run3 = mysqli_query($conn,$query3);
   $rowData3 = mysqli_fetch_array($query_run3);
   
   
   $query4="SELECT `Postal_Code` FROM `Addresses` WHERE `id2`='$ID2'";
   $query_run4 = mysqli_query($conn,$query4);
   $rowData4 = mysqli_fetch_array($query_run4);
   
   $query7="SELECT `id` FROM `Addresses` WHERE `id2`='$ID2'";
   $query_run7 = mysqli_query($conn,$query7);
   $rowData7 = mysqli_fetch_array($query_run7);
   $id = $rowData7[0];
   
?>

<style>


    #BackButton{
        background-color: black ;
        color: white;
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
        background-color: lightgreen;
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
        <!--header section starts-->

        <header style="background-color:lightblue;">
    
            <a href="#" class="logo"><i class="fas fa-utensils"></i>Script Kidoh's Kitchen.</a>

            <nav class="navbar">

                <a href="home.php">Home</a>
        
            </nav>
        </header>
        <section class="dishes" id="dishes">
            <h1 class="heading">Payment Appro</h1>
            <div class="box-container">
                <div class="box">
                    <head>
                        <title>100% Mthobisi Khanyile</title>
                    </head>
                    <body style="font-family: tahoma;background-color: lightyellow;">
                        <div id= "bar">
                        <div style="font-size: 30px; font-style:normal; color:darkblue; ">
                        <h1>edit your address</h1>
                </div>
                <button onclick="history.back()"  id="BackButton"></i>Back</button>
            </div>
            <div id="bar2">
                <form method="post" action="EditAddress.php" >

                    <input name="Street_Address" type="text" value = <?php echo $rowData[0] ?>  id="text" placeholder="Street Address" required><br><br>
                    <input name="Complex_Building" type="text"  id="text" placeholder="Complex/Building(Optional)"><br><br>

                    <span style="font-weight: normal; color: darkblue;"> Town : </span><br>
                    <select id="text" name="City_Town">
        
                        <option><?php echo $rowData2[0] ?><option>
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
                    <input name="Postal_Code" type="text"  value = <?php echo $rowData4[0] ?> id="text" placeholder="Postal Code" required><br><br>
                    <input type="submit" id="button" value="SAVE"><br><br><br>
                </form>
            </div>      
        </section>
    </html>
</html>


