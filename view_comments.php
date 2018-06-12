<?php 


		require_once "header.php";

		if(!$user->logged_in()) {


			redirect::to('login.php');
		}


		$user_id = $user->data()->user_id;

		$post_id = input::get('post_id');

		$post = new Posts($post_id);


		//delete comment


		if(input::exist('post', 'delete_submit')) {


			$post->delete_comment(input::get('post_id'), input::get('comment_id'));
		}



 ?>


		<div class="container">
			

				<div class="row">

					<div class="col-md-8 offset-md-2">


						<?php 


							if(session::exist('messages')) {


								?>

									<p class="alert alert-success"><?php echo session::flash('messages');?></p>

								<?php 
							}


						 ?>


						<?php 


								//check if post exist before displaying data
								if($post->exists()) {


									$data = $post->data();

									//var_dump($data);


									$post_body = $data->post_body;
									$post_id = $data->post_id;


									$comments = $post->get_post_comment($post_id);

							
								}

						 ?>
					
					<div class="comment-unit">
						
						<div class="post">
							

							<form action="" method='post'>

								<div class="form-group">
									
										<strong style='margin-bottom: 20px'><?php echo $post_body; ?></strong>
									
								</div>
								
								<div class="form-group">
									<input type="text" class="form-control" name='comment_body' placeholder='Add Comment'>
								</div>

								<button type='submit' name='comment_submit' class='btn btn-primary'>Add Comment</button>
							</form>

						</div>


						<div class="comments">

							<p>Comments: </p>

							<?php 

									if($comments) {


										//var_dump($comments[0]);

										foreach($comments as $comment) {

											$person_id = $comment->user_id;

											$comment_body = $comment->comment_body;

											$comment_id = $comment->comment_id;


											$user  = new User($person_id);
											$profile_picture = $user->get_profile_picture();

								

											?>

											<div class="user-unit">
												
												<div class="face" style='background-image: url(img/<?php echo $profile_picture; ?>)'></div>
												<div class="content">

													 <?php echo $comment_body; ?>
													
												</div>

												<!--====  delete button=======-->	

												<?php 	if($user_id == $person_id):  ?> 
												<form action="" method='post'>
													<input type="hidden" name='comment_id' value='<?php echo $comment_id; ?>'>

													<input type="hidden" name='post_id' value='<?php echo $post_id; ?>'>
													<button class="btn btn-danger" type='submit' name='delete_submit'>Delete</button>
												</form>

											<?php 	endif; ?>


											</div>


											<?php 
										}
									}

							 ?>
							



					</div>

					</div>
				</div>

		</div>


 <?php 


 	require_once "footer.php";

  ?>