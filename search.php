<?php 

require_once "core/init.php";

$search = input::get('search');

$user = new User;

$user_id = $user->data()->user_id;

$user_search = $user->search($search);

if($user_search) {


	foreach($user_search  as $user) {

			$name = $user->name;
			$person_id = $user->user_id;

		?>


		<div class="col-md-3">

			<div class="thumb-unit">
				<img src="img/default.jpg" alt="" class='thumbnail'>
				<div class="content">
					<p class="text lead">Name: <?php echo $name; ?></p>


					<?php 


						//display the follow button only when it is not the same as user

						if($person_id != $user_id) {

							?>

								<form action="" method='post'>
									<button class='btn btn-primary' type='submit' ='follow_submit'>Follow</button>
								</form>


							<?php 
						} else {


							?>

								<a href="profile.php?user_id=<?php echo $user_id; ?>">Your Profile</a>

							<?php  
						}



					 ?>

					
				</div> 
			</div>
		</div>

		<?php 
	}
} else {


		?>
			
			<p class="alert alert-danger">There are no users matching your description</p>


		<?php

}