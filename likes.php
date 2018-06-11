<?php 


require_once "header.php";

if(!$user->logged_in()) {


	redirect::to('login.php');
}


$user_id = $user->data()->user_id;

$post_id = input::get('post_id');

$post = new Posts;
$likes = $post->get_people_likes($post_id);

?>



<div class="container">
	
	<h1 class='display-4'>These people liked your post</h1>
	<div class="row">


		<?php 


		if($likes) {


			var_dump($likes[0]);


			foreach ($likes as $like) {

				$file_name = $like->file_name;
				$profile_pic = ($file_name == "") ? 'default.jpg' : $file_name;
				$person_id = $like->user_id;




				$name = $like->name;


				?>



				<div class="col-md-3">

					<div class="like-unit">
						<div class="face" style='background-image: url(img/<?php echo $profile_pic; ?>); height: 200px; width: 200px; background-size: cover'></div>

						<div class="content">
							<p class='lead'><strong>

								<?php 

								if($user_id == $person_id) {


									?>

									You

									<?php 
								} else {

									?>

									Name: <?php echo $name; ?>

									<?php 
								}

								?>

							</strong></p>
						</div>
					</div>
				</div>



				<?php 
			}
		}


		?>
		


	</div>

</div>




<?php 


require_once "footer.php";

?>