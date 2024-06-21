<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/../vendor/autoload.php';
use TimoLehnertz\formula\Formula;


$input = file_get_contents('php://input');
// ob_start();
try {
    $formula = new Formula($input);
    $result = $formula->calculate();
} catch(\Exception $e) {
    echo $e->getMessage();
}
// $output = ob_get_contents();
// ob_end();