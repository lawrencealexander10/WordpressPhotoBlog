<?php namespace Zara4\API\Communication;


class Util {

	/**
	 * Is cURL available on this server?
	 *
	 * @return bool
	 */
	public static function curl_available() {
		return function_exists( 'curl_init' );
	}


	public static function user_agent() {
		return 'WordPress/Version/' . get_bloginfo( 'version' ) . ' Plugin/Version/' . ZARA4_VERSION;
	}



	/**
	 * Get the url to the given path.
	 *
	 * @param $path
	 * @return string
	 */
	public static function url( $path ) {
		return Config::BASE_URL() . $path;
	}


	/**
	 * GET the given $data to the given $url.
	 *
	 * @param $url
	 * @param $data
	 * @return array
	 * @throws Exception
	 * @throws AccessDeniedException
	 */
	public static function get( $url, array $data = array() ) {
		// cURL typically has better performance than fgc - favor cURL where possible
		if ( self::curl_available() ) {
			return self::curl_get( $url, $data );
		} else {
			return self::fgc_get( $url, $data );
		}
	}


	/**
	 * Perform a GET request to the given $url with the given $data using file_get_contents()
	 *
	 * @param $url
	 * @param $data
	 * @return string
	 */
	private static function fgc_get( $url, $data ) {
		$options = array(
			"http" => array(
				"method"  => "GET",
				"content" => http_build_query( $data ),
			),
		);
		$context = stream_context_create( $options );
		return file_get_contents( $url, false, $context );
	}


	/**
	 * Perform a GET request to the given $url with the given $data using cURL
	 *
	 * @param $url
	 * @param $data
	 * @return mixed
	 */
	private static function curl_get( $url, $data ) {
		$ch = curl_init();

		$query = http_build_query( $data ) ;
		curl_setopt( $ch,CURLOPT_URL, "{$url}?{$query}" );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt( $ch, CURLOPT_CAINFO, __DIR__.DIRECTORY_SEPARATOR.'cacert.pem');
		curl_setopt( $ch, CURLOPT_CAPATH, __DIR__.DIRECTORY_SEPARATOR.'cacert.pem');
		curl_setopt( $ch, CURLOPT_USERAGENT,	self::user_agent());

		$result = curl_exec( $ch );
		curl_close( $ch );

		return $result;
	}



	/**
	 * Post the given $data to the given $url.
	 *
	 * @param $url
	 * @param $data
	 * @return array
	 * @throws Exception
	 * @throws AccessDeniedException
	 */
	public static function post( $url, $data ) {
		// cURL typically has better performance than fgc - favor cURL where possible
		//if(self::curlAvailable()) {
			return self::curl_post( $url, $data );
		//} else {
		// return self::fgcPost($url, $data);
		//}
	}


	/**
	 * Perform a POST request to the given $url with the given $data using file_get_contents()
	 *
	 * @param $url
	 * @param array $data
	 * @return string
	 */
	private static function fgc_post( $url, array $data ) {
		$options = array(
			"http" => array(
				"header"  => "Content-type: application/x-www-form-urlencoded\r\n",
				"method"  => "POST",
				"content" => http_build_query( $data ),
			),
		);
		$context = stream_context_create( $options );
		return file_get_contents( $url, false, $context );
	}


	/**
	 * Perform a POST request to the given $url with the given $data using cURL
	 *
	 * @param $url
	 * @param array $data
	 * @return string
	 */
	private static function curl_post( $url, array $data ) {
		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POST, count( $data ) );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt( $ch, CURLOPT_CAINFO, __DIR__.DIRECTORY_SEPARATOR . 'cacert.pem' );
		curl_setopt( $ch, CURLOPT_CAPATH, __DIR__.DIRECTORY_SEPARATOR . 'cacert.pem' );
		curl_setopt( $ch, CURLOPT_USERAGENT, self::user_agent() );

		$result = curl_exec( $ch );
		curl_close( $ch );

		return $result;
	}




	/**
	 * Calculate the expiry time from the given lifetime time.
	 *
	 * @param int $expires_in
	 * @return int
	 */
	public static function calculate_expiry_time( $expires_in ) {
		// Give 60 second buffer for expiry
		$expires_in = intval( $expires_in ) - 60;
		return time() + $expires_in;
	}

} 