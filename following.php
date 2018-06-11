<?php 

require_once "header.php";


	$user_id = $user->data()->user_id;


	$data = $user->get_following($user_id);



?>

<div class="container">
	
	<h1 class="display-4">Your are following:</h1>
	
</div>



	<div class="container">
		
	<div class="row">
		
		<div class="col-md-3">
			<div class="profile-unit">
				
				<div class="face" style='background-image: url(img/default.jpg)'></div>
				<div class="content">
					<p class="lead">Name: Kofi Arhin</p>
				</div>

			</div>
		</div>
	</div>


	</div>

<?php 


require_once "footer.php";


?>