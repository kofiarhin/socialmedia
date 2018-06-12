<?php 



class User {


	private $db = null,
	$logged_in = false,
	$session_name,
	$profile_picture,
	$data = array();


	public function __construct($user = false) {


		$this->db = db::get_instance();

		$this->session_name = config::get('session/session_name');

		$this->profile_picture = "default.jpg";

		$check = $this->check_profile_image();

		if(!$user) {

			if(session::exist($this->session_name)) {

				$user = session::get($this->session_name);

				$this->check_profile_image($user);

				if($this->find($user)) {

					$this->logged_in = true;
				}
			}
		} else {

			if($this->find($user)) {

				$this->check_profile_image($this->data()->user_id);

			
			}
		}

	}


	public function find($user) {

		$field = is_numeric($user) ? 'user_id' : 'username';


		$check = $this->db->get('users', array($field, '=', $user));


		if($check->count()) {


			$this->data = $check->first();

			return true;
		}



		return false;


	}


	public function check_profile_image($user_id = false) {



		$profile = $this->db->get('profile_images', array('user_id', '=', $user_id));

		if($profile->count()) {




			$file_name = $profile->first()->file_name;

			$path = "img/".$file_name;



			if(file_exists($path)) {


				$this->profile_picture = $file_name;
			}

			return true;


		}
	

			return false;


			
	}


	public function unfollow($user_id, $person_id) {


			$fields = array(

				'user_id' => $user_id,
				'persion_id' => $person_id

			);

			$sql = "delete from followers where user_id = ? and follower_id = ?";

			$query = $this->db->query($sql, $fields);

			if($query->count()) {


				session::flash('messages', 'unfolowed users successfully');

				return true;
			}


			return false;

	}



	public function login($username, $password) {


		$user = $this->find($username);

		if($user) {


			$enc_password = hash::make($password, $this->data()->salt);

			if($enc_password == $this->data()->password) {


				session::put($this->session_name, $this->data()->user_id);

				return true;
			}


		}


		return false;

	}



	public function create($fields) {


		$username = $fields['username'];

	


		$account = $this->db->insert('users', $fields);

		if ($account) {

			//user should follow himself

				$user = $this->db->get('users', array('username', '=', $username));

				if($user->count()) {

					$user_id = $user->first()->user_id;

					echo $user_id;

				

					$follow_fields = array(

						'user_id' => (int) $user_id,
						'follower_id' => (int) $user_id 
					);


					


					$follow_insert = $this->db->insert('followers', $follow_fields);

					if($follow_insert) {

						session::flash('message', 'Your account was successfully craeted');

						return true;
					}


				}

					
	
		}


		return false;
		
	}


	public function exist() {

		return (!empty($this->data)) ? true : false;

	}

	public function data() {

		return $this->data;
	}




	public function logged_in() {

		return $this->logged_in;
	}

	public function logout() {

		session::delete($this->session_name);
		
	}


	public function search($search) {

		$sql = "select * from users where users.username like ? or users.name like ?";

		$fields = array(

			'username' => "%$search%",
			"name" => "%$search%"
		);




		

		$query = $this->db->query($sql, $fields);

		if($query->count()) {


			return $query->result();
		}

		return false;
	}


	public function get_all_users() {


		$users = $this->db->get('users');

		if($users->count()) {


			return $users->result();
		}

		return false;
	}


	public function update_profile_image($user_id, $file_name) {


		$checks = $this->db->get('profile_images', array('user_id', '=', $user_id));

		if($checks->count()) {

			//update the existing table

			$update_fields = array(

				'file_name' => $file_name
			);

			$update = $this->db->update('profile_images', $update_fields, array('user_id', '=', $user_id));

			if($update) {

				echo "profile updated";

				return true;
			}

			echo "update current table";
 
		} else {

			// create new insert

			$profile_fields = array(

				'user_id' => $user_id,
				'file_name' => $file_name
			);

			$insert = $this->db->insert('profile_images', $profile_fields);

			if($insert) {

				//update the users field

				$user_field = array(

					'profile_status' => 1
				);

				$update = $this->db->update('users', $user_field, array('user_id', '=', $user_id));

				if($update) {

					echo "profile updated";

					return true; 
					
				}

			}

		}


		return false;
 	}


