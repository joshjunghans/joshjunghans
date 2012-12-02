;(function($) {
$(document).ready(function() {

	$('form').each(function() {

		var $form = $(this);
		var form_id = $form.attr('id');
		var $results = $form.find('.results');

		$form.submit(function(e) {

			e.preventDefault();
			$results.empty().hide();

			var save_settings = {
				'edit_profile' : {
					'success' : {
						'message'  : 'Profile Updated',
						'callback' : function() {
							$results.html( save_settings.edit_profile.success.message )
								.removeClass('fail')
								.addClass('success')
								.fadeIn()
								.delay(4000)
								.fadeOut();
						}
					},
					'fail'    : {
						'message'  : 'Profile Update Failed',
						'callback' : function() {
							$results.html( save_settings.edit_profile.fail.message )
								.removeClass('success')
								.addClass('fail')
								.fadeIn();
						}
					}
				},
				'new_page' : {
					'success' : {
						'message'  : 'Page Saved',
						'callback' : function( new_id ) {
							window.location.replace('/admin/pages.php?action=edit&p_id='+new_id );
						}
					},
					'fail'    : {
						'message'  : 'Page Save Failed',
						'callback' : function() {
							$results.html( save_settings.new_page.fail.message )
								.removeClass('success')
								.addClass('fail')
								.fadeIn();
						}
					}
				},
				'edit_page' : {
					'success' : {
						'message'  : 'Page Updated',
						'callback' : function() {
							$results.html( save_settings.edit_page.success.message )
								.removeClass('fail')
								.addClass('success')
								.fadeIn()
								.delay(4000)
								.fadeOut();
						}
					},
					'fail'    : {
						'message'  : 'Page Update Failed',
						'callback' : function() {
							$results.html( save_settings.edit_page.fail.message )
								.removeClass('success')
								.addClass('fail')
								.fadeIn();
						}
					}
				}
			}

			var form_data = $form.serializeArray();
			var form_action = $form.attr('action');

			$.ajax({
				'type' : 'POST',
				'url' : form_action + '&return=json',
				'data' : form_data,
				'dataType' : 'json',
				'success' : function(data) {
					if( data.status ) {
						save_settings[form_id].success.callback(data.insert_id);
					} else {
						save_settings[form_id].fail.callback();
					}
				},
				'error' : function( xhr ) {
					save_settings[form_id].fail.callback();
				}
			});


		});

	});

});
})(jQuery);