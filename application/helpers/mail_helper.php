<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('send_mail'))
{
	

	function send_mail($destinatarios = array(), $asunto = "", $mensajeHTML = "", $mensajeText = "", $fileName ="")
	{
                
		$url = 'http://sendgrid.com/';
		$user = 'laspartes';
		$pass = 'L1sp1rt2s111';
                $filePath = 'resources/facturas';
                //$path = dirname('resources/facturas/'.$fileName); 
                
		$to = array();
		foreach($destinatarios as $destinatario){
			$to[] = $destinatario->email;
		}

                
               
                
		$json_string = array(
			'to' => $to,
			'category' => 'Usuarios Laspartes.com'
		);

                if(isset($fileName) && $fileName != ""){
                    $params = array(
                            'api_user'                  => $user,
                            'api_key'                   => $pass,
                            'x-smtpapi'                 => json_encode($json_string),
                            'to'			=> 'test@laspartes.com',
                            'subject'                   => $asunto,
                            'html'			=> $mensajeHTML,
                            'text'			=> $mensajeText,
                            'from'			=> 'no-reply@laspartes.com.co',
                            'fromname'                  => 'Laspartes.com',
                            'files['.$fileName.']'  => '@'.$filePath.'/'.$fileName
                    );
                }else{
                   $params = array(
                            'api_user'                  => $user,
                            'api_key'                   => $pass,
                            'x-smtpapi'                 => json_encode($json_string),
                            'to'			=> 'test@laspartes.com',
                            'subject'                   => $asunto,
                            'html'			=> $mensajeHTML,
                            'text'			=> $mensajeText,
                            'from'			=> 'no-reply@laspartes.com.co',
                            'fromname'                  => 'Laspartes.com'
                    ); 
                }

		$request = $url.'api/mail.send.json';

		// Generate curl request
		$session = curl_init($request);
		// Tell curl to use HTTP POST
		curl_setopt ($session, CURLOPT_POST, true);
		// Tell curl that this is the body of the POST
		curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
		// Tell curl not to return headers, but do return the response
		curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

		// obtain response
		$response = curl_exec($session);
		curl_close($session);
		// print everything out
//		print_r($response);   
                
	}
}

