<?php 
include('inc/header.php');
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
    $who = $user_data['userid'];
    $conn = mysqli_connect("localhost","root","","food_db");
    $query="SELECT `user_type` FROM `users` WHERE `userid`='$who'";
    $query_run = mysqli_query($conn,$query);
    $rowData = mysqli_fetch_array($query_run);
    $user_type = $rowData[0];

    $menu_id = $_GET['menu_id'];
    $query1="SELECT * FROM `order` WHERE `menu_id`='$menu_id' AND `userid`='$who'";
    $query_run1 = mysqli_query($conn,$query1);

    $query2="SELECT `ratingId` FROM `item_rating` WHERE `itemId`='$menu_id' AND `userid`='$who'";
    $query_run2 = mysqli_query($conn,$query2);
    $rowData2 = mysqli_fetch_array($query_run2);

    $query10="SELECT `user_type` FROM `users` WHERE `userid`='$who'";
    $query_run10 = mysqli_query($conn,$query10);
    $rowData10 = mysqli_fetch_array($query_run10);
    $user_type1 = $rowData10[0];
    if (isset($_GET['ratingId']) && $user_type1 =="")
    {
    $ratingId=$_GET['ratingId'];
    $delete=mysqli_query($conn, "DELETE FROM `item_rating` WHERE `ratingId`='$ratingId'");
    header("location:show_rating.php?menu_id=".$_GET['menu_id']);
    die();
    }

?>

