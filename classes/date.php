<?php 

	class Date {


		public static function current_date() {

			$date = new DateTime;

			return $date->format("Y-m-d H:i:s");
		}


		public static function expiry($days = null) {

			if(!$days) {


				$days = 30;
			}

			$date = new DateTime("+".$days." days");

			return $date->format("Y-m-d H:i:s");
		}

	}