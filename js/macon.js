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
	var base_url = "//192.168.1.13:5000";

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

	var error_set = false;

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
				console.log("Success");
				dashboard["lights"]["state"] = res["state"];
				// TODO: Look into deactivating until ajax load is done.
				// If the recieved state differs from the one displayed, change it.
				if(convertLightState(res["state"]) != $('#light').bootstrapSwitch('state')) {
					$('#light').bootstrapSwitch('toggleState', true, true);
				}
			}
		}),

		/** Get current light color **/
		$.ajax({
    		url: base_url + '/lights/color',
    		dataType: 'JSONP',
    		jsonpCallback: 'callback',
    		type: 'GET',
    		timeout: 10000,
    		success: function(res) {
    			dashboard["lights"]["color"] = res["color"];
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
	        		console.log(data);
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
    	if (state == "opened")
			return true;
		else
			return false;
    };
});