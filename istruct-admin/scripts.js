;(function($) {
$(document).ready(function() {

	$( 'textarea.editor' ).ckeditor();
	CKEDITOR.config.autoParagraph = false;
	CKEDITOR.config.baseHref = '/';
	CKEDITOR.config.contentsCss = '../styles/style.css';

});
})(jQuery);