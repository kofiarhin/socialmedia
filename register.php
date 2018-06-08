<?php 

require_once "header.php";

	//check if submit button has been clicked



?>

<h1 class="display-4 text-center">Create An Account</h1>


<div class="container">


	<div class="row">
		<div class="col-md-6 offset-md-3">


			<?php 


			if(input::exist('post', 'create_account_submit')) {


				$validation = new  Validation;

				$fields = array(


					'name' => array(

						'required' => true,
						'min' => 3,
						'max' => 50
					),

					'username' => array(

						'required' => true,
						'min' => 3,
						'max' => 50,
						'unique' => 'users'
					),

					'password' => array(


						'required' => true,
						'min' => 3,
						'max' => 50
					),

					'password_again' => array(


						'required' => true,
						'matches' => 'password'
					)


				);


				$check = $validation->check($_POST, $fields);



				// if there is no error create the user account
				if($check->passed()) {


					$user = new User;

					//get filed values from user

					$salt =  hash::salt(32);
					$password = hash::make(input::get('password'), $salt);

					$fields = array(

						'name' => input::get('name'),
						'username' => input::get('username'),
						'password' => $password,
						'salt' => $salt,
						'joined' => date('Y-m-d'),
						'profile_status' => 0

					);

					//create account
					$account = $user->create($fields);


					if($account) {

						redirect::to('index.php');
					} else {


						?>

						<p class="alert alert-danger">There was a problem creating account please try again</p>

						<?php 
					}


				} else {



										//display errors fromt the validation

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
					<input type="text" name='name' placeholder='Name' class="form-control" value=<?php echo input::get('name'); ?>>
				</div>

				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" name='username' class="form-control" placeholder="Username" value='<?php echo input::get('username'); ?>'>
				</div>

				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" name='password' placeholder="Password" class="form-control" value='<?php echo input::get('password') ?>'>
				</div>

				<div class="form-group">
					<label for="password_repeat">Repeat Password</label>
					<input type="text" name='password_again' class='form-control' placeholder='Re-enter Password' value=<?php echo input::get('password_again'); ?>>
				</div>


				<button type='submit' name='create_account_submit' class="btn btn-primary">Create Account</button>

				<p class='text' style="margin-top: 15px">Already have an account <a href="index.php">Login into your Account</a></p>
			</form>
		</div>
	</div>
</div>

<?php 


require_once "footer.php";


?>