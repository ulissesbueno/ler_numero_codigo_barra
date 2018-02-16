<?php
// Includes...
require_once('decode_codbar.php');

// Como usar? 
// Simples... 
$ret = DecodeCodBar::decode('03398739800000433089000000100000000000120101');
// O retorno é um objeto com propridades resultantes do Decode!!
echo "<pre>". print_r( $ret, 1 ) ."</pre>";

// Manada Vê Garoto!!
						