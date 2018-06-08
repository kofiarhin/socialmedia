<?php 

	class Validation {


		private $db = null,
				$errors = array(),
				$passed = false;


		public function __construct() {

			$this->db = db::get_instance();

		}

		public function check($source, $fields = array()) {

			foreach($fields as $field => $rules) {

				$value = $source[$field];


				foreach($rules as $rule => $rule_value) {


					if($rule === 'required' && empty($value)) {

						$this->add_error("{$field} is required");

					} else if(!empty($value)) {

						switch ($rule) {
							case 'min':
								if(strlen($value) < $rule_value) {

									$this->add_error("{$field} must be more than {$rule_value} characters");
								}
								break;

							case 'max':

									if(strlen($value) > $rule_value) {

										$this->add_error("{$field} cannot be more than {$rule_value} characters");
									}
								break;

							case 'unique':

								$user = $this->db->get($rule_value, array($field, '=', $value));

								if($user->count()) {

									$this->add_error("{$field} already exist");
								}

								break;

							case 'matches':

								if($value != $source[$rule_value]) {

									$this->add_error("{$rule_value} must match {$field}");
								}

								break;
							
							default:
								# code...
								break;
						}
					}
				}
			}

			if(empty($this->errors)) {

				$this->passed = true;
			}


			//var_dump($this);

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
 
	}