(function($) {
	/*
	* Стандартные параметры.
	* Выполняются если не вызвана функция $.setParams
	*/
	var params = {
		form: '#sendForm', // форма
		alerts: '#alerts', // в какой див выводить сообшение
		button: '#okButton', // кнопка
		errorCallback: false, // выполнять callback при ошибке (json.error == true)
	};
	
	/*
	* Стандартные заголовки.
	* записываются если нету params.headers
	*/
	var headers = {
		'X-CSRF-TOKEN': $('meta[name="csrf"]').attr('content'),
	};
	
	$.setParams = function(object) {
		params = object;
	};
	
	$.alert = function(html, type = 'danger', close = 3, callback = false) {
		const randomId = randomInt(1000, 10000);
		const alerts = ( !params.alerts ? $('#alerts') : $(params.alerts) );
		
		if ($('.alert').length < 3)
		{
			alerts.append('<div class="alert theme alert-' + type + ' mt-3 w-100" id="alert-' + randomId + '">' + html + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		}
		const animateParams = {
			opacity: 0,
		};
		
		setTimeout(function() {
			$('#alert-' + randomId).animate(animateParams, 500, "swing", function() {
				setTimeout(function() {
					$('#alert-' + randomId).remove();
				}, 500);
			});
			if (typeof callback != "undefined" && callback !== false) callback();
		}, (close * 1000));
	};
	
	$.apiForm = function(url, method = 'POST', callback = false) {
		var alerts = ( !params.alerts ? $('#alerts') : $(params.alerts) );
		
		$(params.button).on('click', function(e) {
			e.preventDefault();
            
			var formData = new FormData($(params.form)[0]);
            
            /*
            if (localStorage.getItem('guestToken') != 'undefined')
            {
                const guestToken = localStorage.getItem('guestToken');
                
                formData.append('guestToken', guestToken);
            }*/
            
            
			$.ajax({
				url: url,
				type: method,
				data: formData,
				headers: headers,
				dataType: 'json',
                processData: false,
                contentType: false,
				success: function(json) {
                    
					if (json.error)
					{
						if (json.message)
						{
							$.alert(json.message);
						}
						else if (json.messages)
						{
							var index = 0;
							var inputPrefix = $(params.form).data('prefix');
							
							$.each(json.messages, function(key, msg) {
                                let message;
								
								if (index == 0)
								{
									$('#' + inputPrefix + '-' + key).focus();
								}
								message = (Array.isArray(msg) ? msg[0] : msg);
								
                                console.log('#' + inputPrefix + '-error-' + key);
                                
								$(params.form).find('#' + inputPrefix + '-error-' + key).html('<strong>' + message + '</strong>').addClass('d-block');
								$(params.form).find('#' + inputPrefix + '-' + key).addClass('is-invalid');
								
								setTimeout(function() {
									$(params.form).find('#' + inputPrefix + '-error-' + key).html('').removeClass('d-block');
									$(params.form).find('#' + inputPrefix + '-' + key).removeClass('is-invalid');
								}, 4000);
								
								index++;
							});
						}
						else
						{
							if (typeof callback !== "undefined" && callback !== false)
							{
								callback(json, params);
							}
							else
							{
								console.error('Нечего выполнять');
							}
						}
					}
					else
					{
                        if (json.message)
						{
							$.alert(json.message, 'success', 3);
						}
						else
						{
							if (typeof callback !== "undefined" && callback !== false)
							{
								callback(json, params);
							}
							else
							{
								console.error('Нечего выполнять');
							}
						}
					}
                    
					setTimeout(function() {
						if (typeof json.redirect !== "undefined") location.href = json.redirect;
						if (typeof callback !== "undefined" && callback !== false) callback(json, params);
					}, 3000);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					if (isJson(xhr.responseText))
					{
						const error = JSON.parse(xhr.responseText);
						
						$.alert(error.message, 'danger', 8);
					}
					else
					{
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n " + xhr.responseText);
					}
				}
			});
		});
		return this;
	}; 
})(jQuery);

function isJson(item)
{
	let response = false;
    item = typeof item !== "string"
        ? JSON.stringify(item)
        : item;

    try {
        item = JSON.parse(item);
    } catch (e) {
        response = false;
    }
    if (typeof item === "object" && item !== null) response = true;
}

function randomInt(min = 0, max = 10) {
	 return Math.floor(Math.random() * (max - min)) + min;
}
