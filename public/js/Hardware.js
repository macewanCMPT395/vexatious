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
			hwListRoute: "",
			hwInfoRoute: "",
			kitInfoRoute: "",
			hwUpdateRoute: "",
			hwRmFromKit: "",
			
			damageUpdate: "#form-reportDamage",
			removeFromKitForm: "#form-removeFromKit",
			clearDamageForm: "#form-clearDamage",
			
			_postDone: function(){},
			postDone: function(v) {
				instance._postDone = function(hw){
					v(hw);
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
			
			_onListStart: function(){},
			onListStart: function(v) {
				instance._onListStart = function(listing) {
					v(listing);
				};
			},
			
			_onListDone: function(){},
			onListDone: function(v) {
				instance._onListDone = function(listing) {
					v(listing);
				};
			},
			
			_onDeviceFill: function() {},
			onDeviceFill: function(v) {
				instance._onDeviceFill = function(id) {
					v(id);	
				};
			},
			
			//fill the hardware form
			fill: function(hwID) {
				var url = instance.hwInfoRoute.replace('%7Bhardware%7D', hwID);
				console.log(url);
				instance._getStart();
				$.get(url, {"_method": "get"}, null, 'json').done(function(response) {
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
					$('#hw-title-text').text(device.name + ' [asset: ' + device.assetTag + ']');

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
					
					$('#damaged').val("");

					//finally set kit reference if necessary
					if(device.kitID) {
						var refURL = instance.kitInfoRoute.replace('%7Bkits%7D', device.kitID);
						var urlObj = $('<a></a>').attr("href", refURL)
							.text('This device is associated with kit: ' + device.barcode);

						$('#hw-kitinfo .hw-box-text').empty().append(urlObj);
					}	


					//update post URLS
					//var action = $('#form-booking').attr("action");
					$(instance.damageUpdate).attr("action", 
											instance.hwUpdateRoute.replace('%23', device.id));
					
						
					$(instance.removeFromKitForm).attr("action", function() {
							return instance.hwRmFromKit.replace('%7BkitID%7D', device.kitID)
											 .replace('%7BhwID%7D', device.id);
					});
					
					$(instance.clearDamageForm).attr("action", function() {
						return instance.hwUpdateRoute.replace('%23', device.id);
					});

					
					instance._onDeviceFill(hwID);
					instance._getDone();
				});
			},


			_post: function(button, data) {
				instance._postStart();
				postOverride(button, 'put', 
					data,
					function(resp) {
						instance._postDone(resp);
					},
					function(resp) {
						console.log(resp);
						instance.fill(resp.device.id);
						instance._postDone(resp.device.id);

					}
				);	
					
			},
			
			//override the post for the form, so
			//we don't have to worry about redirecting
			//or refreshing the page 
			post: function() {
				
				$(instance.damageUpdate).on('submit', function(e) {
					e.preventDefault();
					instance._post(this, { "damaged": $('#damaged').val() });
					return false;
				});
				
				
				$(instance.clearDamageForm).on('submit', function(e){
					e.preventDefault();
					instance._post(this, { "clear": true });
					return false;					
				});
				
				
				
			},
			
			//get a listing of all the hardware in the system
			list: function(error, done) {
				var url = instance.hwListRoute;
				$.get(url, {"_method": "get"}, null, 'json').done(function(response) {
					//make sure we got a list
					if(response.status == 1) {
						if(error)error();				
						return;
					}
					if(done)done(response.devices);
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

				
				instance.hwUpdateRoute = $(instance.damageUpdate).attr("action");
            }
            return instance;
        }
    }
})();
/*function HardwareForm (fields) {
	
	var hwInfoRoute = "{{ route('hardware.get'); }}";	
	var kitInfoRoute = "{{ route('kits.edit'); }}"
	



}*/