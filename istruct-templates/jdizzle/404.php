<?php $struct->head(); ?>
<?php $struct->page_head(); ?>

<?php do_hook( 'before_page_content' ); ?>

<div id="content">

	<?php do_hook( 'before_content' ); ?>
	
	<h2>404: Page not found...</h2>
	
	<?php var_dump( $GLOBALS ); ?>
	
	

	<?php do_hook( 'after_content' ); ?>

</div>

<?php do_hook( 'after_page_content' ); ?>

<?php $struct->page_footer(); ?>
