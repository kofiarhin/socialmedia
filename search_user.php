<?php 

require_once "header.php";


if(!$user->logged_in()) {


	redirect::to('login.php');
}


$users = $user->get_all_users();

?>


<?php 

 	//checks 

 	//follow button

if(input::exist('post', 'follow_submit')) {


	$fields = array(

		'user_id' => $user_id,
		'follower_id' => input::get('person_id')


	);


	$follow = $user->follow($fields);

	if($follow) {

		redirect::to("timeline.php");
	} else {


		?>

		<p class="alert alert-danger">There was a problem following user</p>

		<?php
	}




}



//check if unfollow button clicked

if(input::exist('post',  'unfollow_submit')) {


	//undoloow user

	$unfollow = $user->unfollow(session::get('user'), input::get('person_id'));

	if($unfollow) {


		redirect::to('timeline.php');
	}
}


?>


<div class="container">




	<h1 class="display-4 title">Search Users</h1>

	<div class="row thumb-wrapper" id='result'>



		<?php 

		if($users) {

			//var_dump($users[0]);

			foreach($users as $data) {

				//var_dump($user);

				$name = $data->name;
				$person_id = $data->user_id;


				



				if($person_id  != $user_id) {

					//echo $person_id;

					$person = new User($person_id);

					$profile_pic = $person->get_profile_picture();


					?>

					<div class="col-md-3">

						<div class="thumb-unit">
							<div class="face" style="background-image: url(img/<?php echo $profile_pic; ?>)"></div>
							<div class="content">
								<p class='lead'>
									<a href="view_user_profile?person_id=<?php echo $person_id ?>" class="text lead">Name: <?php echo $name ?></a>

								</p>

								<!--====  follow user form=======-->

								<form action="" method='post'>
									<input type="hidden" name='person_id' value='<?php echo $person_id; ?>'>

									<?php 

												//check if user is following
									if($user->check_following($user_id, $person_id)) {



										?>

										<button class='btn btn-danger' type='submit' name='unfollow_submit'>Unfollow</button>						

										<?php 
									} else {


										?>


										<button class='btn btn-primary' type='submit' name='follow_submit'>Follow</button>

										<?php 
									}

									?>
								</form>
							</div> 
						</div>
					</div>



					<?php 

				}










			}
		}


		?>


	</div>


</div>

<?php 

require_once "footer.php";

?>