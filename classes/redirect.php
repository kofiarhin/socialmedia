<?php 


	class Redirect {

		public static function to($path) {

			if($path) {

				header("Location: ".$path);
			}
		}
	}