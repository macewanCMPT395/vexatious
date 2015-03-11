<?php

class EmailTest extends TestCase {

	public function testMail()
	{

	/* this should be implimented into the notifications controller */
		/* test tp see how the laravel mailing api actually works.

		to send mail, the arguments are:
		- name_of_view to send (can be generated dynamically. can be an
		  array of views, containing both an html view AND a plain text
		  view)
		- $data - an array of items that are to be passed to the view
		  that we are using. an empty array may be passed in if
		  nothing is required, but at least an empty array is required
		- the third option is a closure used to specify things about
		  the actual email. in this example, details about the message
		  are specified. details we can specify about a message
		  include:

			to, cc, from, subject, attatchment, ...

		*/

		/*$data = array();*/
		$testkitid = 12345;
		$recipient = 'janedoe@epl.ca';
		$ccs = array('johndoe@epl.ca', 'admin@epl.ca');
		Mail::send('emails.recieved', ['token' => 'signIn', 'kit' => array('id' => $testkitid)], function($message) use ($testkitid, $recipient, $ccs){

			/* name is not required in message->to. to add a username, use the format:
			<address>, <name> */
			$message->to($recipient)->subject('Kit recieved? Kit ID#: '.$testkitid)->cc($ccs);

		});
		

	}

}

