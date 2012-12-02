;(function($) {
$(document).ready(function() {

	// "Format" select.select elements
	$('select.select').each(function() {
		var $this = $(this);
		var sel_class = $this.attr('class');

		// Build the options into an array
		var opts = [];

		$this.children('option').each(function() {

			// determine if the option is 'selected'
			var is_selected = $(this).attr('selected') == 'selected' ? true : false;

			var opt = {
				'val' : $(this).attr('value'),
				'txt' : $(this).text(),
				'isSelected' : is_selected
			};

			opts.push(opt);

		});

		var out = '<ul class="'+sel_class+'">';

		for(var i=0;i<opts.length;i++) {
			out += '<li id="'+opts[i].val+'"';
			if(opts[i].isSelected) {
				out += ' class="selected"';
			}
			out += '>';
			out += opts[i].txt;
			out += '</li>';
		}

		out += '</ul>';

		$this.after(out);

	});

});
})(jQuery);