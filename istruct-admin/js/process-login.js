;(function($) {
$(document).ready(function() {

	$('form').submit(function() {

		var $this = $(this);
		var field_errs = [];
		var $errdiv = $('div.errors').empty();

		var form_fields = $this.serializeArray();

		$.ajax({
			'type' : 'POST',
			'url' : 'func/process-login.php',
			'data' : form_fields,
			'dataType' : 'json',
			'success' : function(data) {

				if(!data.status) {
					$errdiv.append('<ul></ul>');
					var $errul = $errdiv.children('ul');
					$errul.append('<li class="fail">'+data.error+'</li>');
				} else {
					window.location.replace('index.php');
				}

			},
			'error' : function(xhr) {
				$errdiv.append('<ul></ul>');
				var $errul = $errdiv.children('ul');
				$errul.append('<li>'+xhr.statusText+'</li>');
			}
		});

		return false;

	});

});
})(jQuery);