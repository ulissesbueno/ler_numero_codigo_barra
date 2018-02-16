<?php

class DecodeCodBar{
	
	// Layout do Número do código de barras
	private static $lay = [  

		[ "id" => "bank", "size" => 3],
		[ "id" => "coin", "size" => 1],
		[ "id" => "dv", "size" => 1],
		[ "id" => "expires", "size" => 4],
		[ "id" => "value", "size" => 10],
		[ "id" => "fix", "size" => 1],
		[ "id" => "customer", "size" => 7],
		[ "id" => "our_number", "size" => 13],							 
		[ "id" => "IOF", "size" => 1],
		[ "id" => "type", "size" => 3]  
	];

	// Layout do Linha digitável
	private static $lay_dig = [
		[ "id" => "bank", "size" => 3],
		[ "id" => "coin", "size" => 1],
		[ "id" => "free1", "size" => 5],
		[ "id" => "dv", "size" => 1],
		[ "id" => "free2", "size" => 10],
		[ "id" => "dv", "size" => 1],
		[ "id" => "free3", "size" => 10],
		[ "id" => "dv", "size" => 1],
		[ "id" => "DIV", "size" => 1],
		[ "id" => "expires", "size" => 4],
		[ "id" => "value", "size" => 10]
	];

	// Decodifica o código
	public static function decode( $cod ){

		// Deixa somente números
		$cod = preg_replace('/[\.|\s]/','',$cod);

		/* Identifica de é CODBAR ou linha Digitável */
		if ( strlen($cod) == 44 ){
			$layout = self::$lay;
		} else if ( strlen($cod) == 47 ) {
			$layout = self::$lay_dig;
		} else {
			return false;
		}

		// Mapeia o layout e criar um partner para Expressão regular
		$partner_ar = array_map( function( $v ){
			return "([0-9]{". $v['size'] ."})";
		}, $layout );

		// Pega as partes do numero
		$partner = implode('',$partner_ar);
		preg_match( "/".$partner."/", $cod, $match );

		if( preg_match( "/".$partner."/", $cod, $match ) ){

			// tira o primeiro index do array
			array_shift( $match );

			$ret = [];
			// Set as propriedades 
			foreach( $match as $i => $v ){
				$ret[ $layout[ $i ]['id'] ] = $v ;
			}	

			// Converte dados
			$ret['dt_expires'] = self::expireDecode( $ret['expires'] ); // Data vencimento
			$ret['value_money'] = self::valueDecode( $ret['value'] ); // Valor Boleto

			// Retorna!!!
			return (Object) $ret;

		} else {
			// Deu ruim
			return false;
		}
	}

	// Decodifica a data de vecimento
	private static function expireDecode( $v ) {
	  	
		$date = new DateTime('1997-10-07');
		$date->add(new DateInterval('P'. $v .'D'));
		return $date->format('Y-m-d');

	}	

	// Decodifica o valor do Boleto
	private static function valueDecode( $v ) {
	  	
	  	$v = (int) $v;
	  	$v = str_pad($v, 3, '0', STR_PAD_LEFT);
	  	preg_match('/^([0-9]{1,})([0-9]{2})/' , $v, $match );
	  	return $match[1].".".$match[2];

	}

	

}