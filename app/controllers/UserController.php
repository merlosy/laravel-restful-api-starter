<?php

class UserController extends BaseController {

	public $restful = true;

	public function index() {
		return User::all();
	}
	
	public function store() {

		$input = Input::all();
		$user = '';

		$validator = Validator::make( $input, User::getCreateRules() );

		if ( $validator->passes() ) {

			$user = new User();
			$user->email 				= Input::has('email')? $input['email'] : '';
			$user->firstname 			= Input::has('firstname')? $input['firstname'] : '';
			$user->lastname 			= Input::has('lastname')? $input['lastname'] : '';
			$user->password 			= Hash::make( $input['password'] );

			if ( !$user->save() )
				$user = ApiResponse::error('An error occured. Please, try again.');

		}
		else {
			return ApiResponse::validation($validator);
		}
		Log::info('<!> Created : '.$user);

		return $user;
	}

	public function authenticate() {

		$input = Input::all();
		$validator = Validator::make( $input, User::getAuthRules() );

		if ( $validator->passes() ){

			$user = User::where('email', '=', $input['email'])->first();
			if ( !($user instanceof User) ) {
				return ApiResponse::error("User is not registered.");
			}
			
			if ( Hash::check( $input['password'] , $user->password) ) {

				$device_id = Input::has('device_id')? $input['device_id'] : '';
				$device_type = Input::has('device_type')? $input['device_type'] : '';
				$device_token = Input::has('device_token')? $input['device_token'] : '';

				$token = $user->login( $device_id, $device_type, $device_token );

				Log::info('<!> Device Token Received : '. $device_token .' - Device ID Received : '. $device_id .' for user id: '.$token->user_id);
				Log::info('<!> Logged : '.$token->user_id.' on '.$token->device_os.'['.$token->device_id.'] with token '.$token->token);
				
				$token->user = $user->toArray();
			}
			else $token = ApiResponse::error("Incorrect password.");
			
			return $token;
		}
		else {
			return ApiResponse::validation($validator);
		}
	}

	public function logout() {
		$input = Input::all();
		$validator = Validator::make( $input, User::getActiveRules() );

		if ( $validator->passes() ) {
			$token = Token::where('token', '=', $input['token'])->first();

			if ( empty($token) )	return ApiResponse::error('No active session found.');

			if ( $token->delete() ){
				Log::info('<!> Logged out from : '.$input['token'] );
				return ApiResponse::success('User logged out successfully.');
			}	
			else
				return ApiResponse::error('User could not log out. Please try again.');

		}
		else {
			return ApiResponse::validation($validator);
		}
	}

	public function forgot() {
		$input = Input::all();
		$validator = Validator::make( $input, User::getForgotRules() );

		if ( $validator->passes() ) {

			$user = User::where('email', '=', $input['email'])->first();
			// $reset = $user->generatePassResetKey();

			// $sent = TriggerEmail::send( 'lost_password', $user, $reset );
			$sent = false;

			if ( $sent )
				return ApiResponse::success('Email sent successfully.');
			else
				return ApiResponse::warning('An error has occured, the Email was not sent.');
		}
		else {
			return ApiResponse::validation($validator);
		}
	}

	public function resetPassword() {
		$input = Input::all();
		$validator = Validator::make( $input, User::getResetPassRules() );

		if ( $validator->passes() ) {
			$reset = ResetKeys::where('key', $input['key'])->first();
			if ( !($reset instanceof ResetKeys) )
				return ApiResponse::error("Invalid reset key.");

			$user = $reset->user;

			$user->password = Hash::make($input['password']);
			$user->save();

			$reset->delete();

			return $user;
		}
		else {
			return ApiResponse::validation($validator);
		}
	}

	public function show($user) {

		Log::info('<!> Showing : '.$user );

		return $user;
	}

	public function missingMethod( $parameters = array() )
	{
	    return ApiResponse::error('Sorry, no method found');
	}

}