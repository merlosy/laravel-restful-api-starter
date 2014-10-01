<?php

use Jenssegers\Mongodb\Model as Eloquent;

class ResetKey extends Eloquent {

	/**
	 * The database collection used by the model.
	 *
	 * @var string
	 */
	protected $collection = 'reset_keys';

	protected $hidden = array('_id');
	protected $guarded = array('key');
	public $timestamps = true;

	public static function getInstance($user, $h_delay=24) {
		$reset = null;
		if ( $user instanceof User ) {
			$reset = new ResetKey();
			$reset->user_id = $user->id;
			$reset->expiration_date = (new DateTime())->modify('+'.$h_delay.' hours');
			$reset->key = Token::randomKey(16);
		}
		return $reset;
	}
	
    public function user() {
    	return $this->belongsTo('User');
    }

    public function isExpired(){
    	// TODO implement
    }


}