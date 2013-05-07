<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('smtp_send_mail'))
{
	//echo BASEPATH;
	include BASEPATH."../application/libraries/swift_required.php";
	include BASEPATH.'../application/libraries/SmtpApiHeader.php';

	function smtp_send_mail($destinatarios = array(), $asunto = "", $mensajeHTML = "", $mensajeText = "")
	{
		$hdr = new SmtpApiHeader();
		
		// The list of addresses this message will be sent to
		// [This list is used for sending multiple emails using just ONE request to SendGrid]
		$mails = array();
		$names = array();
		$toList = array();
		foreach($destinatarios as $destinatario){
			$toList[] = $destinatario->email;
			$mails[] = $destinatario->email;
			$names[] = $destinatario->nombres;
		}

		// Set all of the above variables
		$hdr->addTo($toList);
		$hdr->addSubVal('-name-', $names);

		// Specify that this is an initial contact message
		$hdr->setCategory("initial");

		// You can optionally setup individual filters here, in this example, we have enabled the 
		// footer filter
		$hdr->addFilterSetting('footer', 'enable', 1);
		$hdr->addFilterSetting('footer', "text/plain", "Thank you for your business");

		// The subject of your email
		$subject = $asunto;

		// Where is this message coming from. For example, this message can be from 
		// support@yourcompany.com, info@yourcompany.com
		$from = array('no-reply@laspartes.com' => 'LasPartes.com');

		// If you do not specify a sender list above, you can specifiy the user here. If a sender 
		// list IS specified above
		// This email address becomes irrelevant.
		$to = array();
		foreach($destinatarios as $destinatario){
			$to[$destinatario->email] = $destinatario->nombres;
		}

		# Create the body of the message (a plain-text and an HTML version).
		# text is your plain-text email
		# html is your html version of the email
		# if the reciever is able to view html emails then only the html
		# email will be displayed

		// Your SendGrid account credentials
		$username = 'laspartes';
		$password = 'L1sp1rt2s111';

		// Create new swift connection and authenticate
		$transport = Swift_SmtpTransport::newInstance('localhost', 25);
		$transport ->setUsername($username);
		$transport ->setPassword($password);
		$swift = Swift_Mailer::newInstance($transport);

		// Create a message (subject)
		$message = new Swift_Message($subject);

		// add SMTPAPI header to the message
		// *****IMPORTANT NOTE*****
		// SendGrid's asJSON function escapes characters. If you are using Swift Mailer's
		// PHP Mailer functions, the getTextHeader function will also escape characters.
		// This can cause the filter to be dropped.
		$headers = $message->getHeaders();
		$headers->addTextHeader('X-SMTPAPI', $hdr->asJSON());

		// attach the body of the email
		$message->setFrom($from);
		$message->setBody($mensajeHTML, 'text/html');
		$message->setTo($to);
		$message->addPart($mensajeText, 'text/plain');

		// send message
		if ($recipients = $swift->send($message, $failures))
		{
			// This will let us know how many users received this message
			// If we specify the names in the X-SMTPAPI header, then this will always be 1.
			echo 'Se ha enviado el mensaje a '.$recipients.' usuarios';
		}
		// something went wrong =(
		else
		{
			echo "Existe un error en el envío de mensajes - ";
			print_r($failures);
		}
	}
}

