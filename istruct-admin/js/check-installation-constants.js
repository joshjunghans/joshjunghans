;(function($) {
$(document).ready(function() {

	$('a#validate_install').click(function() {

		var $this = $(this);

		$('#validate li.error').remove();
		$('#validate li').removeAttr('class');
		$('#validate #response').show();

		$.getJSON('func/check-install-constants.php?check=constants', function(data) {

			$('li#'+data.checking).addClass('loading');

			if( data.status ) {
				$('li#'+data.checking).removeClass('loading').addClass('success');

				$.getJSON('func/check-install-constants.php?check=dbcon', function(condata) {

					$('li#'+condata.checking).addClass('loading');

					if( condata.status ) {
						$('li#'+condata.checking).removeClass('loading').addClass('success');
						$this.text('Continue Installation').attr('id','continue');
						$this.attr('href','install2.php');
					} else {
						$('li#'+condata.checking).removeClass('loading').addClass('fail');
						for(var i=0;i<condata.flags.length;i++) {
							var flag = condata.flags[i];
							var dbstr = '<li class="error">- '+flag+'</li>';
							$('li#dbcon').after(dbstr);
						}
					}

				});

			} else {
				$('#validate li').removeClass('loading').removeClass('success').addClass('fail');

				$this.text('Try To Revalidate')

				for(var i=0;i<data.flags.length;i++) {
					var flag = data.flags[i];
					var str = '<li class="error">- Check your value for '+flag.constant+' on line '+flag.line+' of gloabls.php.</li>';
					$('li#dbcon').before(str);
					var dbstr = '<li class="error">- The database constants must be valid in order to connet to the database.</li>';
					$('li#dbcon').after(dbstr);
				}

			}

		});

	});

});
})(jQuery);