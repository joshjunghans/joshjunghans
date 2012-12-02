;(function($) {
$(document).ready(function() {

	$( 'textarea.editor' ).ckeditor();
	CKEDITOR.config.autoParagraph = false;
	CKEDITOR.config.baseHref = '/';

});
})(jQuery);