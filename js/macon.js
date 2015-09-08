/*
*
*	Author: Grant McGovern
*	Date: 21 May 2015
*
* 	Description:
*	
*	This is the main script powering the macon-
*	command-center dashboard.
*/

$(document).ready(function(){
	var base_url = "//macon-command-center-api.ngrok.io"; //"//raspberrypi.local:5000";

	/**** On page load, get current dashboard values ****/
	var dashboard = {
		"lights": {
			"state": "",
			"color": "",

		},
		"blinds": {
			"side": "",
			"backyard": ""
		},
	};

	var DEBUG = true;

	// Execute ajax requests one after the other.
	$.when(
		/** Get current light state **/
		$.ajax({
			url: base_url + '/lights/state',
			dataType: 'JSONP',
			jsonpCallback: 'color',
			type: 'GET',
			timeout: 10000,
			success: function(res) {
				if(DEBUG) console.log("Success: ", res["state"]);
				dashboard["lights"]["state"] = res["state"];
				// TODO: Look into deactivating until ajax load is done.
				// If the recieved state differs from the one displayed, change it.
				// Normalize both responses by sending them through convertLightState() method
				if(res["state"] != convertLightState($('#light').bootstrapSwitch('state'))) {
					$('#light').bootstrapSwitch('toggleState', false, false);
				}
			}
		}),

		/** Get current light color **/
    	$.ajax({
    		url: base_url + '/lights/currentcolor',
    		dataType: 'JSONP',
    		jsonpCallback: 'currentcolor',
    		type: 'GET',
    		timeout: 10000,
    		success: function(res) {
    			console.log(res);
    			if(DEBUG) { console.log("Success: ", res["color-hex"]) };
    			dashboard["lights"]["color"] = res["color-hex"];
    			// If the recieved light color differs from the one displayed, change it.
				if(res["color-hex"] != $("#cpDiv2").colorpicker("val")) {
					$("#cpDiv2").colorpicker("val", res["color-hex"]);
				}
    		}
    	}),

    	/** Get blind positions for backyard and side **/
		$.ajax({
    		url: base_url + '/blinds/position',
    		dataType: 'JSONP',
    		jsonpCallback: 'position',
    		type: 'GET',
    		timeout: 10000,
    		success: function(res) {
    			if(DEBUG) { console.log(
    				"Success: ", "(Side): ", res["side"], "(Backyard): ", res["backyard"]
    				) };
    			dashboard["blinds"]["side"] = res["side"];
    			dashboard["blinds"]["backyard"] = res["backyard"];
    			// If the recieved state differs from the one displayed, change it.
    			// Backyard
				if(convertBlindState(res["backyard"]) != $('#backyard-blinds').bootstrapSwitch('state')) {
					$('#backyard-blinds').bootstrapSwitch('toggleState');
				}
    			// Side
    			if(convertBlindState(res["side"]) != $('#side-blinds').bootstrapSwitch('state')) {
					$('#side-blinds').bootstrapSwitch('toggleState');
				}
    		}
    	})

    ).then(function() {
    	/**** Light Change ****/
		/* Listen for change of light state */
		$('#light').on('switchChange.bootstrapSwitch', function(event, state) {
			changeLightState(state);
		});

		/**** Blind Change ****/
		/* Listen for change of backyard blind position */
		$('#backyard-blinds').on('switchChange.bootstrapSwitch', function(event, position) {
			changeBackyardBlindPosition(position);
		});

		/* Listen for change of side blind position */
		$('#side-blinds').on('switchChange.bootstrapSwitch', function(event, position) {
			changeSideBlindPosition(position);
		});

		/**** Color Change ****/
		/* Listen for change of light color */
		$('#cpDiv2').on('change.color', function(event, color) {
    		changeLightColor(color);
		});

		var error_set = false;

		function changeLightState(_state) {
			state = convertLightState(_state);

			$.ajax({
	    		url: base_url + '/lights/state/' + state,
	    		dataType: 'JSONP',
	    		jsonpCallback: 'callback',
	    		type: 'GET',
	    		timeout: 5000,
	    		error: function(XMLHttpRequest, textStatus, errorThrown) {
	    			// Append error to the state button
	    			if(!error_set) {
	    				$(".light-switch").after( 
	    					"<p style='color:red;'>Error, could not execute command.</p>"
	    				);
	    				error_set = true;
	    			}
	    		},
	    		success: function(data) {
	        		if(DEBUG) { console.log(data) };
	    		}
			});
		};

		var error_set = false;

		function changeBackyardBlindPosition(_position) {
			// Position: (true => open | false => close)
			position = (_position) ? "open" : "close";

			$.ajax({
	    		url: base_url + '/blinds/backyard/' + position,
	    		dataType: 'JSONP',
	    		jsonpCallback: 'position',
	    		type: 'GET',
	    		timeout: 5000,
	    		error: function(XMLHttpRequest, textStatus, errorThrown) {
	    			// Append error to the state button
	    			if(!error_set) {
	    				$(".blind-switches").after( 
	    					"<p style='color:red;'>Error, could not execute command for backyard blinds.</p>"
	    				);
	    				error_set = true;
	    			}
	    		},
	    		success: function(data) {
	        		if(DEBUG) { console.log(data) };
	    		}
			});
		};

		var error_set = false;

		function changeSideBlindPosition(_position) {
			// Position: (true => open | false => close)
			position = (_position) ? "open" : "close";

			$.ajax({
	    		url: base_url + '/blinds/side/' + position,
	    		dataType: 'JSONP',
	    		jsonpCallback: 'position',
	    		type: 'GET',
	    		timeout: 5000,
	    		error: function(XMLHttpRequest, textStatus, errorThrown) {
	    			// Append error to the state button
	    			if(!error_set) {
	    				displayError('.blind-switches');
	    				error_set = true;
	    			}
	    		},
	    		success: function(data) {
	        		if(DEBUG) { console.log(data) };
	    		}
			});
		};

		var error_set = false;

		function changeLightColor(_color) {
			// Escape '#' characters
			color = _color.replace("#", "%23");

			$.ajax({
	    		url: base_url + '/lights/' + color,
	    		dataType: 'JSONP',
	    		jsonpCallback: 'color',
	    		type: 'GET',
	    		timeout: 5000,
	    		error: function(XMLHttpRequest, textStatus, errorThrown) {
	    			// Append error to the state button
	    			if(!error_set) {
	    				displayError('.light-switch');
	    				error_set = true;
	    			}
	    		},
	    		success: function(data) {
	        		if(DEBUG) { console.log(data) };
	    		}
			});
		};

    });

    /* Helper Conversion Methods */
    function convertLightState(state) {
    	if (!state)
			state = "off";
		else
			state = "on";
		return state;
    };

    function convertBlindState(state) {
    	if (state == "open")
			return true;
		else
			return false;
    };

    function displayError(element) {
    	$(element).after(
    		"<p id='error-text' style='color:red;'>Error, could not execute command.</p>"
    		);
    };

    function cleanError() {
    	$('#error-text').each(function() {
    		$('#error-text').fadeOut().empty();
    	});
    }

    setTimeout(cleanError, 5000);

    var error_set = false;
    /* Custom theme handling */
    $('.custom-lighting-theme').on('click', function() {
    	var theme = $(this).data("theme");
    	$.ajax({
    		url: base_url + '/lights/theme/' + theme,
    		dataType: 'JSONP',
    		jsonpCallback: 'callback',
    		type: 'POST',
    		timeout: 5000,
    		error: function(XMLHttpRequest, textStatus, errorThrown) {
    			// Append error to the state button
    			if(!error_set) {
    				//displayError('.light-switch');
    				error_set = true;
    			}
    		},
    		success: function(data) {
        		if(DEBUG) console.log(data);
    		}
		});
    });
});