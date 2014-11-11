<?php

class Token extends SmartLoquent {

	protected $collection = 'tokens';

    protected $guarded = array('key');

    public static function randomKey($size) {
        do {
             $key = openssl_random_pseudo_bytes ( $size , $strongEnough );
        } while( !$strongEnough );
        $key = str_replace( '+', '', base64_encode($key) );
        $key = str_replace( '/', '', $key );

        return base64_encode($key);
    }

	public static function getInstance() {
        $token = new Token();
        $token->key = Token::randomKey(32);
        return $token;
    }

    public static function userFor($token) {
    	$token = Token::where('key', '=', $token)->first();
    	if ( empty($token) ) return null;

    	return User::find($token->user_id);
    }

    public static function isUserToken( $user_id, $token ) {
    	return Token::where('user_id', '=', $user_id)
        			->where('key', '=', $token)
        			->exists();
    }


}