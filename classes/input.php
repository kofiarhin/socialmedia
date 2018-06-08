<?php 

	class Input {



		public static function exist($type = 'post', $btn_name = false) {


				$btn_name = ($btn_name) ? $btn_name : 'submit';

				switch ($type) {
					case 'post':
						return (isset($_POST[$btn_name])) ? true: false;
						break;
					case 'get':
						return (isset($_GET[$btn_name])) ? true : false;
						break;
					default:
						return false;
						break;
				}


		}



		public static function get($item) {

			if(isset($_POST[$item])) {

				return $_POST[$item];
			} else if(isset($_GET[$item])) {

				return $_GET[$item];
			} else if(isset($_FILES[$item])) {

				return $_FILES[$item];
			}

			return "";
		}
	}