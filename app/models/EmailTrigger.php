<?php

Queue::getIron()->ssl_verifypeer = false;

class EmailTrigger {


	public static function send( $action='', $object1=null ) {
        Log::info('--- Triggered email: '.$action.' ---');
		$base = Config::get('app.url');
		$bcc = array();
		$result = false;

		$sender = array( 
				'email'	=>	Config::get('mail.from.address'),
				'name'	=>	Config::get('mail.from.name'),
			);

		switch ( $action ) {
			case 'lost_password':
				$title = 'Request for password';
				$content = array();

				if ( $object1 instanceof ResetKey ){
					$receiver = $object1->user->email;
					$content = array(
							'firstname'		=> $object1->user->firstname,
							'lastname'		=> $object1->user->lastname,
							'expiration'	=> $object1->expiration_date->format('d F Y - H:i:s'),
							'url'			=> URL::to('v1/users/reset/'.$object1->key),
						);
				}
				
				$result = EmailTrigger::email( 'trig_lost_password' , $title, $content, $receiver, $sender, $bcc );

				break;

			default:
				Log::info('<!!!> Email action '.$action.' is not valid!');
				break;
		}
		Log::info('--- End Trigger ---');
		return $result;
	}

	protected static function email( $template, $title, $data, $receivers, $sender, $bcc=null, $file=null ) {

		$data['app_name'] = Config::get('app.name');
		$data['base'] = Config::get('app.url');

        $data['title'] = $title;
        $data['receivers'] = $receivers;
        $data['user_name'] = $sender['name'];
        $data['user_email'] = $sender['email'];
        $data['bcc'] = (array) $bcc;
        $data['file'] = $file;

        $success = false;

        try {
        	Log::info('<!> Sending new email...');
	        Mail::queue('emails.'.$template, $data, function($message) use ($data) {

	            $message->from( $data['user_email'] , $data['user_name'] )->subject($data['app_name'].' - '.$data['title']);

	            if ( !empty($data['receivers']) )
	            	$message->to( $data['receivers'] );

	            if ( !empty($data['bcc']) )
	            	$message->bcc( $data['bcc'] );

	            if ( !empty( $data['file']) )                              
	                $message->attach( $data['file'] );

	        });
	        Log::info('...DONE!');
	        // Log::info( json_encode($data) );
	        $success = true;
	    } catch (Exception $e) {
	    	Log::warning('<!!!> ...FAILED! Exception while sending email: '.$e->getMessage() );
	    }

        return $success;
	}

}