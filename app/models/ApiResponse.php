<?php
/**
 *	@author Jeremy Legros
 *	@version 0.1.1
 * 	@license http://opensource.org/licenses/MIT MIT
 */

use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Response as Response;

/**
 *	Convenient method to format response messages
 */
class ApiResponse extends Response {

	/**
	 *	@param Validation $validator Illuminate\Validation\Validator instance to format errors
	 * 	@return json String representation of the validation errors
	 */
	public static function validation ($validator, $stringify=false, $status='412', $headers=array() ) {
		if ( !($validator instanceof Validator) )
			throw new Exception('Argument is not a Validator instance ('.get_class($validator).' found).');

		$response = array('result'=>'Validation passed!');

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
	 */
	public static function makeProtocol ( $url ) {
        $response = self::make();
        $response->header('Location', $url);
        return $response;
    }

	/**
	 *	@param string $string Message to format
	 *	@param code $code Error code to return
	 * 	@return json String representation of the error message
	 */

	public static function errorUnauthorized( $data=array(), $headers=array() ){
		return self::json( $data, '401', $headers );
	}

	public static function errorForbidden( $data=array(), $headers=array() ){
		return self::json( $data, '403', $headers );
	}

	public static function errorNotFound( $data=array(), $headers=array() ){
		return self::json( $data, '404', $headers );
	}

	public static function errorInternal( $data=array(), $headers=array() ){
		return self::json( $data, '500', $headers );
	}

	protected static function isAssocArray( $array ){
		if ( empty($array) ) return false;
    	return (bool)count(array_filter(array_keys($array), 'is_string'));
	}


}