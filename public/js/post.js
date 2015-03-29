/*
Requires jquery, an easy wrapper for overriding
laravel posts with our own.

	postButton refers to the button that submits the action.
	method is: 
		-post for store
		-put for update 
		-delete for destroy
	
	fields are the form values to submit in the request
	error is an anonymous function to call if the post fails
	success is an anonymous function to call if the post is successful
	
*/
function postOverride(postButton, method,fields, error, success) {
	//add required data to fields
	fields["_token"] = $(postButton).find( 'input[name=_token]' ).val(),
	fields["respType"] = "json";
	fields["_method"] = method;
	
	console.log($(postButton).prop('action'));
	$.post($(postButton).prop('action'), fields, null, 'json')
		.done(function(data) {
			console.log("done!");
			if(data.status == 1){
				if(error)error(data);
			} else {
				if(success)success(data);
			}
		})
		.fail(function(stuff) {
			if(error)error(stuff);
		});
}