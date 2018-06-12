<?php 

require_once "header.php";


?>


<div class="container">

	<h1 class="display-4 text-center">Change Password</h1>

	<div class="row">
		<div class="col-md-6 offset-md-3">


			<?php 

					if(input::exist('post', 'change_submit')) {


						$fields = array(

							'current_password' => array(

								'required' => true,

							),

							'new_password' => array(

								'required' => true,
								'min' => 4,
								'max' => 50

							)



						);


						$validation = new Validation;
						$check = $validation->check($_POST, $fields);


						if($check->passed()) {

									
									$update = $user->change_password(input::get('current_password'), input::get('new_password'));


									if($update) {


										redirect::to('profile.php');
									} else {



										?>

									<p class="alert alert-danger">There was a problem  changing password</p>
	
										<?php 
									}






						} else {


							foreach($check->errors() as $error) {


								?>
						
								<p class="alert alert-danger"><?php echo $error; ?></p>


								<?php  
							}
						}
					}

			 ?>

			<form action="" method='post'>

				<div class="form-group">
					<label for="current_password">Current Password</label>
					<input type="text" name='current_password' class='form-control' placeholder='Current Password'>
				</div>


				<div class="form-group">
					<label for="new_password">New Password</label>
					<input type="text" name='new_password' class='form-control' placeholder='New Password'>
				</div>

				<button class="btn btn-primary" name='change_submit'>Change Password</button>

			</form>
		</div>

	</div>

</div>


<?php 


require_once "footer.php";

?>