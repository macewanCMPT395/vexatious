/*
This is javascript for dealing with
	layouts/hardware.php

You can fill a form by through a get request,
and perform a post in the same page
*/
var HardwareForm = (function() {
    var instance;

    function _init() {
        return {
			hwInfoRoute: "",
			kitInfoRoute: "",
			devices: "",
			
			_postDone: function(){},
			postDone: function(v) {
				instance._postDone = function(){
					v();
				};
			},
			
			_postStart: function(){},
			postStart: function(v) {
				instance._postStart = function() {
					v();
				};
			},
			
			_getStart: function(){},
			getStart: function(v) {
				instance._getStart = function() {
					v();
				};
			},
			
			_getDone: function(){},
			getDone: function(v) {
				instance._getDone = function() {
					v();
				};
			},
			
			//fill the hardware form
			fill: function(hwID) {
				var url = instance.hwInfoRoute.replace('%7Bhardware%7D', hwID);
				console.log(url);
				instance._getStart();
				$.get(url, {"_method": "get"}, null, 'json').done(function(response) {
					instance._getDone();
					//make sure we got a list
					if(response.status == 1) {
						$('.hw-none').show();
						$('.hw-exists').hide();
						$('.hw-none').text("No hardware associated with this kit.");
						
						
						return;
					}
					$('.hw-none').hide();
					$('.hw-exists').show();
					//a device was found, lets fill the hardware form
					var device = response.device;

					//set title
					$('#hw-title-text').text(device.name + ' [' + device.assetTag + ']');

					//set description
					$('#hw-description .hw-box-text')
						.text(device.description);

					$('#hw-damage .hw-box-text').empty();
					$('#hw-damage-list').empty();
					//fill in damages list
					if(device.damaged) {
						var damages = device.damaged.split('\n');
						damages.forEach(function(d) {
							var li = $(document.createElement('li')).text(d);
							$('#hw-damage-list').append(li);

						});
					} else {
						$('#hw-damage .hw-box-text').text("No damage to report");
					}

					//finally set kit reference if necessary
					if(device.kitID) {
						var refURL = instance.kitInfoRoute.replace('%7Bkits%7D', device.kitID);
						var urlObj = $('<a></a>').attr("href", refURL)
							.text('This device is associated with kit: ' + device.barcode);

						$('#hw-kitinfo .hw-box-text').empty().append(urlObj);
					}	


					//update post URLS
					var action = $('#form-booking').attr("action");
					$('#form-booking').attr("action", action.replace('%23', device.kitID));
				});
			},


			//override the post for the form, so
			//we don't have to worry about redirecting
			//or refreshing the page 
			post: function() {
				$('#form-booking').on('submit', function(e) {
					e.preventDefault();
					instance._postStart();
					postOverride(this, 'put', { "damaged": $('#damaged').val() },
						function(resp) {
							instance._postDone();
						},
						function(resp) {
						console.log(resp);
							instance._postDone();
							instance.fill(resp.device.id);
							$('#damaged').val("");
					});


					return false;
				});
			}
        }
    }

    return {
        init: function(values) {
            if (!instance) {
                instance = _init();

                //initialization values
                for (var key in values) {
                    if (values.hasOwnProperty(key))
                        instance[key] = values[key];
                }

            }
            return instance;
        }
    }
})();
/*function HardwareForm (fields) {
	
	var hwInfoRoute = "{{ route('hardware.get'); }}";	
	var kitInfoRoute = "{{ route('kits.edit'); }}"
	



}*/