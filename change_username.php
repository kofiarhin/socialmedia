<?php 


require_once "header.php";



?>



<div class="container">

	<h1 class="display-4 text-center">Change Username</h1>
	<div class="row">
		<div class="col-md-6 offset-md-3">

			<?php 

				if(input::exist('post', 'change_submit')) {


					$validation = new Validation;

					$fields = array(


						'username' => array(


							'required' => true,
							'min' => 4,
							'unique' => 'users'

						)

					);

					$check = $validation->check($_POST, $fields);

					if($check->passed()) {


						$upate = $user->change_username(input::get('username'));

						if($upate) {


							redirect::to('profile.php');
						} else {


							?>
									
									<p class="alert alert-danger">There was a problem updating account!</p>


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
					<label for="current_password">Username</label>
					<input type="text" name="username" class='form-control' placeholder='New Username'>
				</div>




				<button class="btn btn-primary" name='change_submit'>Change Username</button>

			</form>
		</div>
	</div>



	<?php 


	require_once "footer.php";


	?>