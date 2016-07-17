<?php namespace Zara4\WordPress;


class Settings {

	const SETTINGS_OPTION_NAME          = '_zara4_settings';


	const KEY__API_CLIENT_ID 			      = 'api-client-id';
	const KEY__API_CLIENT_SECRET 	      = 'api-client-secret';
	const KEY__COMPRESS_SIZES			      = 'compress-size';
  const KEY__AUTO_OPTIMISE 			      = 'auto-optimise';
  const KEY__BACK_UP_ORIGINAL_IMAGES  = 'back-up-original-images';


	private $data;


	/**
	 *
	 */
	public function __construct() {
		$this->data = self::read();
	}


	public function save() {
		self::write( $this->data );
	}


	public static function read() {
		return get_option( self::SETTINGS_OPTION_NAME );
	}


	private static function write( $settings ) {
		update_option( self::SETTINGS_OPTION_NAME, $settings );
	}


	/**
	 * Clear settings.
	 */
	public static function clear() {
		self::write( array() );
	}


	/**
	 *
	 *
	 * @return string[]
	 */
	public static function thumbnail_size_names() {
		global $_wp_additional_image_sizes;
		return array_merge( array('original', 'thumbnail', 'medium', 'large'), array_keys( $_wp_additional_image_sizes ) );
	}



	// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---

	/**
	 * Read an attribute as a string.
	 *
	 * @param $key
	 * @return string
	 */
	private function read_attribute_as_string( $key ) {
		return (string) $this->data[$key];
	}


	/**
	 * Write an attribute as a string.
	 *
	 * @param $key
	 * @param $value
	 */
	private function write_attribute_as_string( $key, $value ) {
		$this->data[$key] = (string) $value;
	}


	/**
	 * Read an attribute as a boolean.
	 *
	 * @param string $key
	 * @param bool $default
	 * @return bool
	 */
	private function read_attribute_as_boolean( $key, $default = true ) {
		return isset( $this->data[$key] ) ? (boolean) $this->data[$key] : $default;
	}


	/**
	 * Write an attribute as a boolean.
	 *
	 * @param $key
	 * @param $value
	 */
	private function write_attribute_as_boolean( $key, $value ) {
		$this->data[$key] = (boolean) $value;
	}


	// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


	/**
	 * Do these settings have API credentials.
	 *
	 * @return bool
	 */
	public function has_api_credentials() {
		return $this->api_client_id() && $this->api_client_secret();
	}


	// --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- ---


	/**
	 * Get the API client id
	 *
	 * @return string
	 */
	public function api_client_id() {
		return $this->read_attribute_as_string( self::KEY__API_CLIENT_ID );
	}


	/**
	 * Set the API client id
	 *
	 * @param string $api_client_id
	 */
	public function set_api_client_id( $api_client_id ) {
		$this->write_attribute_as_string( self::KEY__API_CLIENT_ID, $api_client_id );
	}


	/**
	 * Get the API client secret
	 *
	 * @return string
	 */
	public function api_client_secret() {
		return $this->read_attribute_as_string( self::KEY__API_CLIENT_SECRET );
	}


	/**
	 * Set the API client secret
	 *
	 * @param string $api_client_secret
	 */
	public function set_api_client_secret( $api_client_secret ) {
		$this->write_attribute_as_string( self::KEY__API_CLIENT_SECRET, $api_client_secret );
	}


	/**
	 * Get whether images should be automatically optimised.
	 *
	 * @return bool
	 */
	public function auto_optimise() {
		return $this->read_attribute_as_boolean( self::KEY__AUTO_OPTIMISE );
	}


	/**
	 * Set whether images should be automatically optimised.
	 *
	 * @param bool $auto_optimise
	 */
	public function set_auto_optimise( $auto_optimise ) {
		$this->write_attribute_as_boolean( self::KEY__AUTO_OPTIMISE, $auto_optimise );
	}


  /**
   * @return bool
   */
  public function back_up_original_images() {
    return $this->read_attribute_as_boolean( self::KEY__BACK_UP_ORIGINAL_IMAGES, true );
  }


  /**
   * @param $back_up_original_images
   */
  public function set_back_up_original_images( $back_up_original_images ) {
    $this->write_attribute_as_boolean( self::KEY__BACK_UP_ORIGINAL_IMAGES, $back_up_original_images );
  }


	/**
	 * Get whether an image size should be compressed.
	 *
	 * @param $name
	 * @return bool
	 */
	public function image_size_should_be_compressed( $name ) {

		// Assume should be compressed if no compression data is set.
		if( ! isset( $this->data[self::KEY__COMPRESS_SIZES] ) ) {
			return true;
		}

		return (boolean) isset( $this->data[self::KEY__COMPRESS_SIZES][$name] )
			? $this->data[self::KEY__COMPRESS_SIZES][$name] : false;
	}


	/**
	 * Set whether an image size should be compressed.
	 *
	 * @param $name
	 * @param $should_be_compressed
	 */
	public function set_image_size_should_be_compressed( $name, $should_be_compressed ) {

		// Ensure compression data is set.
		if( ! isset( $this->data[self::KEY__COMPRESS_SIZES] ) ) {
			$this->data[self::KEY__COMPRESS_SIZES] = array();
		}

		$this->data[self::KEY__COMPRESS_SIZES][$name] = (boolean) $should_be_compressed;
	}


} 