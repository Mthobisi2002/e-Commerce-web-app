
<?php
include('inc/header.php');
?>
<title>Menu</title>
<script src="js/rating.js"></script>
<link rel="stylesheet" href="css/style.css">
<style>
.product_image{
    width:200px;
	height:200px;
	margin-top: 150px;
	border-radius: 50%;
	list-style: 300px;
	display: inline-block;
	padding: 0 0.5rem;


}

</style>
<div class="container">		
	<?php
	include 'classes/Rating.php';
	$rating = new Rating();
	$itemList = $rating->getItemList();
	foreach($itemList as $item){
		$average = $rating->getRatingAverage($item["menu_id"]);
	?>	
	<div class="row">
		<div class="col-sm-2" style="width:150px">
			<img class="product_image" src="<?php echo $item["image"]; ?>">
		</div>
		<div class="col-sm-4">
		<h4 style="margin-top:10px; padding-left:100px;"><?php echo $item["name"]; ?></h4>
		<a href="<?php echo 'Home.php?id=' .$item['id'] ?>" class="btn btn-info">Add to Cart</a>
		<div style="margin-top:10px; padding-left:100px;"><span class="average"><?php printf('%.1f', $average); ?> <small>/ 5</small></span> <span class="rating-reviews"><a href="show_rating.php?menu_id=<?php echo $item["menu_id"]; ?>">Rating & Reviews</a></span></div>
		<?php echo $item["description"]; ?>		
		</div>		
	</div>
	<?php } ?>	
</div>	
</div>	
<?php include('inc/footer.php');?>






