<?php
		
	if(isset($_GET['ws'])) {
		$func = $_GET['ws'];
		callWebService($func);
	}

		
	function callWebService($url){
			$json = file_get_contents($url);
			$array = json_decode($json,true);
			echo $json;
		}
		
	?>
		