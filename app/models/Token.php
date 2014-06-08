<?php

use Jenssegers\Mongodb\Model as Eloquent;

class Token extends Eloquent {

	protected $collection = 'tokens';

	public static function generate() {
		do {
			$token = openssl_random_pseudo_bytes ( 20 , $strongEnough );
		} while( !$strongEnough );

		return sha1($token);
    }

    public static function userFor($token) {
    	$token = Token::where('token', '=', $token)->first();
    	if ( empty($token) ) return null;

    	return User::find($token->user_id);
    }

    public function isOwnerOf($token) {
        $owner = Token::userFor( $token );
        if ( empty($owner) || $owner->id!=$this->id )
            return false;
        else
            return true;
    }

    public static function isUserToken( $user_id, $token ) {
    	return Token::where('user_id', '=', $user_id)
        			->where('token', '=', $token)
        			->exists();
    }


}