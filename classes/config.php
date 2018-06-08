<?php 

	class Config {

		public static function get($path) {

			$path = explode('/', $path);

			$config = $GLOBALS['config'];


			foreach($path as $bit) {

				if(isset($config[$bit])) {

					$config  = $config[$bit];
				}
			}


			return $config;
		}
	}