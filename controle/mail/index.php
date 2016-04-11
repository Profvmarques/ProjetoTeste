<html>
	<head>
		<title>PHPMailer - SMTP advanced test with no authentication</title>
	</head>
	<body>
		<?php
			if ($_POST['enviar']) {
				require_once('class.phpmailer.php');
				//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
				
				$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
				
				$mail->IsSMTP(); // telling the class to use SMTP
				
				try {
					$mail->Host       = "relay.proderj.rj.gov.br"; // SMTP server
					//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
					$mail->AddReplyTo('ouvidoria@cienciaetecnologia.rj.gov.br', 'Ouvidoria SECT');
					$mail->SetFrom('ouvidoria@cienciaetecnologia.rj.gov.br', 'Ouvidoria SECT');
					$mail->AddAddress($_POST['endereco'], 'Nome do Manifestante');
					//$mail->AddReplyTo('ouvidoria@cienciaetecnologia.rj.gov.br', 'First Last');
					$mail->Subject = $_POST['assunto'];
					$mail->AltBody = 'Para ver esta mensagem, use um visualizador de e-mail compatível com HTML'; // optional - MsgHTML will create an alternate automatically
					$mail->MsgHTML($_POST['texto']);
					//$mail->AddAttachment('images/phpmailer.gif');      // attachment
					//$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
					
					$mail->Send();
					echo "Mensagem enviada</p>\n";
				}
				catch (phpmailerException $e) {
					echo $e->errorMessage(); //Pretty error messages from PHPMailer
				}
				catch (Exception $e) {
					echo $e->getMessage(); //Boring error messages from anything else!
				}
			}
		?>
		<form method='post'>
			<label>Enviar para: </label>
			<input type='text' name='endereco' id='endereco'>
			<br>
			
			<label>Assunto: </label>
			<input type='text' name='assunto' id='assunto'>
			<br>
			
			<label>Texto: </label>
			<br>
			<textarea name='texto' id='texto'></textarea>
			<br>
			
			<input type='submit' name='enviar' id='enviar' value='Enviar'>
		</form>
	</body>
</html>