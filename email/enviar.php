<html>
<head>
<title>PHPMailer - SMTP advanced test with no authentication</title>
</head>
<body>

<?php
/*$headers = 'From: izaias@faetec.rj.gov.br' . "\r\n" .
    'Reply-To: izaias@faetec.rj.gov.br' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
if (!mail("izaias.ignacio@gmail.com","aa","msg",$headers)) {
	die('erro');
}*/
require_once('class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

$mail->IsSMTP(); // telling the class to use SMTP

try {
  $mail->Host       = "smtps.proderj.rj.gov.br"; // SMTP server
  $mail->SMTPSecure = 'ssl';
  $mail->SMTPAuth = true;
  $mail->Port = 465;
  $mail->Username = 'dinfosedes@faetec.rj.gov.br';
  $mail->Password = 'faetec2010';
  $mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
  $mail->AddReplyTo('izaias@faetec.rj.gov.br', 'First Last');
  $mail->AddAddress('izaias.ignacio@gmail.com', 'John Doe');
  $mail->SetFrom('izaias@faetec.rj.gov.br', 'First Last');
  $mail->Subject = 'PHPMailer Test Subject via mail(), advanced';
  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
  //$mail->MsgHTML(file_get_contents('contents.html'));
  $mail->MsgHTML('teste');
  //$mail->AddAttachment('testeemail/images/phpmailer.gif');      // attachment
  //$mail->AddAttachment('testeemail/images/phpmailer_mini.gif'); // attachment
  $mail->Send();
  echo "Message Sent OK</p>\n";
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //Boring error messages from anything else!
}
?>

</body>
</html>
