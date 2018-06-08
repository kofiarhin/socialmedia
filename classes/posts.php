<?php 

	class Posts {



		private $db=null;

		public function __construct() {


			$this->db = db::get_instance();

		}

		public function create($fields) {


				$create = $this->db->insert('posts', $fields);

				if($create) {

					session::flash('messages', 'You have successfully created post');

					return true;
				}

				echo "error";
				return false;
		} 

		public function get_following_post($user_id) {

			$sql = "select * from followers 

			inner join users
			on followers.follower_id = users.user_id

			inner join posts
			on followers.follower_id = posts.user_id

			where followers.user_id = ?";

			$fields = array(

				'user_id' => $user_id

			);

			$query = $this->db->query($sql, $fields);

			if($query->count()) {

				return $query->result();
			}

			return false;

		
		}
	}