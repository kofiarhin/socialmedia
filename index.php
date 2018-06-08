<?php 

require_once "header.php";



?>




<div class="container">
	<div class="row">

		<div class="col-md-4 offset-md-4">

			<?php 

					//session messages

			if(session::exist('message')) {

				?>

				<p class="alert alert-success"><?php echo session::flash('message'); ?></p>

				<?php 
			}

			?>


			<?php 

			//check if user has clicked login form

			if(input::exist('post', 'login_submit')) {


				$validation = new Validation;

				$fields = array(


					'username' => array(


						'required' => true
					),

					'password' => array(

						'required' => true

					)
				);


				$check = $validation->check($_POST, $fields);

				if($check->passed()) {

					

					$login = $user->login(input::get('username'), input::get('password'));

					if($login) {

						redirect::to("timeline.php");
					} else {

						?>

						<p class="alert alert-danger">Invalid Username/Password Combination</p>

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


			<?php 

			if(!$user->logged_in()) {

				?>

				<h1 class="display-4 text-center">Login</h1>

				<form action="" method='post'>
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" class="form-control" name='username' placeholder='Username' value='<?php echo input::get('username') ?>'>
					</div>


					<div class="form-group">
						<label for="password">Password</label>
						<input type="text" name='password' class='form-control' placeholder='Password..' value='<?php echo input::get('password') ?>'>
					</div>


					<button type='submit' name='login_submit'  class='btn btn-primary btn-sm'>Login</button> <span>Or</span> <a href="register.php">Register</a>
				</form>


				<?php 
			} else {


				?>
		
						<h1 class="display-5">Welcome <?php echo $user->data()->username; ?></h1>


				<?php 

			}

			?>
			<!--====  login form=======-->
			
		</div>
	</div>
</div>

<?php 


require_once "footer.php";


?>