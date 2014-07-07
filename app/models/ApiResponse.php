<?php
/**
 *	@author Jeremy Legros
 *	@version 0.1.1
 * 	@license http://opensource.org/licenses/MIT MIT
 */

use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Response as Response;

/**
 *	Convenient method to format Json response messages, but not only
 */
class ApiResponse extends Response {

	/**
	 *	@param Validation $validator Illuminate\Validation\Validator instance to format errors
	 *	@param boolean $stringify Specify whether the response should be formatted in a string or as an array (default)
	 *	@param array $headers Additional header to append to the request
	 * 	@return json String or Array representation of the validation errors
	 */
	public static function validation ($validator, $stringify=false, $status='412', $headers=array() ) {
		if ( !($validator instanceof Validator) )
			throw new Exception('Argument is not a Validator instance ('.get_class($validator).' found).');

		$response = array('validation'=>'Passed!');

		if ( $validator->fails() ) {
			$errors = $validator->messages()->toArray();
			if ( $stringify ) {
				$response = '';
				if ( is_array($errors) ) {
					foreach ($errors as $key => $value) {
						if ( self::isAssocArray($value) ){
							$response .= $key.' ';
							foreach ($value as $key => $val) {
								$response .= strtolower($key).'. ';
							}
						}
						else for ($i=0; $i <count($value) ; $i++) { 
								$response .= $value[$i].' ';
						}
					}
				}
				else $response .= $errors;
			}
			else
				$response = $errors;
		}
		
		// return json_encode(array( 'validation' => $response) );
		return self::json( array( 'validation' => $response), $status, $headers);
	}

	/**
	 *	@param url $url protocol to redirect to
	 *	@return ApiResponse Response to client
	 */
	public static function makeProtocol ( $url ) {
        $response = self::make();
        $response->header('Location', $url);
        return $response;
    }

	/**
	 *	@param array|string $date Message to format
	 *	@param array $headers Additional header to append to the request
	 * 	@return ApiResponse JSON representation of the error message
	 */
	public static function errorUnauthorized( $data=array(), $headers=array() ){
		return self::json( $data, '401', $headers );
	}

	/**
	 *	@param array|string $date Message to format
	 *	@param array $headers Additional header to append to the request
	 * 	@return ApiResponse JSON representation of the error message
	 */
	public static function errorForbidden( $data=array(), $headers=array() ){
		return self::json( $data, '403', $headers );
	}

	/**
	 *	@param array|string $date Message to format
	 *	@param array $headers Additional header to append to the request
	 * 	@return ApiResponse JSON representation of the error message
	 */
	public static function errorNotFound( $data=array(), $headers=array() ){
		return self::json( $data, '404', $headers );
	}

	/**
	 *	@param array|string $date Message to format
	 *	@param array $headers Additional header to append to the request
	 * 	@return ApiResponse JSON representation of the error message
	 */
	public static function errorInternal( $data=array(), $headers=array() ){
		return self::json( $data, '500', $headers );
	}

	/**
	 *	@param array $array Message to format
	 *	@return boolean true is associative array, false otherwise
	 */
	protected static function isAssocArray( $array ){
		if ( empty($array) ) return false;
    	return (bool)count(array_filter(array_keys($array), 'is_string'));
	}


}