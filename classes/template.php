<?php 

	class Template {



		public function __construct($path = false) {


				include "header.php";

					if($path) {

						include "/views/".$path.".php";
					}

				include "footer.php";

		}
	}