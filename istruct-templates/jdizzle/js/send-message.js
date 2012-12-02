;(function($) {
$(document).ready(function() {

	$('form').submit(function(event) {

		var err = [];

		var $this = $(this);
		var $result = $this.children('#result');

		$result.removeClass().empty().hide();

		var email = $this.find('#email').val();
		var message = $this.find('#message').val();

		if(email == '' || email == null) {
			err.push('You must enter your email address');
		}

		if(message == '' || message == null) {
			err.push('You must enter a message');
		}

		if(err.length < 1) {

			var action = $this.attr('action');
			var form_data = $this.serializeArray();

			$.ajax({
				'type' : 'POST',
				'url' : action,
				'data' : form_data,
				'dataType' : 'json',
				'success' : function(data) {

					if(data.status) {
						$result.addClass('success').text('Your message was sent.').show();
					} else {
						$result.addClass('error').text(data.message).show();
					}
				},
				'error' : function(xhr) {
					$result.addClass('error').text(xhr.responseText).show();
					console.log(xhr);
				}
			});

		} else {
			var out = '';

			for(var i=0;i<err.length;i++) {
				out += '<p>'+err[i]+'</p>';
			}

			$result.addClass('error').html(out).show();
		}

		return false;

	});

});
})(jQuery);