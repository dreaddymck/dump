<?php

function request()
{
    $data = "";

    try {

        if ( isset($_REQUEST["route"]) && is_valid_domain( $_REQUEST["route"] ) ) {

            $data = file_get_contents($_REQUEST["route"]);

            if(substr($data, 0, 5) == "<?xml") { $data = simplexml_load_string($data,"SimpleXMLElement",LIBXML_NOCDATA); }

            header("Access-Control-Allow-Headers: Authorization, Content-Type");
            header("Access-Control-Allow-Origin: *");

            if (isset($_REQUEST["callback"])) {

                header('content-type: application/json; charset=utf-8');

                return $_REQUEST["callback"]."(".$data.")";
            }
            return $data = json_encode($data);
        }
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
    return null;
}

function is_valid_domain( $url ) {

    $whitelisted = array( 'http://localhost');
    
    $test = parse_url( $url, PHP_URL_SCHEME ) . "://". parse_url( $url, PHP_URL_HOST );

    // Check if we match the domain exactly
	if ( in_array( $test, $whitelisted ) )
		return true;
	$valid = false;
    
    foreach( $whitelisted as $w ) {
		$w = '.' . $w; // Prevent things like 'evilsitetime.com'
		if( strpos( $test, $w ) === ( strlen( $test ) - strlen( $w ) ) ) {
			$valid = true;
			break;
		}
	}
	return $valid;
}

exit(request());
?>
