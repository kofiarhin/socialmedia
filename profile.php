<?php 


require_once "header.php";

if(!$user->logged_in()) {


	redirect::to('login.php');
}


$user_id = $user->data()->user_id;
$name = $user->data()->name;

$following = $user->get_following($user_id);
$followers = $user->get_followers($user_id);

$num_following = count($following) - 1;

$num_followers = count($followers) - 1;


$profile_picture = $user->get_profile_picture();



?>


<div class="container">

	<div class="row">

		<div class="col-md-3 offset-md-2">
			<div class="profile-unit">

				<div class="face" style="background-image: url(img/<?php echo $profile_picture; ?>);">


				</div>

				<!--====  profile picture upload form=======-->

				<?php 

					//check if change of profile

				if(input::exist('post', 'profile_submit')) {

					$file = $_FILES['file'];

					$upload = new File;

					$check = $upload->check($file);

					if($check->passed()) {

						$file_upload = $upload->upload();


						if($file_upload) {


							$file_name = $check->file_name();

							$fields = array(

								'profile_status' => 1

							);

							//checks

							$update = $user->update_profile_image($user_id, $file_name);



							if($update) {

								session::flash('profile_update', 'Your profile image was successfully uploaded');

								redirect::to('timeline.php');
								
							}
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
				<form action="" method='post' enctype="multipart/form-data">

					<div class="form-group">
						<input type="file" class="form-control" name='file'>
					</div>

					<button class='btn btn-primary' type='submit' name='profile_submit'>change Profile</button>

				</form>
				
			</div>
		</div>

		<div class="col-md-6">
			<div class="content" style='margin-top: 40px'>
				<p class="lead text-capitalize">Name: <?php echo $name; ?></p>
				<p class='text'><a href="following.php?user_id={$user_id}">Following: <?php echo $num_following; ?></a></p>
				<p class='text'><a href="followers.php?user_id={$user_id}">Followers: <?php echo $num_followers; ?></a></p>
				<p><a href="edit_profile.php" class="btn btn-link">Edit Profile</a></p>
				<p><a href="change_password.php" class="btn btn-link">Change Password</a></p>
				<p><a href="change_username.php" class="btn btn-link">Change Username</a></p>
			</div>
		</div>
	</div>


</div>

<?php 

require_once "footer.php";

?>