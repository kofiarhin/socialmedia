<?php 

require_once "header.php";

if(!$user->logged_in()) {

	redirect::to('login.php');
}


//check if save changes



?>



<div class="container">




	<h1 class="display-4 text-center">Edit Your Profile</h1>
	<div class="row">


		<?php if($user->exist() ): ?>

			<?php 

				$name = $user->data()->name;
				$username= $user->data()->username;

			 ?>

			<div class="col-md-6 offset-md-3">



				<?php 


					//check if changes

				if(input::exist('post', 'save_submit')) {

					$fields = array(

						'name' => array(

							'required' => true,
							'min' => 3,
							'max' => 50
						)

					);


					$validation = new Validation();

					$check  = $validation->check($_POST, $fields);

					if($check->passed()) {

						$fields = array(

							'name' => input::get('name')
						);


						$update = $user->update_info($fields);

						if($update) {

							redirect::to('profile.php');
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
						<label for="name">Name</label>
						<input type="text" class="form-control text-capitalize" value="<?php echo $name; ?>" name='name'>
					</div>

		


					<button class="btn btn-primary" type='submit' name='save_submit'>Save Changes</button>

				</form>
			</div>

		<?php endif ?>

		
	</div>

</div>

<?php 

require_once "footer.php";

?>