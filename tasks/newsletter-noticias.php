<?php
	function guardarHash(){
		$fecha1 = date('Y-F-d');
		$fecha2 = date('Y-m-d');
		$hash1 = md5($fecha1);
		$hash2 = md5($fecha2);
		$param = $hash1."|".$hash2;
		
		$url = 'http://www.laspartes.com/newsletterNoticias';
		$params = array(
			param	=> $param
		);
		$session = curl_init($url);
		curl_setopt ($session, CURLOPT_POST, true);
		curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
		curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($session);
		curl_close($session);
		echo $response;
		
	}
	
	guardarHash();
?>