 	public function get_profile_picture() {

 		return $this->profile_picture;
 	}


 	public function follow($fields) {


 		$follow = $this->db->insert('followers', $fields);

 		if($follow) {

 			session::flash("messages", "Follow success");
 			return true;
 		}

 		return false;

 	}

 	public function check_following($user_id, $person_id )  {

 			$sql = "select * from followers where user_id = ? and follower_id = ?";

 			$fields = array(

 				'user_id' => $user_id, 
 				'follower_id' => $person_id
 			);

 			$query = $this->db->query($sql, $fields);

 			if($query->count()) {


 				return true;
 			}


 			return false;
 	}

  public function get_followers_post($user_id) {


  	$sql = "select * from followers 
	
	inner join users
	on followers.follower_id = users.user_id

	inner join posts
	on followers.follower_id = posts.user_id 

  	where followers.user_id = ?

	order by posts.post_date desc
  	";




  	$fields = array(

  		'user_id' => $user_id
  	);

  	


  	$query = $this->db->query($sql, $fields);

  	if($query->count()) {


  		return $query->result();
  	}

  return false;

  
  }


  public function get_following($user_id) {


  		$sql = "select * from followers 

		inner join users

		on followers.follower_id = users.user_id


		left join profile_images

		on followers.follower_id = profile_images.user_id

  		where followers.user_id = ?

		order by users.name

  		";

  		$fields = array(

  			'user_id' => $user_id
  		);

  		$query = $this->db->query($sql, $fields);

  		if($query->count()) {


  			return $query->result();
  		}

  		return false;
   }


   public function get_followers($user_id) {


   	$sql = "select * from followers 

	inner join users

	on followers.user_id = users.user_id


	left join profile_images
	on followers.user_id = profile_images.user_id

   	where follower_id = ?

	order by users.name

   	";

   	$fields = array(

   		'follower_id' => $user_id
   	);

   	$query = $this->db->query($sql, $fields);

   	if($query->count()) {


   		return ($query->result());
   	}

   	return false;

   }


   public function update_info($fields) {


   		if($this->exist()) {


   			$user_id = $this->data()->user_id;


   			$update = $this->db->update('users', $fields, array('user_id', '=', $user_id));


   			if($update) {

   				session::flash('messages', 'You have successfully updated your info');
   				return true;
   			}

   		}


   		return false;

   }


   public function change_password($current_password, $new_password) {


  		if($this->exist()) {


  				$enc_password = $this->data()->password;

  				$cur_salt = $this->data()->salt;
  				$user_id = $this->data()->user_id;


  				$enc_current_pass = hash::make($current_password, $cur_salt);

  				if($enc_password == $enc_current_pass) {

  					$new_salt = hash::salt(32);

  					$new_enc_pass = hash::make($new_password, $new_salt);


  					$fields = array(

  						'password' => $new_enc_pass,
  						'salt' => $new_salt

  					);


  					$update = $this->db->update('users', $fields, array('user_id', '=', $user_id));

  					var_dump($update);


  					if($update) {


  						session::flash('messages', 'Your password was successfully updated');

  						return true;
  					}



  				}

  		}


  		return false;


   }


   public function change_username($username) {


   			if($this->exist()) {

   				$user_id  = $this->data()->user_id;

   				$fields = array(

   					'username' => $username

   				);


   				$update = $this->db->update('users', $fields, array('user_id', '=', $user_id));

   				if($update) {


   					session::flash('messages', 'Username successfully changed');

   					return true;
   				}
   			}

   			return false;


   }

}