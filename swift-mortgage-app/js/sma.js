jQuery(function($) {

	$('#'+sma_data.form_id + ' #' + sma_data.file_field_id ).on('blur', function(e){			
		
		var client_id = $(this).val();
		
		//alert(client_id);
		
		var data = {
			'action': 'sma_save_log',
			'client_id': client_id      // We pass php values differently!
		};
		// We can also pass the url value separately from ajaxurl for front end AJAX implementations
		jQuery.post(sma_data.ajax_url, data, function(response) {
			//alert('Got this from the server: ' + response);
		});
		
	});
	
	$('#'+sma_data.form_id + ' #' + sma_data.name_field_id ).on('blur', function(e){			
		
		var client_name = $(this).val();
		
		//alert(client_name);
		
		var data = {
			'action': 'sma_save_log_name',
			'client_name': client_name      // We pass php values differently!
		};
		// We can also pass the url value separately from ajaxurl for front end AJAX implementations
		jQuery.post(sma_data.ajax_url, data, function(response) {
			//alert('Got this from the server: ' + response);
		});
		
	});
	
	$('#'+sma_data.form_id + ' #' + sma_data.email_field_id ).on('blur', function(e){			
		
		var client_email = $(this).val();
		
		//alert(client_email);
		
		var data = {
			'action': 'sma_save_log_email',
			'client_email': client_email      // We pass php values differently!
		};
		// We can also pass the url value separately from ajaxurl for front end AJAX implementations
		jQuery.post(sma_data.ajax_url, data, function(response) {
			//alert('Got this from the server: ' + response);
		});
		
	});
	
	$('#'+sma_data.form_id + ' #' + sma_data.phone_field_id ).on('blur', function(e){			
		
		var client_phone = $(this).val();
		
		//alert(client_phone);
		
		var data = {
			'action': 'sma_save_log_phone',
			'client_phone': client_phone      // We pass php values differently!
		};
		// We can also pass the url value separately from ajaxurl for front end AJAX implementations
		jQuery.post(sma_data.ajax_url, data, function(response) {
			//alert('Got this from the server: ' + response);
		});
		
	});
	
	$('#'+sma_data.form_id + ' #' + sma_data.submit_field_id ).on('click', function(e){			
  		
		//alert('finish');
		//$(this).prop( "disabled", true );
		
		//Activate spinner
		$(this).toggleClass('active');
		
		var data = {
			'action': 'sma_save_log_complete'
 		};
		// We can also pass the url value separately from ajaxurl for front end AJAX implementations
		jQuery.post(sma_data.ajax_url, data, function(response) {
			//alert('Got this from the server: ' + response);
		});
		
	});
	
	//Virtual page views.
	dataLayer.push({
	'event':'VirtualPageview',
	'virtualPageURL':'/order/step1',
	'virtualPageTitle' : 'Order Step 1 – Contact Information'
	});
	
});