<title>100% Mthobisi Khanyile</title>
<link rel="stylesheet" href="css/style.css">
<div class="container" style="background-color:light; border: .1rem solid rgba(0,0,0,.2);">
    <a href="Home.php" style="font-style: italic; color:white; bottom:640px; margin-left:-150px; position:fixed; color:white;
    display: inline-block;  background: black; border-radius: .5rem; ">Previous</a>
    <div style="font-style:normal; color:black; font-size:30px;">
	    <h2 class="bold padding-bottom-7">RATE AND REVIEW SECTION</h2>
    </div>
	<?php
	    include 'classes/Rating.php';
	    $rating = new Rating();
	    $itemDetails = $rating->getItem($_GET['menu_id']);
	    foreach($itemDetails as $item){
		   $average = $rating->getRatingAverage($item["menu_id"]);
	        ?>	
	        <div class="row">
		        <div class="col-sm-2" style="width:150px">
		        	<img class="product_image" src="<?php echo $item["image"]; ?>" style="width:100px;height:200px;padding-top:10px;">
		        </div>
		        <div class="col-sm-4">
		            <h4 style="margin-top:10px;"><?php echo $item["name"]; ?></h4>
		        <div><span class="average"><?php printf('%.1f', $average); ?> <small>/ 5</small></span> <span class="rating-reviews"><a href="show_rating.php?menu_id=<?php echo $item["menu_id"]; ?>">Rating & Reviews</a></span></div>
		            <?php echo $item["description"]; ?>				
		        </div>		
	        </div>
	        <?php 
        } 
    ?>	
		
	<?php	
	    $itemRating = $rating->getItemRating($_GET['menu_id']);	
	    $ratingNumber = 0;
	    $count = 0;
	    $fiveStarRating = 0;
	    $fourStarRating = 0;
	    $threeStarRating = 0;
	    $twoStarRating = 0;
	    $oneStarRating = 0;	
	    foreach($itemRating as $rate){
		    $ratingNumber+= $rate['ratingNumber'];
		    $count += 1;
		    if($rate['ratingNumber'] == 5) {
		    	$fiveStarRating +=1;
		    } else if($rate['ratingNumber'] == 4) {
		    	$fourStarRating +=1;
		    } else if($rate['ratingNumber'] == 3) {
		    	$threeStarRating +=1;
		    } else if($rate['ratingNumber'] == 2) {
		    	$twoStarRating +=1;
		    } else if($rate['ratingNumber'] == 1) {
		    	$oneStarRating +=1;
		    }
	    }
	    $average = 0;
	    if($ratingNumber && $count) {
		    $average = $ratingNumber/$count;
	    }	
	?>		
	<br>		
	<div id="ratingDetails"> 		
		<div class="row">			
			<div class="col-sm-3">				
				<h4>Avarage</h4>
				<h2 class="bold padding-bottom-7"><?php printf('%.1f', $average); ?> <small>/ 5</small></h2>				
				<?php
				$averageRating = round($average, 0);
				for ($i = 1; $i <= 5; $i++) {
					$ratingClass = "btn-default btn-grey";
					if($i <= $averageRating) {
						$ratingClass = "btn-warning";
					}
				    ?>
				    <button type="button" class="btn btn-sm <?php echo $ratingClass; ?>" aria-label="Left Align">
				      <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
				    </button>	
				    <?php
				}?>				
			</div>
		    <div class="col-sm-3">
				<?php
				    $fiveStarRatingPercent = round(($fiveStarRating/5)*100);
				    $fiveStarRatingPercent = !empty($fiveStarRatingPercent)?$fiveStarRatingPercent.'%':'0%';	
				    
				    $fourStarRatingPercent = round(($fourStarRating/5)*100);
				    $fourStarRatingPercent = !empty($fourStarRatingPercent)?$fourStarRatingPercent.'%':'0%';
				    
				    $threeStarRatingPercent = round(($threeStarRating/5)*100);
				    $threeStarRatingPercent = !empty($threeStarRatingPercent)?$threeStarRatingPercent.'%':'0%';
				    
				    $twoStarRatingPercent = round(($twoStarRating/5)*100);
				    $twoStarRatingPercent = !empty($twoStarRatingPercent)?$twoStarRatingPercent.'%':'0%';
				    
				    $oneStarRatingPercent = round(($oneStarRating/5)*100);
				    $oneStarRatingPercent = !empty($oneStarRatingPercent)?$oneStarRatingPercent.'%':'0%';
				?>
				<div class="pull-left">
					<div class="pull-left" style="width:35px; line-height:1;">
						<div style="height:9px; margin:5px 0;">5 <span class="glyphicon glyphicon-star"></span></div>
					</div>
					<div class="pull-left" style="width:180px;">
						<div class="progress" style="height:9px; margin:8px 0;">
						    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo $fiveStarRatingPercent; ?>">
							    <span class="sr-only"><?php echo $fiveStarRatingPercent; ?></span>
						    </div>
						</div>
					</div>
					<div class="pull-right" style="margin-left:10px;"><?php echo $fiveStarRating; ?></div>
				</div>
				<div class="pull-left">
					<div class="pull-left" style="width:35px; line-height:1;">
						<div style="height:9px; margin:5px 0;">4 <span class="glyphicon glyphicon-star"></span></div>
					</div>
					<div class="pull-left" style="width:180px;">
						<div class="progress" style="height:9px; margin:8px 0;">
						    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo $fourStarRatingPercent; ?>">
							    <span class="sr-only"><?php echo $fourStarRatingPercent; ?></span>
						    </div>
						</div>
					</div>
					<div class="pull-right" style="margin-left:10px;"><?php echo $fourStarRating; ?></div>
				</div>
				<div class="pull-left">
					<div class="pull-left" style="width:35px; line-height:1;">
						<div style="height:9px; margin:5px 0;">3 <span class="glyphicon glyphicon-star"></span></div>
					</div>
					<div class="pull-left" style="width:180px;">
						<div class="progress" style="height:9px; margin:8px 0;">
						    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="3" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo $threeStarRatingPercent; ?>">
							    <span class="sr-only"><?php echo $threeStarRatingPercent; ?></span>
						    </div>
						</div>
					</div>
				    <div class="pull-right" style="margin-left:10px;"><?php echo $threeStarRating; ?></div>
				</div>
				<div class="pull-left">
					<div class="pull-left" style="width:35px; line-height:1;">
						<div style="height:9px; margin:5px 0;">2 <span class="glyphicon glyphicon-star"></span></div>
					</div>
					<div class="pull-left" style="width:180px;">
						<div class="progress" style="height:9px; margin:8px 0;">
						    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo $twoStarRatingPercent; ?>">
							    <span class="sr-only"><?php echo $twoStarRatingPercent; ?></span>
						    </div>
						</div>
					</div>
					<div class="pull-right" style="margin-left:10px;"><?php echo $twoStarRating; ?></div>
				</div>
				<div class="pull-left">
					<div class="pull-left" style="width:35px; line-height:1;">
						<div style="height:9px; margin:5px 0;">1 <span class="glyphicon glyphicon-star"></span></div>
					</div>
					<div class="pull-left" style="width:180px;">
						<div class="progress" style="height:9px; margin:8px 0;">
						    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo $oneStarRatingPercent; ?>">
							    <span class="sr-only"><?php echo $oneStarRatingPercent; ?></span>
						    </div>
						</div>
					</div>
					<div class="pull-right" style="margin-left:10px;"><?php echo $oneStarRating; ?></div>
				</div>
			</div>		
			<?php 
				if(mysqli_num_rows($query_run1) > 0 && $user_type == "" && empty($rowData2[0]))
				{?>
				    <div class="col-sm-3">
                        <button type="button" id="rateProduct" class="btn btn-info">Rate this product</button>
					</div>	
				    <?php 
				}?>
		</div>		
		<div class="row">
			<div class="col-sm-7">
				<hr/>
				
				<h1 class="bold padding-bottom-7">Comments</h1>
				<div class="review-block">		
				    <?php
				    $itemRating = $rating->getItemRating($_GET['menu_id']);
				    foreach($itemRating as $rating){				
					    $date=date_create($rating['created']);
					    $reviewDate = date_format($date,"M d, Y");	
					    $theirId=$rating['userid'];
					    $query11="SELECT `gender` FROM `users` WHERE `userid`='$theirId'";
					    $query_run11 = mysqli_query($conn,$query11);
					    $rowData11 = mysqli_fetch_array($query_run11);
					    $gender = $rowData11[0];
                        $profilePic = "images/user_male.jpg";

					    if($gender == "Female")
					    {
					        $profilePic = "images/user_female.jpg";
					    }
					    if($rating['profile_image']) {
						    $profilePic = $rating['profile_image'];	
					    }?>				
					    <div class="row">
						    <div class="col-sm-3">
							    <img src="<?php echo $profilePic; ?>" width="100px" alt="Image" class="img-rounded user-pic">
							    <div class="review-block-name">By <a href="#"><?php echo $rating['first_name']; ?></a></div>
							    <div class="review-block-date"><?php echo $reviewDate; ?></div>
						    </div>
						    <div class="col-sm-9">
							    <div class="review-block-rate">
								    <?php
								    for ($i = 1; $i <= 5; $i++) {
									    $ratingClass = "btn-default btn-grey";
									    if($i <= $rating['ratingNumber']) {
										    $ratingClass = "btn-warning";
									    }
								        ?>
								        <button type="button" class="btn btn-xs <?php echo $ratingClass; ?>" aria-label="Left Align">
								            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
								        </button>								
								        <?php
									}?>
							    </div>
							    <div class="review-block-title"><?php echo $rating['title']; ?></div>
							    <div class="review-block-description"><?php echo $rating['comments']; ?></div>
							    <h1  class="bold padding-bottom-7" style="margin-top:10px; font-style:italic; padding-left:500px;">Reply:</h1>
							    <div class="review-block-reply" style="margin-top:10px; background:ghostwhite; padding-left:500px;"><?php echo $rating['reply']; ?></div>
                                <?php
                                    switch($user_type){
								    case "Administrator":?>
							        <div class="col-sm-3" style="margin-top:10px; padding-left:500px;">
									    <a href="<?php echo 'AdminReply.php?ratingId='.$rating['ratingId'];?>" class="btn btn-info">reply/remove</a>
								    </div>
								<?php
								break;
							    }
							
							    $ratingId=$rating['ratingId'];
							    $query3 = "SELECT * FROM `item_rating` WHERE `ratingId`='$ratingId' AND `userid`='$who'";
							    $query_run3 = mysqli_query($conn,$query3);
                                $rowData3 = mysqli_fetch_array($query_run3);
							    if(!empty($rowData3))
							    {?>
							        <div class="col-sm-3" style="margin-top:10px; padding-left:450px;">
								        <a href="<?php echo 'show_rating.php?ratingId='.$rating['ratingId'].'&menu_id='.$_GET['menu_id']?>">delete</a>
							        </div>
							    <?php
							    }
                                ?>
						    </div>
					    </div>
					    <hr/>					
				        <?php 
				    }
					?>
				</div>
			</div>
		</div>	
	</div>
	<div id="ratingSection" style="display:none;">
		<div class="row">
			<div class="col-sm-12">
				<form id="ratingForm" method="POST">					
					<div class="form-group">
						<h4>Rate this product</h4>
						<button type="button" class="btn btn-warning btn-sm rateButton" aria-label="Left Align">
						    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
						</button>
						<button type="button" class="btn btn-default btn-grey btn-sm rateButton" aria-label="Left Align">
						    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
						</button>
						<button type="button" class="btn btn-default btn-grey btn-sm rateButton" aria-label="Left Align">
						    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
						</button>
						<button type="button" class="btn btn-default btn-grey btn-sm rateButton" aria-label="Left Align">
						    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
						</button>
						<button type="button" class="btn btn-default btn-grey btn-sm rateButton" aria-label="Left Align">
						    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
						</button>
						<input type="hidden" class="form-control" id="rating" name="rating" value="1">
						<input type="hidden" class="form-control" id="itemId" name="itemId" value="<?php echo $_GET['menu_id']; ?>">
						<input type="hidden" name="action" value="saveRating">
					</div>		
					<div class="form-group">
						<label for="comment">Comment*</label>
						<textarea class="form-control" rows="5" id="comment" name="comment" required></textarea>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-info" id="saveReview">post</button> <button type="button" class="btn btn-info" id="cancelReview">Cancel</button>
					</div>			
				</form>
			</div>
		</div>		
	</div>
