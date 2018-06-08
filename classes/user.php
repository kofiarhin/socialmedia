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

				if($this->find($user)) {

					$this->logged_in = true;
				}
			}
		} else {

			if($this->find($user_id)) {

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


		if(!$user_id) {

			if(session::exist($this->session_name)) {

				$user_id = session::get($this->session_name);

			}
		}


		$profile = $this->db->get('profile_images', array('user_id', '=', $user_id));

		if($profile->count()) {

			$this->profile_picture = $profile->first()->file_name;



		}
	


			
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
}