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


	var_dump($fields);


}


?>


<div class="container">




	<h1 class="display-4 title">Search Users</h1>

	<div class="row thumb-wrapper" id='result'>



		<?php 

		if($users) {

			foreach($users as $user) {


				$name = $user->name;
				$person_id = $user->user_id;


				if($person_id  != $user_id) {

					?>

					<div class="col-md-3">

						<div class="thumb-unit">
							<img src="img/default.jpg" alt="" class='thumbnail'>
							<div class="content">
								<p class="text lead">Name: <?php echo $name ?></p>

								<!--====  follow user form=======-->

								<form action="" method='post'>
									<input type="hidden" name='person_id' value='<?php echo $person_id; ?>'>
									<button class='btn btn-primary' type='submit' name='follow_submit'>Follow</button>
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