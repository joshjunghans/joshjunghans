;(function($) {
$(document).ready(function() {

	$('#header #user_info a.toggle').click(function() {

		var $submenu = $(this).siblings('ul');

		$submenu.toggle();

	});

});
})(jQuery);