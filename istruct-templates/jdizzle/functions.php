<?php

add_to_stack( 'init', 'jdizzle_init' );
function jdizzle_init() {

	add_script( 'jquery', ISTRUCT_JQUERY );

	if( is_page( 'contact' ) ) {
		add_script( 'send-message' , ISTRUCT_TEMPLATE_URL . 'js/send-message.js' );
	}

}

add_to_stack( 'before_content', 'jdizzle_projects_content' );
function jdizzle_projects_content() {

	if( !is_page( 'portfolio' ) )
		return;

	?>
		<div class="slideshow">
			<ul class="slideshow-nav">
				<li><a href="#delta" title="Delta Defense LLC."><img title="Delta Defense LLC." src="<?php image_thumb( template_image( 'delta-cluster.png', false, false ), 100, 100, 'center' ); ?>" /></a></li>
				<li><a href="#superior" title="Superior Lifting Specialists"><img title="Superior Lifting Specialists" src="<?php image_thumb( template_image( 'superiorlifting.png', false, false ), 100, 100, 'center' ); ?>" /></li>
			</ul>
			<div class="slide" id="delta">
				<img class="right" src="<?php template_image( 'delta-cluster.png' ); ?>" />
				<h2>Delta Defense LLC.</h2>
				<p class="project-title">Lead Developer</p>
				<p class="project-dates">Aug. 2008 - Oct. 2012</p>
				<h3>Duties Included:</h3>
				<ul>
					<li>Developing markup for web-pages per supplied mock-ups</li>
					<li>Develop custom front-end functionality using Javascript and jQuery</li>
				</ul>
			</div>
		</div>
		<div class="clear"></div>
	<?php
}

?>