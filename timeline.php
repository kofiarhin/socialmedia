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

		<div class="col-6 offset-md-2">


			<?php 

			//check for session messages

			session::test();

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
			
			<!--====  post-unit=======-->
			<div class="post-unit">

				<div class="face"></div>

				<div class="content">
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Porro id laudantium eum, ipsa adipisci iusto aspernatur, quasi officia saepe, quam laboriosam sapiente itaque. Nemo quas nobis iste, iusto eligendi. Eveniet.</p>
						<form action="" method='post'>
							<div class="form-group">
								<input type="text" class="form-control" name='comment'>
							</div>
							<div class="form-group">
							</div>
								<button class="btn btn-primary">Comment</button>
						</form>
				</div>
			</div> <!--====  end post-unit =======-->


			<div class="post-unit">

				<div class="face"></div>

				<div class="content">
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Porro id laudantium eum, ipsa adipisci iusto aspernatur, quasi officia saepe, quam laboriosam sapiente itaque. Nemo quas nobis iste, iusto eligendi. Eveniet.</p>
						<form action="" method='post'>
							<div class="form-group">
								<input type="text" class="form-control" name='comment'>
							</div>
							<div class="form-group">
							</div>
								<button class="btn btn-primary">Comment</button>
						</form>
				</div>
			</div>

		</div>
		
	


		

	</div>

</div>



<?php 


require_once "footer.php";


?>