<?php 


		require_once "core/init.php";

 ?>

<?php 


	$search = input::get('search');


	$user = new User;

	$check = $user->search($search);



 ?>

<div class="user-link">

	<?php if($check):  ?>

				<?php foreach($check as $person):  ?>

					<?php $name = $person->name;
						  $username = $person->username;
						  $person_id = $person->user_id;
					 ?>
					<a class="link-unit" href="view_user_profile?person_id=<?php echo $person_id; ?>">
						<div class="face" style="background-image: url(img/default.jpg)"></div>
						<p><?php echo $name." @".$username; ?></p>
					</a>

				<?php endforeach; ?>
	<?php endif; ?>
	<!--====  end 
	<div class="link-unit">
		<p><a href="view_user_profile">Kofi Ahrin</a></p>
	</div>

	<div class="link-unit">
		<p><a href="view_user_profile">Kofi Ahrin</a></p>
	</div>


	<div class="link-unit">
		<p><a href="view_user_profile">Kofi Ahrin  @kofiarhin</a></p>
	</div>


	<div class="link-unit">
		<p><a href="view_user_profile">Kofi Ahrin @kofiarhin</a></p>
	</div>

	=======-->

</div>