<?php 


require_once "header.php";

?>


<?php 



if(!$user->logged_in()) {

	redirect::to('login.php');
}


$user_id = $user->data()->user_id;

//get all post by user and who he/she is following
$post = new Posts;


$datas = $post->get_following_post($user->data()->user_id);


?>

<div class="container">

	<div class="row">

		

		<div class="col-md-8 offset-md-2">


			<?php 

			//check for session messages

			//session::test();

			if(session::exist('messages')) {


				?>

				<p class="alert alert-success"><?php echo session::flash('messages') ?></p>
				<?php 
			}


			if(session::exist('profile_update')) {
				

				?>

				<p class="alert alert-success"><?php echo session::flash('profile_update') ?></p>


				<?php 
			}

			?>

			<?php 


			//creating a post

			if(input::exist('post', 'post_submit')) {


				

				$fields = array (

					'user_id' => input::get('user_id'), 
					'post_body' => input::get('post_body'),
					'post_date' => date("Y-m-d H:i:s"),
					'post_likes' => 0,
					'post_comments' => 0
				);

				$create = $post->create($fields);

				if($create) {


					redirect::to('timeline.php');

				} else {


					?>

					<p class="alert alert-danger">There was a problem creating post</p>

					<?php 
				}
				
			}


			//add comment

			if(input::exist('post', 'comment_submit')) {


				$fields = array(

					'post_id' => (int) input::get('post_id'),
					'user_id' => (int) input::get('user_id'),
					'comment_body' => input::get('comment'),
					'comment_date' => date("Y-m-d H:i:s")

				);


				$post  = new Posts;

				$comment = $post->add_comment($fields);

				var_dump($comment);

				if($comment) {

					redirect::to('timeline.php');
				}
			}


			//like comment

			if(input::exist('post', 'like_submit')) {


				$fields = array(

					'post_id' => input::get('post_id'),
					'user_id' => input::get('user_id'),
					'like_date' => date('Y-m-d H:i:s')

				);


				$like = $post->like($fields);

				if($like) {


					redirect::to('timeline.php');
				}
			}

			//delete button

			if(input::exist('post', 'delete_submit')) {

				$fields = array(

					'post_id' => input::get('post_id'), 
					'user_id' => input::get('user_id')

				);


				if($post->delete($fields)) {

					redirect::to('timeline.php');
				} else {

					?>
					<p class="alert alert-danger">There was a problem deleting post</p>

					<?php 
				}
			}


			//unlike button


			if(input::exist('post', 'unlike_submit')) {


				$unlike = $post->unlike(input::get('post_id'), input::get('user_id'));

				if($unlike) {


					redirect::to('timeline.php');
				}
			}


			?>

			<!--====  post form =======-->
			<form action="" method='post'>

				<!--====  hidden user_id =======-->


				<input type="hidden" name='user_id' value='<?php echo $user_id; ?>'>
				<div class="form-group">
					<label for="status">What is on your mind</label>
					<textarea name="post_body" id="" cols="30" rows="3" class="form-control" placeholder="Write something here..s"></textarea>
				</div>

				<button class="btn btn-primary" type='submit' name='post_submit'>Tweet</button>
			</form>
		</div> 	 			
	</div>


	<div class="row timeline">




		<div class="col-md-8 offset-md-2">


			<?php 

			//get followers post

			$datas = $user->get_followers_post($user_id);


			if($datas) {

				//var_dump($datas[0]);

				foreach($datas as $data) {


					$name = $data->name;
					$post_body = $data->post_body;
					$post_id = $data->post_id;
					$post_comments = $data->post_comments;
					$likes = $data->post_likes;
					$follower_id = $data->follower_id;




					$user = new User($follower_id);

					$profile_picture = $user->get_profile_picture();

					?>

					<div class="post-unit">

						


						<div class="face" style='background-image: url(img/<?php echo $profile_picture; ?>)'></div>

						<div class="content">

							<p class='text-capitalize'><a href="view_user_profile.php?person_id=<?php echo $follower_id; ?>"><?php echo $name; ?></a></p>
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
									<a href="likes.php?post_id=<?php echo $post_id; ?>">Likes: <?php echo $likes; ?></a>



								</div>

								<button class="btn btn-primary" name='comment_submit' type='submit'>Comment</button>


								<?php 

								//show the delete button if follow is the same as user
								if($user_id == $follower_id) {

									?>

									<button class="btn btn-danger delete_btn" type='submit' name='delete_submit'>Delete</button>

									<?php 
								}

								?>

								

								<?php 

								//check if user liked post
								if($post->check_like($post_id, $user_id)) {


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


					<?php 
				}
			}


			?>
			

			



		</div>

	</div>



	<?php 


	require_once "footer.php";


	?>