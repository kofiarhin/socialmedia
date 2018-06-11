<?php 

require_once "header.php";

$posts = new Posts;

$user_id  = $user->data()->user_id;
$person_id = input::get('person_id');


$person = new User($person_id);


$person_profile = "default.jpg";

if($person->exist()) {

	$person_profile = $person->get_profile_picture();

	$name = $person->data()->name;

}


$following  = $user->check_following($user_id, $person_id);




?>



<?php 


//follow user

if(input::exist('post', 'follow_submit')) {


	$fields = array(

		'user_id' => input::get('user_id'),
		'follower_id' =>  input::get('person_id')

	);


	$follow = $user->follow($fields);

	if($follow) {


		redirect::to("view_user_profile.php?person_id={$person_id}");
	}

}


	// unfolow user

if(input::exist('post', 'unfollow_submit')) {


	$unfollow = $user->unfollow(input::get('user_id'), input::get('person_id'));


	if($unfollow) {


		redirect::to("view_user_profile.php?person_id={$person_id}");
	}
}


		//like button


		if(input::exist('post', 'like_submit')) {


			$fields = array(


				'post_id' => input::get('post_id'),
				'user_id' => input::get('user_id'),
				'like_date' => date("Y-m-d H:i:s")

			);


			$like = $posts->like($fields);

			if($like) {


				redirect::to("view_user_profile.php?person_id={$person_id}");
			}
		}



		//add comment



		if(input::exist('post', 'comment_submit')) {


			$fields = array(

				'post_id' => input::get('post_id'),
				'user_id' => input::get('user_id'),
				'comment_body' => input::get('comment'),
				'comment_date' => date("Y-m-d H:i:s")

			);

			$comment = $posts->add_Comment($fields);

			if($comment) {

				redirect::to("view_user_profile.php?person_id={$person_id}");
			}

		}


?>

<div class="container">


	<div class="row">

		<div class="col-md-8 offset-md-2">

			<div class="profile-unit">
				<div class="face" style='background-image: url(img/<?php echo $person_profile; ?>)'>

				</div>
				<div class="content">
					<p class="lead text-capitalize">Name: <?php echo $name; ?></p>
					<form action="" method='post'>

						<input type="hidden" name='user_id' value='<?php echo $user_id; ?>'>
						<input type="hidden" name='person_id' value='<?php echo $person_id; ?>'>

						<?php 

						if($user->check_following($user_id, $person_id)) {

							?>

							<?php if($user_id !== $person_id): ?>
							<button class="btn btn-danger" type='submit' name='unfollow_submit'>unFollow</button>

							<?php else: ?>
								<p class="lead">Your Profile</p>

						<?php endif; ?>

							<?php 
						} else {

							?>

							<button class="btn btn-primary" type='submit' name='follow_submit'>Follow</button>


							<?php 
						}

						?>

					</form>
				</div>
			</div>

			<div class="timeline">


				<?php 

				if($following) {


					

					$datas = $posts->get_user_posts($person_id);

					//var_dump($datas[0]);




					?>


					<?php if($datas):  ?>

						<?php foreach($datas as $data): ?>
							<?php 

							$post_body = $data->post_body;
							$post_id = $data->post_id;
							$post_date = $data->post_date;
							$post_comments = $data->post_comments;
							$post_likes = $data->post_likes;
							?>
							<div class="post-unit">




								<div class="face" style='background-image: url(img/<?php echo $person_profile; ?>)'></div>

								<div class="content">

									<p class='text-capitalize'><a href="view_user_profile.php?person_id=<?php echo $person_id; ?>"><?php echo $name; ?></a></p>
									<p><?php echo $post_body; ?></p>

									<!--====  add comment form =======-->
									<form action="" method='post'>

										<div class="form-group">
											<input type="text" class="form-control" name='comment'>

											<!--====  hiden fields=======-->
											<input type="hidden" name='post_id' value="<?php echo $post_id; ?>">
											<input type="hidden" name='user_id' value="<?php echo $user_id; ?>">
										</div>


										<div class="form-group">

											<a href="view_comments.php?post_id=<?php echo $post_id ?>">Comments: <?php echo $post_comments; ?></a> 

											<!--====  like button=======-->
											<a href="likes.php?post_id=<?php echo $post_id; ?>">Likes: <?php echo $post_likes; ?></a>



										</div>

										<button class="btn btn-primary" name='comment_submit' type='submit'>Comment</button>


										<?php 

															//show the delete button if follow is the same as user
										if($user_id == $person_id) {

											?>

											<button class="btn btn-danger delete_btn" type='submit' name='delete_submit'>Delete</button>

											<?php 
										}

										?>



										<?php 

										//check if user liked post
										if($posts->check_like($post_id, $user_id)) {


											?>

											<button class="btn btn-danger" name='unlike_submit' type='submit'>Unlike</button>


											<?php 
										} else {

																//show the like button

											?>


											<button class="btn btn-default" name='like_submit' type='submit'>Like</button>



											<?php 
										}


										?>

									</form>
								</div>
							</div> <!--====  end post-unit =======-->

						<?php endforeach;  ?>

					<?php endif; ?>

					<?php 
				}

				?>







			</div>

		</div>

	</div>


</div>

<?php 


require_once "footer.php";


?>