</div>

<script>
    $(document).ready(function(){
    
    	// rating form hide/show
     	$(document).on("click","#rateProduct", function() {
    				
    		$("#ratingDetails").hide();
    		$("#ratingSection").show();
    		
    	});
    	$( "#cancelReview" ).click(function() {
    		$("#ratingSection").hide();
    		$("#ratingDetails").show();		
    	});	
    	
    	// implement start rating select/deselect
    	$( ".rateButton" ).click(function() {
    		if($(this).hasClass('btn-grey')) {			
    			$(this).removeClass('btn-grey btn-default').addClass('btn-warning star-selected');
    			$(this).prevAll('.rateButton').removeClass('btn-grey btn-default').addClass('btn-warning star-selected');
    			$(this).nextAll('.rateButton').removeClass('btn-warning star-selected').addClass('btn-grey btn-default');			
    		} else {						
    			$(this).nextAll('.rateButton').removeClass('btn-warning star-selected').addClass('btn-grey btn-default');
    		}
    		$("#rating").val($('.star-selected').length);		
    	});
    	// save review using Ajax
    	$('#ratingForm').on('submit', function(event){
    		event.preventDefault();
    		var formData = $(this).serialize();
    		$.ajax({
    			type : 'POST',
    			dataType: "json",	
    			url : 'action.php',					
    			data : formData,
    			success:function(response){
    				if(response.success == 1) {
    					$("#ratingForm")[0].reset();
    					window.location.reload();
    				}
    			}
    		});		
    	});
         
    });
</script>

<?php include('inc/footer.php');?>






