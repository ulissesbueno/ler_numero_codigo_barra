<?php
// Includes...
require_once('decode_codbar.php');

// Como usar? 
// Simples... 

//$ret = DecodeCodBar::decode('03398739800000433089000000100000000000120101');
$ret = DecodeCodBar::decode('03399.93875 77300.000005 00001.901016 3 74370000153252');

// O retorno é um objeto com propridades resultantes do Decode!!
echo "<pre>". print_r( $ret, 1 ) ."</pre>";

// Manada Vê Garoto!!
						