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

<style>

    body{
    min-height: 50vh;
    font-family: 'Exo 2';
    font-size: 14px;   
    color: #fff;
    background:white;	
    }
    .modal-content{
    background-color: green;
    border-color: #42469d;
    border-radius: 1rem;
    }
    @media (min-width: 576px){
    .modal-dialog {
    max-width: 750px;
    margin: 1.75rem auto;
    }
    }
    .show{
    padding: 0;
    }
    .modal-header{
    border-bottom: none;
    text-align: center;
    }
    .modal-header .close {
    padding: 1rem 1rem;
    margin: -1rem -1rem -1rem 0;
    color: #fff;
    }
    :-moz-any-link:focus {
    outline: none;
    }
    .modal-title{
    line-height: 3rem;
    }
    .modal-body{
    padding: 1rem;
    }
    #progressbar {
    margin-bottom: 3vh;
    overflow: hidden;
    color: white;
    padding-left: 0px;
    margin-top: 3vh
    }
    #progressbar li {
    list-style-type: none;
    font-size: 0.8rem;
    width: 25%;
    float: left;
    position: relative;
    font-weight: 400;
    color: white;
    }
    #progressbar #step1:before {
    content: "";
    color: white;
    width: 20px;
    height: 20px;
    margin-left: 0px !important;
    }
    #progressbar #step2:before {
    content: "";
    color: #fff;
    width: 20px;
    height: 20px;
    margin-left: 32%;
    }
    #progressbar #step3:before {
    content: "";
    color: #fff;
    width: 20px;
    height: 20px;
    margin-right: 32% ; 
    }
    #progressbar #step4:before {
    content: "";
    color: rgb(151, 149, 149, 0.651);
    width: 20px;
    height: 20px;
    margin-right: 0px !important;
    }
    #progressbar li:before {
    line-height: 29px;
    display: block;
    font-size: 12px;
    background: rgb(151, 149, 149);
    border-radius: 50%;
    margin: auto;
    z-index: -1;
    margin-bottom: 1vh;
    }
    #progressbar li:after {
    content: '';
    height: 3px;
    background: rgb(151, 149, 149, 0.651);
    position: absolute;
    left: 0%;
    right: 0%;
    margin-bottom: 2vh;
    top: 8px;
    z-index: 1;
    }
    .progress-track{
    padding: 0 8%;
    }
    #progressbar li:nth-child(2):after {
    margin-right: auto;
    }
    #progressbar li:nth-child(1):after {
    margin: auto;
    }
    #progressbar li:nth-child(3):after {
    float: left;
    width: 68%;
    }
    #progressbar li:nth-child(4):after {
    margin-left: auto;
    width: 132%;
    }
    #progressbar li.active:before,
    #progressbar li.active:after {
    background: white;
    }
    #three{
    font-size: 1.2rem;
    }
    @media (max-width: 767px){
    #three{
        font-size: 1rem;
    } 
    }
    .details{
    padding: 2rem;
    font-size: 1.4rem;
    line-height: 3.5rem;
    }
    @media (max-width: 767px){
    .details {
    padding: 2rem 0;
    font-size: 1rem;
    line-height: 2.5rem;
    }
    }
    .d-table{
    width: 100%;
    }
    .d-table-row{
    width: 100%;
    }
    .d-table-cell{
    padding-left: 3rem;
    }
    @media (max-width: 767px){
    .d-table-cell{
        padding-left: 1rem;
    } 
    }
    .col-3{
    display: grid;
    text-align: end;
    }
    .col-3 .d-table-row{
    align-self: flex-end;
    }
    .fa{
    font-size: xx-large;
    text-align: center;
    width: 3rem;
    padding: 0.5rem;
    color: #42469d;
    background-color: #fff;
    border-radius: 2rem;
    bottom: 0;
    right: 0;
    }
    button:active{
    outline: none;
    }
    button:focus{
    outline: none;
    }
</style>
<?php
    $conn = mysqli_connect("localhost","root","","food_db");
    $who=$user_data['userid'];
    $order_id = $_GET['order_id'];
    $query = "SELECT`status` FROM `order` WHERE `order_id`='$order_id'";
    $query_run = mysqli_query($conn,$query);
    $rowData = mysqli_fetch_array($query_run);
    $status = $rowData[0];
    
    $query1 = "SELECT `userid` FROM `order` WHERE `order_id`='$order_id'";
    $query_run1 = mysqli_query($conn,$query1);
    $rowData1 = mysqli_fetch_array($query_run1);
    $userid = $rowData1[0];
    
    $query2 = "SELECT `Street_Address` FROM `addresses` WHERE `userid`='$userid'";
    $query_run2 = mysqli_query($conn,$query2);
    $rowData2 = mysqli_fetch_array($query_run2);
    $StreetAddress = $rowData2[0];
    
    $query3 = "SELECT `City_Town` FROM `addresses` WHERE `userid`='$userid'";
    $query_run3 = mysqli_query($conn,$query3);
    $rowData3 = mysqli_fetch_array($query_run3);
    $CityTown = $rowData3[0];
?>    

<a href="Home.php" style="font-style: italic; color:white; bottom:640px; margin-left:0px; position:fixed; color:white;
display: inline-block;  background: black; border-radius: .5rem; ">Previous</a>
<!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title mx-auto">Order Status
                    <br>ORDER Number: <?php echo $order_id ?></h4>
                    <h5>Street Address: <?php echo $StreetAddress ?></h5>
                    <h6>City/Town: <?php echo $CityTown ?></h6>
                </div>  
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="progress-track">
                        <ul id="progressbar">
                            <li class="step0 active " id="step1">Order placed</li>
                            <li class="step0 active text-center" id="step2">Driver Accepted</li>
                             
                            <?php
                                if($status == "Driver Accepted")
                                {?>
                                    <li class="step0 text-right" id="step3">
                                    <a href="<?php echo 'O4DProcess.php?order_id=' .$order_id ?>">Out for Delivery</a></li>
                                    <?php
                                }else if($status !== "Driver Accepted")
                                {?>
                                    <li class="step0 active text-right" id="step3">
                                    <span id="three">Out for Delivery</span></li>
                                    <?php
                                }?>
                                <?php
                            if($status == "Out for Delivery" || $status == "Driver Assigned")
                            {?>
                                <li class="step0 text-right" id="step4">
                                <a href="<?php echo 'DProcess.php?order_id=' .$order_id ?>"> Delivered</a></li>
                                <?php
                            }else if($status == "Delivered"){
                                ?>
                                <li class="step0 active text-right" id="step4">
                                <span id="three">Delivered</span></li>
                                <?php
                            }?>
                        </ul>
                    </div>   
                </div>                  
            </div>
        </div>
    </div>
</div>