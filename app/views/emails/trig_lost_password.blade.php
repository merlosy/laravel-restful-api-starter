<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

<title>Email Triggered</title>
  
</head>

<body style='font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;color: #02081e;'>

<div>
	
	<div style="padding: 15px;margin:0;position:relative;text-align:center;background-color:#07102f;">
		<div style="display:inline-block;vertical-align:middle;">
			<img height="100px" src="{{{ $message->embed('assets/locker.png') }}}">
		</div>
		<div style="display:inline-block;vertical-align:middle;color:#f2f2f2;font-weight:bold;padding: 0 30px;text-align:left;">
			<p style="font-size:1.7em;">{{ $app_name }}</p>
			<p style="font-size:1.2em">Reset my password</p>
		</div>
	</div>


	<div style="margin:0;padding:10px;text-align:center;background-color:#f2f2f2;">
		<p style="color:#02081e;text-align:left;">To reset your password, click on the link below:</p>
		<p style="text-align:left;"><a target="_blank" href="{{ $url }}" 
				style="text-decoration: none;
					display: inline-block;
					background-color: #656565;
					color: #fff;
					padding: 7px 10px;
					-webkit-border-radius: 3px;
					-moz-border-radius: 3px;
					border-radius: 3px;">
			Click here to reset password</a></p>
		<p style="color:#02081e;text-align:left;">You will be redirected to your application.</p>

		<p style="color:#02081e;text-align:left;">This link will expire on <strong>{{$expiration}}</strong>.</p>

	</div>


	<p style="color:#02081e;text-align:left;margin-top:10px;font-size:0.9em;margin-top:10px;">
		You received this email because you asked to reset your password.
		<br>Copyright {{ date('Y') }}, {{ $app_name }}
	</p>

</div>

</body></html>
