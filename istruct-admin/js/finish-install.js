;(function($) {
$(document).ready(function() {

	$('form').submit(function() {

		var $this = $(this);

		$this.find('li.error').remove();

		var atts = $this.serializeArray();

		$.ajax({
			'type' : 'POST',
			'url' : 'func/finish-install.php',
			'data' : atts,
			'dataType' : 'json',
			'success' : function(data) {
				if(!data.status && (typeof(data.errors) != 'undefined')) {
					for(var i=0;i<data.errors.length;i++) {
						var err = data.errors[i];
						var errstr = '<li class="error">- '+err.error+'</li>';
						$('input#'+err.field).parent('li').after(errstr);
					}
				} else {
					window.location.replace('login.php');
				}
			},
			'error' : function(xhr) {

			}
		});

		return false;

	});

});
})(jQuery);