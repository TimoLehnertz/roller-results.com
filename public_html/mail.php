<?php
$headers = 'From: timolehnertz1@gmail.com' . "\r\n" .
    'Reply-To: timolehnertz1@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
mail("timolehnertz1@gmail.com", "test", "Moin meister", $headers);