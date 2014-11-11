<?php

class ResetKey extends SmartLoquent {

	/**
	 * The database collection used by the model.
	 *
	 * @var string
	 */
	protected $collection = 'reset_keys';

	protected $hidden = array('_id');
	protected $guarded = array('key');
	public $timestamps = true;

	public static function getInstance($user, $h_delay=12) {
		$reset = null;
		if ( $user instanceof User ) {
			$reset = new ResetKey();
			$reset->user_id = $user->_id;
			$reset->expiration_date = (new DateTime())->modify('+'.$h_delay.' hours');
			$reset->key = Token::randomKey(16);
		}
		return $reset;
	}
	
    public function user() {
    	return $this->belongsTo('User');
    }

    public function isExpired(){
    	$date_old = new DateTime( is_array($this->expiration_date)? $this->expiration_date['date'] : $this->expiration_date );
    	return $date_old < new DateTime();
    }


}