<?php 

	class File {


		private $errors = array(),
				$file_destionation,
				$file_name,
				$passed = false;


		public function __construct() {


			$this->file_name = "default.jpg";


		}

		public function check($file) {


			$file_name  = $file['name'];
			$file_size = $file['size'];

			$file_extention = explode('.', $file_name);

			$file_extention = strtolower(end($file_extention));

			$allowed = array('jpg', 'jpeg');


			if($file_name == "") {

					$this->add_error("Profile Picture cannot be empty");
			} else if($file_size > 1000000) {

				$this->add_error("File Size too huge");
			} else if(!in_array($file_extention, $allowed)) {

				$this->add_error("File type: ".$file_extention." not allowed");
			}



			if(empty($this->errors)) {

				$file_name = uniqid('', true).".".$file_extention;

				$this->file_tmp = $file['tmp_name'];

				$this->file_name = $file_name;

				$this->file_destination = 'img/'.$file_name;

				$this->passed = true;
			}

			var_dump($this);

			return $this;

		}


		public function add_error($error) {

			$this->errors[] = $error;
		}
		public function errors() {

			return $this->errors;
		}


		public function passed() {

			return $this->passed;
		}

		public function file_name() {

			return $this->file_name;
		}



		public function upload() {

				$file_tmp = $this->file_tmp;

				if(move_uploaded_file($this->file_tmp, $this->file_destination)) {


					return true;
				}

				return false;
		}
	}