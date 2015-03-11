<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Has this kit been recieved yet?</h2>

		<div>
			<p>To confirm that the following kit has been recieved, please follow this link and sign in.: {{ URL::to('signIn', array($token)) }}.</p>
			<p>Kit ID#: {{Form::label('kitID', $kit['id'])}}</p>
			<p>If the kit has not yet been recieved, please contact the appropriate branch and ensure it gets shipped.</p>
		</div>
	</body>
</html>

