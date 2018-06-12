<?php 

require_once "core/init.php";

$user = new User;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Social Meida</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/styles.css">
	<script src='js/jquery.js'></script>
	<script src='js/bootstrap.min.js'></script>
	<script src='js/main.js'></script>
</head>
<body>


	<div class="container">


		<header class="main-header">

		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand" href="index.php">Logo</a>
			
			<div class="collapse navbar-collapse" id="navbarTogglerDemo02">
				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
					

					<?php 


					if($user->logged_in()) {

						$user_id = $user->data()->user_id;

						?>

						<li class="nav-item">
							<a class="nav-link text-capitalize" href="profile.php?user_id=<?php echo $user_id; ?>"><?php echo $user->data()->username; ?></a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="timeline.php">Timeline</a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="search_user.php">Search</a>
						</li>
						
						<li class="nav-item">
							<a class="nav-link" href="following.php">Following</a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="followers.php">Followers</a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="notifications.php">Notifications</a>
						</li>


						<li class="nav-item">
							<a class="nav-link" href="messages.php">Messages</a>
						</li>


						<li class="nav-item">
							<a class="nav-link" href="logout.php">Logout</a>
						</li>


						<?php 
					} else {

						?>

						<li class="nav-item">
							<a class="nav-link" href="login.php">Login</a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="register.php">Register</a>
						</li>


						<?php 
					}

					?>
					
				</ul>

				<?php 

				if($user->logged_in()) {

					?>

					<form 
					action= "" method='post' class="form-inline my-2 my-lg-0" id="inner-form-search">
					<input name="search" class="form-control mr-sm-2" type="search" placeholder="Search" id='search'>

					<div id="search_result"></div>
				</form>

				<?php 
			}

			?>
		</div>
	</nav>

	</header>
</div>