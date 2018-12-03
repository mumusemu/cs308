<?php
$to      = 'selinsezer@sabanciuniv.edu';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: webmaster@yourdomain.com' . "\r\n" .
   'Reply-To: webmaster@yourdomain.com';

mail($to, $subject, $message, $headers);
?>