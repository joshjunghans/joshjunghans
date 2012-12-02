<?php $struct->head() ?>

<?php do_stack( 'before_page_content' ); ?>

<div id="content">

<h1><?php $struct->page_title(); ?></h1>

<?php do_stack( 'before_content' ); ?>

<?php $struct->page_content(); ?>

<?php do_stack( 'after_content' ); ?>

</div>

<?php do_stack( 'after_page_content' ); ?>

<?php $struct->foot(); ?>