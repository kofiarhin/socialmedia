<?php 

	class Posts {



		private $db=null,
				$data = array();

		public function __construct($post_id = false) {


			$this->db = db::get_instance();


			if($post_id) {

				$this->find($post_id);
			}

		}


		public function find($post_id) {


			$sql = "select * from posts where posts.post_id = ?";

			$fields = array(

				'post_id' => $post_id

			);


			$query = $this->db->query($sql, $fields);

			if($query->count()) {


				$this->data = $query->first();

				return true;
			}

			return false;
		}


		public function like($fields) {


			$like = $this->db->insert('likes', $fields);


			var_dump($like);

			$post_id = $fields['post_id'];


			if($like) {


				$post = $this->db->get('posts', array('post_id', '=', $post_id));

				if($post->count()) {


					$like = $post->first()->post_likes;

					$new_like = $like + 1;

					//update the post table

					$update_fields = array(

						'post_likes' => $new_like

					);

					$update = $this->db->update('posts', $update_fields, array('post_id', '=', $post_id));

					if($update) {

						echo "liked";

						return true;
					}
				}

			}

			return false;
		}


		public function check_like($post_id, $user_id) {

			$sql = "select * from likes where  post_id = ? and user_id = ?";

			$fields = array(

				'post_id' => $post_id,
				'user_id' => $user_id

			);

			$query = $this->db->query($sql, $fields);

			if($query->count()) {


				return true;
			}

			return false;
		}


		public function exists() {

			return (!empty($this->data)) ? true : false;
		}


		public function delete($fields) {


			$sql = "delete from posts where post_id = ? and user_id = ? ";

			$query = $this->db->query($sql, $fields);

			if($query->count()) {


				echo 'post deleted';

				session::flash('messages', 'you have successfully deleted post');

				return true;
			}


			return false;

		}

		public function get_people_likes($post_id) {

	

			$sql = "select * from likes 

			inner join users on
			likes.user_id = users.user_id

			left join profile_images

			on likes.user_id = profile_images.user_id

			where likes.post_id = ?

			order by likes.like_date

			";

			$fields = array(


				'post_id' => $post_id
			);

			$query = $this->db->query($sql, $fields);

			if($query->count()) {

				return $query->result();
			}

			return false;
		}


		public function unlike($post_id, $user_id) {


			//delete from likes table
			//reduce the post like by 1

			$sql = "delete from likes where post_id = ? and user_id = ?";

			$fields = array(

				'post_id' => $post_id,
				'user_id' => $user_id

			);


			$query = $this->db->query($sql, $fields);

			if($query->count()) {

				//reduce the likes on post by 1

				$post = $this->db->get('posts', array('post_id','=', $post_id));


				if($post->count()) {


					$likes = $post->first()->post_likes;
					$new_like = $likes - 1;


					//update the post table


					$update_fields  = array(

						'post_likes' => $new_like

					);

					$update = $this->db->update('posts', $update_fields, array('post_id', '=', $post_id));

					if($update) {

						echo "unliked";
						return true;
					}
				}
			}

		
			return false;
		}


		public function delete_comment($post_id, $comment_id) {



				//reduce the post_comments field by 1;


				$post = $this->get_post($post_id);

				if($post) {

					$post_comment = $post->post_comments;

					$new_post_comment = $post_comment - 1;

					if($new_post_comment < 0) {

						$new_post_comment = 0;
					}


					//update the post the

					$update_fields = array(

						'post_comments' => $new_post_comment

					);


					$update = $this->db->update('posts', $update_fields, array('post_id', '=', $post_id));

					if($update) {


							$delete = $this->db->delete('comments', array('comment_id', '=', $comment_id));


							if($delete) {

								//reduce the post_comments by 1;
								session::flash("messages", "comment successfully deleted");

								return true;
							}



					}
				}

			
				
				return false;

		}


		public function get_post($post_id) {


			$post = $this->db->get('posts', array('post_id', '=', $post_id));

			if($post->count()) {

				return $post->first();
			}

			return false;
		}

		public function data() {

			return $this->data;
		}



		public function get_post_comment($post_id) {


			$sql = "select * from comments 

			where comments.post_id = ?
		

			order by comments.comment_date desc

			";
			$fields = array(

				'post_id' => $post_id
			);


			$query = $this->db->query($sql, $fields);

			if($query->count()) {


				return $query->result();

			}

			return false;
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


		public function add_comment($fields) {


			$comment = $this->db->insert('comments', $fields);

			if($comment) {

				$post_id  = $fields['post_id'];

				$post = $this->db->get('posts', array('post_id', '=', $post_id));

				if($post->count()) {


					$post_comments = $post->first()->post_comments;

					$new_post_comment = $post_comments + 1;

					//update the post table

					$update_fields = array(

						'post_comments' => $new_post_comment
					);

					$update = $this->db->update('posts', $update_fields, array('post_id', '=', $post_id));


					if($update) {

						session::flash('messages', 'You have successfully added comment');
						return true;
						
					}


				}
			}


			return false;
		}


		public function get_user_posts($user_id) {


			$sql = "select * from posts where posts.user_id = ? order by posts.post_date desc";

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