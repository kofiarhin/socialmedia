<?php 

require_once "header.php";


$user_id = $user->data()->user_id;


$datas = $user->get_following($user_id);





?>

<div class="container">
	
	<h1 class="display-4">Your are following: <?php  ?></h1>
	
</div>



<div class="container">

	<div class="row">
		<?php if($datas):  ?>

			<?php foreach($datas as $data): ?>

				<?php 
						//var_dump($data);
						$name = $data->name;
						$person_id = $data->follower_id;
						$person_profile = $data->file_name;


						if(!$person_profile) {

							$person_profile = "default.jpg";
						}

				 ?>

				 <?php 	if($user_id != $person_id):  ?>

				<div class="col-md-3">
					<div class="profile-unit">

						<div class="face" style='background-image: url(img/<?php echo $person_profile; ?>)'></div>
						<div class="content">
							<p class="lead"><a href="view_user_profile.php?person_id=<?php echo $person_id; ?>">Name: <?php echo $name; ?></a></p>
						</div>

					</div>

				</div>

			<?php 	endif; ?>
			<?php endforeach; ?>

		<?php endif; ?>
		
		
	</div>


</div>

<?php 


require_once "footer.php";


?>